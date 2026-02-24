<?php
/**
 * 404 Not Found template - Premium TechOrbit SEO Edition
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="page-404-premium" style="padding: 100px 0; background: var(--bg-soft); min-height: 80vh; display: flex; align-items: center; text-align: center;">
    <div class="container" style="max-width: 800px;">
        <div class="error-visual" style="margin-bottom: 40px;">
            <span style="font-size: 120px; display: block; filter: drop-shadow(0 20px 30px rgba(255,107,44,0.2));">🚀</span>
            <div class="error-code-badge" style="display: inline-block; background: var(--gradient-cta); color: #fff; padding: 4px 24px; border-radius: 50px; font-weight: 800; font-size: 14px; margin-top: -20px; position: relative; z-index: 2; box-shadow: var(--shadow-md);">ERROR 404</div>
        </div>

        <h1 style="font-size: 48px; margin-bottom: 16px; color: var(--text-dark); letter-spacing: -1px;">Lost in the Orbit?</h1>
        <p style="font-size: 18px; color: var(--text-muted); max-width: 600px; margin: 0 auto 40px; line-height: 1.7;">
            The page you're looking for has drifted away. Don't worry, our AI tools are still here to help you get back on track.
        </p>

        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; margin-bottom: 60px;">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary" style="height: 52px; padding: 0 32px; display: inline-flex; align-items: center; gap: 8px;">
                🏠 Back to Home
            </a>
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-secondary" style="height: 52px; padding: 0 32px; display: inline-flex; align-items: center; gap: 8px; background: #fff; border: 1.5px solid var(--border);">
                ⚒️ Browse AI Tools
            </a>
        </div>

        <!-- Popular Tools Grid for 404 -->
        <div class="popular-tools-mini" style="background: #fff; border: 1px solid var(--border); border-radius: var(--radius-xl); padding: 40px; box-shadow: var(--shadow-sm);">
            <h3 style="font-size: 18px; margin-bottom: 24px; color: var(--text-dark); display: flex; align-items: center; justify-content: center; gap: 8px;">
                <span style="color: var(--primary);">🔥</span> Popular Destinations
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px;">
                <a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>" style="text-decoration: none; padding: 16px; border: 1px solid var(--border); border-radius: var(--radius); transition: var(--transition); text-align: left; display: block;" class="mini-tool-link">
                    <span style="font-size: 24px; display: block; margin-bottom: 8px;">🏷️</span>
                    <strong style="display: block; font-size: 14px; color: var(--text-dark);">Meta Generator</strong>
                </a>
                <a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>" style="text-decoration: none; padding: 16px; border: 1px solid var(--border); border-radius: var(--radius); transition: var(--transition); text-align: left; display: block;" class="mini-tool-link">
                    <span style="font-size: 24px; display: block; margin-bottom: 8px;">📝</span>
                    <strong style="display: block; font-size: 14px; color: var(--text-dark);">Blog Outline</strong>
                </a>
                <a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>" style="text-decoration: none; padding: 16px; border: 1px solid var(--border); border-radius: var(--radius); transition: var(--transition); text-align: left; display: block;" class="mini-tool-link">
                    <span style="font-size: 24px; display: block; margin-bottom: 8px;">🔑</span>
                    <strong style="display: block; font-size: 14px; color: var(--text-dark);">Keyword Cluster</strong>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.mini-tool-link:hover {
    border-color: var(--primary);
    background: var(--primary-light);
    transform: translateY(-3px);
    box-shadow: var(--shadow);
}
@media (max-width: 600px) {
    .page-404-premium h1 { font-size: 32px; }
    .page-404-premium { padding: 60px 0; }
}
</style>

<?php get_footer(); ?>
