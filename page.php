<?php
/**
 * Static page template (falls back when no custom template assigned)
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="page-standard-wrap container">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="page-<?php the_ID(); ?>" <?php post_class( 'static-page-article' ); ?>>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="static-page-hero">
                    <?php the_post_thumbnail( 'techorbit-hero', [ 'loading' => 'eager' ] ); ?>
                </div>
            <?php endif; ?>

            <div class="static-page-body">
                <header class="static-page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="static-page-content single-post-content">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>

    <?php endwhile; ?>
</div>

<?php get_footer(); ?>
