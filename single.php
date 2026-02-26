<?php
/**
 * Single blog post template - Premium Readability Edition
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="post-single-wrap">
    <?php while ( have_posts() ) : the_post(); ?>
        
        <!-- Premium Article Header -->
        <header class="post-view-header">
            <div class="container">
                <div class="post-view-tag">
                    <?php 
                    $cats = get_the_category();
                    if($cats) echo '<span>' . esc_html($cats[0]->name) . '</span>';
                    ?>
                </div>
                <h1 class="post-view-title"><?php the_title(); ?></h1>
                
                <div class="post-view-meta">
                    <div class="post-meta-item author">
                        <span class="avatar-icon">👤</span>
                        <strong><?php the_author(); ?></strong>
                    </div>
                    <div class="post-meta-item date">
                        📅 <?php echo esc_html(get_the_date()); ?>
                    </div>
                    <?php if ( function_exists('techorbit_reading_time') ) : ?>
                    <div class="post-meta-item reading-time">
                        ⏱ <?php echo esc_html(techorbit_reading_time()); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="post-view-layout">
                <main class="post-view-main">
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <div class="post-view-content single-post-content">
                            <?php 
                            // Display content, but provide a way to avoid redundant images if needed 
                            the_content(); 
                            ?>
                        </div>

                        <!-- Tags -->
                        <?php $tags = get_the_tags(); if($tags): ?>
                            <div class="post-view-tags">
                                <?php foreach($tags as $tag): ?>
                                    <a href="<?php echo get_tag_link($tag->term_id); ?>">
                                        #<?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </article>

                    <!-- Post Nav -->
                    <nav class="post-view-navigation">
                        <?php 
                        $prev = get_previous_post();
                        $next = get_next_post();
                        if($prev): ?>
                            <a href="<?php echo get_permalink($prev->ID); ?>" class="nav-link prev">
                                <span class="nav-label">Previous Article</span>
                                <strong class="nav-title"><?php echo esc_html($prev->post_title); ?></strong>
                            </a>
                        <?php endif; ?>
                        <?php if($next): ?>
                            <a href="<?php echo get_permalink($next->ID); ?>" class="nav-link next">
                                <span class="nav-label">Next Article</span>
                                <strong class="nav-title"><?php echo esc_html($next->post_title); ?></strong>
                            </a>
                        <?php endif; ?>
                    </nav>
                </main>

                <!-- Blog Sidebar -->
                <aside class="post-view-sidebar">
                    
                    <!-- Related Posts Widget -->
                    <?php
                    $categories = get_the_category();
                    if ( $categories ) :
                        $related_args = array(
                            'category__in'   => array( $categories[0]->term_id ),
                            'post__not_in'   => array( get_the_ID() ),
                            'posts_per_page' => 3,
                            'orderby'        => 'rand'
                        );
                        $related_query = new WP_Query( $related_args );
                        if ( $related_query->have_posts() ) :
                    ?>
                    <div class="sidebar-widget related-posts-widget">
                        <h3>Related Articles</h3>
                        <div class="related-posts-list">
                            <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                                <a href="<?php the_permalink(); ?>" class="related-post-item">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <div class="related-post-thumb">
                                            <?php the_post_thumbnail( 'thumbnail' ); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="related-post-info">
                                        <strong><?php the_title(); ?></strong>
                                        <span>📅 <?php echo get_the_date(); ?></span>
                                    </div>
                                </a>
                            <?php endwhile; wp_reset_postdata(); ?>
                        </div>
                    </div>
                    <?php endif; endif; ?>

                    <div class="sidebar-widget tools-widget">
                        <h3>Top AI Tools</h3>
                        <div class="related-tools-list">
                            <a href="<?php echo esc_url(home_url('/tools/meta-generator/')); ?>" class="related-tool-item-mini">
                               <span class="tool-icon">🏷️</span>
                               <div class="tool-info">
                                   <strong>Meta Generator</strong>
                                   <span>AI Meta Tags</span>
                               </div>
                            </a>
                            <a href="<?php echo esc_url(home_url('/tools/keyword-cluster/')); ?>" class="related-tool-item-mini">
                               <span class="tool-icon">🗂️</span>
                               <div class="tool-info">
                                   <strong>Keyword Cluster</strong>
                                   <span>Topic Grouping</span>
                               </div>
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
