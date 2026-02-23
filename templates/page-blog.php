<?php
/**
 * Template Name: Blog
 * 
 * @package techorbit-seo
 */
get_header();
?>

<div class="blog-header" style="background:var(--gradient);padding:60px 24px;text-align:center;color:#fff;">
    <div class="container">
        <h1 style="font-size:42px;margin-bottom:12px;"><?php esc_html_e( 'SEO Blog & Insights', 'techorbit-seo' ); ?></h1>
        <p style="color:rgba(255,255,255,0.75);font-size:18px;"><?php esc_html_e( 'Expert tips, tools, and strategies to boost your organic rankings.', 'techorbit-seo' ); ?></p>
    </div>
</div>

<div class="site-content">
    <main class="site-main" id="main" role="main">

        <?php 
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = [
            'post_type' => 'post',
            'paged'     => $paged
        ];
        $query = new WP_Query( $args );

        if ( $query->have_posts() ) : ?>

            <div class="blog-grid">
                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail( 'large' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-card-body">
                            <div class="post-meta">
                                <span>📁 <?php the_category( ', ' ); ?></span>
                            </div>
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="post-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 25 ); ?></p>
                            <a href="<?php the_permalink(); ?>" class="read-more">Read More →</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                echo paginate_links( [
                    'total' => $query->max_num_pages,
                    'type'  => 'list',
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

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
