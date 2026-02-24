<?php
/**
 * Theme Settings — register all options
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register settings with WordPress Options API
 */
function techorbit_register_settings() {
    $settings = [
        // AI
        'techorbit_openai_api_key',
        'techorbit_gemini_api_key',
        'techorbit_default_ai_model',
        'techorbit_openrouter_api_key',
        'techorbit_openrouter_model',
        'techorbit_enable_failover',
        'techorbit_failover_order',
        // AdSense
        'techorbit_adsense_publisher_id',
        'techorbit_adsense_slot_header',
        'techorbit_adsense_slot_content',
        'techorbit_adsense_slot_content_after',
        'techorbit_adsense_slot_sidebar',
        'techorbit_adsense_slot_footer',

        // Branding
        'techorbit_site_logo',
        // Social
        'techorbit_social_twitter',
        'techorbit_social_instagram',
        'techorbit_social_facebook',
        'techorbit_social_youtube',
        'techorbit_social_pinterest',
        // Tools
        'techorbit_tools_status',
    ];

    foreach ( $settings as $option ) {
        register_setting(
            'techorbit_settings_group',
            $option,
            [
                'sanitize_callback' => 'techorbit_sanitize_setting',
                'show_in_rest'      => false,
            ]
        );
    }
}
add_action( 'admin_init', 'techorbit_register_settings' );

/**
 * Sanitize individual settings.
 */
function techorbit_sanitize_setting( $value ) {
    return sanitize_text_field( $value );
}

/**
 * Get all theme settings as an array.
 */
function techorbit_get_settings() {
    return [
        'openai_api_key'        => get_option( 'techorbit_openai_api_key', '' ),
        'gemini_api_key'        => get_option( 'techorbit_gemini_api_key', '' ),
        'default_ai_model'      => get_option( 'techorbit_default_ai_model', 'gemini-flash-latest' ),
        'openrouter_api_key'    => get_option( 'techorbit_openrouter_api_key', '' ),
        'openrouter_model'      => get_option( 'techorbit_openrouter_model', 'google/gemma-2-9b-it:free' ),
        'enable_failover'       => get_option( 'techorbit_enable_failover', '1' ),
        'failover_order'        => get_option( 'techorbit_failover_order', 'openrouter,gemini,openai' ),
        'adsense_publisher_id'  => get_option( 'techorbit_adsense_publisher_id', '' ),
        'adsense_slot_header'   => get_option( 'techorbit_adsense_slot_header', '' ),
        'adsense_slot_content'  => get_option( 'techorbit_adsense_slot_content', '' ),
        'adsense_slot_content_after' => get_option( 'techorbit_adsense_slot_content_after', '' ),
        'adsense_slot_sidebar'  => get_option( 'techorbit_adsense_slot_sidebar', '' ),
        'adsense_slot_footer'   => get_option( 'techorbit_adsense_slot_footer', '' ),

        'site_logo'             => get_option( 'techorbit_site_logo', '' ),
        'social_twitter'        => get_option( 'techorbit_social_twitter', 'https://x.com/PortalYojana' ),
        'social_instagram'      => get_option( 'techorbit_social_instagram', 'https://www.instagram.com/yojanaportal2110/' ),
        'social_facebook'       => get_option( 'techorbit_social_facebook', 'https://www.facebook.com/profile.php?id=61584773969337' ),
        'social_youtube'        => get_option( 'techorbit_social_youtube', 'https://www.youtube.com/@YojanaPortal' ),
        'social_pinterest'      => get_option( 'techorbit_social_pinterest', 'https://www.pinterest.com/yojanaportal/_profile/' ),
    ];
}

/**
 * Available AI models.
 */
function techorbit_ai_models() {
    return [
        'gpt-4o-mini'         => 'GPT-4o Mini (OpenAI — Fast & Cheap)',
        'gpt-4o'              => 'GPT-4o (OpenAI — Most Capable)',
        'gemini-1.5-flash'    => 'Gemini 1.5 Flash (Google — Fast)',
        'gemini-1.5-pro'      => 'Gemini 1.5 Pro (Google — Best Quality)',
        'openrouter-auto'     => 'OpenRouter (Auto Select — Primary)',
    ];
}

/**
 * Check if a model is an OpenRouter model.
 */
function techorbit_is_openrouter( $model ) {
    return str_contains( $model, '/' ) || $model === 'openrouter-auto';
}

/**
 * Check if a model is a Gemini model.
 */
function techorbit_is_gemini( $model ) {
    return str_starts_with( $model, 'gemini' );
}
