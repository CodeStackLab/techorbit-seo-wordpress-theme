<?php
/**
 * Template Name: About
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="page-header-vibrant">
    <div class="container">
        <span class="section-label-light">About Us</span>
        <h1 class="page-title-hero">About TechOrbit SEO</h1>
        <p class="page-subtitle">AI-powered SEO tools built for content creators, marketers, and SEO professionals in India and beyond.</p>
    </div>
</div>

<div class="page-standard-wrap container">

    <div class="static-page-article">
        <div class="static-page-body single-post-content">

            <h2>Who We Are</h2>
            <p>
                TechOrbit SEO is a free AI-powered SEO tools platform built by <strong>Akeel Khan</strong>, an independent developer and digital marketer passionate about making professional SEO accessible to everyone — especially small businesses, bloggers, and solopreneurs who can't afford enterprise tools like SEMrush or Ahrefs.
            </p>

            <p>
                We believe that great SEO shouldn't require a $500/month subscription. By integrating the latest AI models — OpenAI GPT-4o and Google Gemini — directly into our platform, we provide professional-grade SEO outputs that previously required expensive software or seasoned consultants.
            </p>

            <h2>Our Mission</h2>
            <p>
                To democratize SEO by giving every website owner, blogger, and small business access to the same AI tools used by Fortune 500 marketing teams — completely free.
            </p>

            <h2>Our Tools</h2>
            <ul>
                <li>🏷️ <strong>AI Meta Generator</strong> — Optimized titles and descriptions in seconds</li>
                <li>📝 <strong>Blog Outline Builder</strong> — SEO-structured content plans</li>
                <li>🔑 <strong>Keyword Cluster Tool</strong> — Intent-mapped keyword groups</li>
                <li>❓ <strong>FAQ Generator</strong> — Schema.org JSON-LD ready FAQs</li>
                <li>🛒 <strong>Product Description Writer</strong> — E-commerce copy that ranks and converts</li>
            </ul>

            <h2>Get In Touch</h2>
            <p>
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
