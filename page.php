<?php
/**
 * Static page template (falls back when no custom template assigned)
 *
 * @package techorbit-seo
 */
get_header();
?>

<div style="max-width:860px;margin:60px auto;padding:0 24px;">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="page-<?php the_ID(); ?>" <?php post_class( 'single-post-article' ); ?>>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-post-hero" style="border-radius:var(--radius-lg);overflow:hidden;margin-bottom:0;">
                    <?php the_post_thumbnail( 'techorbit-hero', [ 'loading' => 'eager' ] ); ?>
                </div>
            <?php endif; ?>

            <div class="single-post-body">
                <h1 style="margin-bottom:24px;"><?php the_title(); ?></h1>
                <div class="single-post-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
