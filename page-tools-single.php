<?php
/**
 * Template Name: AI Tool Single
 * Dynamic template for individual AI tools
 *
 * @package techorbit-seo
 */

get_header();

// Get tool details based on slug
$slug  = get_post_field('post_name', get_the_ID());
$tools = techorbit_get_tools_registry();
$tool  = $tools[$slug] ?? null;

// Fallback to post title if not in array
if (!$tool) {
    $tool = [
        'name' => get_the_title(),
        'desc' => 'AI powered SEO tool.',
        'icon' => '🛠',
        'cat'  => 'seo'
    ];
}

$tool_id = $slug === 'product-description' ? 'product-desc' : $slug;
?>

<section class="tool-hero-compact">
    <div class="container">
        <div class="tool-hero-inner">
            <div class="tool-icon-large"><?php echo $tool['icon']; ?></div>
            <div class="tool-title-wrap">
                <span class="tool-cat-badge"><?php echo esc_html(ucfirst($tool['cat'])); ?> Tool</span>
                <h1><?php echo esc_html($tool['name']); ?></h1>
                <p><?php echo esc_html($tool['desc']); ?></p>
            </div>
        </div>
    </div>
</section>

<div class="site-content" style="background: var(--bg-soft); min-height: 100vh;">
    <div class="container tool-main-container">
        <div class="tool-layout">
            <!-- Main Content Area -->
            <div class="tool-main-content">
                <div class="tool-main-card">
                    <form id="ai-tool-form" data-tool="<?php echo esc_attr($tool_id); ?>">
                        <div class="form-group">
                            <label for="tool_input">Describe what you need</label>
                            <textarea name="tool_input" id="tool_input" placeholder="e.g., Sustainable Fashion, SEO Strategy for Realtors..." required></textarea>
                            <div id="char-counter">0 characters</div>
                        </div>

                        <?php if ($tool_id === 'product-desc' || $tool_id === 'paragraph-expander' || $tool_id === 'schema-generator'): ?>
                        <div class="form-group" style="margin-top:24px;">
                            <label for="tool_input2">Additional Context (Optional)</label>
                            <textarea name="tool_input2" id="tool_input2" placeholder="e.g., Target audience, key features, specific keywords to include..."></textarea>
                        </div>
                        <?php endif; ?>

                        <div class="tool-actions" style="margin-top: 32px;">
                            <button type="submit" id="tool-submit-btn" class="btn-primary" style="width:100%; height:60px; font-size:18px; border-radius:16px;">
                                Generate Results ✨
                            </button>
                        </div>
                    </form>

                    <!-- Loading State -->
                    <div id="loading" class="tool-loading" style="display:none; flex-direction:column; align-items:center; justify-content:center; padding:60px 0; margin-top:32px;">
                        <div class="spinner"></div>
                        <p style="margin-top:20px; font-weight:600; color:var(--text-dark);">AI is processing your request...</p>
                        <p style="font-size:14px; color:var(--text-muted);">This usually takes 5-10 seconds.</p>
                    </div>

                    <!-- Error State -->
                    <div id="tool-error" class="tool-error-msg" style="display:none; margin-top:24px; padding:16px; background:#FEF2F2; color:#DC2626; border-radius:12px; border:1px solid #FCA5A5;"></div>

                    <!-- Output Block -->
                    <div id="tool-output" class="tool-output-block" style="display:none; margin-top:40px;">
                        <div class="output-header">
                            <span class="output-label">Generated content</span>
                            <button class="btn-copy" onclick="copyResult(this)">📋 Copy</button>
                        </div>
                        <div id="output-content" class="output-content"></div>
                    </div>
                </div>

                <!-- Toolkit Description -->
                <div class="tool-content-info" style="margin-top: 60px; background:#fff; border-radius:24px; padding:40px; border:1px solid var(--border);">
                    <h2 style="font-size: 28px; margin-bottom: 24px; color: var(--text-dark); letter-spacing:-0.5px;">About <?php echo esc_html($tool['name']); ?></h2>
                    <div class="tool-description-text" style="color: var(--text-body); line-height: 1.8; font-size: 16px;">
                        <p><?php echo esc_html($tool['desc']); ?></p>
                        <p style="margin-top: 20px;">
                            This AI-powered tool is designed to help you streamline your <?php echo esc_html($tool['cat']); ?> workflow. 
                            By leveraging advanced language models, it provides high-quality, relevant results that can save you hours of manual work.
                        </p>
                        
                        <div class="benefits-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-top: 40px;">
                            <div class="benefit-item">
                                <span style="font-size:32px; display:block; margin-bottom:12px;">⚡</span>
                                <strong>Fast & Efficient</strong>
                                <p style="font-size:14px; margin-top:8px;">Get results in seconds, not hours.</p>
                            </div>
                            <div class="benefit-item">
                                <span style="font-size:32px; display:block; margin-bottom:12px;">📈</span>
                                <strong>SEO Optimized</strong>
                                <p style="font-size:14px; margin-top:8px;">Built with search engine best practices.</p>
                            </div>
                            <div class="benefit-item">
                                <span style="font-size:32px; display:block; margin-bottom:12px;">✅</span>
                                <strong>High Quality</strong>
                                <p style="font-size:14px; margin-top:8px;">Professional grade AI output.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="tool-sidebar">
                <div class="sidebar-widget" style="background:var(--gradient-cta); color:#fff; padding:30px; border-radius:24px; box-shadow: 0 10px 20px rgba(255,107,44,0.2);">
                    <h3 style="color:#fff; margin-bottom:16px;">💡 Pro Tips</h3>
                    <ul style="list-style:none; padding:0; display:flex; flex-direction:column; gap:12px;">
                        <li style="display:flex; gap:10px; font-size:14px;"><span>✔</span> Be specific about your topic.</li>
                        <li style="display:flex; gap:10px; font-size:14px;"><span>✔</span> Provide context if possible.</li>
                        <li style="display:flex; gap:10px; font-size:14px;"><span>✔</span> Tweak input for better results.</li>
                    </ul>
                </div>

                <!-- Related Tools Widget -->
                <div class="sidebar-widget" style="margin-top:32px;">
                    <h3>🔗 Related Tools</h3>
                    <div class="related-tools-list" style="display: flex; flex-direction: column; gap: 12px; margin-top:20px;">
                        <?php 
                        $current_cat = $tool['cat'];
                        $related_count = 0;
                        foreach ($tools as $t_slug => $t_data) {
                            if ($t_data['cat'] === $current_cat && $t_slug !== $slug && $related_count < 4) {
                                $related_count++;
                                ?>
                                <a href="/tools/<?php echo esc_attr($t_slug); ?>/" class="related-tool-item" style="display: flex; align-items: center; gap: 15px; padding: 16px; background:#fff; border: 1px solid var(--border); border-radius: 16px; text-decoration: none; transition: var(--transition);">
                                    <span style="font-size: 24px;"><?php echo $t_data['icon']; ?></span>
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-size: 14px; font-weight: 700; color: var(--text-dark);"><?php echo esc_html($t_data['name']); ?></span>
                                        <span style="font-size: 11px; color: var(--text-muted);"><?php echo esc_html(substr($t_data['desc'], 0, 35)); ?>...</span>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <div class="sidebar-widget ads-widget" style="margin-top:32px;">
                    <?php techorbit_adsense('sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>
