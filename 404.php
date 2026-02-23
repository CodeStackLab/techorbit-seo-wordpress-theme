<?php
/**
 * 404 Not Found template
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="page-404">
    <div class="container">
        <div class="error-code">404</div>
        <h2><?php esc_html_e( 'Page Not Found', 'techorbit-seo' ); ?></h2>
        <p><?php esc_html_e( "Oops! The page you're looking for doesn't exist or has been moved.", 'techorbit-seo' ); ?></p>

        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary">🏠 <?php esc_html_e( 'Go Home', 'techorbit-seo' ); ?></a>
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-secondary">🛠 <?php esc_html_e( 'Try Our SEO Tools', 'techorbit-seo' ); ?></a>
        </div>

        <!-- Search box -->
        <div style="margin-top:48px;max-width:480px;margin-left:auto;margin-right:auto;">
            <?php get_search_form(); ?>
        </div>

        <!-- Popular Tools Quick Links -->
        <div style="margin-top:56px;">
            <h3 style="font-size:20px;margin-bottom:24px;color:var(--text-muted);"><?php esc_html_e( 'Popular AI Tools', 'techorbit-seo' ); ?></h3>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>" style="background:#F3F4F6;padding:10px 20px;border-radius:8px;color:var(--text-dark);font-weight:600;transition:var(--transition);">🏷️ Meta Generator</a>
                <a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>" style="background:#F3F4F6;padding:10px 20px;border-radius:8px;color:var(--text-dark);font-weight:600;">📝 Blog Outline</a>
                <a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>" style="background:#F3F4F6;padding:10px 20px;border-radius:8px;color:var(--text-dark);font-weight:600;">🔑 Keyword Cluster</a>
                <a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>" style="background:#F3F4F6;padding:10px 20px;border-radius:8px;color:var(--text-dark);font-weight:600;">❓ FAQ Generator</a>
                <a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>" style="background:#F3F4F6;padding:10px 20px;border-radius:8px;color:var(--text-dark);font-weight:600;">🛒 Product Desc</a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
