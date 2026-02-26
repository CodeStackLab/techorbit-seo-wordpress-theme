<?php
/**
 * Template Name: Blog
 * 
 * @package techorbit-seo
 */
get_header();
?>

<div class="page-header-vibrant">
    <div class="container container-narrow">
        <h1 class="page-title-hero"><?php esc_html_e( 'SEO Blog & Insights', 'techorbit-seo' ); ?></h1>
        <p class="page-subtitle"><?php esc_html_e( 'Expert tips, tools, and strategies to boost your organic rankings.', 'techorbit-seo' ); ?></p>
        
        <!-- Header Search Bar -->
        <div class="blog-header-search">
            <form role="search" method="get" class="search-form-modern" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                <div class="search-input-wrap">
                    <span class="search-icon-inside">🔍</span>
                    <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search articles...', 'placeholder', 'techorbit-seo' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                </div>
                <button type="submit" class="search-submit-btn"><?php echo esc_html_x( 'Search', 'submit button', 'techorbit-seo' ); ?></button>
            </form>
        </div>
    </div>
</div>

<div class="site-content blog-centered-layout">
    <main class="site-main" id="main" role="main">

        <?php 
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = [
            'post_type'   => 'post',
            'post_status' => 'publish',
            'paged'       => $paged
        ];
        $query = new WP_Query( $args );

        if ( $query->have_posts() ) : ?>

            <div class="article-list-view article-grid">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'premium-post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumb">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'medium' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-details">
                            <div class="post-meta-compact">
                                <span>📅 <?php echo get_the_date(); ?></span>
                                <span>⏱ <?php echo techorbit_reading_time(); ?></span>
                                <span class="post-cat-highlight"><?php the_category( ' ' ); ?></span>
                            </div>
                            <h2 class="post-title-link">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="post-excerpt"><?php echo techorbit_excerpt( get_the_ID(), 30 ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="btn-text-cta">Read More →</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="premium-pagination">
                <?php
                echo paginate_links( [
                    'total'     => $query->max_num_pages,
                    'type'      => 'list',
                    'prev_text' => '← Previous',
                    'next_text' => 'Next →',
                ] );
                ?>
            </div>

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="no-posts" style="text-align:center;padding:60px 0;">
                <h2>No articles found.</h2>
                <p>Check back later for new updates!</p>
            </div>
        <?php endif; ?>

    </main>
</div>

<?php get_footer(); ?>
