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
            <nav class="primary-nav" aria-label="Primary Navigation">
                <?php wp_nav_menu([
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => function() { ?>
                        <ul class="nav-menu">
                            <li><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                            <li><a href="<?php echo esc_url(home_url('/tools/')); ?>">Tools</a></li>
                            <li><a href="<?php echo esc_url(home_url('/blog/')); ?>">Blog</a></li>
                            <li><a href="<?php echo esc_url(home_url('/about/')); ?>">About</a></li>
                        </ul>
                    <?php }
                ]); ?>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <a href="<?php echo esc_url(home_url('/tools/')); ?>" class="btn-nav-tools">
                    🛠 All Tools
                </a>
                <button class="mobile-menu-toggle" id="mobileMenuBtn" aria-label="Toggle menu" aria-expanded="false">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

        </div>
    </div>
</header>

<?php if ($adsense_id) : ?>
<div class="header-ad-wrap">
    <div class="container">
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=<?php echo esc_attr($adsense_id); ?>" crossorigin="anonymous"></script>
        <ins class="adsbygoogle" style="display:block" data-ad-client="<?php echo esc_attr($adsense_id); ?>" data-ad-slot="header" data-ad-format="auto" data-full-width-responsive="true"></ins>
        <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
</div>
<?php endif; ?>
