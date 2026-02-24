<?php
/**
 * Template Name: Tools Directory
 * Lists all 35+ AI SEO tools with premium UI
 *
 * @package techorbit-seo
 */
get_header();

// Full list of 35+ 
$all_tools      = techorbit_get_tools_registry();
$categories     = techorbit_get_tool_categories();
$disabled_tools = get_option('techorbit_disabled_tools', []); 
$tool_status    = get_option('techorbit_tools_status', []);

// Filter tools based on status
$tools = array_filter($all_tools, function($tool_slug) use ($tool_status) {
    return !isset($tool_status[$tool_slug]) || $tool_status[$tool_slug] == '1';
}, ARRAY_FILTER_USE_KEY);
?>

<!-- ==================== TOOLS DIRECTORY HERO ==================== -->
<section class="tools-directory-hero">
    <div class="container">
        <div class="hero-inner">
            <span class="section-label" style="background:rgba(255,107,44,0.18); color:#FFB07A; border:1px solid rgba(255,107,44,0.3); margin-bottom: 24px;">Complete AI Toolkit</span>
            <h1 class="hero-title">SEO Tools Directory</h1>
            <p class="hero-sub" style="max-width: 650px; margin-left: auto; margin-right: auto; color: rgba(255,255,255,0.8);">
                Explore our professional suite of AI tools designed to simplify your SEO workflow and boost your search visibility.
            </p>
            
            <div class="hero-search" style="margin-top: 24px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                <input type="text" class="hero-search-input" id="hero-search" placeholder="Search across all ferramentas..." autocomplete="off" oninput="filterDirectory(this.value)" style="color: #fff;">
                <div id="search-suggestions" class="search-suggestions"></div>
                <button class="hero-search-btn">Find Tool</button>
            </div>
        </div>
    </div>
</section>

<div class="container" style="padding-top:40px; padding-bottom:80px;">
    <div class="tools-grid" id="directoryGrid">
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
           data-desc="<?php echo esc_attr(strtolower($tool['desc'])); ?>"
           <?php if (!$is_live) echo 'onclick="return false;" style="cursor:default;"'; ?>>
            <div class="tool-card-head">
                <div class="tool-icon-wrap" data-cat="<?php echo esc_attr($tool['cat']); ?>"><?php echo $tool['icon']; ?></div>
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
                    <span class="tool-arrow">Open Tool →</span>
                <?php else : ?>
                    <span class="tool-arrow" style="color:var(--text-light);font-size:12px;">Coming soon</span>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <!-- No results message -->
    <div id="noDirResults" style="display:none; text-align:center; padding:60px 0; color:var(--text-muted);">
        <div style="font-size:48px; margin-bottom:16px;">🔍</div>
        <h3 style="font-size:22px; margin-bottom:8px; color: var(--text-dark);">No tools matched your search</h3>
        <p style="font-size:16px;">Try a different keyword or browse by scrolling.</p>
    </div>
</div>

<script>
function filterDirectory(query) {
    const q = query.toLowerCase().trim();
    let visible = 0;
    document.querySelectorAll('#directoryGrid .tool-card').forEach(card => {
        const name = card.dataset.name || '';
        const desc = card.dataset.desc || '';
        const match = !q || name.includes(q) || desc.includes(q);
        card.style.display = match ? 'block' : 'none';
        if (match) visible++;
    });
    document.getElementById('noDirResults').style.display = visible === 0 ? 'block' : 'none';
}
</script>

<!-- Bottom AdSense -->
<div class="container" style="padding:0 24px 48px;text-align:center;">
    <?php techorbit_adsense( 'content' ); ?>
</div>

<?php get_footer(); ?>
