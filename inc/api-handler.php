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
    $primary_model = 'gemini-flash-lite-latest'; 
    $enable_failover = true;
    
    // Failover order
    $failover_order = [ 'groq', 'gemini', 'openai', 'openrouter', 'free' ];
    
    // 5. Build prompt
    $prompt = techorbit_build_prompt( $tool, $user_input, $input2 );
    if ( is_wp_error( $prompt ) ) {
        wp_send_json_error( [ 'message' => $prompt->get_error_message() ] );
    }
    
    // 6. Call AI with Failover Loop
    $final_result = null;
    $errors       = [];

    foreach ( $failover_order as $provider ) {
        $result = null;

        switch ( $provider ) {
            case 'gemini':
                // Use Gemini Flash-Lite Latest (highest quota availability)
                $result = techorbit_call_gemini( $prompt, 'gemini-1.5-flash' );
                break;
            case 'groq':
                $result = techorbit_call_groq( $prompt, 'llama-3.3-70b-versatile' );
                break;
            case 'openai':
                $result = techorbit_call_openai( $prompt, 'gpt-4o-mini' );
                break;
            case 'openrouter':
                $result = techorbit_call_openrouter( $prompt, 'google/gemma-2-9b-it:free' );
                break;
            case 'free':
                $result = techorbit_call_openrouter( $prompt, 'google/gemma-2-9b-it:free' );
                break;
        }

        if ( $result && ! is_wp_error( $result ) ) {
            $final_result = $result;
            break; 
        } else if ( is_wp_error( $result ) ) {
            $errors[] = strtoupper($provider) . ': ' . $result->get_error_message();
            if ( ! $enable_failover ) break; 
        }
    }

    if ( ! $final_result ) {
        $error_msg = __( 'API not working. All providers are currently unavailable.', 'techorbit-seo' );
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
        'meta-generator' => "You are an Elite SEO strategist. Analyze the topic: {INPUT}.
            Generate a single, perfect SEO Meta Title and Meta Description.
            Format the response exactly like this:
            
            ### 🏷️ Optimized Meta Title
            [Your Title Here]
            
            ### 📝 Optimized Meta Description
            [Your Description Here]
            
            ### 🎯 SEO Strategy & Reasoning
            [Brief explanation of why this works]
            
            Return ONLY standard Markdown text. Do NOT use JSON.",
            
        'blog-outline'   => "You are a Content Architecture Specialist. Create a strict, semantic SEO blog OUTLINE for: {INPUT}. 
            CRITICAL INSTRUCTION: DO NOT write paragraphs of blog content. ONLY output the structured outline (headings and short bullet points). If you write a full article, you have failed.
            Include:
            - A click-worthy H1 title.
            - Logical H2, H3, and H4 sections.
            - For each section, provide 2-3 short bullet points of what to cover.
            - LSI keywords to weave into the content.
            - Search intent analysis (Informational/Commercial).
            Format with clear Markdown headers and bullet points only.",

        'keyword-cluster' => "You are a Semantic Search Expert. For the keyword '{INPUT}', generate a 5-pillar Keyword Cluster strategy.
            For each pillar, provide:
            - Pillar Name & Primary Keyword.
            - 5-7 supporting Long-tail keywords.
            - User Search Intent (Detailed).
            - Content Type recommendation (e.g., Guide, Review, Comparison).
            Return ONLY valid JSON array: [{\"cluster\": \"...\", \"primary\": \"...\", \"keywords\": [\"...\"], \"intent\": \"...\", \"strategy\": \"...\"}]",

        'faq-generator'   => "Generate a valid Schema.org FAQPage JSON-LD block for the topic: {INPUT}. 
            Requirements:
            1. Questions must reflect actual user search queries.
            2. Answers must be concise and SEO-friendly.
            3. Return ONLY the JSON-LD code block wrapped in triple backticks.
            4. Do NOT include any introductory or concluding text.",

        'product-desc'    => "You are a Conversion-Focused Copywriter. Write a premium, benefit-driven product description for: {INPUT}.
            Context: {INPUT2}.
            Structure:
            1. Hook: 1 punchy sentence.
            2. Features vs Benefits Table: 4-5 items.
            3. Body: 200 words of persuasive storytelling.
            4. SEO Keywords used: List 5 keywords.
            Maintain a luxury/premium tone.",

        'og-tag-generator' => "Generate professional Open Graph (OG) and Twitter Card tags for: {INPUT}. 
            Format:
            1. Provide the Meta Tags in a standard Markdown code block.
            2. Follow with a brief explanation of why these tags matter for SEO.",

        'robots-generator' => "Generate a sophisticated robots.txt file for a modern WordPress site specialized in: {INPUT}. 
            Format:
            1. Provide the robots.txt content in a standard Markdown code block.
            2. Follow with a brief explanation of the rules included.",

        'sitemap-helper'   => "Analyze the sitemap requirements for a '{INPUT}' website.
            Provide:
            - A conceptual XML structure.
            - Priority and Changefreq value recommendations for different page types.
            - 5 tips for sitemap optimization that competitors often miss.",

        'canonical-advisor' => "Act as a Technical SEO Consultant. Explain the canonical strategy for {INPUT}.
            Detail:
            - When to use self-referencing tags.
            - How to handle pagination and tracking parameters.
            - Provide 3 specific <link rel='canonical'> examples for different scenarios.",

        'title-analyzer'  => "Analyze this title for viral and SEO potential: '{INPUT}'.
            Provide:
            - SEO Score (1-100).
            - Emotional Impact Score (1-100).
            - 5 Actionable 'Pro Fixes' to make it rank higher and get more clicks.
            - 3 'Power Move' alternatives.",

        // Technical & Advanced
        'schema-generator' => "Generate an advanced {INPUT2} Schema JSON-LD for {INPUT}. 
            Ensure it includes all required and recommended fields by schema.org. 
            Provide the code in a copy-pasteable <script> tag followed by a simple breakdown of the fields included.",

        'twitter-card'    => "Generate optimized Twitter/X Card meta tags for: {INPUT}. 
            Include Large Image card specifications and a summary of how this will appear in the feed.",

        'alt-text-generator' => "You are an Accessibility and SEO Specialist. Generate 5 variations of descriptive Alt Text for an image described as: {INPUT}. 
            Include: 1. Descriptive (General), 2. SEO-Focused, 3. Narrative, 4. Decorative, 5. Short/Punchy.",

        'vitals-advisor'  => "Act as a Web Performance Engineer. Provide a detailed step-by-step audit guide to improve LCP, INP, and CLS for a page about {INPUT}. 
            Include specific tools to use and code-level optimization tips (e.g., fetchpriority, font-display).",

        // Content & Strategy
        'blog-topic'      => "Generate 15 advanced blog topic ideas for: {INPUT}. 
            CRITICAL INSTRUCTION: DO NOT write actual blog posts. ONLY provide the 15 titles and brief explanations.
            Categorize them by:
            - The 'What is' (Top of Funnel).
            - The 'How to' (Middle of Funnel).
            - The 'Comparison/Vs' (Bottom of Funnel).
            Briefly explain why each will attract traffic.",
        
        'paragraph-expander' => "Expand this concept: {INPUT}. 
            Constraints: {INPUT2}.
            CRITICAL INSTRUCTION: ONLY write the 3 requested paragraphs. Do not write a full blog post. Do not include titles.
            Deliver: 3 rich paragraphs with a smooth transition. Use high-level vocabulary and ensure a 'Thought Leadership' tone. Include data-driven sounding arguments where logical.",

        'social-caption'  => "Generate a 3-part social media content series for: {INPUT}.
            1. The 'Story/Hook' Post.
            2. The 'Value/Education' Post.
            3. The 'Direct Offer' Post.
            Include specific emojis, spacing for readability, and 30 targeted hashtags.",

        'twitter-thread'  => "Create a 10-tweet viral Twitter/X thread based on: {INPUT}. 
            Tweet 1 must be a viral hook. Tweet 10 must be a Call to Action. Ensure each tweet flows into the next with 'scrolling' psychology.",
        // Missed Content Tools
        'content-summarizer' => "Summarize the primary takeaways from this content: {INPUT}.
            Extract exactly 5 key bullet points. Do not include introductory text.",

        'headline-analyzer' => "Analyze this headline: {INPUT}.
            Give a score out of 100 for clickability and SEO value.
            Provide 3 alternative optimized headlines.",

        'intro-generator' => "Write ONLY an engaging, SEO-optimized blog INTRODUCTION (1-2 paragraphs max) for the topic: {INPUT}.
            CRITICAL INSTRUCTION: DO NOT write the rest of the blog post. Only the introduction.
            Use the PAS (Problem-Agitation-Solution) copywriting framework.
            Include a hook to keep the reader interested.",

        'conclusion-writer' => "Write a powerful conclusion for a blog post about: {INPUT}.
            Include a wrap-up of the main points and a strong Call to Action (CTA).",

        'article-rewriter' => "Rewrite the following content to be 100% unique while preserving the original meaning: {INPUT}.
            CRITICAL INSTRUCTION: ONLY rewrite the provided text. Do not add new sections or expand it into a longer blog post.
            Ensure a professional, engaging tone.",

        // Keyword Tools
        'lsi-generator' => "Generate 20 LSI (Latent Semantic Indexing) keywords for the main topic: {INPUT}.
            Format as a bulleted list.",

        'long-tail-finder' => "Give me 15 high-converting long-tail keyword variations for: {INPUT}.
            Include the estimated search intent (Informational, Navigational, Transactional) for each.",

        'intent-analyzer' => "Analyze the search intent for the keyword: {INPUT}.
            Is the user looking to buy, learn, or find a specific website?
            Provide content recommendations to satisfy this intent.",

        'difficulty-estimator' => "Estimate the SEO difficulty for ranking for the keyword: {INPUT}.
            Provide a rating (Low, Medium, High) and explain what kind of backlinks/content length would be required to compete.",

        'competitor-spy' => "Act as a competitor research analyst. What are the top 5 semantic keyword themes a competitor ranking for '{INPUT}' is likely targeting?
            Provide a brief strategic overview.",

        // Technical Tools
        'hreflang-builder' => "Generate standard hreflang HTML link tags for a webpage about {INPUT}.
            Include variations for English (US, UK), Spanish, and French. Format as a valid HTML code block.",

        'json-ld-generator' => "Generate a basic JSON-LD Article Schema for {INPUT}.
            Use placeholder values for Author and Publisher if not provided. Enclose in a <script> tag.",

        // Social Tools
        'hashtag-generator' => "Generate 30 highly relevant, trending hashtags for a social media post about: {INPUT}.
            Group them into: Broad, Niche, and Community hashtags.",

        'linkedin-writer' => "Write a professional, engagement-driven LinkedIn post about: {INPUT}.
            Use formatting, emojis, and end with an engaging question to drive comments.",

        'ad-copy' => "Write persuasive Google Ads copy for: {INPUT}.
            Include 3 Variations of Headlines (max 30 characters each) and 3 Variations of Descriptions (max 90 characters each).",
            
        'email-subject' => "Generate 10 highly clickable email subject lines for a campaign about: {INPUT}.
            Include a mix of curiosity, urgency, and direct benefit angles.",

        'cta-generator' => "Generate 10 powerful Call-to-Action (CTA) phrases for a landing page about: {INPUT}.
            Focus on conversion rate optimization (CRO) principles.",
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
            'sslverify' => false,
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
    $api_key = get_option( 'techorbit_gemini_api_key', 'AIzaSyCR_TJyuF4dFdzEAVzqoWLgp8Sw0cunyH0' );
    if ( empty( $api_key ) ) {
        $api_key = 'AIzaSyCR_TJyuF4dFdzEAVzqoWLgp8Sw0cunyH0';
    }

    $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $api_key;

    $response = wp_remote_post(
        $endpoint,
        [
            'timeout' => 60,
            'sslverify' => false,
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
            'sslverify' => false,
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

/* ============================================================
   GROQ API CALL (OpenAI Compatible)
   ============================================================ */
function techorbit_call_groq( $prompt, $model ) {
    $api_key = get_option( 'techorbit_groq_api_key', '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' );
    if ( empty( $api_key ) ) {
        $api_key = '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';
    }

    $response = wp_remote_post(
        'https://api.groq.com/openai/v1/chat/completions',
        [
            'timeout' => 60,
            'sslverify' => false,
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

    return techorbit_parse_groq_response( $response );
}

function techorbit_parse_groq_response( $response ) {
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'request_failed', $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( $code !== 200 ) {
        $msg = isset( $data['error']['message'] ) ? $data['error']['message'] : 'Groq API error (HTTP ' . $code . ')';
        return new WP_Error( 'api_error', $msg );
    }

    $content = $data['choices'][0]['message']['content'] ?? '';
    if ( empty( $content ) ) {
        return new WP_Error( 'empty_response', __( 'AI returned an empty response. Please try again.', 'techorbit-seo' ) );
    }

    return $content;
}
