<?php
/**
 * Template Name: FAQ Generator
 * AI FAQ Generator with Schema JSON-LD
 *
 * @package techorbit-seo
 */
get_header();

$model       = get_option( 'techorbit_default_ai_model', 'gpt-4o-mini' );
$model_label = techorbit_ai_models()[ $model ] ?? $model;
?>

<div class="tool-hero">
    <span class="tool-hero-label">❓ AI FAQ Tool</span>
    <h1>AI FAQ Generator</h1>
    <p>Generate 8 SEO-optimized FAQs with complete Schema.org FAQPage JSON-LD markup — ready to paste into HTML.</p>
    <div class="tool-hero-meta">
        <span class="tool-meta-item">⚡ 8 FAQs instantly</span>
        <span class="tool-meta-item">✅ Schema.org JSON-LD</span>
        <span class="tool-meta-item">🏆 Featured Snippet Ready</span>
    </div>
</div>

<div class="tool-page-layout">
    <div class="tool-main">

        <?php techorbit_adsense( 'content' ); ?>

        <div class="tool-interface">
            <div class="tool-interface-header">
                <span class="tool-interface-icon">❓</span>
                <h2>Generate Schema-Ready FAQs</h2>
            </div>
            <div class="tool-interface-body">
                <form id="ai-tool-form" data-tool="faq-generator" novalidate>
                    <div class="tool-input-panel">
                        <label class="input-label" for="tool_input">Topic or Page Title <span style="color:#EF4444;">*</span></label>
                        <span class="input-hint">Enter the topic, product, or service you want FAQs for</span>
                        <input type="text"
                               id="tool_input"
                               name="tool_input"
                               class="tool-input"
                               placeholder="e.g. WordPress SEO Optimization"
                               maxlength="200"
                               required>
                        <div class="tool-input-char-count"><span id="char-counter">0 characters</span></div>
                    </div>

                    <div class="tool-submit-row">
                        <button type="submit" class="tool-submit-btn" id="tool-submit-btn">
                            <span>🤖 Generate FAQs + Schema</span>
                        </button>
                        <div class="tool-model-badge">
                            <span class="model-dot"></span>
                            <?php echo esc_html( $model_label ); ?>
                        </div>
                    </div>
                </form>

                <div class="loading-spinner" id="loading">
                    <div class="spinner"></div>
                    <p>AI is generating your FAQs<span class="loading-dots"><span>.</span><span>.</span><span>.</span></span></p>
                </div>

                <div class="tool-error" id="tool-error" role="alert"></div>

                <div class="tool-output-panel" id="tool-output">
                    <div class="output-header">
                        <h3>✅ FAQ JSON-LD Schema</h3>
                        <div class="output-actions">
                            <button class="btn-regenerate" onclick="document.getElementById('ai-tool-form').dispatchEvent(new Event('submit'))">↻ Regenerate</button>
                            <button class="btn-copy" onclick="copyResult(this)">📋 Copy Code</button>
                        </div>
                    </div>
                    <div class="output-content" id="output-content"></div>
                    <p style="font-size:12px;color:var(--text-muted);padding:0 0 16px 0;margin:0;">
                        📌 Paste this code inside your page's <code>&lt;head&gt;</code> section or before <code>&lt;/body&gt;</code>.
                    </p>
                </div>
            </div>
        </div>

        <?php techorbit_adsense( 'content_after' ); ?>

        <div class="tool-description-section">
            <h2>What Is FAQ Schema Markup?</h2>
            <p>FAQ Schema is a type of structured data markup (JSON-LD) that tells Google your page contains a list of frequently asked questions with answers. When Google detects valid FAQ schema on your page, it may display an expanded FAQ section directly in the search results — showing your questions as rich results beneath your blue link.</p>

            <h3>Benefits of FAQ Schema for SEO</h3>
            <p>Adding FAQ schema to your pages can significantly improve your SERP presence and click-through rates:</p>
            <ul>
                <li><strong>Rich snippets</strong> — expandable Q&amp;A sections appear directly in Google results</li>
                <li><strong>Double the SERP real estate</strong> — your listing takes up more space, pushing competitors lower</li>
                <li><strong>Featured snippet opportunities</strong> — well-written answers can trigger position zero</li>
                <li><strong>Voice search alignment</strong> — FAQ format matches how people ask questions to Google Assistant</li>
                <li><strong>Higher CTR</strong> — rich results consistently outperform standard blue links</li>
            </ul>

            <h3>How to Add FAQ Schema to WordPress</h3>
            <p>Copy the JSON-LD script tag generated by our tool. In WordPress, paste it using the Classic Editor's "Text" view, or use the "Custom HTML" block in Gutenberg. Alternatively, you can paste it in a header/footer plugin, or directly in your theme's single.php template. Once live, test it with Google's Rich Results Testing Tool to verify it's valid.</p>

            <h3>FAQ Schema Best Practices</h3>
            <p>For maximum results, ensure your FAQ answers are 40–100 words each — long enough to be informative, short enough to appear as a featured snippet. Questions should match how users actually search. Use this tool alongside the Meta Generator to create fully optimized pages with both tags and structured data.</p>
        </div>

    </div>

    <div class="tool-sidebar">
        <?php techorbit_adsense( 'sidebar' ); ?>
        <div class="sidebar-card" style="margin-top:20px;background:var(--gradient);border:none;">
            <h3 class="sidebar-card-title" style="color:#fff;">🏆 Why FAQ Schema?</h3>
            <ul style="display:flex;flex-direction:column;gap:10px;color:rgba(255,255,255,0.8);font-size:14px;">
                <li>✅ Rich results in Google</li>
                <li>✅ 2-4× more SERP space</li>
                <li>✅ Voice search ready</li>
                <li>✅ Featured snippet boost</li>
                <li>✅ Higher click-through rate</li>
            </ul>
        </div>
        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">📚 Other AI Tools</h3>
            <ul class="sidebar-tool-list">
                <li><a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>"><span class="tool-emoji">🏷️</span> Meta Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>"><span class="tool-emoji">📝</span> Blog Outline Builder</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>"><span class="tool-emoji">🔑</span> Keyword Cluster Tool</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/product-description/' ) ); ?>"><span class="tool-emoji">🛒</span> Product Description</a></li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
