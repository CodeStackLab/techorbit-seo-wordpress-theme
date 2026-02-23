<?php
/**
 * Header template
 *
 * @package techorbit-seo
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php
// AdSense Auto Ads
$pub_id = get_option( 'techorbit_adsense_publisher_id', '' );
if ( $pub_id ) :
?>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo esc_attr( $pub_id ); ?>" crossorigin="anonymous"></script>
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link sr-only" href="#main-content"><?php esc_html_e( 'Skip to content', 'techorbit-seo' ); ?></a>

<!-- ============================================================
     SITE HEADER
     ============================================================ -->
<header class="site-header" id="site-header" role="banner">
    <div class="header-inner container-wide">

        <!-- Logo -->
        <div class="site-logo">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?>">
                <?php
                $logo_id = get_option( 'techorbit_site_logo', '' );
                if ( $logo_id ) {
                    $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                    echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="logo-img" width="180" height="44" loading="eager">';
                } else {
                    echo '<div class="logo-text"><span class="logo-icon">⚡</span><span class="logo-name">TechOrbit</span><span class="logo-tag">SEO</span></div>';
                }
                ?>
            </a>
        </div>

        <!-- Primary Navigation -->
        <nav class="primary-nav" id="primary-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary navigation', 'techorbit-seo' ); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_class'     => 'nav-menu',
                'container'      => false,
                'fallback_cb'    => false,
                'walker'         => false,
                'items_wrap'     => '<ul id="primary-menu" class="nav-menu" role="menubar">%3$s</ul>',
            ] );
            ?>
        </nav>

        <!-- Header Actions -->
        <div class="header-actions">
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-ghost header-tools-link">🛠 All Tools</a>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-primary header-cta">Get Started Free</a>
        </div>

        <!-- Mobile Hamburger -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false" aria-controls="primary-nav">
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
            <span class="hamburger-line"></span>
        </button>

    </div><!-- .header-inner -->
</header><!-- .site-header -->

<!-- Header AdSense (leaderboard 728x90) -->
<?php
$show_header_ad = ! is_front_page();
if ( $show_header_ad ) {
    echo '<div class="header-ad-wrap container">';
    techorbit_adsense( 'header' );
    echo '</div>';
}
?>

<div id="main-content">
