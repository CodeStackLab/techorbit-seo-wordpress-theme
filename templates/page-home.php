<?php
/**
 * Template Name: Home
 * Homepage template — 30+ AI SEO tools with category filter
 */

get_header();

// 35 Tools across 5 categories
$tools = [
    // SEO Tools
    ['name'=>'AI Meta Generator','desc'=>'Generate optimised title tags & meta descriptions instantly.','icon'=>'🎯','cat'=>'seo','url'=>'/tools/meta-generator/','badge'=>'popular'],
    ['name'=>'Keyword Cluster Tool','desc'=>'Group keywords by search intent for smarter content planning.','icon'=>'🗂','cat'=>'seo','url'=>'/tools/keyword-cluster/','badge'=>'popular'],
    ['name'=>'FAQ Schema Generator','desc'=>'Create JSON-LD FAQ schema markup for Google rich results.','icon'=>'❓','cat'=>'seo','url'=>'/tools/faq-generator/','badge'=>''],
    ['name'=>'Open Graph Tag Generator','desc'=>'Generate perfect OG tags for social media previews.','icon'=>'🔗','cat'=>'seo','url'=>'#','badge'=>''],
    ['name'=>'Robots.txt Generator','desc'=>'Build a proper robots.txt file with custom rules.','icon'=>'🤖','cat'=>'seo','url'=>'#','badge'=>'new'],
    ['name'=>'XML Sitemap Helper','desc'=>'Checklist and guide for generating perfect XML sitemaps.','icon'=>'🗺','cat'=>'seo','url'=>'#','badge'=>''],
    ['name'=>'Canonical Tag Advisor','desc'=>'Prevent duplicate content with proper canonical tags.','icon'=>'🔁','cat'=>'seo','url'=>'#','badge'=>''],
    ['name'=>'Title Tag Analyzer','desc'=>'Analyse and score your title tags for SEO effectiveness.','icon'=>'📊','cat'=>'seo','url'=>'#','badge'=>''],

    // Content Tools
    ['name'=>'Blog Outline Builder','desc'=>'Generate structured H1/H2/H3 blog outlines in seconds.','icon'=>'📝','cat'=>'content','url'=>'/tools/blog-outline/','badge'=>'popular'],
    ['name'=>'Product Description Writer','desc'=>'Write compelling SEO-ready product descriptions.','icon'=>'🛒','cat'=>'content','url'=>'/tools/product-description/','badge'=>''],
    ['name'=>'Blog Topic Generator','desc'=>'Get 10+ blog topic ideas from a single keyword.','icon'=>'💡','cat'=>'content','url'=>'#','badge'=>'new'],
    ['name'=>'Paragraph Expander','desc'=>'Expand short sentences into rich, detailed paragraphs.','icon'=>'📄','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Content Summarizer','desc'=>'Summarise long articles into key takeaways.','icon'=>'✂️','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Headline Analyzer','desc'=>'Score your blog headlines for clicks and SEO.','icon'=>'📰','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Intro Generator','desc'=>'Craft engaging article introductions that hook readers.','icon'=>'🪝','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Conclusion Writer','desc'=>'Write strong conclusions with a clear call to action.','icon'=>'🏁','cat'=>'content','url'=>'#','badge'=>''],
    ['name'=>'Article Rewriter','desc'=>'Rewrite content in a fresh voice while preserving meaning.','icon'=>'✏️','cat'=>'content','url'=>'#','badge'=>'new'],

    // Keyword Tools
    ['name'=>'LSI Keyword Generator','desc'=>'Find semantically-related keywords to enrich your content.','icon'=>'🔍','cat'=>'keyword','url'=>'#','badge'=>''],
    ['name'=>'Long-tail Keyword Finder','desc'=>'Discover low-competition long-tail keyword opportunities.','icon'=>'📈','cat'=>'keyword','url'=>'#','badge'=>'new'],
    ['name'=>'Search Intent Analyzer','desc'=>'Classify any keyword by informational, commercial or transactional intent.','icon'=>'🧭','cat'=>'keyword','url'=>'#','badge'=>''],
    ['name'=>'Keyword Difficulty Estimator','desc'=>'Get a quick difficulty score for any keyword.','icon'=>'🏋️','cat'=>'keyword','url'=>'#','badge'=>''],
    ['name'=>'Competitor Keyword Spy','desc'=>'Discover which keywords your competitors rank for.','icon'=>'🕵️','cat'=>'keyword','url'=>'#','badge'=>'new'],

    // Technical SEO
    ['name'=>'Schema Markup Generator','desc'=>'Generate structured data schema for any content type.','icon'=>'🏗','cat'=>'technical','url'=>'#','badge'=>''],
    ['name'=>'Twitter Card Generator','desc'=>'Create Twitter card meta tags for better social sharing.','icon'=>'🐦','cat'=>'technical','url'=>'#','badge'=>''],
    ['name'=>'Alt Text Generator','desc'=>'Generate descriptive alt text for images from AI.','icon'=>'🖼','cat'=>'technical','url'=>'#','badge'=>'new'],
    ['name'=>'Core Web Vitals Advisor','desc'=>'Get actionable tips to improve LCP, CLS & FID.','icon'=>'⚡','cat'=>'technical','url'=>'#','badge'=>''],
    ['name'=>'Hreflang Tag Builder','desc'=>'Build hreflang tags for multilingual SEO.','icon'=>'🌐','cat'=>'technical','url'=>'#','badge'=>''],
    ['name'=>'JSON-LD Generator','desc'=>'Create custom JSON-LD structured data snippets.','icon'=>'{ }','cat'=>'technical','url'=>'#','badge'=>''],

    // Social & Copywriting
    ['name'=>'Social Media Caption Writer','desc'=>'Write engaging captions for Instagram, Facebook & LinkedIn.','icon'=>'📱','cat'=>'social','url'=>'#','badge'=>'new'],
    ['name'=>'Hashtag Generator','desc'=>'Get relevant hashtags for any topic or niche.','icon'=>'#️⃣','cat'=>'social','url'=>'#','badge'=>''],
    ['name'=>'LinkedIn Post Writer','desc'=>'Create professional LinkedIn posts that drive engagement.','icon'=>'💼','cat'=>'social','url'=>'#','badge'=>''],
    ['name'=>'Twitter Thread Generator','desc'=>'Turn any blog post into a compelling Twitter thread.','icon'=>'🧵','cat'=>'social','url'=>'#','badge'=>'new'],
    ['name'=>'Ad Copy Generator','desc'=>'Write high-converting Google & Facebook ad copy.','icon'=>'📣','cat'=>'social','url'=>'#','badge'=>''],
    ['name'=>'Email Subject Line Writer','desc'=>'Craft irresistible email subject lines with AI.','icon'=>'📧','cat'=>'social','url'=>'#','badge'=>''],
    ['name'=>'Call-to-Action Generator','desc'=>'Generate powerful CTAs for landing pages and blogs.','icon'=>'👆','cat'=>'social','url'=>'#','badge'=>''],
];

$categories = [
    'all'       => ['label'=>'All Tools',      'count'=>count($tools)],
    'seo'       => ['label'=>'SEO',            'count'=>count(array_filter($tools, fn($t)=>$t['cat']==='seo'))],
    'content'   => ['label'=>'Content',        'count'=>count(array_filter($tools, fn($t)=>$t['cat']==='content'))],
    'keyword'   => ['label'=>'Keywords',       'count'=>count(array_filter($tools, fn($t)=>$t['cat']==='keyword'))],
    'technical' => ['label'=>'Technical SEO',  'count'=>count(array_filter($tools, fn($t)=>$t['cat']==='technical'))],
    'social'    => ['label'=>'Social & Copy',  'count'=>count(array_filter($tools, fn($t)=>$t['cat']==='social'))],
];
?>

<!-- ==================== HERO ==================== -->
<section class="hero-section">
    <div class="container">
        <div class="hero-inner">
            <div class="hero-badge"><span class="dot"></span> AI-Powered · <?php echo count($tools); ?>+ SEO Tools</div>
            <h1 class="hero-title">
                All-in-One SEO Toolkit<br>
                <span class="hl">Powered by AI</span>
            </h1>
            <p class="hero-sub">
                Generate meta tags, cluster keywords, build blog outlines, write FAQs and product descriptions — all in seconds using OpenAI &amp; Google Gemini.
            </p>

            <!-- Search Bar -->
            <div class="hero-search">
                <input type="text" class="hero-search-input" id="toolSearch" placeholder="Search 35+ tools — meta generator, keyword cluster…" oninput="filterBySearch(this.value)">
                <button class="hero-search-btn" onclick="filterBySearch(document.getElementById('toolSearch').value)">Search</button>
            </div>

            <!-- Stats -->
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number" data-count="35">0</span>
                    <span class="stat-label">AI Tools</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="50000">0</span>
                    <span class="stat-label">Monthly Users</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="99">0</span>
                    <span class="stat-label">% Uptime</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="0">∞</span>
                    <span class="stat-label">Cost</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== TRUST STRIP ==================== -->
<div class="trust-strip">
    <div class="container">
        <div class="trust-strip-inner">
            <div class="trust-item"><span class="trust-icon">⚡</span><div><span>Instant Results</span><small>No sign-up needed</small></div></div>
            <div class="trust-item"><span class="trust-icon">🤖</span><div><span>GPT-4o + Gemini</span><small>Latest AI models</small></div></div>
            <div class="trust-item"><span class="trust-icon">🔒</span><div><span>Privacy First</span><small>No data stored</small></div></div>
            <div class="trust-item"><span class="trust-icon">📱</span><div><span>Mobile Friendly</span><small>Works everywhere</small></div></div>
            <div class="trust-item"><span class="trust-icon">🔄</span><div><span>Always Updated</span><small>New tools weekly</small></div></div>
        </div>
    </div>
</div>

<!-- ==================== TOOLS SECTION ==================== -->
<section class="tools-section" id="tools">
    <div class="container">
        <div class="section-header">
            <span class="section-label">🛠 AI Tool Suite</span>
            <h2>Complete SEO Toolkit</h2>
            <p>Everything you need to dominate search rankings — from keyword research to schema markup.</p>
        </div>

        <!-- Category Filter -->
        <div class="category-filter" id="catFilter">
            <?php foreach ($categories as $key => $cat) : ?>
            <button class="cat-btn <?php echo $key === 'all' ? 'active' : ''; ?>"
                    data-cat="<?php echo esc_attr($key); ?>"
                    onclick="filterCat('<?php echo esc_attr($key); ?>', this)">
                <?php echo esc_html($cat['label']); ?>
                <span class="cat-count"><?php echo $cat['count']; ?></span>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Tools Grid -->
        <div class="tools-grid" id="toolsGrid">
            <?php foreach ($tools as $tool) :
                $link = !empty($tool['url']) && $tool['url'] !== '#'
                    ? esc_url(home_url($tool['url']))
                    : '#';
                $is_live = $tool['url'] !== '#';
            ?>
            <a href="<?php echo $link; ?>"
               class="tool-card"
               data-cat="<?php echo esc_attr($tool['cat']); ?>"
               data-name="<?php echo esc_attr(strtolower($tool['name'])); ?>"
               <?php if (!$is_live) echo 'onclick="return false;" style="cursor:default;"'; ?>>
                <div class="tool-card-head">
                    <div class="tool-icon-wrap"><?php echo $tool['icon']; ?></div>
                    <?php if ($tool['badge'] === 'new') : ?>
                        <span class="tool-badge-new">New</span>
                    <?php elseif ($tool['badge'] === 'popular') : ?>
                        <span class="tool-badge-popular">⭐ Popular</span>
                    <?php endif; ?>
                </div>
                <h3><?php echo esc_html($tool['name']); ?></h3>
                <p><?php echo esc_html($tool['desc']); ?></p>
                <div class="tool-card-foot">
                    <span class="tool-cat-tag"><?php echo esc_html(ucfirst($tool['cat'])); ?></span>
                    <?php if ($is_live) : ?>
                        <span class="tool-arrow">Try now →</span>
                    <?php else : ?>
                        <span class="tool-arrow" style="color:var(--text-light);font-size:12px;">Coming soon</span>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- No results message -->
        <div id="noResults" style="display:none; text-align:center; padding:48px 0; color:var(--text-muted);">
            <div style="font-size:40px; margin-bottom:12px;">🔍</div>
            <h3 style="font-size:18px; margin-bottom:8px;">No tools found</h3>
            <p style="font-size:14px;">Try a different search term or category.</p>
        </div>
    </div>
</section>

<!-- ==================== HOW IT WORKS ==================== -->
<section class="how-section">
    <div class="container">
        <div class="section-header center">
            <span class="section-label">⚙️ Simple Process</span>
            <h2>How TechOrbit Works</h2>
            <p>Three steps from keyword to content-ready output.</p>
        </div>
        <div class="steps-row">
            <div class="step-item">
                <div class="step-num">1</div>
                <h3>Choose Your Tool</h3>
                <p>Pick from 35+ AI tools — SEO, content writing, keyword research, or technical SEO.</p>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <h3>Enter Your Topic</h3>
                <p>Type your keyword or topic. Our AI uses GPT-4o or Gemini to generate results instantly.</p>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <h3>Copy &amp; Publish</h3>
                <p>Copy the generated output directly to your CMS, Google Sheets, or wherever you work.</p>
            </div>
        </div>
    </div>
</section>

<!-- ==================== TESTIMONIALS ==================== -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header center">
            <span class="section-label">💬 What Users Say</span>
            <h2>Trusted by SEO Professionals</h2>
            <p>Join thousands of bloggers, agencies, and marketers who use TechOrbit daily.</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"The keyword cluster tool alone saved me 3 hours of manual research. I use it before every content sprint now."</p>
                <div class="testimonial-auth">
                    <div class="auth-avatar">R</div>
                    <div class="auth-info"><strong>Rohit Sharma</strong><span>SEO Strategist · Mumbai</span></div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"Better meta descriptions in 10 seconds flat. My CTR jumped 18% in the first month after switching to TechOrbit."</p>
                <div class="testimonial-auth">
                    <div class="auth-avatar">P</div>
                    <div class="auth-info"><strong>Priya Nair</strong><span>Content Lead · Bangalore</span></div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">★★★★★</div>
                <p class="testimonial-text">"The FAQ schema generator is brilliant. Rich results showing up within a week of implementation. Incredible!"</p>
                <div class="testimonial-auth">
                    <div class="auth-avatar">A</div>
                    <div class="auth-info"><strong>Ahmed Al-Rashid</strong><span>Digital Agency Owner · Dubai</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==================== CTA ==================== -->
<section class="cta-section">
    <div class="container">
        <div class="cta-inner">
            <span class="section-label" style="background:rgba(255,107,44,0.18); color:#FFB07A; border:1px solid rgba(255,107,44,0.3);">No Account Required</span>
            <h2>Start Optimising Your Content Today</h2>
            <p>35+ AI-powered tools. No registration. No limits. Just results.</p>
            <div class="cta-btns">
                <a href="<?php echo esc_url(home_url('/tools/')); ?>" class="btn-primary" style="font-size:15px; padding:12px 28px;">🛠 Explore All Tools</a>
                <a href="<?php echo esc_url(home_url('/tools/meta-generator/')); ?>" class="btn-ghost-dark">Try Meta Generator</a>
            </div>
        </div>
    </div>
</section>

<!-- Category filter + search JS -->
<script>
function filterCat(cat, btn) {
    // Update active button
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    // Clear search
    document.getElementById('toolSearch').value = '';
    // Filter cards
    let visible = 0;
    document.querySelectorAll('.tool-card').forEach(card => {
        const match = cat === 'all' || card.dataset.cat === cat;
        card.style.display = match ? 'block' : 'none';
        if (match) visible++;
    });
    document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
}
function filterBySearch(query) {
    // Clear category filter
    document.querySelectorAll('.cat-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('[data-cat="all"]').classList.add('active');
    const q = query.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('.tool-card').forEach(card => {
        const name = card.dataset.name || '';
        const desc = card.querySelector('p')?.textContent.toLowerCase() || '';
        const match = !q || name.includes(q) || desc.includes(q);
        card.style.display = match ? 'block' : 'none';
        if (match) visible++;
    });
    document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
}
</script>

<?php
// Footer Ad
techorbit_adsense( 'footer' );
?>


<?php get_footer(); ?>
