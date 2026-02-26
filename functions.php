<?php
/**
 * TechOrbit SEO — Functions
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'TECHORBIT_VERSION', '1.0.0' );
define( 'TECHORBIT_DIR', get_template_directory() );
define( 'TECHORBIT_URI', get_template_directory_uri() );

/* ============================================================
   THEME SETUP
   ============================================================ */
function techorbit_setup() {
    load_theme_textdomain( 'techorbit-seo', TECHORBIT_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style',
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );

    // Menus
    register_nav_menus( [
        'primary'  => __( 'Primary Menu', 'techorbit-seo' ),
        'footer'   => __( 'Footer Menu', 'techorbit-seo' ),
        'footer-2' => __( 'Footer Menu Tools', 'techorbit-seo' ),
    ] );

    // Image sizes
    add_image_size( 'techorbit-card', 800, 450, true );
    add_image_size( 'techorbit-hero', 1600, 700, true );

    // Content width
    global $content_width;
    if ( ! isset( $content_width ) ) {
        $content_width = 800;
    }
}
add_action( 'after_setup_theme', 'techorbit_setup' );

/* ============================================================
   WIDGETS / SIDEBARS
   ============================================================ */
function techorbit_widgets_init() {
    register_sidebar( [
        'name'          => __( 'Primary Sidebar', 'techorbit-seo' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here.', 'techorbit-seo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );

    register_sidebar( [
        'name'          => __( 'Tool Page Sidebar', 'techorbit-seo' ),
        'id'            => 'sidebar-tools',
        'description'   => __( 'Shown on AI tool pages.', 'techorbit-seo' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ] );
}
add_action( 'widgets_init', 'techorbit_widgets_init' );

/* ============================================================
   LOAD INCLUDES
   ============================================================ */
require_once TECHORBIT_DIR . '/inc/settings.php';
require_once TECHORBIT_DIR . '/inc/tools-config.php';
require_once TECHORBIT_DIR . '/inc/enqueue.php';
require_once TECHORBIT_DIR . '/inc/api-handler.php';
require_once TECHORBIT_DIR . '/inc/seo-meta.php';
require_once TECHORBIT_DIR . '/inc/auth-verification.php';

// Admin
if ( is_admin() ) {
    require_once TECHORBIT_DIR . '/admin/admin-page.php';
    require_once TECHORBIT_DIR . '/admin/ajax-handlers.php';
}

/* ============================================================
   HELPER FUNCTIONS
   ============================================================ */

/**
 * Returns an AdSense block from theme settings.
 * @param string $slot 'header'|'content'|'content_after'|'sidebar'|'footer'
 */
function techorbit_adsense( $slot = 'content' ) {
    $settings = techorbit_get_settings();
    $pub_id   = $settings['adsense_publisher_id'] ?? '';
    
    $slot_ids  = [
        'header'        => $settings['adsense_slot_header'] ?? '',
        'content'       => $settings['adsense_slot_content'] ?? '',
        'content_after' => $settings['adsense_slot_content_after'] ?? '',
        'sidebar'       => $settings['adsense_slot_sidebar'] ?? '',
        'footer'        => $settings['adsense_slot_footer'] ?? '',
    ];
    $slot_id = isset( $slot_ids[ $slot ] ) ? $slot_ids[ $slot ] : '';

    // STRICT: If no pub_id or no slot_id, hide EVERYTHING (labels, spacers, etc)
    if ( ! $pub_id || ! $slot_id ) {
        return;
    }

    $format = ( $slot === 'header' ) ? 'auto' : 'auto';
    ?>
    <div class="adsense-slot adsense-zone-<?php echo esc_attr( $slot ); ?>">
        <p class="ad-label"><?php esc_html_e( 'Advertisement', 'techorbit-seo' ); ?></p>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="<?php echo esc_attr( $pub_id ); ?>"
             data-ad-slot="<?php echo esc_attr( $slot_id ); ?>"
             data-ad-format="<?php echo esc_attr( $format ); ?>"
             data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
    <?php
}


/**
 * Social links array from theme options.
 */
function techorbit_social_links() {
    return [
        'twitter'   => [
            'url'   => get_option( 'techorbit_social_twitter', 'https://x.com/PortalYojana' ),
            'label' => 'Twitter / X',
            'icon'  => '𝕏',
        ],
        'instagram' => [
            'url'   => get_option( 'techorbit_social_instagram', 'https://www.instagram.com/yojanaportal2110/' ),
            'label' => 'Instagram',
            'icon'  => '📷',
        ],
        'facebook'  => [
            'url'   => get_option( 'techorbit_social_facebook', 'https://www.facebook.com/profile.php?id=61584773969337' ),
            'label' => 'Facebook',
            'icon'  => '🔵',
        ],
        'youtube'   => [
            'url'   => get_option( 'techorbit_social_youtube', 'https://www.youtube.com/@YojanaPortal' ),
            'label' => 'YouTube',
            'icon'  => '▶',
        ],
        'pinterest' => [
            'url'   => get_option( 'techorbit_social_pinterest', 'https://www.pinterest.com/yojanaportal/_profile/' ),
            'label' => 'Pinterest',
            'icon'  => '📌',
        ],
    ];
}

/**
 * Force Blog Template for /blog/ page
 */
add_filter('template_include', function($template) {
    if (is_front_page()) return $template; // Don't interfere with home
    
    // Check if we are on the blog page by URL path or slug
    $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, '/blog/') !== false) {
        $new_template = locate_template(['templates/page-blog.php']);
        if (!empty($new_template)) {
            return $new_template;
        }
    }
    return $template;
}, 99);

/**
 * Returns reading time estimate.
 */
function techorbit_reading_time( $post_id = null ) {
    $content    = get_post_field( 'post_content', $post_id );
    $word_count = str_word_count( strip_tags( $content ) );
    $minutes    = ceil( $word_count / 200 );
    return $minutes . ' min read';
}

/**
 * Excerpt with custom length.
 */
function techorbit_excerpt( $post_id = null, $length = 25 ) {
    $text = get_the_excerpt( $post_id );
    if ( ! $text ) {
        $text = get_the_content( null, false, $post_id );
        $text = strip_shortcodes( $text );
        $text = wp_strip_all_tags( $text );
    }
    return wp_trim_words( $text, $length, '...' );
}

/**
 * Allowed HTML for tool output.
 */
function techorbit_allowed_html() {
    return [
        'div'  => [ 'class' => [] ],
        'p'    => [ 'class' => [] ],
        'span' => [ 'class' => [] ],
        'h1'   => [], 'h2' => [], 'h3' => [], 'h4' => [], 'h5' => [],
        'ul'   => [], 'ol' => [],
        'li'   => [],
        'strong' => [], 'em' => [], 'b' => [], 'i' => [],
        'br'   => [],
        'code' => [ 'class' => [] ],
        'pre'  => [ 'class' => [] ],
        'a'    => [ 'href' => [], 'target' => [], 'rel' => [] ],
    ];
}
/**
 * Output social SVG icon by key.
 */
function techorbit_social_svg( $key ) {
    $icons = [
        'twitter'   => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        'instagram' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
        'facebook'  => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
        'youtube'   => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
        'pinterest' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 0 1 .083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.632-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0z"/></svg>',
    ];
    echo isset( $icons[ $key ] ) ? $icons[ $key ] : '';
}
