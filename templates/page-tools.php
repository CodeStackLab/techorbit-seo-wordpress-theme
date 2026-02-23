<?php
/**
 * Template Name: Tools Directory
 * Lists all 5 AI SEO tools
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="tools-listing-hero">
    <div class="container">
        <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">AI Powered</span>
        <h1>Free AI SEO Tools</h1>
        <p>Five powerful tools to supercharge your SEO — powered by OpenAI GPT-4o and Google Gemini.</p>
    </div>
</div>

<?php
$tools = [
    [
        'icon'   => '🏷️',
        'title'  => 'AI Meta Generator',
        'desc'   => 'Instantly generate SEO-optimized meta titles (max 60 characters) and meta descriptions (max 160 characters) for any page or post. Improve your SERP click-through rate without hours of manual writing.',
        'url'    => home_url( '/tools/meta-generator/' ),
        'tags'   => ['Meta Tags', 'SERP CTR', 'On-Page SEO'],
        'badge'  => '🔥 Most Used',
    ],
    [
        'icon'   => '📝',
        'title'  => 'AI Blog Outline Builder',
        'desc'   => 'Create detailed SEO-optimized blog post outlines with H1, H2, and H3 headings structured for search intent. Start publishing faster and rank higher with a properly structured article.',
        'url'    => home_url( '/tools/blog-outline/' ),
        'tags'   => ['Content Strategy', 'Blog SEO', 'Headings'],
        'badge'  => '📝 Content',
    ],
    [
        'icon'   => '🔑',
        'title'  => 'AI Keyword Cluster Tool',
        'desc'   => 'Group your seed keywords into topical clusters with search intent classification. Understand whether users want to learn (informational), buy (transactional), or compare (commercial).',
        'url'    => home_url( '/tools/keyword-cluster/' ),
        'tags'   => ['Keyword Research', 'Search Intent', 'Topical SEO'],
        'badge'  => '🔍 Research',
    ],
    [
        'icon'   => '❓',
        'title'  => 'AI FAQ Generator',
        'desc'   => 'Generate 8 SEO-optimized FAQs with complete Schema.org FAQPage JSON-LD markup. Ready to paste into your HTML — maximize your chances of winning Google featured snippets.',
        'url'    => home_url( '/tools/faq-generator/' ),
        'tags'   => ['Schema Markup', 'Featured Snippets', 'Rich Results'],
        'badge'  => '⚡ Schema',
    ],
    [
        'icon'   => '🛒',
        'title'  => 'AI Product Description Writer',
        'desc'   => 'Write SEO-optimized e-commerce product descriptions that rank in search and convert visitors into buyers. Benefits-first copywriting with natural keyword integration.',
        'url'    => home_url( '/tools/product-description/' ),
        'tags'   => ['E-commerce', 'Product SEO', 'Copywriting'],
        'badge'  => '🛒 E-Commerce',
    ],
];
?>

<div class="tools-listing-grid">
    <?php foreach ( $tools as $tool ) : ?>
        <a href="<?php echo esc_url( $tool['url'] ); ?>" class="tools-listing-card">
            <div class="tools-listing-icon"><?php echo esc_html( $tool['icon'] ); ?></div>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                <h2><?php echo esc_html( $tool['title'] ); ?></h2>
                <span class="tool-badge"><?php echo esc_html( $tool['badge'] ); ?></span>
            </div>

            <p><?php echo esc_html( $tool['desc'] ); ?></p>

            <div class="cta-row">
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    <?php foreach ( $tool['tags'] as $tag ) : ?>
                        <span style="background:#F3F4F6;color:var(--text-muted);padding:4px 10px;border-radius:50px;font-size:12px;font-weight:600;"><?php echo esc_html( $tag ); ?></span>
                    <?php endforeach; ?>
                </div>
                <span style="color:var(--primary);font-weight:700;font-size:14px;white-space:nowrap;margin-left:8px;">Try Free →</span>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<!-- Bottom AdSense -->
<div class="container" style="padding:0 24px 48px;text-align:center;">
    <?php techorbit_adsense( 'content' ); ?>
</div>

<?php get_footer(); ?>
