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
require_once TECHORBIT_DIR . '/inc/enqueue.php';
require_once TECHORBIT_DIR . '/inc/api-handler.php';
require_once TECHORBIT_DIR . '/inc/seo-meta.php';

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
 * @param string $slot 'header'|'content'|'sidebar'
 */
function techorbit_adsense( $slot = 'content' ) {
    $pub_id    = get_option( 'techorbit_adsense_publisher_id', '' );
    $slot_ids  = [
        'header'  => get_option( 'techorbit_adsense_slot_header', '' ),
        'content' => get_option( 'techorbit_adsense_slot_content', '' ),
        'sidebar' => get_option( 'techorbit_adsense_slot_sidebar', '' ),
    ];
    $slot_id = isset( $slot_ids[ $slot ] ) ? $slot_ids[ $slot ] : '';

    if ( ! $pub_id || ! $slot_id ) {
        // Placeholder when not configured
        echo '<div class="adsense-slot adsense-placeholder"><span>Advertisement</span></div>';
        return;
    }

    $format = ( $slot === 'header' ) ? 'auto' : 'auto';
    ?>
    <div class="adsense-slot">
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
