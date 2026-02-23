<?php
/**
 * Archive template
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="blog-header" style="background:var(--gradient);padding:60px 24px;text-align:center;color:#fff;">
    <div class="container">
        <?php the_archive_title( '<h1 style="font-size:38px;margin-bottom:12px;">', '</h1>' ); ?>
        <?php the_archive_description( '<p style="color:rgba(255,255,255,0.75);font-size:17px;">', '</p>' ); ?>
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
                            <span>📅 <?php echo esc_html( get_the_date() ); ?></span>
                            <span>⏱ <?php echo esc_html( techorbit_reading_time() ); ?></span>
                        </div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="post-excerpt"><?php echo esc_html( techorbit_excerpt( get_the_ID(), 25 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'Read Article', 'techorbit-seo' ); ?> →</a>
                    </div>
                </article>
            <?php endwhile; ?>

            <div class="pagination">
                <?php echo paginate_links( [ 'prev_text' => '← Prev', 'next_text' => 'Next →' ] ); ?>
            </div>
        <?php else : ?>
            <p style="text-align:center;padding:60px;"><?php esc_html_e( 'No posts found.', 'techorbit-seo' ); ?></p>
        <?php endif; ?>

    </main>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
