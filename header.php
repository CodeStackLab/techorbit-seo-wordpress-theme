<?php
/**
 * Header Template - TechOrbit SEO
 * Professional SemRush-style design
 */
$settings     = techorbit_get_settings();
$logo_url     = $settings['logo_url'] ?? '';
$adsense_id   = $settings['adsense_id'] ?? '';
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() . '/assets/img/favicon.png?v=' . time() ); ?>" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="container">
        <div class="header-inner">

            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo" aria-label="<?php bloginfo('name'); ?>">
                <?php if ($logo_url) : ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="logo-img">
                <?php else : ?>
                    <div class="logo-text">
                        <span class="logo-icon">⚡</span>
                        <span class="logo-name"><?php bloginfo('name'); ?></span>
                        <span class="logo-tag">SEO</span>
                    </div>
                <?php endif; ?>
            </a>

            <!-- Primary Nav -->
            <nav class="primary-nav" id="primary-nav" aria-label="Primary Navigation">
                <?php wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => function() { ?>
                        <ul class="nav-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>">🏠 Home</a></li>
                            <li><a href="<?php echo esc_url(home_url('/tools/')); ?>">🛠 SEO Tools</a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">📝 Blog</a></li>
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>">ℹ️ About</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">📧 Contact Us</a></li>
                        </ul>
                    <?php }
                ]); ?>
                
                <!-- Mobile Only Auth -->
                <div class="mobile-auth-links">
                    <a href="<?php echo esc_url(home_url('/tools/')); ?>" class="btn-signup-link mobile-tools-btn" style="background: var(--gradient-vibrant); margin-bottom: 8px;">
                        🛠 Explore All Tools
                    </a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( home_url( '/logout/' ) ); ?>" class="btn-signup-link"><?php esc_html_e( 'Logout', 'techorbit-seo' ); ?></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>" class="btn-login-link"><?php esc_html_e( 'Log in', 'techorbit-seo' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/register/' ) ); ?>" class="btn-signup-link"><?php esc_html_e( 'Sign up', 'techorbit-seo' ); ?></a>
                    <?php endif; ?>
                </div>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <div class="header-auth">
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( home_url( '/logout/' ) ); ?>" class="btn-login-link"><?php esc_html_e( 'Logout', 'techorbit-seo' ); ?></a>
                    <?php else : ?>
                        <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>" class="btn-login-link"><?php esc_html_e( 'Log in', 'techorbit-seo' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/register/' ) ); ?>" class="btn-signup-link"><?php esc_html_e( 'Sign up', 'techorbit-seo' ); ?></a>
                    <?php endif; ?>
                </div>

                <a href="<?php echo esc_url(home_url('/tools/')); ?>" class="btn-nav-tools hide-mobile">
                    🛠 All Tools
                </a>
                <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Toggle menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

        </div>
    </div>
</header>

<?php 
// Header Ad Slot
techorbit_adsense( 'header' ); 
?>

<div id="main-content" class="site-main">

