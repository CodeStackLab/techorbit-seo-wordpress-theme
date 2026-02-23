<?php
/**
 * Template Name: Blog Outline Builder
 * AI Blog Outline Generator Tool
 *
 * @package techorbit-seo
 */
get_header();

$model       = get_option( 'techorbit_default_ai_model', 'gpt-4o-mini' );
$model_label = techorbit_ai_models()[ $model ] ?? $model;
?>

<div class="tool-hero">
    <span class="tool-hero-label">📝 AI Content Tool</span>
    <h1>AI Blog Outline Builder</h1>
    <p>Create detailed, SEO-structured blog post outlines with H1, H2, and H3 headings in seconds.</p>
    <div class="tool-hero-meta">
        <span class="tool-meta-item">⚡ Full outline in ~5 seconds</span>
        <span class="tool-meta-item">✅ H1, H2, H3 structured</span>
        <span class="tool-meta-item">📋 Copy-ready format</span>
    </div>
</div>

<div class="tool-page-layout">
    <div class="tool-main">

        <div class="tool-interface">
            <div class="tool-interface-header">
                <span class="tool-interface-icon">📝</span>
                <h2>Generate Your Blog Outline</h2>
            </div>
            <div class="tool-interface-body">
                <form id="ai-tool-form" data-tool="blog-outline" novalidate>
                    <div class="tool-input-panel">
                        <label class="input-label" for="tool_input">Blog Topic or Target Keyword <span style="color:#EF4444;">*</span></label>
                        <span class="input-hint">Be specific — include your main keyword and topic angle for better results</span>
                        <input type="text"
                               id="tool_input"
                               name="tool_input"
                               class="tool-input"
                               placeholder="e.g. How to Do Keyword Research for a New Blog in 2025"
                               maxlength="300"
                               required>
                        <div class="tool-input-char-count"><span id="char-counter">0 characters</span></div>
                    </div>

                    <div class="tool-submit-row">
                        <button type="submit" class="tool-submit-btn" id="tool-submit-btn">
                            <span>🤖 Generate Blog Outline</span>
                        </button>
                        <div class="tool-model-badge">
                            <span class="model-dot"></span>
                            <?php echo esc_html( $model_label ); ?>
                        </div>
                    </div>
                </form>

                <div class="loading-spinner" id="loading">
                    <div class="spinner"></div>
                    <p>Building your SEO outline<span class="loading-dots"><span>.</span><span>.</span><span>.</span></span></p>
                </div>

                <div class="tool-error" id="tool-error" role="alert"></div>

                <div class="tool-output-panel" id="tool-output">
                    <div class="output-header">
                        <h3>✅ Your Blog Outline</h3>
                        <div class="output-actions">
                            <button class="btn-regenerate" onclick="document.getElementById('ai-tool-form').dispatchEvent(new Event('submit'))">↻ Regenerate</button>
                            <button class="btn-copy" onclick="copyResult(this)">📋 Copy Outline</button>
                        </div>
                    </div>
                    <div class="output-content" id="output-content" style="background:#fff;padding:28px;"></div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px;"><?php techorbit_adsense( 'content' ); ?></div>

        <div class="tool-description-section">
            <h2>Why Use an AI Blog Outline Generator?</h2>
            <p>Writing a well-structured blog post is one of the highest-impact SEO activities, but creating the outline from scratch can take 30–60 minutes per article. An AI blog outline builder collapses that time to under 10 seconds while producing outlines that are better structured, more comprehensive, and more aligned with search intent than most manually written outlines.</p>

            <h3>What Makes an SEO-Optimized Blog Outline?</h3>
            <p>Google's algorithms reward content that demonstrates topical authority and comprehensive coverage. Our AI generates outlines with a single SEO-focused H1, multiple H2 sections covering the topic's key subtopics, and H3 sub-sections for detailed breakdowns. This structure naturally creates opportunities for LSI keywords and long-tail keyword coverage.</p>

            <h3>How to Use Your Generated Outline</h3>
            <p>Once you receive your outline, copy it directly into your WordPress, Google Docs, or Notion editor. Use the H1 as your post title, write content under each H2 and H3 section, aiming for 150–300 words per section. This approach produces 1,500–3,000 word articles that rank well for competitive keywords.</p>

            <h3>Best Practices for Blog Outlines</h3>
            <ul>
                <li>Include your primary keyword in the H1 and at least 2–3 H2 headings</li>
                <li>Add an FAQ section at the end to capture featured snippet opportunities</li>
                <li>Use numbers in headings (e.g., "7 Ways to...") for higher CTR</li>
                <li>Include a "Key Takeaways" or "Quick Summary" section for better UX</li>
                <li>Research top-ranking pages for your keyword before finalizing the outline</li>
            </ul>
        </div>

    </div><!-- .tool-main -->

    <div class="tool-sidebar">
        <?php techorbit_adsense( 'sidebar' ); ?>
        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">📚 Other AI Tools</h3>
            <ul class="sidebar-tool-list">
                <li><a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>"><span class="tool-emoji">🏷️</span> Meta Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>"><span class="tool-emoji">🔑</span> Keyword Cluster Tool</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>"><span class="tool-emoji">❓</span> FAQ Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>"><span class="tool-emoji">🛒</span> Product Description</a></li>
            </ul>
        </div>
        <div class="sidebar-card sidebar-tips" style="margin-top:20px;">
            <h3 class="sidebar-card-title">💡 Pro Tip</h3>
            <p>Articles with 7+ H2 sections tend to rank in more keyword variations. Use this outline tool to plan comprehensive coverage.</p>
        </div>
    </div>
</div>

<?php get_footer(); ?>
