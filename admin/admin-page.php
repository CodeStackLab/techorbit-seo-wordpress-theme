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
    add_options_page(
        __( 'TechOrbit AI Settings', 'techorbit-seo' ),
        __( 'TechOrbit AI', 'techorbit-seo' ),
        'manage_options',
        'techorbit-ai-settings',
        'techorbit_admin_page_render'
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
                        <label for="techorbit_adsense_slot_content" class="field-label"><?php esc_html_e( 'In-Content Ad Slot ID', 'techorbit-seo' ); ?> <span class="badge">Auto</span></label>
                        <input type="text" id="techorbit_adsense_slot_content" name="techorbit_adsense_slot_content"
                               value="<?php echo esc_attr( $settings['adsense_slot_content'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                    </div>

                    <div class="settings-field">
                        <label for="techorbit_adsense_slot_sidebar" class="field-label"><?php esc_html_e( 'Sidebar Ad Slot ID', 'techorbit-seo' ); ?> <span class="badge">300×250</span></label>
                        <input type="text" id="techorbit_adsense_slot_sidebar" name="techorbit_adsense_slot_sidebar"
                               value="<?php echo esc_attr( $settings['adsense_slot_sidebar'] ); ?>"
                               class="settings-input" placeholder="1234567890">
                    </div>
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

            <!-- Save Button -->
            <div class="settings-footer">
                <?php submit_button( __( '💾 Save All Settings', 'techorbit-seo' ), 'primary large', 'submit', false ); ?>
            </div>

        </form>
    </div><!-- .techorbit-admin-wrap -->
    <?php
}
