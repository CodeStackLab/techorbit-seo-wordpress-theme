<?php
/**
 * AI API Handler — OpenAI + Google Gemini
 * Called via WordPress AJAX: wp_ajax_techorbit_ai_call
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
   MAIN AJAX HANDLER
   ============================================================ */
function techorbit_ai_call() {
    // 1. Verify nonce
    if ( ! check_ajax_referer( 'techorbit_ai_nonce', 'nonce', false ) ) {
        wp_send_json_error( [ 'message' => __( 'Security check failed. Please refresh and try again.', 'techorbit-seo' ) ] );
    }

    // 2. Rate limiting (100 calls per hour per IP via transients)
    $ip          = sanitize_text_field( $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0' );
    $rate_key    = 'techorbit_rate_' . md5( $ip );
    $call_count  = (int) get_transient( $rate_key );

    if ( $call_count >= 100 ) {
        wp_send_json_error( [ 'message' => __( 'Rate limit reached (100 calls/hour). Please try again later.', 'techorbit-seo' ) ] );
    }

    // Increment rate limit counter
    if ( $call_count === 0 ) {
        set_transient( $rate_key, 1, HOUR_IN_SECONDS );
    } else {
        set_transient( $rate_key, $call_count + 1, HOUR_IN_SECONDS );
    }

    // 3. Sanitize inputs
    $tool       = sanitize_key( $_POST['tool'] ?? '' );
    $user_input = sanitize_textarea_field( $_POST['input'] ?? '' );
    $input2     = sanitize_textarea_field( $_POST['input2'] ?? '' );

    if ( empty( $tool ) || empty( $user_input ) ) {
        wp_send_json_error( [ 'message' => __( 'Tool name and input are required.', 'techorbit-seo' ) ] );
    }

    // 4. Get model & API keys
    $model = get_option( 'techorbit_default_ai_model', 'gpt-4o-mini' );

    // 5. Build prompt
    $prompt = techorbit_build_prompt( $tool, $user_input, $input2 );
    if ( is_wp_error( $prompt ) ) {
        wp_send_json_error( [ 'message' => $prompt->get_error_message() ] );
    }

    // 6. Call AI
    if ( techorbit_is_gemini( $model ) ) {
        $result = techorbit_call_gemini( $prompt, $model );
    } else {
        $result = techorbit_call_openai( $prompt, $model );
    }

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( [ 'message' => $result->get_error_message() ] );
    }

    wp_send_json_success( [ 'result' => $result, 'tool' => $tool ] );
}
add_action( 'wp_ajax_techorbit_ai_call', 'techorbit_ai_call' );
add_action( 'wp_ajax_nopriv_techorbit_ai_call', 'techorbit_ai_call' );

/* ============================================================
   PROMPT BUILDER
   ============================================================ */
function techorbit_build_prompt( $tool, $input, $input2 = '' ) {
    $prompts = [
        'meta-generator' => "You are an SEO expert. Generate an optimized SEO meta title (max 60 characters) and meta description (max 160 characters) for the following topic: {INPUT}. Return ONLY valid JSON in this exact format: {\"title\": \"...\", \"description\": \"...\"}",

        'blog-outline'   => "You are an SEO content strategist. Create a detailed SEO-optimized blog post outline for the topic: {INPUT}. Include an H1 title, multiple H2 sections with H3 sub-sections, an introduction hook, and a conclusion section. Format as a clean structured outline with proper indentation.",

        'keyword-cluster' => "You are an SEO keyword research expert. Generate 5 keyword clusters for the main keyword: {INPUT}. For each cluster provide: cluster name, 5 related long-tail keywords, and search intent (informational/commercial/transactional/navigational). Return ONLY valid JSON array in this format: [{\"cluster\": \"...\", \"keywords\": [\"...\"], \"intent\": \"...\"}]",

        'faq-generator'   => "Generate 8 SEO-optimized frequently asked questions and answers for the topic: {INPUT}. Format the output as a valid Schema.org FAQPage JSON-LD <script> tag, ready to paste into HTML. Only output the complete script tag with no other text.",

        'product-desc'    => "You are an e-commerce SEO copywriter. Write an SEO-optimized product description for: {INPUT}. Key features and details: {INPUT2}. Include the focus keyword naturally, use benefits-first writing style, and end with a soft call to action. Write 150-300 words in a professional yet engaging tone.",
    ];

    if ( ! isset( $prompts[ $tool ] ) ) {
        return new WP_Error( 'invalid_tool', __( 'Invalid tool specified.', 'techorbit-seo' ) );
    }

    $prompt = str_replace( '{INPUT}', $input, $prompts[ $tool ] );
    $prompt = str_replace( '{INPUT2}', $input2 ?: 'No additional details provided.', $prompt );

    return $prompt;
}

/* ============================================================
   OPENAI API CALL
   ============================================================ */
function techorbit_call_openai( $prompt, $model ) {
    $api_key = get_option( 'techorbit_openai_api_key', '' );
    if ( empty( $api_key ) ) {
        return new WP_Error( 'no_key', __( 'OpenAI API key is not configured. Please set it in Settings → TechOrbit AI Settings.', 'techorbit-seo' ) );
    }

    $response = wp_remote_post(
        'https://api.openai.com/v1/chat/completions',
        [
            'timeout' => 60,
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
            ],
            'body' => wp_json_encode( [
                'model'       => $model,
                'messages'    => [
                    [ 'role' => 'user', 'content' => $prompt ],
                ],
                'temperature' => 0.7,
                'max_tokens'  => 2000,
            ] ),
        ]
    );

    return techorbit_parse_openai_response( $response );
}

function techorbit_parse_openai_response( $response ) {
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'request_failed', $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( $code !== 200 ) {
        $msg = isset( $data['error']['message'] ) ? $data['error']['message'] : 'OpenAI API error (HTTP ' . $code . ')';
        return new WP_Error( 'api_error', $msg );
    }

    $content = $data['choices'][0]['message']['content'] ?? '';
    if ( empty( $content ) ) {
        return new WP_Error( 'empty_response', __( 'AI returned an empty response. Please try again.', 'techorbit-seo' ) );
    }

    return $content;
}

/* ============================================================
   GOOGLE GEMINI API CALL
   ============================================================ */
function techorbit_call_gemini( $prompt, $model ) {
    $api_key = get_option( 'techorbit_gemini_api_key', '' );
    if ( empty( $api_key ) ) {
        return new WP_Error( 'no_key', __( 'Google Gemini API key is not configured. Please set it in Settings → TechOrbit AI Settings.', 'techorbit-seo' ) );
    }

    $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $api_key;

    $response = wp_remote_post(
        $endpoint,
        [
            'timeout' => 60,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => wp_json_encode( [
                'contents' => [
                    [
                        'parts' => [
                            [ 'text' => $prompt ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 2000,
                ],
            ] ),
        ]
    );

    return techorbit_parse_gemini_response( $response );
}

function techorbit_parse_gemini_response( $response ) {
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'request_failed', $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( $code !== 200 ) {
        $msg = isset( $data['error']['message'] ) ? $data['error']['message'] : 'Gemini API error (HTTP ' . $code . ')';
        return new WP_Error( 'api_error', $msg );
    }

    $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
    if ( empty( $content ) ) {
        return new WP_Error( 'empty_response', __( 'AI returned an empty response. Please try again.', 'techorbit-seo' ) );
    }

    return $content;
}
