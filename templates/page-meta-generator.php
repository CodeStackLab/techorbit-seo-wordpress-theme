<?php
/**
 * Template Name: Meta Generator
 * AI Meta Title & Description Generator Tool
 *
 * @package techorbit-seo
 */
get_header();

$model = get_option( 'techorbit_default_ai_model', 'gpt-4o-mini' );
$model_label = techorbit_ai_models()[ $model ] ?? $model;
?>

<div class="tool-hero">
    <span class="tool-hero-label">🏷️ AI SEO Tool</span>
    <h1>AI Meta Tag Generator</h1>
    <p>Generate SEO-optimized meta titles and meta descriptions in one click. Powered by <?php echo esc_html( $model_label ); ?>.</p>
    <div class="tool-hero-meta">
        <span class="tool-meta-item">⚡ Results in ~3 seconds</span>
        <span class="tool-meta-item">✅ Schema-ready output</span>
        <span class="tool-meta-item">🔒 Rate limited & secure</span>
    </div>
</div>

<div class="tool-page-layout">
    <div class="tool-main">

        <?php techorbit_adsense( 'content' ); ?>

        <!-- Tool Interface -->

        <div class="tool-interface">
            <div class="tool-interface-header">
                <span class="tool-interface-icon">🏷️</span>
                <h2>Generate Your SEO Meta Tags</h2>
            </div>
            <div class="tool-interface-body">
                <form id="ai-tool-form" data-tool="meta-generator" novalidate>
                    <div class="tool-input-panel">
                        <label class="input-label" for="tool_input">
                            Page Title or Topic <span style="color:#EF4444;">*</span>
                        </label>
                        <span class="input-hint">Enter your page title, blog topic, or keyword phrase</span>
                        <input type="text"
                               id="tool_input"
                               name="tool_input"
                               class="tool-input"
                               placeholder="e.g. Best SEO Tools for Small Businesses in 2025"
                               maxlength="200"
                               required
                               aria-required="true">
                        <div class="tool-input-char-count"><span id="char-counter">0 characters</span></div>
                    </div>

                    <div class="tool-submit-row">
                        <button type="submit" class="tool-submit-btn" id="tool-submit-btn">
                            <span>🤖 Generate Meta Tags</span>
                        </button>
                        <div class="tool-model-badge">
                            <span class="model-dot"></span>
                            <?php echo esc_html( $model_label ); ?>
                        </div>
                    </div>
                </form>

                <!-- Loading -->
                <div class="loading-spinner" id="loading">
                    <div class="spinner"></div>
                    <p>AI is crafting your meta tags<span class="loading-dots"><span>.</span><span>.</span><span>.</span></span></p>
                </div>

                <!-- Error -->
                <div class="tool-error" id="tool-error" role="alert"></div>

                <!-- Output -->
                <div class="tool-output-panel" id="tool-output">
                    <div class="output-header">
                        <h3>✅ Generated Meta Tags</h3>
                        <div class="output-actions">
                            <button class="btn-regenerate" onclick="document.getElementById('ai-tool-form').dispatchEvent(new Event('submit'))">↻ Regenerate</button>
                            <button class="btn-copy" onclick="copyResult(this)">📋 Copy All</button>
                        </div>
                    </div>
                    <div class="output-content" id="output-content"></div>
                </div>
            </div><!-- .tool-interface-body -->
        </div><!-- .tool-interface -->

        <?php techorbit_adsense( 'content_after' ); ?>



        <!-- SEO Description -->
        <div class="tool-description-section">
            <h2>What Is an AI Meta Tag Generator?</h2>
            <p>An AI meta tag generator is a tool that uses artificial intelligence to automatically create SEO-optimized meta titles and meta descriptions for any web page. Instead of manually writing and testing dozens of variations, the AI analyzes your topic and generates search-engine-friendly copy in seconds.</p>

            <h3>Why Meta Tags Matter for SEO</h3>
            <p>Meta tags are one of the most critical on-page SEO elements. Your meta title is the clickable blue headline that appears in Google search results — it must be compelling, include your target keyword, and stay under 60 characters to avoid truncation. Your meta description is the 160-character snippet below the title that convinces users to click your link over a competitor's.</p>

            <p>Studies show that optimizing meta tags can increase organic click-through rates by 5–30%. That means more traffic from the same ranking position — without building more backlinks or creating more content.</p>

            <h3>How Our AI Meta Generator Works</h3>
            <p>Our tool uses OpenAI GPT-4o or Google Gemini to analyze your page topic and apply SEO best practices automatically:</p>
            <ul>
                <li><strong>Keyword-rich titles</strong> — naturally includes your primary keyword near the beginning</li>
                <li><strong>Exact character limits</strong> — enforces the 60-char title and 160-char description limits</li>
                <li><strong>Compelling copy</strong> — uses power words that drive click-throughs</li>
                <li><strong>SERP preview</strong> — shows how your tags will look in Google search results</li>
                <li><strong>Instant results</strong> — generates in under 3 seconds</li>
            </ul>

            <h3>When to Use This Tool</h3>
            <p>Use the AI meta generator whenever you publish a new blog post, update an existing page, optimize product pages, or prepare content for a new site launch. It works equally well for blog articles, landing pages, e-commerce product pages, and local business pages.</p>
        </div>

    </div><!-- .tool-main -->

    <!-- Sidebar -->
    <div class="tool-sidebar">
        <?php techorbit_adsense( 'sidebar' ); ?>

        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">📚 Other AI Tools</h3>
            <ul class="sidebar-tool-list">
                <li><a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>"><span class="tool-emoji">📝</span> Blog Outline Builder</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>"><span class="tool-emoji">🔑</span> Keyword Cluster Tool</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>"><span class="tool-emoji">❓</span> FAQ Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>"><span class="tool-emoji">🛒</span> Product Description</a></li>
            </ul>
        </div>

        <div class="sidebar-card sidebar-tips" style="margin-top:20px;">
            <h3 class="sidebar-card-title">💡 Pro Tip</h3>
            <p>Include your target keyword in the first 3 words of your meta title for better relevance signals to Google.</p>
        </div>
    </div>

</div><!-- .tool-page-layout -->

<?php get_footer(); ?>
