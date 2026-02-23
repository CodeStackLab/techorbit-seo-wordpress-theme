<?php
/**
 * SEO Meta Tags Output
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Output SEO meta tags in <head>.
 */
function techorbit_seo_meta() {
    global $post;

    // Skip if another SEO plugin is active (Yoast, RankMath, AIO SEO)
    if (
        defined( 'WPSEO_VERSION' ) ||
        defined( 'RANK_MATH_VERSION' ) ||
        class_exists( 'All_in_One_SEO' )
    ) {
        return;
    }

    $site_name   = get_bloginfo( 'name' );
    $site_desc   = get_bloginfo( 'description' );
    $site_url    = home_url( '/' );
    $current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    // Defaults
    $meta_title       = $site_name . ( $site_desc ? ' — ' . $site_desc : '' );
    $meta_description = $site_desc ?: 'AI-powered SEO tools to boost your rankings.';
    $og_image         = TECHORBIT_URI . '/assets/images/og-image.jpg';
    $og_type          = 'website';

    if ( is_singular() && isset( $post ) ) {
        $meta_title = get_the_title( $post->ID ) . ' — ' . $site_name;

        // Custom meta from post meta
        $custom_desc = get_post_meta( $post->ID, '_techorbit_meta_description', true );
        if ( $custom_desc ) {
            $meta_description = $custom_desc;
        } else {
            $excerpt = get_the_excerpt( $post->ID );
            if ( $excerpt ) {
                $meta_description = wp_trim_words( wp_strip_all_tags( $excerpt ), 30, '...' );
            }
        }

        if ( has_post_thumbnail( $post->ID ) ) {
            $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
            if ( $thumb_src ) {
                $og_image = $thumb_src[0];
            }
        }

        $og_type = 'article';
    } elseif ( is_category() || is_tag() || is_tax() ) {
        $term         = get_queried_object();
        $meta_title   = $term->name . ' — ' . $site_name;
        $term_desc    = term_description();
        if ( $term_desc ) {
            $meta_description = wp_strip_all_tags( $term_desc );
        }
    } elseif ( is_search() ) {
        $meta_title    = sprintf( __( 'Search: %s — %s', 'techorbit-seo' ), get_search_query(), $site_name );
        $meta_description = sprintf( __( 'Search results for "%s" on %s.', 'techorbit-seo' ), get_search_query(), $site_name );
    } elseif ( is_404() ) {
        $meta_title   = '404 Not Found — ' . $site_name;
        $meta_description = 'The page you were looking for could not be found.';
    }

    // Clean up
    $meta_title       = esc_attr( wp_strip_all_tags( $meta_title ) );
    $meta_description = esc_attr( wp_strip_all_tags( wp_trim_words( $meta_description, 35, '...' ) ) );
    $og_image         = esc_url( $og_image );
    $current_url      = esc_url( $current_url );

    ?>
<!-- TechOrbit SEO Meta -->
<meta name="description" content="<?php echo $meta_description; ?>">
<meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
<link rel="canonical" href="<?php echo $current_url; ?>">

<!-- Open Graph -->
<meta property="og:title" content="<?php echo $meta_title; ?>">
<meta property="og:description" content="<?php echo $meta_description; ?>">
<meta property="og:url" content="<?php echo $current_url; ?>">
<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
<meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>">
<meta property="og:image" content="<?php echo $og_image; ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="<?php echo esc_attr( str_replace( '-', '_', get_locale() ) ); ?>">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo $meta_title; ?>">
<meta name="twitter:description" content="<?php echo $meta_description; ?>">
<meta name="twitter:image" content="<?php echo $og_image; ?>">
<meta name="twitter:site" content="@PortalYojana">

<?php if ( is_singular() ) : ?>
<meta property="article:published_time" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
<meta property="article:modified_time" content="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>">
<?php endif; ?>
<!-- /TechOrbit SEO Meta -->
    <?php
}
add_action( 'wp_head', 'techorbit_seo_meta', 5 );
