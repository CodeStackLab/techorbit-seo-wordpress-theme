<?php
/**
 * Admin Settings Page — TechOrbit SEO
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Register admin menu page.
 */
function techorbit_admin_menu() {
    add_menu_page(
        __( 'TechOrbit AI Settings', 'techorbit-seo' ),
        __( 'TechOrbit AI', 'techorbit-seo' ),
        'manage_options',
        'techorbit-ai-settings',
        'techorbit_admin_page_render',
        'dashicons-chart-area', // Modern SEO/AI icon
        26
    );
}
add_action( 'admin_menu', 'techorbit_admin_menu' );

/**
 * Render the admin settings page.
 */
function techorbit_admin_page_render() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    $settings = techorbit_get_settings();
    $models   = techorbit_ai_models();
    $saved    = isset( $_GET['settings-updated'] ) && $_GET['settings-updated'];
    ?>
    <div class="wrap techorbit-admin-wrap" id="techorbit-settings">
        <div class="techorbit-admin-header">
            <div class="admin-header-logo">
                <span class="logo-icon">⚡</span>
                <span>TechOrbit SEO</span>
            </div>
            <span class="admin-version">v<?php echo esc_html( TECHORBIT_VERSION ); ?></span>
        </div>

        <?php if ( $saved ) : ?>
            <div class="notice notice-success is-dismissible" style="margin:16px 0;">
                <p><strong><?php esc_html_e( '✅ Settings saved successfully!', 'techorbit-seo' ); ?></strong></p>
            </div>
        <?php endif; ?>

        <!-- Tab Navigation -->
        <nav class="techorbit-tabs" role="tablist">
            <button class="tab-btn active" data-tab="ai-settings" role="tab" aria-selected="true" id="tab-ai">
                🤖 <?php esc_html_e( 'AI Settings', 'techorbit-seo' ); ?>
            </button>
            <button class="tab-btn" data-tab="adsense" role="tab" aria-selected="false" id="tab-adsense">
                💰 <?php esc_html_e( 'AdSense', 'techorbit-seo' ); ?>
            </button>
            <button class="tab-btn" data-tab="branding" role="tab" aria-selected="false" id="tab-branding">
                🎨 <?php esc_html_e( 'Branding', 'techorbit-seo' ); ?>
            </button>
            <button class="tab-btn" data-tab="social" role="tab" aria-selected="false" id="tab-social">
                📱 <?php esc_html_e( 'Social Media', 'techorbit-seo' ); ?>
            </button>
            <button class="tab-btn" data-tab="tools-manager" role="tab" aria-selected="false" id="tab-tools">
                🔧 <?php esc_html_e( 'Tools Manager', 'techorbit-seo' ); ?>
            </button>
        </nav>

        <form method="post" action="options.php" class="techorbit-settings-form">
            <?php settings_fields( 'techorbit_settings_group' ); ?>

            <!-- ================================================
                 TAB: AI SETTINGS
                 ================================================ -->
            <div class="tab-panel active" id="panel-ai-settings" role="tabpanel" aria-labelledby="tab-ai">
                <div class="settings-section">
                    <h2><?php esc_html_e( 'AI Model Settings', 'techorbit-seo' ); ?></h2>
                    <p class="section-desc"><?php esc_html_e( 'Configure your AI provider and API keys. Keys are stored securely in your WordPress database.', 'techorbit-seo' ); ?></p>

                    <!-- Default Model -->
                    <div class="settings-field">
                        <label for="techorbit_default_ai_model" class="field-label">
                            <?php esc_html_e( 'Default AI Model', 'techorbit-seo' ); ?>
                        </label>
                        <select id="techorbit_default_ai_model" name="techorbit_default_ai_model" class="settings-select">
                            <?php foreach ( $models as $key => $label ) : ?>
                                <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $settings['default_ai_model'], $key ); ?>>
                                    <?php echo esc_html( $label ); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="field-desc"><?php esc_html_e( 'Choose which AI model powers your SEO tools.', 'techorbit-seo' ); ?></p>
                    </div>

                    <!-- OpenAI API Key -->
                    <div class="settings-field">
                        <label for="techorbit_openai_api_key" class="field-label">
                            🟢 <?php esc_html_e( 'OpenAI API Key', 'techorbit-seo' ); ?>
                        </label>
                        <div class="api-key-wrap">
                            <input type="password"
                                   id="techorbit_openai_api_key"
                                   name="techorbit_openai_api_key"
                                   value="<?php echo esc_attr( $settings['openai_api_key'] ); ?>"
                                   class="settings-input api-key-input"
                                   placeholder="sk-..."
                                   autocomplete="off">
                            <button type="button" class="toggle-key-btn" data-target="techorbit_openai_api_key" title="Show/hide key">👁</button>
                            <button type="button" class="test-api-btn" data-provider="openai" id="test-openai-btn">
                                <?php esc_html_e( 'Test Connection', 'techorbit-seo' ); ?>
                            </button>
                        </div>
                        <span class="api-test-result" id="openai-test-result"></span>
                        <p class="field-desc">
                            <?php esc_html_e( 'Get your key at', 'techorbit-seo' ); ?>
                            <a href="https://platform.openai.com/api-keys" target="_blank" rel="noopener">platform.openai.com</a>
                        </p>
                    </div>

                    <!-- Gemini API Key -->
                    <div class="settings-field">
                        <label for="techorbit_gemini_api_key" class="field-label">
                            🔵 <?php esc_html_e( 'Google Gemini API Key', 'techorbit-seo' ); ?>
                        </label>
                        <div class="api-key-wrap">
                            <input type="password"
                                   id="techorbit_gemini_api_key"
                                   name="techorbit_gemini_api_key"
                                   value="<?php echo esc_attr( $settings['gemini_api_key'] ); ?>"
                                   class="settings-input api-key-input"
                                   placeholder="AIza..."
                                   autocomplete="off">
                            <button type="button" class="toggle-key-btn" data-target="techorbit_gemini_api_key" title="Show/hide key">👁</button>
                            <button type="button" class="test-api-btn" data-provider="gemini" id="test-gemini-btn">
                                <?php esc_html_e( 'Test Connection', 'techorbit-seo' ); ?>
                            </button>
                        </div>
                        <span class="api-test-result" id="gemini-test-result"></span>
                        <p class="field-desc">
                            <?php esc_html_e( 'Get your key at', 'techorbit-seo' ); ?>
                            <a href="https://aistudio.google.com/app/apikey" target="_blank" rel="noopener">aistudio.google.com</a>
                        </p>
                    </div>

                    <!-- Groq API Key -->
                    <div class="settings-field">
                        <label for="techorbit_groq_api_key" class="field-label">
                            🟠 <?php esc_html_e( 'Groq API Key (High Speed)', 'techorbit-seo' ); ?>
                        </label>
                        <div class="api-key-wrap">
                            <input type="password"
                                   id="techorbit_groq_api_key"
                                   name="techorbit_groq_api_key"
                                   value="<?php echo esc_attr( $settings['groq_api_key'] ); ?>"
                                   class="settings-input api-key-input"
                                   placeholder="gsk_..."
                                   autocomplete="off">
                            <button type="button" class="toggle-key-btn" data-target="techorbit_groq_api_key" title="Show/hide key">👁</button>
                            <button type="button" class="test-api-btn" data-provider="groq" id="test-groq-btn">
                                <?php esc_html_e( 'Test Connection', 'techorbit-seo' ); ?>
                            </button>
                        </div>
                        <span class="api-test-result" id="groq-test-result"></span>
                        <p class="field-desc">
                            <?php esc_html_e( 'Get your key at', 'techorbit-seo' ); ?>
                            <a href="https://console.groq.com/keys" target="_blank" rel="noopener">console.groq.com</a>
                        </p>
                    </div>

                    <hr style="margin: 30px 0; border: 0; border-top: 1px solid var(--border);">

                    <!-- OpenRouter API Key -->
                    <div class="settings-field">
                        <label for="techorbit_openrouter_api_key" class="field-label">
                            🟣 <?php esc_html_e( 'OpenRouter API Key (200+ Models)', 'techorbit-seo' ); ?>
                        </label>
                        <div class="api-key-wrap">
                            <input type="password"
                                   id="techorbit_openrouter_api_key"
                                   name="techorbit_openrouter_api_key"
                                   value="<?php echo esc_attr( $settings['openrouter_api_key'] ); ?>"
                                   class="settings-input api-key-input"
                                   placeholder="sk-or-v1-..."
                                   autocomplete="off">
                            <button type="button" class="toggle-key-btn" data-target="techorbit_openrouter_api_key" title="Show/hide key">👁</button>
                            <button type="button" class="test-api-btn" data-provider="openrouter" id="test-openrouter-btn">
                                <?php esc_html_e( 'Test Connection', 'techorbit-seo' ); ?>
                            </button>
                        </div>
                        <span class="api-test-result" id="openrouter-test-result"></span>
                        <p class="field-desc">
                            <?php esc_html_e( 'Access GPT-4, Claude, Llama, and more via', 'techorbit-seo' ); ?>
                            <a href="https://openrouter.ai/keys" target="_blank" rel="noopener">openrouter.ai</a>
                        </p>
                    </div>

                    <!-- OpenRouter Custom Model -->
                    <div class="settings-field">
                        <label for="techorbit_openrouter_model" class="field-label">
                            🚀 <?php esc_html_e( 'OpenRouter Custom Model', 'techorbit-seo' ); ?>
                        </label>
                        <input type="text"
                               id="techorbit_openrouter_model"
                               name="techorbit_openrouter_model"
                               value="<?php echo esc_attr( $settings['openrouter_model'] ); ?>"
                               class="settings-input"
                               placeholder="e.g., anthropic/claude-3-opus:beta">
                        <p class="field-desc"><?php esc_html_e( 'Enter any model string from OpenRouter. Example: "meta-llama/llama-3-70b-instruct", "google/gemma-2-9b-it:free"', 'techorbit-seo' ); ?></p>
                    </div>

                    <hr style="margin: 30px 0; border: 0; border-top: 1px solid var(--border);">

                    <!-- Advanced Failover -->
                    <div class="settings-field">
                        <label class="field-label">🛡 <?php esc_html_e( 'Advanced Smart Failover', 'techorbit-seo' ); ?></label>
                        <div style="display: flex; gap: 20px; align-items: start; margin-top: 10px;">
                            <label class="techorbit-toggle">
                                <input type="checkbox" name="techorbit_enable_failover" value="1" <?php checked( $settings['enable_failover'], '1' ); ?>>
                                <span class="toggle-slider"></span>
                            </label>
                            <div>
                                <strong><?php esc_html_e( 'Enable Multi-Provider Fallback', 'techorbit-seo' ); ?></strong>
                                <p class="field-desc" style="margin-top: 4px;"><?php esc_html_e( 'If the primary model fails or hits rate limits, the toolkit will automatically switch to the next available provider to prevent downtime.', 'techorbit-seo' ); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Provider Priority -->
                    <div class="settings-field">
                        <label for="techorbit_failover_order" class="field-label">
                            🔄 <?php esc_html_e( 'Failover Priority Order', 'techorbit-seo' ); ?>
                        </label>
                        <input type="text"
                               id="techorbit_failover_order"
                               name="techorbit_failover_order"
                               value="<?php echo esc_attr( $settings['failover_order'] ); ?>"
                               class="settings-input"
                               placeholder="openrouter,gemini,openai">
                        <p class="field-desc"><?php esc_html_e( 'Comma-separated list of providers to try in order. "free" is always added at the end as a survival backup.', 'techorbit-seo' ); ?></p>
                    </div>

                </div><!-- .settings-section -->
            </div><!-- #panel-ai-settings -->

            <!-- ================================================
                 TAB: ADSENSE
                 ================================================ -->
            <div class="tab-panel" id="panel-adsense" role="tabpanel" aria-labelledby="tab-adsense">
                <div class="settings-section">
                    <h2><?php esc_html_e( 'Google AdSense Configuration', 'techorbit-seo' ); ?></h2>
                    <p class="section-desc"><?php esc_html_e( 'Enter your AdSense publisher ID and slot IDs. Ads will automatically appear in the header, content, and sidebar zones.', 'techorbit-seo' ); ?></p>

                    <div class="settings-field">
                        <label for="techorbit_adsense_publisher_id" class="field-label"><?php esc_html_e( 'Publisher ID', 'techorbit-seo' ); ?></label>
                        <input type="text" id="techorbit_adsense_publisher_id" name="techorbit_adsense_publisher_id"
                               value="<?php echo esc_attr( $settings['adsense_publisher_id'] ); ?>"
                               class="settings-input" placeholder="ca-pub-1234567890123456">
                        <p class="field-desc"><?php esc_html_e( 'Format: ca-pub-XXXXXXXXXXXXXXXX', 'techorbit-seo' ); ?></p>
                    </div>

                    <div class="settings-field">
                        <label for="techorbit_adsense_slot_header" class="field-label"><?php esc_html_e( 'Header Ad Slot ID', 'techorbit-seo' ); ?> <span class="badge">728×90</span></label>
                        <input type="text" id="techorbit_adsense_slot_header" name="techorbit_adsense_slot_header"
                               value="<?php echo esc_attr( $settings['adsense_slot_header'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                    </div>

                    <div class="settings-field">
                        <label for="techorbit_adsense_slot_content" class="field-label"><?php esc_html_e( 'In-Content Ad Slot ID (Top)', 'techorbit-seo' ); ?> <span class="badge">Auto</span></label>
                        <input type="text" id="techorbit_adsense_slot_content" name="techorbit_adsense_slot_content"
                               value="<?php echo esc_attr( $settings['adsense_slot_content'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                        <p class="field-desc"><?php esc_html_e( 'Appears before the main tool content.', 'techorbit-seo' ); ?></p>
                    </div>

                    <div class="settings-field">
                        <label for="techorbit_adsense_slot_content_after" class="field-label"><?php esc_html_e( 'In-Content Ad Slot ID (Bottom)', 'techorbit-seo' ); ?> <span class="badge">Auto</span></label>
                        <input type="text" id="techorbit_adsense_slot_content_after" name="techorbit_adsense_slot_content_after"
                               value="<?php echo esc_attr( $settings['adsense_slot_content_after'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                        <p class="field-desc"><?php esc_html_e( 'Appears after the main tool content.', 'techorbit-seo' ); ?></p>
                    </div>

                    <div class="settings-field">
                        <label for="techorbit_adsense_slot_sidebar" class="field-label"><?php esc_html_e( 'Sidebar Ad Slot ID', 'techorbit-seo' ); ?> <span class="badge">300×250</span></label>
                        <input type="text" id="techorbit_adsense_slot_sidebar" name="techorbit_adsense_slot_sidebar"
                               value="<?php echo esc_attr( $settings['adsense_slot_sidebar'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                    </div>

                    <div class="settings-field">
                        <label for="techorbit_adsense_slot_footer" class="field-label"><?php esc_html_e( 'Footer Ad Slot ID', 'techorbit-seo' ); ?> <span class="badge">Auto</span></label>
                        <input type="text" id="techorbit_adsense_slot_footer" name="techorbit_adsense_slot_footer"
                               value="<?php echo esc_attr( $settings['adsense_slot_footer'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                    </div>

                    <p class="notice notice-info" style="margin-top:20px; padding:10px; border-left-color:var(--primary);">
                        <?php esc_html_e( '💡 Note: If you leave a Slot ID or Publisher ID empty, the respective ad unit (and its label) will be completely hidden from the frontend.', 'techorbit-seo' ); ?>
                    </p>
                </div>
            </div>

            <!-- ================================================
                 TAB: BRANDING
                 ================================================ -->
            <div class="tab-panel" id="panel-branding" role="tabpanel" aria-labelledby="tab-branding">
                <div class="settings-section">
                    <h2><?php esc_html_e( 'Site Branding', 'techorbit-seo' ); ?></h2>

                    <div class="settings-field">
                        <label class="field-label"><?php esc_html_e( 'Site Logo', 'techorbit-seo' ); ?></label>
                        <div class="logo-upload-wrap">
                            <?php
                            $logo_id  = $settings['site_logo'];
                            $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'thumbnail' ) : '';
                            ?>
                            <?php if ( $logo_url ) : ?>
                                <img src="<?php echo esc_url( $logo_url ); ?>" alt="Current logo" id="logo-preview" style="max-height:60px;border-radius:6px;margin-bottom:12px;">
                            <?php else : ?>
                                <div id="logo-preview" style="display:none;"></div>
                            <?php endif; ?>
                            <input type="hidden" id="techorbit_site_logo" name="techorbit_site_logo" value="<?php echo esc_attr( $logo_id ); ?>">
                            <button type="button" id="upload-logo-btn" class="btn-upload"><?php esc_html_e( '📁 Upload Logo', 'techorbit-seo' ); ?></button>
                            <?php if ( $logo_url ) : ?>
                                <button type="button" id="remove-logo-btn" class="btn-remove"><?php esc_html_e( '✕ Remove', 'techorbit-seo' ); ?></button>
                            <?php endif; ?>
                        </div>
                        <p class="field-desc"><?php esc_html_e( 'Recommended: PNG, max 300×80px, transparent background.', 'techorbit-seo' ); ?></p>
                    </div>
                </div>
            </div>

            <!-- ================================================
                 TAB: SOCIAL
                 ================================================ -->
            <div class="tab-panel" id="panel-social" role="tabpanel" aria-labelledby="tab-social">
                <div class="settings-section">
                    <h2><?php esc_html_e( 'Social Media Links', 'techorbit-seo' ); ?></h2>
                    <p class="section-desc"><?php esc_html_e( 'These links appear in the site footer and social meta tags.', 'techorbit-seo' ); ?></p>

                    <?php
                    $social_fields = [
                        'techorbit_social_twitter'   => [ '𝕏 Twitter / X', 'https://x.com/PortalYojana' ],
                        'techorbit_social_instagram' => [ '📷 Instagram', 'https://www.instagram.com/yojanaportal2110/' ],
                        'techorbit_social_facebook'  => [ '🔵 Facebook', 'https://www.facebook.com/profile.php?id=61584773969337' ],
                        'techorbit_social_youtube'   => [ '▶ YouTube', 'https://www.youtube.com/@YojanaPortal' ],
                        'techorbit_social_pinterest' => [ '📌 Pinterest', 'https://www.pinterest.com/yojanaportal/_profile/' ],
                    ];
                    foreach ( $social_fields as $option_key => $field ) :
                        $key = str_replace( 'techorbit_social_', '', $option_key );
                    ?>
                        <div class="settings-field">
                            <label for="<?php echo esc_attr( $option_key ); ?>" class="field-label"><?php echo esc_html( $field[0] ); ?></label>
                            <input type="url"
                                   id="<?php echo esc_attr( $option_key ); ?>"
                                   name="<?php echo esc_attr( $option_key ); ?>"
                                   value="<?php echo esc_attr( get_option( $option_key, $field[1] ) ); ?>"
                                   class="settings-input"
                                   placeholder="<?php echo esc_attr( $field[1] ); ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ================================================
                 TAB: TOOLS MANAGER
                 ================================================ -->
            <div class="tab-panel" id="panel-tools-manager" role="tabpanel" aria-labelledby="tab-tools">
                <div class="settings-section">
                    <h2><?php esc_html_e( 'Manage AI Tools', 'techorbit-seo' ); ?></h2>
                    <p class="section-desc">
                        <?php esc_html_e( 'Enable or disable individual tools from your 35+ SEO toolkit. Disabled tools will be hidden from the frontend.', 'techorbit-seo' ); ?>
                    </p>

                    <div class="admin-tools-manager-grid">
                        <?php 
                        $all_tools      = techorbit_get_tools_registry();
                        $saved_stats    = get_option('techorbit_tools_status', []);
                        
                        $current_cat = '';
                        foreach ($all_tools as $tool_slug => $tool) : 
                            if ($current_cat !== $tool['cat']) :
                                $current_cat = $tool['cat'];
                                echo '<div class="admin-tools-cat-header">' . esc_html(ucfirst($current_cat)) . ' Tools</div>';
                            endif;

                            // Default to enabled (true) if not set
                            $is_enabled = !isset($saved_stats[$tool_slug]) || $saved_stats[$tool_slug] == '1';
                        ?>
                            <div class="admin-tool-toggle-item">
                                <div class="admin-tool-info">
                                    <span class="admin-tool-icon"><?php echo $tool['icon']; ?></span>
                                    <div class="admin-tool-text">
                                        <strong><?php echo esc_html($tool['name']); ?></strong>
                                        <p><?php echo esc_html($tool['desc']); ?></p>
                                    </div>
                                </div>
                                <label class="techorbit-admin-switch">
                                    <input type="checkbox" name="techorbit_tools_status[<?php echo esc_attr($tool_slug); ?>]" value="1" <?php checked($is_enabled); ?>>
                                    <span class="admin-switch-slider"></span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="settings-footer">
                <?php submit_button( __( '💾 Save All Settings', 'techorbit-seo' ), 'primary large', 'submit', false ); ?>
            </div>

        </form>
    </div><!-- .techorbit-admin-wrap -->
    <?php
}
