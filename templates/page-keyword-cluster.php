<?php
/**
 * Template Name: Keyword Cluster Tool
 * AI Keyword Cluster Generator
 *
 * @package techorbit-seo
 */
get_header();

$model       = get_option( 'techorbit_default_ai_model', 'gpt-4o-mini' );
$model_label = techorbit_ai_models()[ $model ] ?? $model;
?>

<div class="tool-hero">
    <span class="tool-hero-label">🔑 AI Keyword Tool</span>
    <h1>AI Keyword Cluster Tool</h1>
    <p>Generate 5 keyword clusters with search intent classification from any seed keyword — in seconds.</p>
    <div class="tool-hero-meta">
        <span class="tool-meta-item">⚡ 5 clusters instantly</span>
        <span class="tool-meta-item">✅ Search intent tagged</span>
        <span class="tool-meta-item">📊 25 keywords per run</span>
    </div>
</div>

<div class="tool-page-layout">
    <div class="tool-main">

        <div class="tool-interface">
            <div class="tool-interface-header">
                <span class="tool-interface-icon">🔑</span>
                <h2>Cluster Your Keywords by Intent</h2>
            </div>
            <div class="tool-interface-body">
                <form id="ai-tool-form" data-tool="keyword-cluster" novalidate>
                    <div class="tool-input-panel">
                        <label class="input-label" for="tool_input">Seed / Main Keyword <span style="color:#EF4444;">*</span></label>
                        <span class="input-hint">Enter your primary keyword or topic (e.g., "email marketing", "vegan recipes")</span>
                        <input type="text"
                               id="tool_input"
                               name="tool_input"
                               class="tool-input"
                               placeholder="e.g. content marketing"
                               maxlength="150"
                               required>
                        <div class="tool-input-char-count"><span id="char-counter">0 characters</span></div>
                    </div>

                    <div class="tool-submit-row">
                        <button type="submit" class="tool-submit-btn" id="tool-submit-btn">
                            <span>🤖 Generate Keyword Clusters</span>
                        </button>
                        <div class="tool-model-badge">
                            <span class="model-dot"></span>
                            <?php echo esc_html( $model_label ); ?>
                        </div>
                    </div>
                </form>

                <div class="loading-spinner" id="loading">
                    <div class="spinner"></div>
                    <p>AI is clustering your keywords<span class="loading-dots"><span>.</span><span>.</span><span>.</span></span></p>
                </div>

                <div class="tool-error" id="tool-error" role="alert"></div>

                <div class="tool-output-panel" id="tool-output">
                    <div class="output-header">
                        <h3>✅ Keyword Clusters</h3>
                        <div class="output-actions">
                            <button class="btn-regenerate" onclick="document.getElementById('ai-tool-form').dispatchEvent(new Event('submit'))">↻ Regenerate</button>
                            <button class="btn-copy" onclick="copyResult(this)">📋 Copy All</button>
                        </div>
                    </div>
                    <div class="output-content" id="output-content" style="background:#F9FAFB;padding:20px;"></div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px;"><?php techorbit_adsense( 'content' ); ?></div>

        <div class="tool-description-section">
            <h2>What Is Keyword Clustering in SEO?</h2>
            <p>Keyword clustering is the practice of grouping related keywords together based on semantic relevance and search intent. Instead of creating one page per keyword, you create comprehensive pages that target entire clusters of related terms simultaneously. This is how modern SEO works in the era of Google's Helpful Content and EEAT updates.</p>

            <h3>Why Keyword Clustering Matters</h3>
            <p>Google now evaluates pages based on topical authority — meaning sites that cover a topic deeply and comprehensively tend to outrank sites with many thin, individual-keyword pages. By clustering keywords, you create content that satisfies multiple search queries at once, increasing your chances of ranking for dozens of long-tail variations from a single article.</p>

            <h3>Understanding Search Intent</h3>
            <p>Our AI automatically classifies each cluster by search intent type:</p>
            <ul>
                <li><strong>Informational</strong> — users want to learn (e.g., "what is keyword clustering")</li>
                <li><strong>Commercial</strong> — users are comparing options (e.g., "best keyword research tools")</li>
                <li><strong>Transactional</strong> — users are ready to buy (e.g., "buy SEO software")</li>
                <li><strong>Navigational</strong> — users want a specific site (e.g., "Semrush login")</li>
            </ul>

            <h3>How to Use Keyword Clusters in Your Content Strategy</h3>
            <p>Once you have your clusters, create one pillar page per cluster. Link all related content back to the pillar using internal links. This creates a topical map that Google's crawlers can follow, establishing your site as an authoritative source on the topic. Pair this tool with the Blog Outline Builder to create perfectly structured content for each cluster.</p>
        </div>

    </div>

    <div class="tool-sidebar">
        <?php techorbit_adsense( 'sidebar' ); ?>
        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">🎯 Intent Legend</h3>
            <ul style="display:flex;flex-direction:column;gap:8px;margin-top:4px;">
                <li><span class="cluster-intent intent-informational">Informational</span> — Learn</li>
                <li><span class="cluster-intent intent-commercial">Commercial</span> — Compare</li>
                <li><span class="cluster-intent intent-transactional">Transactional</span> — Buy</li>
                <li><span class="cluster-intent intent-navigational">Navigational</span> — Find Site</li>
            </ul>
        </div>
        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">📚 Other AI Tools</h3>
            <ul class="sidebar-tool-list">
                <li><a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>"><span class="tool-emoji">🏷️</span> Meta Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>"><span class="tool-emoji">📝</span> Blog Outline Builder</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>"><span class="tool-emoji">❓</span> FAQ Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>"><span class="tool-emoji">🛒</span> Product Description</a></li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
