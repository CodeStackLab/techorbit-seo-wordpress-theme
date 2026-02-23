<?php
/**
 * Enqueue scripts and styles
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
   FRONTEND ENQUEUE
   ============================================================ */
function techorbit_enqueue_scripts() {
    $ver = TECHORBIT_VERSION;

    // Google Fonts
    wp_enqueue_style(
        'techorbit-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;600&display=swap',
        [],
        null
    );

    // Main CSS
    wp_enqueue_style( 'techorbit-main', TECHORBIT_URI . '/assets/css/main.css', [ 'techorbit-fonts' ], $ver );

    // Tools CSS (only on tool/template pages)
    if ( is_page_template( [
        'templates/page-meta-generator.php',
        'templates/page-blog-outline.php',
        'templates/page-keyword-cluster.php',
        'templates/page-faq-generator.php',
        'templates/page-product-desc.php',
        'templates/page-tools.php',
    ] ) ) {
        wp_enqueue_style( 'techorbit-tools', TECHORBIT_URI . '/assets/css/tools.css', [], $ver );
    }

    // Main JS
    wp_enqueue_script( 'techorbit-main', TECHORBIT_URI . '/assets/js/main.js', [], $ver, true );

    // AI Tools JS (only on tool pages)
    if ( is_page_template( [
        'templates/page-meta-generator.php',
        'templates/page-blog-outline.php',
        'templates/page-keyword-cluster.php',
        'templates/page-faq-generator.php',
        'templates/page-product-desc.php',
    ] ) ) {
        wp_enqueue_script( 'techorbit-ai-tools', TECHORBIT_URI . '/assets/js/ai-tools.js', [ 'techorbit-main' ], $ver, true );
    }

    // Localize vars for JS
    wp_localize_script( 'techorbit-main', 'techorbit_vars', [
        'ajax_url'    => admin_url( 'admin-ajax.php' ),
        'nonce'       => wp_create_nonce( 'techorbit_ai_nonce' ),
        'site_url'    => home_url( '/' ),
        'tools_url'   => home_url( '/tools/' ),
        'is_tool_page' => is_page_template( [
            'templates/page-meta-generator.php',
            'templates/page-blog-outline.php',
            'templates/page-keyword-cluster.php',
            'templates/page-faq-generator.php',
            'templates/page-product-desc.php',
        ] ) ? 'yes' : 'no',
        'strings'     => [
            'copy_success'   => __( 'Copied to clipboard!', 'techorbit-seo' ),
            'copy_fail'      => __( 'Copy failed. Please select and copy manually.', 'techorbit-seo' ),
            'ai_generating'  => __( 'AI is generating...', 'techorbit-seo' ),
            'error_generic'  => __( 'Connection error. Please try again.', 'techorbit-seo' ),
            'enter_input'    => __( 'Please enter some input.', 'techorbit-seo' ),
        ],
    ] );
}
add_action( 'wp_enqueue_scripts', 'techorbit_enqueue_scripts' );

/* ============================================================
   ADMIN ENQUEUE
   ============================================================ */
function techorbit_admin_enqueue_scripts( $hook ) {
    // Only load on our plugin settings page
    if ( strpos( $hook, 'techorbit' ) === false ) return;

    $ver = TECHORBIT_VERSION;

    wp_enqueue_style( 'techorbit-admin', TECHORBIT_URI . '/assets/css/admin.css', [], $ver );
    wp_enqueue_script( 'techorbit-admin', TECHORBIT_URI . '/assets/js/admin.js', [ 'jquery' ], $ver, true );

    wp_localize_script( 'techorbit-admin', 'techorbit_admin_vars', [
        'ajax_url'    => admin_url( 'admin-ajax.php' ),
        'nonce'       => wp_create_nonce( 'techorbit_admin_nonce' ),
        'strings'     => [
            'testing'    => __( 'Testing connection...', 'techorbit-seo' ),
            'success'    => __( '✅ Connection successful!', 'techorbit-seo' ),
            'fail'       => __( '❌ Connection failed: ', 'techorbit-seo' ),
            'enter_key'  => __( 'Please enter an API key first.', 'techorbit-seo' ),
        ],
    ] );

    // Media uploader for logo
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'techorbit_admin_enqueue_scripts' );

/* ============================================================
   PRELOAD KEY RESOURCES
   ============================================================ */
function techorbit_preload_resources() {
    ?>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php
}
add_action( 'wp_head', 'techorbit_preload_resources', 1 );
