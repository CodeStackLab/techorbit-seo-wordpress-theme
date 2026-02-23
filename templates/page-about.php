<?php
/**
 * Template Name: About
 *
 * @package techorbit-seo
 */
get_header();
?>

<div style="background:var(--gradient);padding:64px 24px;text-align:center;">
    <div class="container">
        <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">About Us</span>
        <h1 style="font-size:clamp(28px,4vw,48px);color:#fff;margin:12px 0 16px;">About TechOrbit SEO</h1>
        <p style="color:rgba(255,255,255,0.72);font-size:17px;max-width:560px;margin:0 auto;">AI-powered SEO tools built for content creators, marketers, and SEO professionals in India and beyond.</p>
    </div>
</div>

<div style="max-width:860px;margin:60px auto;padding:0 24px;">

    <div class="single-post-article">
        <div class="single-post-body">

            <h2 style="font-size:28px;margin-bottom:20px;">Who We Are</h2>
            <p style="font-size:16px;line-height:1.8;color:#374151;margin-bottom:20px;">
                TechOrbit SEO is a free AI-powered SEO tools platform built by <strong>Akeel Khan</strong>, an independent developer and digital marketer passionate about making professional SEO accessible to everyone — especially small businesses, bloggers, and solopreneurs who can't afford enterprise tools like SEMrush or Ahrefs.
            </p>

            <p style="font-size:16px;line-height:1.8;color:#374151;margin-bottom:20px;">
                We believe that great SEO shouldn't require a $500/month subscription. By integrating the latest AI models — OpenAI GPT-4o and Google Gemini — directly into our platform, we provide professional-grade SEO outputs that previously required expensive software or seasoned consultants.
            </p>

            <h2 style="font-size:24px;margin:36px 0 16px;">Our Mission</h2>
            <p style="font-size:16px;line-height:1.8;color:#374151;margin-bottom:20px;">
                To democratize SEO by giving every website owner, blogger, and small business access to the same AI tools used by Fortune 500 marketing teams — completely free.
            </p>

            <h2 style="font-size:24px;margin:36px 0 16px;">Our Tools</h2>
            <ul style="font-size:16px;line-height:1.9;color:#374151;padding-left:20px;margin-bottom:24px;">
                <li>🏷️ <strong>AI Meta Generator</strong> — Optimized titles and descriptions in seconds</li>
                <li>📝 <strong>Blog Outline Builder</strong> — SEO-structured content plans</li>
                <li>🔑 <strong>Keyword Cluster Tool</strong> — Intent-mapped keyword groups</li>
                <li>❓ <strong>FAQ Generator</strong> — Schema.org JSON-LD ready FAQs</li>
                <li>🛒 <strong>Product Description Writer</strong> — E-commerce copy that ranks and converts</li>
            </ul>

            <h2 style="font-size:24px;margin:36px 0 16px;">Get In Touch</h2>
            <p style="font-size:16px;line-height:1.8;color:#374151;margin-bottom:20px;">
                Have a suggestion for a new SEO tool? Found a bug? Want to partner with us? We'd love to hear from you.
            </p>
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn-primary">📬 Contact Us</a>

        </div>
    </div>

    <!-- Social Follow Section -->
    <div style="margin-top:48px;background:#fff;border-radius:var(--radius-lg);padding:40px;box-shadow:var(--shadow);text-align:center;border:1px solid var(--border);">
        <h3 style="font-size:22px;margin-bottom:12px;">Follow Us on Social Media</h3>
        <p style="color:var(--text-muted);margin-bottom:24px;">Get SEO tips, tool updates, and digital marketing insights across our channels.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
            <?php foreach ( techorbit_social_links() as $key => $link ) : ?>
                <a href="<?php echo esc_url( $link['url'] ); ?>"
                   class="social-icon social-<?php echo esc_attr( $key ); ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   style="width:48px;height:48px;font-size:20px;border-radius:12px;"
                   aria-label="<?php echo esc_attr( $link['label'] ); ?>">
                    <?php techorbit_social_svg( $key ); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>
