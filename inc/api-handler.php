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

    // 4. Get settings
    $settings      = techorbit_get_settings();
    $primary_model = $settings['default_ai_model'];
    $enable_failover = $settings['enable_failover'];
    $failover_order  = explode( ',', $settings['failover_order'] );
    
    // Always include a free model as a final survival fallback
    if ( ! in_array( 'free', $failover_order ) ) {
        $failover_order[] = 'free';
    }

    // 5. Build prompt
    $prompt = techorbit_build_prompt( $tool, $user_input, $input2 );
    if ( is_wp_error( $prompt ) ) {
        wp_send_json_error( [ 'message' => $prompt->get_error_message() ] );
    }

    // 6. Call AI with Failover Loop
    $final_result = null;
    $errors       = [];

    foreach ( $failover_order as $provider ) {
        $provider = trim( $provider );
        $result   = null;

        switch ( $provider ) {
            case 'openrouter':
                $or_model = $settings['openrouter_model'] ?: 'google/gemma-2-9b-it:free';
                $result   = techorbit_call_openrouter( $prompt, $or_model );
                break;
            case 'gemini':
                $gem_model = str_starts_with( $primary_model, 'gemini' ) ? $primary_model : 'gemini-1.5-flash';
                $result    = techorbit_call_gemini( $prompt, $gem_model );
                break;
            case 'openai':
                $oa_model = str_starts_with( $primary_model, 'gpt' ) ? $primary_model : 'gpt-4o-mini';
                $result   = techorbit_call_openai( $prompt, $oa_model );
                break;
            case 'free':
                // Absolute fallback using a free OpenRouter model
                $result = techorbit_call_openrouter( $prompt, 'google/gemma-2-9b-it:free' );
                break;
        }

        if ( $result && ! is_wp_error( $result ) ) {
            $final_result = $result;
            break; // Success! Exit loop.
        } else if ( is_wp_error( $result ) ) {
            $errors[] = strtoupper($provider) . ': ' . $result->get_error_message();
            if ( ! $enable_failover ) break; // Stop if failover is disabled
        }
    }

    if ( ! $final_result ) {
        $error_msg = __( 'All AI providers failed or reached limits.', 'techorbit-seo' );
        if ( ! empty( $errors ) ) {
            $error_msg .= ' Details: ' . implode( ' | ', $errors );
        }
        wp_send_json_error( [ 'message' => $error_msg ] );
    }

    wp_send_json_success( [ 'result' => $final_result, 'tool' => $tool ] );
}
add_action( 'wp_ajax_techorbit_ai_call', 'techorbit_ai_call' );
add_action( 'wp_ajax_nopriv_techorbit_ai_call', 'techorbit_ai_call' );

/* ============================================================
   PROMPT BUILDER
   ============================================================ */
function techorbit_build_prompt( $tool, $input, $input2 = '' ) {
    $prompts = [
        // SEO Tools
        'meta-generator' => "You are an SEO expert. Generate an optimized SEO meta title (max 60 characters) and meta description (max 160 characters) for the following topic: {INPUT}. Return ONLY valid JSON in this exact format: {\"title\": \"...\", \"description\": \"...\"}",
        'blog-outline'   => "You are an SEO content strategist. Create a detailed SEO-optimized blog post outline for the topic: {INPUT}. Include an H1 title, multiple H2 sections with H3 sub-sections, an introduction hook, and a conclusion section. Format as a clean structured outline with proper indentation.",
        'keyword-cluster' => "You are an SEO keyword research expert. Generate 5 keyword clusters for the main keyword: {INPUT}. For each cluster provide: cluster name, 5 related long-tail keywords, and search intent (informational/commercial/transactional/navigational). Return ONLY valid JSON array in this format: [{\"cluster\": \"...\", \"keywords\": [\"...\"], \"intent\": \"...\"}]",
        'faq-generator'   => "Generate 8 SEO-optimized frequently asked questions and answers for the topic: {INPUT}. Format the output as a valid Schema.org FAQPage JSON-LD <script> tag, ready to paste into HTML. Only output the complete script tag with no other text.",
        'product-desc'    => "You are an e-commerce SEO copywriter. Write an SEO-optimized product description for: {INPUT}. Key features and details: {INPUT2}. Include the focus keyword naturally, use benefits-first writing style, and end with a soft call to action. Write 150-300 words in a professional yet engaging tone.",
        'og-tag-generator' => "Generate Open Graph (OG) meta tags for: {INPUT}. Include og:title, og:description, og:type, and og:site_name. Return the raw HTML meta tags.",
        'robots-generator' => "Generate a robots.txt file content for a website about: {INPUT}. Include standard rules for Sitemap and disallow rules for common sensitive paths like /admin, /wp-admin, etc.",
        'sitemap-helper'   => "Create an XML sitemap checklist or a mock XML sitemap structure for: {INPUT}. Explain best practices for sitemap priority and frequency.",
        'canonical-advisor' => "Explain the correct canonical tag strategy for a page about {INPUT}. Provide the specific <link rel='canonical'> tag based on the provided topic.",
        'title-analyzer'  => "Analyze the SEO effectiveness of this title: {INPUT}. provide a score out of 100, and give 3 actionable suggestions to improve focus keywords, length, and click-through rate.",

        // Content Tools
        'blog-topic'      => "Generate 10 trending and high-volume blog topic ideas for the keyword: {INPUT}. For each topic, explain why it's likely to perform well based on search intent.",
        'paragraph-expander' => "Expand this short text into a rich, detailed, and SEO-friendly paragraph: {INPUT}. Context/Keywords to include: {INPUT2}. Maintain a professional and informative tone.",
        'content-summarizer' => "Summarize the following content into 5 key bullet points: {INPUT}. Ensure the summary captures the main value propositions and takeaways.",
        'headline-analyzer' => "Analyze this headline: {INPUT}. Provide specific scores for Emotional Marketing Value (EMV), length, and keyword presence. Suggest 3 better alternatives.",
        'intro-generator' => "Write a compelling blog post introduction for: {INPUT}. Use a hook (question, stat, or story) to engage readers and naturally include the focus keyword.",
        'conclusion-writer' => "Write a strong conclusion for a blog post about: {INPUT}. Summarize the key points and include a clear call to action (CTA).",
        'article-rewriter' => "Rewrite this article content to be fresh and unique while preserving the original meaning and SEO value: {INPUT}.",

        // Keyword Tools
        'lsi-generator'   => "Generate 20 LSI (Latent Semantic Indexing) keywords related to: {INPUT}. These should be semantically related terms that help Google understand page context.",
        'long-tail-finder' => "Find 15 low-competition long-tail keyword variations for the main keyword: {INPUT}. Include estimated search intent for each.",
        'intent-analyzer' => "Analyze the search intent for these keywords: {INPUT}. Categorize each as Informational, Navigational, Transactional, or Commercial Investigation.",
        'difficulty-estimator' => "Estimate the SEO keyword difficulty (0-100) for: {INPUT}. Explain the factors considered (backlinks needed, content quality, domain authority of competitors).",
        'competitor-spy'  => "List 10 potential keywords that competitors in the '{INPUT}' niche are likely ranking for. Provide strategies to outrank them.",

        // Technical Tools
        'schema-generator' => "Generate JSON-LD schema markup for a {INPUT2} about {INPUT}. Return only the valid JSON-LD <script> tag.",
        'twitter-card'    => "Generate Twitter Card meta tags for: {INPUT}. Include twitter:card, twitter:title, and twitter:description. Return raw HTML meta tags.",
        'alt-text-generator' => "Generate SEO-friendly and accessible Alt Text for an image described as: {INPUT}. Include relevant keywords naturally.",
        'vitals-advisor'  => "Provide actionable tips to improve Core Web Vitals (LCP, CLS, INP) for a page about {INPUT}. Focus on technical optimizations.",
        'hreflang-builder' => "Generate hreflang tags for a website about {INPUT} with versions in English (US), Spanish (ES), and French (FR). Return raw HTML link tags.",
        'json-ld-generator' => "Create a custom JSON-LD structured data snippet for {INPUT}. Focus on accuracy and schema.org compliance.",

        // Social & Copy
        'social-caption'  => "Write 5 engaging social media captions (Instagram, Facebook, LinkedIn) for: {INPUT}. Include relevant emojis and 5 hashtags for each.",
        'hashtag-generator' => "Generate 30 relevant hashtags for: {INPUT}, categorized by popularity (High, Medium, Low volume).",
        'linkedin-writer'  => "Write a professional LinkedIn post about: {INPUT}. Include a strong opening hook, value-driven body content, and an engagement question.",
        'twitter-thread'  => "Generate a 5-tweet Twitter thread based on the topic/content: {INPUT}. Each tweet should be under 280 characters and flow logically.",
        'ad-copy'         => "Write 3 high-converting Google Ads headlines and 2 descriptions for: {INPUT}. Focus on benefits and strong CTAs.",
        'email-subject'   => "Generate 10 irresistible email subject lines for: {INPUT}. Include at least 3 curiosity-based, 3 urgency-based, and 4 benefit-based options.",
        'cta-generator'    => "Generate 5 powerful Call-to-Action (CTA) phrases for a landing page about {INPUT}. Vary the intent (e.g., 'Get Started', 'Download Now', 'Learn More').",
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

/* ============================================================
   OPENROUTER API CALL
   ============================================================ */
function techorbit_call_openrouter( $prompt, $model ) {
    $api_key = get_option( 'techorbit_openrouter_api_key', '' );
    if ( empty( $api_key ) ) {
        return new WP_Error( 'no_key', __( 'OpenRouter API key is not configured.', 'techorbit-seo' ) );
    }

    $response = wp_remote_post(
        'https://openrouter.ai/api/v1/chat/completions',
        [
            'timeout' => 60,
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type'  => 'application/json',
                'HTTP-Referer'  => home_url(),
                'X-Title'       => 'TechOrbit SEO AI Toolkit',
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

    return techorbit_parse_openrouter_response( $response );
}

function techorbit_parse_openrouter_response( $response ) {
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'request_failed', $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( $code !== 200 ) {
        $msg = isset( $data['error']['message'] ) ? $data['error']['message'] : 'OpenRouter API error (HTTP ' . $code . ')';
        return new WP_Error( 'api_error', $msg );
    }

    $content = $data['choices'][0]['message']['content'] ?? '';
    if ( empty( $content ) ) {
        return new WP_Error( 'empty_response', __( 'AI returned an empty response.', 'techorbit-seo' ) );
    }

    return $content;
}
