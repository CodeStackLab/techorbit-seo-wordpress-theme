<?php
/**
 * Single blog post template - Premium Readability Edition
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="blog-single-vibrant" style="background: #fff; padding: 0 0 80px;">
    <?php while ( have_posts() ) : the_post(); ?>
        
        <!-- Premium Article Header -->
        <header class="article-header" style="background: var(--bg-soft); padding: 80px 0 60px; border-bottom: 1px solid var(--border);">
            <div class="container" style="max-width: 900px;">
                <div class="category-pill" style="margin-bottom: 24px;">
                    <?php 
                    $cats = get_the_category();
                    if($cats) echo '<span style="background: var(--primary-light); color: var(--primary); padding: 4px 16px; border-radius: 50px; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">' . esc_html($cats[0]->name) . '</span>';
                    ?>
                </div>
                <h1 style="font-size: clamp(32px, 5vw, 48px); line-height: 1.15; color: var(--text-dark); letter-spacing: -1.5px; margin-bottom: 32px;">
                    <?php the_title(); ?>
                </h1>
                
                <div class="article-meta" style="display: flex; align-items: center; gap: 24px; color: var(--text-muted); font-size: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="width: 36px; height: 36px; background: var(--border); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px;">👤</span>
                        <strong><?php the_author(); ?></strong>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        📅 <?php echo esc_html(get_the_date()); ?>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        ⏱ <?php echo esc_html(techorbit_reading_time()); ?>
                    </div>
                </div>
            </div>
        </header>

        <div class="container" style="max-width: 1280px; display: grid; grid-template-columns: 1fr 340px; gap: 64px; margin-top: 60px;">
            <main class="article-content-wrap">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="featured-image-wrap" style="margin-bottom: 48px;">
                            <?php the_post_thumbnail('large', ['style' => 'width:100%; height:auto; border-radius:var(--radius-xl); box-shadow:var(--shadow-lg);']); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content" style="font-size: 19px; line-height: 1.8; color: var(--text-body);">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php $tags = get_the_tags(); if($tags): ?>
                        <div class="entry-tags" style="margin-top: 60px; padding-top: 30px; border-top: 1px solid var(--border); display: flex; gap: 10px; flex-wrap: wrap;">
                            <?php foreach($tags as $tag): ?>
                                <a href="<?php echo get_tag_link($tag->term_id); ?>" style="background: var(--bg-soft); color: var(--text-muted); padding: 6px 14px; border-radius: 8px; font-size: 14px; text-decoration: none; border: 1px solid var(--border);">
                                    #<?php echo esc_html($tag->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </article>

                <!-- Post Nav -->
                <nav class="article-navigation" style="margin-top: 60px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding-top: 40px; border-top: 1px solid var(--border);">
                    <?php 
                    $prev = get_previous_post();
                    $next = get_next_post();
                    if($prev): ?>
                        <a href="<?php echo get_permalink($prev->ID); ?>" style="text-decoration: none; padding: 20px; border: 1px solid var(--border); border-radius: var(--radius-lg); transition: var(--transition);" class="nav-prev-link">
                            <span style="display: block; font-size: 12px; color: var(--text-light); text-transform: uppercase; margin-bottom: 8px;">Previous Article</span>
                            <strong style="display: block; color: var(--text-dark); font-size: 16px;"><?php echo esc_html($prev->post_title); ?></strong>
                        </a>
                    <?php endif; ?>
                    <?php if($next): ?>
                        <a href="<?php echo get_permalink($next->ID); ?>" style="text-decoration: none; padding: 20px; border: 1px solid var(--border); border-radius: var(--radius-lg); transition: var(--transition); text-align: right;" class="nav-next-link">
                            <span style="display: block; font-size: 12px; color: var(--text-light); text-transform: uppercase; margin-bottom: 8px;">Next Article</span>
                            <strong style="display: block; color: var(--text-dark); font-size: 16px;"><?php echo esc_html($next->post_title); ?></strong>
                        </a>
                    <?php endif; ?>
                </nav>
            </main>

            <!-- Blog Sidebar -->
            <aside class="blog-sidebar">
                <div class="sidebar-widget" style="background: var(--bg-soft); padding: 32px; border-radius: var(--radius-xl); border: 1px solid var(--border);">
                    <h3 style="font-size: 18px; margin-bottom: 24px;">Subscribe to Orbit</h3>
                    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">Get the latest AI SEO tips and tool updates delivered to your inbox.</p>
                    <input type="email" placeholder="Your email address" style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1.5px solid var(--border); margin-bottom: 12px; font-size: 14px;">
                    <button class="btn-primary" style="width: 100%; height: 48px;">Join 5k+ Readers</button>
                </div>

                <div class="sidebar-widget" style="margin-top: 40px;">
                    <h3 style="font-size: 18px; margin-bottom: 20px;">Top AI Tools</h3>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="/tools/meta-generator/" class="related-tool-item-mini" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                           <span style="font-size: 24px;">🏷️</span>
                           <div>
                               <strong style="display:block; font-size: 14px; color: var(--text-dark);">Meta Generator</strong>
                               <span style="font-size: 12px; color: var(--text-muted);">One-click titles/meta</span>
                           </div>
                        </a>
                        <a href="/tools/keyword-cluster/" class="related-tool-item-mini" style="display: flex; align-items: center; gap: 12px; text-decoration: none;">
                           <span style="font-size: 24px;">🗂️</span>
                           <div>
                               <strong style="display:block; font-size: 14px; color: var(--text-dark);">Keyword Cluster</strong>
                               <span style="font-size: 12px; color: var(--text-muted);">Smart intent grouping</span>
                           </div>
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    <?php endwhile; ?>
</div>

<style>
.entry-content p { margin-bottom: 30px; }
.entry-content h2 { margin: 60px 0 24px; font-size: 32px; letter-spacing: -1px; }
.entry-content h3 { margin: 40px 0 20px; font-size: 24px; }
.nav-prev-link:hover, .nav-next-link:hover { border-color: var(--primary); background: var(--primary-light); }
@media (max-width: 992px) {
    .blog-single-vibrant .container { grid-template-columns: 1fr; }
    .blog-sidebar { display: none; }
}
</style>

<?php get_footer(); ?>
