<?php
/**
 * TechOrbit SEO — User Email Verification Logic
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. Hook into user registration to mark as unverified and send email.
 */
function techorbit_handle_registration_verification( $user_id ) {
    // Generate a unique token
    $token = wp_generate_password( 32, false );
    
    // Store token and mark as unverified
    update_user_meta( $user_id, 'techorbit_verification_token', $token );
    update_user_meta( $user_id, 'techorbit_is_verified', '0' );
    
    // Send the verification email
    techorbit_send_verification_email( $user_id, $token );
}
add_action( 'user_register', 'techorbit_handle_registration_verification' );

/**
 * 2. Send verification email using wp_mail (which will go through Brevo SMTP).
 */
function techorbit_send_verification_email( $user_id, $token ) {
    $user = get_userdata( $user_id );
    if ( ! $user ) return;

    $to      = $user->user_email;
    $subject = '[' . get_bloginfo( 'name' ) . '] Please Verify Your Email';
    
    $verify_url = add_query_arg( [
        'techorbit_verify' => $token,
        'user_id'          => $user_id
    ], home_url( '/login/' ) );

    $message  = "Hello " . $user->display_name . ",\r\n\r\n";
    $message .= "Thank you for registering at " . get_bloginfo( 'name' ) . ".\r\n";
    $message .= "To complete your registration and activate your account, please click the link below:\r\n\r\n";
    $message .= $verify_url . "\r\n\r\n";
    $message .= "If you did not register, please ignore this email.\r\n\r\n";
    $message .= "Best regards,\r\n";
    $message .= get_bloginfo( 'name' ) . " Team";

    wp_mail( $to, $subject, $message );
}

/**
 * 3. Handle verification URL when user clicks the link.
 */
function techorbit_process_email_verification() {
    if ( ! isset( $_GET['techorbit_verify'] ) || ! isset( $_GET['user_id'] ) ) {
        return;
    }

    $token   = sanitize_text_field( $_GET['techorbit_verify'] );
    $user_id = intval( $_GET['user_id'] );
    
    $saved_token = get_user_meta( $user_id, 'techorbit_verification_token', true );
    $is_verified = get_user_meta( $user_id, 'techorbit_is_verified', true );

    if ( $saved_token === $token && $is_verified !== '1' ) {
        update_user_meta( $user_id, 'techorbit_is_verified', '1' );
        delete_user_meta( $user_id, 'techorbit_verification_token' );
        
        // Redirect to login with success message
        wp_redirect( add_query_arg( 'verified', 'success', home_url( '/login/' ) ) );
        exit;
    }
}
add_action( 'template_redirect', 'techorbit_process_email_verification' );

/**
 * 4. Block login for unverified users.
 */
function techorbit_block_unverified_login( $user, $username, $password ) {
    if ( is_wp_error( $user ) || ! $user instanceof WP_User ) {
        return $user;
    }

    $is_verified = get_user_meta( $user->ID, 'techorbit_is_verified', true );
    
    // If meta doesn't exist (legacy users), we assume verified or handle accordingly
    // For new flow, '0' means unverified
    if ( $is_verified === '0' ) {
        return new WP_Error( 'email_unverified', __( '<strong>Error</strong>: Your email address is not verified. Please check your inbox for the activation link.', 'techorbit-seo' ) );
    }

    return $user;
}
add_filter( 'authenticate', 'techorbit_block_unverified_login', 30, 3 );
