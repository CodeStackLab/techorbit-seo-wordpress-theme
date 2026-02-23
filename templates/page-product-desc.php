<?php
/**
 * Template Name: Product Description Writer
 * AI Product Description Generator
 *
 * @package techorbit-seo
 */
get_header();

$model       = get_option( 'techorbit_default_ai_model', 'gpt-4o-mini' );
$model_label = techorbit_ai_models()[ $model ] ?? $model;
?>

<div class="tool-hero">
    <span class="tool-hero-label">🛒 E-Commerce SEO Tool</span>
    <h1>AI Product Description Writer</h1>
    <p>Write SEO-optimized product descriptions that rank in search and convert visitors into buyers.</p>
    <div class="tool-hero-meta">
        <span class="tool-meta-item">⚡ 150–300 words in seconds</span>
        <span class="tool-meta-item">✅ SEO keyword integrated</span>
        <span class="tool-meta-item">🛒 Conversion optimized</span>
    </div>
</div>

<div class="tool-page-layout">
    <div class="tool-main">

        <div class="tool-interface">
            <div class="tool-interface-header">
                <span class="tool-interface-icon">🛒</span>
                <h2>Generate Your Product Description</h2>
            </div>
            <div class="tool-interface-body">
                <form id="ai-tool-form" data-tool="product-desc" novalidate>
                    <div class="tool-input-panel">
                        <label class="input-label" for="tool_input">Product Name <span style="color:#EF4444;">*</span></label>
                        <span class="input-hint">Enter the product name exactly as it should appear in the description</span>
                        <input type="text"
                               id="tool_input"
                               name="tool_input"
                               class="tool-input"
                               placeholder="e.g. ProFlash Wireless Earbuds"
                               maxlength="200"
                               required>
                        <div class="tool-input-char-count"><span id="char-counter">0 characters</span></div>
                    </div>

                    <div class="tool-input-panel" style="margin-top:20px;">
                        <label class="input-label" for="tool_input2">Key Features & Details</label>
                        <span class="input-hint">List the features, specifications, or benefits you want highlighted</span>
                        <textarea id="tool_input2"
                                  name="tool_input2"
                                  class="tool-input"
                                  rows="5"
                                  placeholder="e.g.&#10;- 30-hour battery life&#10;- Active Noise Cancellation&#10;- IPX5 waterproof&#10;- Bluetooth 5.3&#10;- Compatible with iOS and Android"></textarea>
                    </div>

                    <div class="tool-submit-row">
                        <button type="submit" class="tool-submit-btn" id="tool-submit-btn">
                            <span>🤖 Write Product Description</span>
                        </button>
                        <div class="tool-model-badge">
                            <span class="model-dot"></span>
                            <?php echo esc_html( $model_label ); ?>
                        </div>
                    </div>
                </form>

                <div class="loading-spinner" id="loading">
                    <div class="spinner"></div>
                    <p>AI is crafting your product copy<span class="loading-dots"><span>.</span><span>.</span><span>.</span></span></p>
                </div>

                <div class="tool-error" id="tool-error" role="alert"></div>

                <div class="tool-output-panel" id="tool-output">
                    <div class="output-header">
                        <h3>✅ Your Product Description</h3>
                        <div class="output-actions">
                            <button class="btn-regenerate" onclick="document.getElementById('ai-tool-form').dispatchEvent(new Event('submit'))">↻ Regenerate</button>
                            <button class="btn-copy" onclick="copyResult(this)">📋 Copy Text</button>
                        </div>
                    </div>
                    <div class="output-content" id="output-content"></div>
                </div>
            </div>
        </div>

        <div style="margin-top:32px;"><?php techorbit_adsense( 'content' ); ?></div>

        <div class="tool-description-section">
            <h2>Why Product Descriptions Matter for E-Commerce SEO</h2>
            <p>Most e-commerce sites make the same critical mistake: they copy manufacturer descriptions verbatim. Google penalizes duplicate content — and manufacturer descriptions appear on hundreds of retailers' sites. A unique, keyword-optimized product description is one of the highest-ROI SEO activities for online stores.</p>

            <h3>What Makes an SEO-Optimized Product Description?</h3>
            <p>Our AI writes product descriptions that satisfy both Google's crawlers and human buyers:</p>
            <ul>
                <li><strong>Primary keyword integration</strong> — includes the product name and key terms naturally, without keyword stuffing</li>
                <li><strong>Benefits-first approach</strong> — leads with what the customer gains, not just features</li>
                <li><strong>150–300 word length</strong> — long enough for SEO signals, concise enough to maintain buyer attention</li>
                <li><strong>Sensory and emotional language</strong> — creates desire and makes the product tangible</li>
                <li><strong>Soft call to action</strong> — nudges toward purchase without hard-selling</li>
            </ul>

            <h3>Where to Use Your Generated Descriptions</h3>
            <p>These descriptions work on WooCommerce, Shopify, Amazon listings, Etsy stores, and any e-commerce platform. For maximum SEO impact, add the product schema markup (Product, Offer, AggregateRating) alongside the description to potentially earn rich results in Google Shopping.</p>

            <h3>Tips for Better Results</h3>
            <p>The more specific your feature list, the better the AI output. Instead of "good earbuds", provide "30-hour battery, ANC, IPX5 waterproof, Bluetooth 5.3". Specificity helps the AI write copy that speaks directly to buyer needs and differentiates your product from generic alternatives.</p>
        </div>

    </div>

    <div class="tool-sidebar">
        <?php techorbit_adsense( 'sidebar' ); ?>
        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">📊 Description Formula</h3>
            <ul style="display:flex;flex-direction:column;gap:10px;font-size:14px;color:var(--text-dark);">
                <li>1️⃣ <strong>Hook</strong> — compelling first sentence</li>
                <li>2️⃣ <strong>Benefits</strong> — what it does for the buyer</li>
                <li>3️⃣ <strong>Features</strong> — key specs</li>
                <li>4️⃣ <strong>Keyword</strong> — natural integration</li>
                <li>5️⃣ <strong>CTA</strong> — soft purchase push</li>
            </ul>
        </div>
        <div class="sidebar-card" style="margin-top:20px;">
            <h3 class="sidebar-card-title">📚 Other AI Tools</h3>
            <ul class="sidebar-tool-list">
                <li><a href="<?php echo esc_url( home_url( '/tools/meta-generator/' ) ); ?>"><span class="tool-emoji">🏷️</span> Meta Generator</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/blog-outline/' ) ); ?>"><span class="tool-emoji">📝</span> Blog Outline Builder</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/keyword-cluster/' ) ); ?>"><span class="tool-emoji">🔑</span> Keyword Cluster Tool</a></li>
                <li><a href="<?php echo esc_url( home_url( '/tools/faq-generator/' ) ); ?>"><span class="tool-emoji">❓</span> FAQ Generator</a></li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); ?>
