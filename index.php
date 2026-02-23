<?php
/**
 * Main index (blog loop fallback)
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

        <?php if ( have_posts() ) : ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-card-image">
                            <a href="<?php the_permalink(); ?>" aria-label="<?php the_title_attribute(); ?>">
                                <?php the_post_thumbnail( 'techorbit-card', [ 'loading' => 'lazy' ] ); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="post-card-body">
                        <div class="post-meta">
                            <span>📁 <?php the_category( ', ' ); ?></span>
                            <span>📅 <?php echo esc_html( get_the_date() ); ?></span>
                            <span>⏱ <?php echo esc_html( techorbit_reading_time() ); ?></span>
                        </div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="post-excerpt"><?php echo esc_html( techorbit_excerpt( get_the_ID(), 30 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more">
                            <?php esc_html_e( 'Read Article', 'techorbit-seo' ); ?> →
                        </a>
                    </div>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php
                echo paginate_links( [
                    'type'      => 'list',
                    'prev_text' => '← ' . __( 'Previous', 'techorbit-seo' ),
                    'next_text' => __( 'Next', 'techorbit-seo' ) . ' →',
                ] );
                ?>
            </div>

        <?php else : ?>
            <div class="no-posts" style="text-align:center;padding:80px 24px;">
                <h2><?php esc_html_e( 'No posts yet!', 'techorbit-seo' ); ?></h2>
                <p style="color:var(--text-muted);margin:16px 0 32px;"><?php esc_html_e( 'Check back soon for SEO tips and strategies.', 'techorbit-seo' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-primary"><?php esc_html_e( 'Try Our AI Tools', 'techorbit-seo' ); ?></a>
            </div>
        <?php endif; ?>

    </main><!-- .site-main -->

    <?php get_sidebar(); ?>

</div><!-- .site-content -->

<?php get_footer(); ?>
