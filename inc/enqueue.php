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
    $theme_dir = get_stylesheet_directory();
    $theme_uri = get_stylesheet_directory_uri();

    // Cache-busting: use file modification time so browsers always get latest CSS/JS
    $main_css_ver  = @filemtime( $theme_dir . '/assets/css/main.css' )  ?: '2.0';
    $tools_css_ver = @filemtime( $theme_dir . '/assets/css/tools.css' ) ?: '2.0';
    $main_js_ver   = @filemtime( $theme_dir . '/assets/js/main.js' )    ?: '2.0';
    $ai_js_ver     = @filemtime( $theme_dir . '/assets/js/ai-tools.js' ) ?: '2.0';

    // Google Fonts
    wp_enqueue_style(
        'techorbit-fonts',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:wght@400;500;600&family=JetBrains+Mono:wght@400;600&display=swap',
        [],
        null
    );

    // Main CSS — always fresh
    wp_enqueue_style( 'techorbit-main', $theme_uri . '/assets/css/main.css', [ 'techorbit-fonts' ], $main_css_ver );


    // Tools CSS (only on tool/template pages)
    if ( is_page_template( [
        'templates/page-meta-generator.php',
        'templates/page-blog-outline.php',
        'templates/page-keyword-cluster.php',
        'templates/page-faq-generator.php',
        'templates/page-product-desc.php',
        'templates/page-tools.php',
        'page-tools-single.php',
    ] ) ) {
        wp_enqueue_style( 'techorbit-tools', $theme_uri . '/assets/css/tools.css', [], $tools_css_ver );
    }

    // Main JS
    wp_enqueue_script( 'techorbit-main', $theme_uri . '/assets/js/main.js', [], $main_js_ver, true );

    // AI Tools JS (only on tool pages)
    if ( is_page_template( [
        'templates/page-meta-generator.php',
        'templates/page-blog-outline.php',
        'templates/page-keyword-cluster.php',
        'templates/page-faq-generator.php',
        'templates/page-product-desc.php',
        'page-tools-single.php',
    ] ) ) {
        wp_enqueue_script( 'techorbit-ai-tools', $theme_uri . '/assets/js/ai-tools.js', [ 'techorbit-main' ], $ai_js_ver, true );
    }

    // Localize vars for JS
    wp_localize_script( 'techorbit-main', 'techorbit_vars', [
        'ajax_url'    => admin_url( 'admin-ajax.php' ),
        'nonce'       => wp_create_nonce( 'techorbit_ai_nonce' ),
        'site_url'    => home_url( '/' ),
        'tools_url'   => home_url( '/tools/' ),
        'tools_registry' => techorbit_get_tools_registry(),
        'is_tool_page' => is_page_template( [
            'templates/page-meta-generator.php',
            'templates/page-blog-outline.php',
            'templates/page-keyword-cluster.php',
            'templates/page-faq-generator.php',
            'templates/page-product-desc.php',
            'page-tools-single.php',
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

    wp_enqueue_style( 'techorbit-admin', $theme_uri . '/assets/css/admin.css', [], $admin_css_ver );
    wp_enqueue_script( 'techorbit-admin', $theme_uri . '/assets/js/admin.js', [ 'jquery' ], $admin_js_ver, true );


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
