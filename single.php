<?php
/**
 * Single blog post template
 *
 * @package techorbit-seo
 */
get_header();
?>

<div class="single-post-container">
    <main class="single-post-main" id="main" role="main">
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post-article' ); ?> itemscope itemtype="https://schema.org/BlogPosting">

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="single-post-hero">
                        <?php the_post_thumbnail( 'techorbit-hero', [ 'loading' => 'eager', 'itemprop' => 'image' ] ); ?>
                    </div>
                <?php endif; ?>

                <div class="single-post-body">
                    <!-- Category breadcrumb -->
                    <div style="margin-bottom:12px;font-size:13px;">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color:var(--text-muted);"><?php esc_html_e( 'Home', 'techorbit-seo' ); ?></a>
                        <span style="color:var(--text-muted);margin:0 6px;">›</span>
                        <a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>" style="color:var(--text-muted);"><?php esc_html_e( 'Blog', 'techorbit-seo' ); ?></a>
                        <span style="color:var(--text-muted);margin:0 6px;">›</span>
                        <span style="color:var(--primary);"><?php the_title(); ?></span>
                    </div>

                    <h1 itemprop="headline"><?php the_title(); ?></h1>

                    <div class="post-meta" style="margin:20px 0;">
                        <span itemprop="author" itemscope itemtype="https://schema.org/Person">
                            👤 <span itemprop="name"><?php the_author(); ?></span>
                        </span>
                        <span>📅 <time itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>
                        <span>⏱ <?php echo esc_html( techorbit_reading_time() ); ?></span>
                        <span>📁 <?php the_category( ', ' ); ?></span>
                    </div>

                    <div class="single-post-content" itemprop="articleBody">
                        <?php the_content(); ?>
                    </div>

                    <!-- In-content AdSense -->
                    <div style="margin:40px 0;">
                        <?php techorbit_adsense( 'content' ); ?>
                    </div>

                    <?php
                    // Tags
                    $tags = get_the_tags();
                    if ( $tags ) :
                    ?>
                        <div class="post-tags">
                            <span>🏷️ Tags:</span>
                            <?php foreach ( $tags as $tag ) : ?>
                                <a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-link">
                                    <?php echo esc_html( $tag->name ); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Post Navigation -->
                    <nav class="post-nav" style="display:flex;justify-content:space-between;padding-top:32px;margin-top:32px;border-top:1px solid var(--border);">
                        <?php
                        $prev = get_previous_post();
                        $next = get_next_post();
                        if ( $prev ) {
                            echo '<a href="' . esc_url( get_permalink( $prev->ID ) ) . '" style="color:var(--primary);font-weight:600;">← ' . esc_html( $prev->post_title ) . '</a>';
                        } else {
                            echo '<span></span>';
                        }
                        if ( $next ) {
                            echo '<a href="' . esc_url( get_permalink( $next->ID ) ) . '" style="color:var(--primary);font-weight:600;">' . esc_html( $next->post_title ) . ' →</a>';
                        }
                        ?>
                    </nav>

                    <?php comments_template(); ?>
                </div><!-- .single-post-body -->
            </article>

        <?php endwhile; ?>
    </main>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
