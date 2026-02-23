<?php
/**
 * Template Name: Tools Directory
 * Lists all 35+ AI SEO tools
 *
 * @package techorbit-seo
 */
get_header();

$tools = [
    // SEO Tools
    ['name'=>'AI Meta Generator','desc'=>'Instantly generate SEO-ready meta titles and descriptions.','icon'=>'🏷️','cat'=>'seo','url'=>'/tools/meta-generator/','badge'=>'popular'],
    ['name'=>'AI FAQ Generator','desc'=>'Generate FAQ schema with 8+ questions in JSON-LD format.','icon'=>'❓','cat'=>'seo','url'=>'/tools/faq-generator/','badge'=>'schema'],
    ['name'=>'AI Keyword Cluster Tool','desc'=>'Group keywords into clusters with search intent analysis.','icon'=>'🔑','cat'=>'seo','url'=>'/tools/keyword-cluster/','badge'=>'research'],
    ['name'=>'Open Graph Tag Generator','desc'=>'Generate perfect OG tags for social media previews.','icon'=>'🔗','cat'=>'seo','url'=>'#','badge'=>''],
    ['name'=>'Robots.txt Generator','desc'=>'Build a proper robots.txt file with custom rules.','icon'=>'🤖','cat'=>'seo','url'=>'#','badge'=>'new'],
    ['name'=>'XML Sitemap Helper','desc'=>'Checklist and guide for generating perfect XML sitemaps.','icon'=>'🗺','cat'=>'seo','url'=>'#','badge'=>''],

    // Content Tools
    ['name'=>'Blog Outline Builder','desc'=>'Generate structured H1/H2/H3 blog outlines in seconds.','icon'=>'📝','cat'=>'content','url'=>'/tools/blog-outline/','badge'=>'popular'],
    ['name'=>'Product Description Writer','desc'=>'Write compelling SEO-ready product descriptions.','icon'=>'🛒','cat'=>'content','url'=>'/tools/product-description/','badge'=>''],
    ['name'=>'Blog Topic Generator','desc'=>'Get 10+ blog topic ideas from a single keyword.','icon'=>'💡','cat'=>'content','url'=>'#','badge'=>'new'],
    ['name'=>'Paragraph Expander','desc'=>'Expand short sentences into rich, detailed paragraphs.','icon'=>'📄','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Content Summarizer','desc'=>'Summarise long articles into key takeaways.','icon'=>'✂️','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Headline Analyzer','desc'=>'Score your blog headlines for clicks and SEO.','icon'=>'📰','cat'=>'content','url'=>'#','badge'=>''],

    // Keyword Tools
    ['name'=>'LSI Keyword Generator','desc'=>'Find semantically-related keywords to enrich your content.','icon'=>'🔍','cat'=>'keyword','url'=>'#','badge'=>''],
    ['name'=>'Long-tail Keyword Finder','desc'=>'Discover low-competition long-tail keyword opportunities.','icon'=>'📈','cat'=>'keyword','url'=>'#','badge'=>'new'],
    ['name'=>'Search Intent Analyzer','desc'=>'Classify any keyword by informational, commercial or transactional intent.','icon'=>'🧭','cat'=>'keyword','url'=>'#','badge'=>''],

    // Technical SEO
    ['name'=>'Schema Markup Generator','desc'=>'Generate structured data schema for any content type.','icon'=>'🏗','cat'=>'technical','url'=>'#','badge'=>''],
    ['name'=>'Twitter Card Generator','desc'=>'Create Twitter card meta tags for better social sharing.','icon'=>'🐦','cat'=>'technical','url'=>'#','badge'=>''],
    ['name'=>'Alt Text Generator','desc'=>'Generate descriptive alt text for images from AI.','icon'=>'🖼','cat'=>'technical','url'=>'#','badge'=>'new'],

    // Social & Copywriting
    ['name'=>'Social Media Caption Writer','desc'=>'Write engaging captions for Instagram, Facebook & LinkedIn.','icon'=>'📱','cat'=>'social','url'=>'#','badge'=>'new'],
    ['name'=>'Hashtag Generator','desc'=>'Get relevant hashtags for any topic or niche.','icon'=>'#️⃣','cat'=>'social','url'=>'#','badge'=>''],
    ['name'=>'LinkedIn Post Writer','desc'=>'Create professional LinkedIn posts that drive engagement.','icon'=>'💼','cat'=>'social','url'=>'#','badge'=>''],
];
?>

<div class="tools-listing-hero">
    <div class="container">
        <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">AI Powered</span>
        <h1>SEO Tools Directory</h1>
        <p>Explore our full suite of 35+ free AI tools — powered by OpenAI GPT-4o and Google Gemini.</p>
    </div>
</div>

<div class="container" style="padding-top:60px; padding-bottom:80px;">
    <div class="tools-listing-grid">
        <?php foreach ( $tools as $tool ) : 
            $link = !empty($tool['url']) && $tool['url'] !== '#' ? esc_url( home_url( $tool['url'] ) ) : '#';
            $is_live = $tool['url'] !== '#';
        ?>
            <a href="<?php echo $link; ?>" class="tools-listing-card" <?php if(!$is_live) echo 'onclick="return false;" style="opacity:0.8;"'; ?>>
                <div class="tools-listing-icon"><?php echo esc_html( $tool['icon'] ); ?></div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <h2 style="font-size:18px;"><?php echo esc_html( $tool['title'] ?? $tool['name'] ); ?></h2>
                    <?php if(!empty($tool['badge'])): ?>
                        <span class="tool-badge"><?php echo esc_html( $tool['badge'] ); ?></span>
                    <?php endif; ?>
                </div>

                <p><?php echo esc_html( $tool['desc'] ); ?></p>

                <div class="cta-row">
                    <span style="font-size:12px; font-weight:600; color:var(--text-muted); opacity: 0.7;">
                        📁 <?php echo esc_html(ucfirst($tool['cat'])); ?>
                    </span>
                    <?php if($is_live): ?>
                        <span style="color:var(--primary);font-weight:700;font-size:14px;white-space:nowrap;margin-left:8px;">Open Tool →</span>
                    <?php else: ?>
                        <span style="color:var(--text-light);font-size:12px;white-space:nowrap;margin-left:8px;">Coming Soon</span>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Bottom AdSense -->
<div class="container" style="padding:0 24px 48px;text-align:center;">
    <?php techorbit_adsense( 'content' ); ?>
</div>

<?php get_footer(); ?>
