<?php
/**
 * Footer template
 *
 * @package techorbit-seo
 */
$social = techorbit_social_links();
?>
</div><!-- #main-content -->

<!-- ============================================================
     SITE FOOTER
     ============================================================ -->
<footer class="site-footer" role="contentinfo">

    <!-- Footer Top -->
    <div class="footer-top">
        <div class="container-wide">
            <div class="footer-grid">

                <!-- Column 1: Brand -->
                <div class="footer-brand">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo-link" aria-label="<?php bloginfo( 'name' ); ?>">
                        <?php
                        $logo_id = get_option( 'techorbit_site_logo', '' );
                        if ( $logo_id ) {
                            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                            echo '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="footer-logo-img" width="160" height="40">';
                        } else {
                            echo '<div class="footer-logo-text"><span class="logo-icon">⚡</span><span class="logo-name">TechOrbit</span><span class="logo-tag">SEO</span></div>';
                        }
                        ?>
                    </a>
                    <p class="footer-tagline"><?php esc_html_e( 'AI-powered SEO tools to grow your organic traffic, rank higher, and outperform the competition.', 'techorbit-seo' ); ?></p>

                    <!-- Social Icons -->
                    <div class="footer-social" role="list" aria-label="Social Media Links">
                        <?php foreach ( $social as $key => $link ) : ?>
                            <a href="<?php echo esc_url( $link['url'] ); ?>"
                               class="social-icon social-<?php echo esc_attr( $key ); ?>"
                               target="_blank"
                               rel="noopener noreferrer"
                               role="listitem"
                               aria-label="<?php echo esc_attr( $link['label'] ); ?>">
                                <?php
                                // SVG icons
                                techorbit_social_svg( $key );
                                ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Column 2: Quick Links -->
                <div class="footer-col">
                    <h4 class="footer-heading"><?php esc_html_e( 'Quick Links', 'techorbit-seo' ); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>"><?php esc_html_e( 'SEO Tools', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'About Us', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'techorbit-seo' ); ?></a></li>
                    </ul>
                </div>

                <!-- Column 3: AI Tools -->
                <div class="footer-col">
                    <h4 class="footer-heading"><?php esc_html_e( 'AI SEO Tools', 'techorbit-seo' ); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>"><?php esc_html_e( 'Meta Generator', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>"><?php esc_html_e( 'Blog Outline Builder', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>"><?php esc_html_e( 'Keyword Cluster Tool', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>"><?php esc_html_e( 'FAQ Generator', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>"><?php esc_html_e( 'Product Description', 'techorbit-seo' ); ?></a></li>
                    </ul>
                </div>

                <!-- Column 4: Legal -->
                <div class="footer-col">
                    <h4 class="footer-heading"><?php esc_html_e( 'Legal & Info', 'techorbit-seo' ); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/terms-of-service/' ) ); ?>"><?php esc_html_e( 'Terms of Service', 'techorbit-seo' ); ?></a></li>
                        <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact Us', 'techorbit-seo' ); ?></a></li>
                    </ul>

                    <div class="footer-newsletter">
                        <h5><?php esc_html_e( 'SEO Tips Newsletter', 'techorbit-seo' ); ?></h5>
                        <form class="newsletter-form" action="#" method="post">
                            <input type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Your email address', 'techorbit-seo' ); ?>" required class="newsletter-input" aria-label="Email address">
                            <button type="submit" class="newsletter-btn">→</button>
                        </form>
                    </div>
                </div>

            </div><!-- .footer-grid -->
        </div><!-- .container-wide -->
    </div><!-- .footer-top -->

    <?php 
    // Footer Ad Slot
    techorbit_adsense( 'footer' ); 
    ?>

    <!-- Footer Bottom -->

    <div class="footer-bottom">
        <div class="container-wide">
            <div class="footer-bottom-inner">
                <p class="footer-copy">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>.
                    <?php esc_html_e( 'All rights reserved. Powered by AI.', 'techorbit-seo' ); ?>
                </p>
                <p class="footer-credits">
                    <?php esc_html_e( 'Built with', 'techorbit-seo' ); ?> ❤️ <?php esc_html_e( 'for SEO Professionals', 'techorbit-seo' ); ?>
                </p>
            </div>
        </div>
    </div><!-- .footer-bottom -->

</footer><!-- .site-footer -->

<?php wp_footer(); ?>
</body>
</html>
?>
