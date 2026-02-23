<?php
/**
 * Template Name: Home
 * Template for the homepage — full hero + features + tools + how-it-works + testimonials
 *
 * @package techorbit-seo
 */
get_header();
?>

<!-- ============================================================
     HERO SECTION
     ============================================================ -->
<section class="hero-section" aria-label="Hero">
    <div class="hero-inner">
        <div class="hero-badge">
            <span class="badge-dot"></span>
            AI-Powered SEO Tools · 100% Free
        </div>

        <h1 class="hero-title">
            All&#8209;in&#8209;One SEO Toolkit<br>
            <span class="highlight">Powered by AI</span>
        </h1>

        <p class="hero-subtitle">
            Generate meta tags, build keyword clusters, create blog outlines, write FAQs and product descriptions — all in seconds with OpenAI &amp; Google Gemini.
        </p>

        <div class="hero-actions">
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-primary" style="font-size:16px;padding:16px 32px;">
                🚀 Try AI Tools Free
            </a>
            <a href="#how-it-works" class="btn-ghost" style="font-size:16px;padding:14px 28px;">
                How It Works ↓
            </a>
        </div>

        <!-- Stats Counter -->
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number" data-count="5000" data-suffix="+">0+</span>
                <span class="stat-label">SEO Reports Generated</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="5" data-suffix="">0</span>
                <span class="stat-label">AI Powered Tools</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="100" data-suffix="%">0%</span>
                <span class="stat-label">Free to Use</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="2" data-suffix=" AI APIs">0</span>
                <span class="stat-label">OpenAI + Gemini</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     FEATURES STRIP
     ============================================================ -->
<section class="features-strip" aria-label="Features">
    <div class="container-wide">
        <div class="features-strip-inner">
            <div class="feature-item">
                <div class="feature-icon">🏷️</div>
                <div class="feature-text">
                    <strong>Meta Generator</strong>
                    <span>AI-optimized titles & descriptions</span>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">📝</div>
                <div class="feature-text">
                    <strong>Blog Outline</strong>
                    <span>SEO-structured content outlines</span>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🔑</div>
                <div class="feature-text">
                    <strong>Keyword Cluster</strong>
                    <span>Intent-matched keyword groups</span>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">❓</div>
                <div class="feature-text">
                    <strong>FAQ Generator</strong>
                    <span>Schema-ready FAQ JSON-LD</span>
                </div>
            </div>
            <div class="feature-item">
                <div class="feature-icon">🛒</div>
                <div class="feature-text">
                    <strong>Product Desc</strong>
                    <span>SEO copy for e-commerce</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     AI TOOLS GRID
     ============================================================ -->
<section class="tools-section" aria-labelledby="tools-heading">
    <div class="container">
        <div class="section-header">
            <span class="section-label">AI-Powered Tools</span>
            <h2 id="tools-heading">Everything You Need to <span class="text-gradient">Rank Higher</span></h2>
            <p>Five powerful AI SEO tools built for content creators, marketers, and SEO professionals. Powered by OpenAI GPT and Google Gemini.</p>
        </div>

        <div class="tools-grid">
            <?php
            $tools = [
                [
                    'icon'  => '🏷️',
                    'title' => 'AI Meta Generator',
                    'desc'  => 'Generate perfectly optimized SEO meta titles (max 60 chars) and meta descriptions (max 160 chars) in one click. Boost your click-through rates from Google SERPs.',
                    'url'   => home_url( '/tools/meta-generator/' ),
                    'badge' => 'Most Popular',
                ],
                [
                    'icon'  => '📝',
                    'title' => 'AI Blog Outline Builder',
                    'desc'  => 'Create detailed, SEO-structured blog post outlines with H1, H2, and H3 headings in seconds. Never start a post from a blank page again.',
                    'url'   => home_url( '/tools/blog-outline/' ),
                    'badge' => 'Content Planning',
                ],
                [
                    'icon'  => '🔑',
                    'title' => 'AI Keyword Cluster Tool',
                    'desc'  => 'Cluster your seed keywords into topical groups with search intent tags — informational, commercial, transactional, or navigational.',
                    'url'   => home_url( '/tools/keyword-cluster/' ),
                    'badge' => 'Keyword Research',
                ],
                [
                    'icon'  => '❓',
                    'title' => 'AI FAQ Generator',
                    'desc'  => 'Generate 8 SEO-optimized FAQs with complete Schema.org FAQPage JSON-LD markup. Improve your chances of winning Google featured snippets.',
                    'url'   => home_url( '/tools/faq-generator/' ),
                    'badge' => 'Schema Ready',
                ],
                [
                    'icon'  => '🛒',
                    'title' => 'AI Product Description',
                    'desc'  => 'Write SEO-optimized product descriptions that rank and convert. Benefits-first copy with natural keyword integration and a soft call to action.',
                    'url'   => home_url( '/tools/product-description/' ),
                    'badge' => 'E-commerce',
                ],
            ];
            foreach ( $tools as $tool ) :
            ?>
                <div class="tool-card">
                    <div class="tool-card-icon"><?php echo esc_html( $tool['icon'] ); ?></div>
                    <h3><?php echo esc_html( $tool['title'] ); ?></h3>
                    <p><?php echo esc_html( $tool['desc'] ); ?></p>
                    <div class="tool-card-footer">
                        <span class="tool-badge">✅ <?php echo esc_html( $tool['badge'] ); ?></span>
                        <a href="<?php echo esc_url( $tool['url'] ); ?>" class="tool-cta">Try Free →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     HOW IT WORKS
     ============================================================ -->
<section class="how-section" id="how-it-works" aria-labelledby="how-heading">
    <div class="container">
        <div class="section-header">
            <span class="section-label">How It Works</span>
            <h2 id="how-heading">Get SEO Results in <span class="text-gradient">3 Simple Steps</span></h2>
        </div>

        <div class="steps-grid">
            <div class="step-item">
                <div class="step-number">1</div>
                <h3>Choose Your Tool</h3>
                <p>Select from our 5 AI-powered SEO tools — meta generator, blog outline builder, keyword clusterer, FAQ generator, or product description writer.</p>
            </div>
            <div class="step-item">
                <div class="step-number">2</div>
                <h3>Enter Your Topic</h3>
                <p>Type your page title, target keyword, or product name. Our AI understands context and intent to produce highly relevant SEO content.</p>
            </div>
            <div class="step-item">
                <div class="step-number">3</div>
                <h3>Copy & Publish</h3>
                <p>Get your AI-generated result in seconds. Copy it to your clipboard and paste it directly into WordPress, Shopify, or any CMS.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     ADSENSE LEADERBOARD
     ============================================================ -->
<div style="background:#F9FAFB;padding:24px 0;">
    <div class="container" style="text-align:center;">
        <?php techorbit_adsense( 'content' ); ?>
    </div>
</div>

<!-- ============================================================
     TESTIMONIALS
     ============================================================ -->
<section class="testimonials-section" aria-labelledby="testimonials-heading">
    <div class="container">
        <div class="section-header">
            <span class="section-label" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.9);">What Users Say</span>
            <h2 id="testimonials-heading" style="color:#fff;">Loved by SEO Professionals</h2>
            <p>Join thousands of marketers and content creators who use TechOrbit SEO daily.</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                <p class="testimonial-text">"The AI Meta Generator saved me hours every week. I used to spend 20 minutes crafting perfect meta tags — now it's done in 5 seconds and the quality is better than what I wrote manually."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">RK</div>
                    <div class="author-info">
                        <strong>Rahul Kumar</strong>
                        <span>SEO Consultant, Delhi</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                <p class="testimonial-text">"The keyword clustering tool is incredible. It groups keywords by search intent in a way I could never do manually. My content strategy has completely transformed since using TechOrbit SEO."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">PS</div>
                    <div class="author-info">
                        <strong>Priya Sharma</strong>
                        <span>Digital Marketing Manager</span>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                <p class="testimonial-text">"FAQ Generator with Schema JSON-LD is a game changer. Three of my product pages now appear in Google's featured snippets thanks to the schema markup this tool generates. Absolutely worth it!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">AM</div>
                    <div class="author-info">
                        <strong>Aisha Mohammed</strong>
                        <span>E-commerce Store Owner</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     BOTTOM CTA
     ============================================================ -->
<section style="background:#fff;padding:80px 0;text-align:center;">
    <div class="container">
        <span class="section-label">Start Now</span>
        <h2 style="font-size:clamp(28px,4vw,42px);margin:12px 0 16px;">Ready to Boost Your SEO Rankings?</h2>
        <p style="color:var(--text-muted);font-size:17px;margin-bottom:40px;max-width:500px;margin-left:auto;margin-right:auto;">
            All 5 AI tools are completely free to use. No sign-up required. Just enter your topic and let AI do the work.
        </p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-primary" style="font-size:16px;padding:16px 36px;">
                🚀 Start Using Free Tools
            </a>
            <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" class="btn-secondary" style="font-size:16px;padding:14px 32px;">
                📖 Read SEO Blog
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
