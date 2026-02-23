<?php
/**
 * Sidebar template
 *
 * @package techorbit-seo
 */
?>
<aside class="site-sidebar" id="secondary" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'techorbit-seo' ); ?>">

    <!-- Sidebar AdSense (300x250) -->
    <div class="sidebar-ad-wrap">
        <?php techorbit_adsense( 'sidebar' ); ?>
    </div>

    <!-- Widget Area -->
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <div class="sidebar-widgets">
            <?php dynamic_sidebar( 'sidebar-1' ); ?>
        </div>
    <?php else : ?>
        <!-- Default sidebar content when no widgets added -->
        <div class="sidebar-default">

            <!-- Popular Tools Card -->
            <div class="sidebar-card">
                <h3 class="sidebar-card-title">🔥 Popular AI Tools</h3>
                <ul class="sidebar-tool-list">
                    <li><a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>"><span class="tool-emoji">🏷️</span> Meta Generator</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>"><span class="tool-emoji">📝</span> Blog Outline</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>"><span class="tool-emoji">🔑</span> Keyword Cluster</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>"><span class="tool-emoji">❓</span> FAQ Generator</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>"><span class="tool-emoji">🛒</span> Product Description</a></li>
                </ul>
            </div>

            <!-- Quick Tips Card -->
            <div class="sidebar-card sidebar-tips">
                <h3 class="sidebar-card-title">💡 Quick SEO Tip</h3>
                <p>Optimize your meta titles to 50–60 characters for best click-through rates in search results.</p>
                <a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>" class="sidebar-cta">Generate Your Meta Tags →</a>
            </div>

        </div>
    <?php endif; ?>

</aside><!-- .site-sidebar -->
