<?php
/**
 * Search results template
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="search-header">
    <div class="container">
        <h1><?php
            /* translators: %s: search query */
            printf( esc_html__( 'Search Results for: %s', 'techorbit-seo' ), '<span style="color:var(--primary-light);">' . esc_html( get_search_query() ) . '</span>' );
        ?></h1>
        <p><?php
            global $wp_query;
            printf( esc_html__( '%d result(s) found', 'techorbit-seo' ), (int) $wp_query->found_posts );
        ?></p>
        <div class="search-form-wrap" style="margin-top:24px;">
            <?php get_search_form(); ?>
        </div>
    </div>
</div>

<div class="site-content">
    <main class="site-main" id="main" role="main">

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="post-card-image">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'techorbit-card', [ 'loading' => 'lazy' ] ); ?></a>
                        </div>
                    <?php endif; ?>
                    <div class="post-card-body">
                        <div class="post-meta">
                            <span>📅 <?php echo esc_html( get_the_date() ); ?></span>
                            <span>📁 <?php the_category( ', ' ); ?></span>
                        </div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p class="post-excerpt"><?php echo esc_html( techorbit_excerpt( get_the_ID(), 30 ) ); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e( 'Read More', 'techorbit-seo' ); ?> →</a>
                    </div>
                </article>
            <?php endwhile; ?>
            <div class="pagination">
                <?php echo paginate_links( [ 'prev_text' => '← Prev', 'next_text' => 'Next →' ] ); ?>
            </div>
        <?php else : ?>
            <div style="text-align:center;padding:80px 24px;">
                <h2><?php esc_html_e( 'No results found', 'techorbit-seo' ); ?></h2>
                <p style="color:var(--text-muted);margin:16px 0 32px;"><?php esc_html_e( 'Try a different search term or explore our AI SEO tools below.', 'techorbit-seo' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn-primary">🛠 <?php esc_html_e( 'Explore AI Tools', 'techorbit-seo' ); ?></a>
            </div>
        <?php endif; ?>

    </main>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
