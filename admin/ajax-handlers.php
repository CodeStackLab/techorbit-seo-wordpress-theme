<?php
/**
 * Admin AJAX Handlers — API connection test
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Test API connection from admin panel.
 */
function techorbit_test_api_connection() {
    if ( ! check_ajax_referer( 'techorbit_admin_nonce', 'nonce', false ) || ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => __( 'Unauthorized.', 'techorbit-seo' ) ] );
    }

    $provider = sanitize_key( $_POST['provider'] ?? '' );
    $api_key  = sanitize_text_field( $_POST['api_key'] ?? '' );

    if ( empty( $provider ) || empty( $api_key ) ) {
        wp_send_json_error( [ 'message' => __( 'Provider and API key are required.', 'techorbit-seo' ) ] );
    }

    if ( $provider === 'openai' ) {
        $result = techorbit_test_openai( $api_key );
    } elseif ( $provider === 'gemini' ) {
        $result = techorbit_test_gemini( $api_key );
    } else {
        wp_send_json_error( [ 'message' => __( 'Unknown provider.', 'techorbit-seo' ) ] );
    }

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( [ 'message' => $result->get_error_message() ] );
    }

    wp_send_json_success( [ 'message' => __( 'Connection successful! API key is valid.', 'techorbit-seo' ) ] );
}
add_action( 'wp_ajax_techorbit_test_api', 'techorbit_test_api_connection' );

/**
 * Test OpenAI key by listing models.
 */
function techorbit_test_openai( $api_key ) {
    $response = wp_remote_get(
        'https://api.openai.com/v1/models',
        [
            'timeout' => 15,
            'headers' => [
                'Authorization' => 'Bearer ' . $api_key,
            ],
        ]
    );

    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'conn_fail', $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );
    if ( $code !== 200 ) {
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        $msg  = $body['error']['message'] ?? 'Invalid API key or account issue.';
        return new WP_Error( 'api_fail', $msg );
    }

    return true;
}

/**
 * Test Gemini key with a minimal generate request.
 */
function techorbit_test_gemini( $api_key ) {
    $endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $api_key;

    $response = wp_remote_post(
        $endpoint,
        [
            'timeout' => 15,
            'headers' => [ 'Content-Type' => 'application/json' ],
            'body'    => wp_json_encode( [
                'contents' => [
                    [ 'parts' => [ [ 'text' => 'Say "ok" in one word.' ] ] ],
                ],
                'generationConfig' => [ 'maxOutputTokens' => 5 ],
            ] ),
        ]
    );

    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'conn_fail', $response->get_error_message() );
    }

    $code = wp_remote_retrieve_response_code( $response );
    if ( $code !== 200 ) {
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        $msg  = $body['error']['message'] ?? 'Invalid API key or quota issue.';
        return new WP_Error( 'api_fail', $msg );
    }

    return true;
}
