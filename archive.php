<?php
/**
 * Archive template - Premium Grid Edition
 *
 * @package techorbit-seo
 */
get_header();
?>

<section class="archive-premium-hero" style="background: var(--bg-soft); padding: 80px 0 60px; border-bottom: 1px solid var(--border); text-align: center;">
    <div class="container" style="max-width: 900px;">
        <span style="background: var(--primary-light); color: var(--primary); padding: 4px 16px; border-radius: 50px; font-weight: 700; font-size: 13px; text-transform: uppercase;">Browsing Orbit</span>
        <?php the_archive_title( '<h1 style="font-size: 48px; margin-top: 16px; margin-bottom: 12px; color: var(--text-dark); letter-spacing: -1.5px;">', '</h1>' ); ?>
        <div style="width: 60px; height: 4px; background: var(--gradient-cta); margin: 0 auto 20px; border-radius: 2px;"></div>
        <?php the_archive_description( '<div style="color: var(--text-muted); font-size: 18px; max-width: 600px; margin: 0 auto; line-height: 1.6;">', '</div>' ); ?>
    </div>
</section>

<div class="container" style="padding: 80px 0;">
    <div class="archive-layout" style="display: grid; grid-template-columns: 1fr 340px; gap: 64px;">
        <main class="archive-main">
            <?php if ( have_posts() ) : ?>
                <div class="article-grid" style="display: grid; grid-template-columns: 1fr; gap: 40px;">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article class="premium-post-card" style="display: grid; grid-template-columns: 300px 1fr; gap: 32px; align-items: center; background: #fff; padding: 24px; border-radius: var(--radius-xl); border: 1px solid var(--border); transition: var(--transition);">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="post-thumb" style="overflow: hidden; border-radius: var(--radius-lg);">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', ['style' => 'width:100%; height:auto; transition: var(--transition-md); display: block;']); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <div class="post-details">
                                <div style="font-size: 13px; color: var(--text-light); margin-bottom: 8px;">
                                    📅 <?php echo get_the_date(); ?> • ⏱ <?php echo techorbit_reading_time(); ?>
                                </div>
                                <h2 style="font-size: 24px; margin-bottom: 16px; line-height: 1.3;">
                                    <a href="<?php the_permalink(); ?>" style="color: var(--text-dark); text-decoration: none; transition: var(--transition);">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                                <p style="color: var(--text-muted); font-size: 15px; line-height: 1.6; margin-bottom: 20px;">
                                    <?php echo techorbit_excerpt(get_the_ID(), 30); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="text-cta" style="color: var(--primary); font-weight: 700; text-decoration: none; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">Read More →</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="premium-pagination" style="margin-top: 60px;">
                    <?php echo paginate_links([
                        'prev_text' => '← Previous',
                        'next_text' => 'Next →',
                        'type' => 'list'
                    ]); ?>
                </div>
            <?php else : ?>
                <div style="text-align: center; padding: 60px 0;">
                    <span style="font-size: 64px; display: block; margin-bottom: 20px;">🏜️</span>
                    <h3>No articles found in this category</h3>
                    <p style="color: var(--text-muted);">Try exploring our AI tools instead!</p>
                </div>
            <?php endif; ?>
        </main>

        <aside class="archive-sidebar">
            <?php get_sidebar(); ?>
        </aside>
    </div>
</div>

<style>
.premium-post-card:hover { border-color: var(--primary); box-shadow: var(--shadow-lg); transform: translateY(-5px); }
.premium-post-card:hover img { transform: scale(1.05); }
.premium-post-card h2 a:hover { color: var(--primary); }
.premium-pagination ul { display: flex; list-style: none; gap: 8px; justify-content: center; }
.premium-pagination .page-numbers { padding: 8px 16px; border-radius: 8px; border: 1px solid var(--border); color: var(--text-dark); text-decoration: none; font-weight: 600; }
.premium-pagination .current { background: var(--primary); color: #fff; border-color: var(--primary); }
@media (max-width: 992px) {
    .archive-layout { grid-template-columns: 1fr; }
    .archive-sidebar { display: none; }
    .premium-post-card { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>
