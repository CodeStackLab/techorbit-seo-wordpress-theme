<?php
/**
 * Tools Configuration — TechOrbit SEO
 * Central registry for all 35+ AI SEO tools.
 *
 * @package techorbit-seo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Returns the primary registry of all tools.
 */
function techorbit_get_tools_registry() {
    return [
        // SEO Tools
        'meta-generator' => [
            'name'  => 'AI Meta Generator',
            'desc'  => 'Generate optimised title tags & meta descriptions instantly.',
            'icon'  => '🎯',
            'cat'   => 'seo',
            'badge' => 'popular',
            'url'   => '/tools/meta-generator/'
        ],
        'keyword-cluster' => [
            'name'  => 'Keyword Cluster Tool',
            'desc'  => 'Group keywords by search intent for smarter content planning.',
            'icon'  => '🗂',
            'cat'   => 'seo',
            'badge' => 'popular',
            'url'   => '/tools/keyword-cluster/'
        ],
        'faq-generator' => [
            'name'  => 'FAQ Schema Generator',
            'desc'  => 'Create JSON-LD FAQ schema markup for Google rich results.',
            'icon'  => '❓',
            'cat'   => 'seo',
            'badge' => '',
            'url'   => '/tools/faq-generator/'
        ],
        'og-tag-generator' => [
            'name'  => 'Open Graph Tag Generator',
            'desc'  => 'Generate perfect OG tags for social media previews.',
            'icon'  => '🔗',
            'cat'   => 'seo',
            'badge' => '',
            'url'   => '/tools/og-tag-generator/'
        ],
        'robots-generator' => [
            'name'  => 'Robots.txt Generator',
            'desc'  => 'Build a proper robots.txt file with custom rules.',
            'icon'  => '🤖',
            'cat'   => 'seo',
            'badge' => 'new',
            'url'   => '/tools/robots-generator/'
        ],
        'sitemap-helper' => [
            'name'  => 'XML Sitemap Helper',
            'desc'  => 'Checklist and guide for generating perfect XML sitemaps.',
            'icon'  => '🗺',
            'cat'   => 'seo',
            'badge' => '',
            'url'   => '/tools/sitemap-helper/'
        ],
        'canonical-advisor' => [
            'name'  => 'Canonical Tag Advisor',
            'desc'  => 'Prevent duplicate content with proper canonical tags.',
            'icon'  => '🔁',
            'cat'   => 'seo',
            'badge' => '',
            'url'   => '/tools/canonical-advisor/'
        ],
        'title-analyzer' => [
            'name'  => 'Title Tag Analyzer',
            'desc'  => 'Analyse and score your title tags for SEO effectiveness.',
            'icon'  => '📊',
            'cat'   => 'seo',
            'badge' => '',
            'url'   => '/tools/title-analyzer/'
        ],

        // Content Tools
        'blog-outline' => [
            'name'  => 'Blog Outline Builder',
            'desc'  => 'Generate structured H1/H2/H3 blog outlines in seconds.',
            'icon'  => '📝',
            'cat'   => 'content',
            'badge' => 'popular',
            'url'   => '/tools/blog-outline/'
        ],
        'product-description' => [
            'name'  => 'Product Description Writer',
            'desc'  => 'Write compelling SEO-ready product descriptions.',
            'icon'  => '🛒',
            'cat'   => 'content',
            'badge' => '',
            'url'   => '/tools/product-description/'
        ],
        'blog-topic' => [
            'name'  => 'Blog Topic Generator',
            'desc'  => 'Get 10+ blog topic ideas from a single keyword.',
            'icon'  => '💡',
            'cat'   => 'content',
            'badge' => 'new',
            'url'   => '/tools/blog-topic/'
        ],
        'paragraph-expander' => [
            'name'  => 'Paragraph Expander',
            'desc'  => 'Expand short sentences into rich, detailed paragraphs.',
            'icon'  => '📄',
            'cat'   => 'content',
            'badge' => '',
            'url'   => '/tools/paragraph-expander/'
        ],
        'content-summarizer' => [
            'name'  => 'Content Summarizer',
            'desc'  => 'Summarise long articles into key takeaways.',
            'icon'  => '✂️',
            'cat'   => 'content',
            'badge' => '',
            'url'   => '/tools/content-summarizer/'
        ],
        'headline-analyzer' => [
            'name'  => 'Headline Analyzer',
            'desc'  => 'Score your blog headlines for clicks and SEO.',
            'icon'  => '📰',
            'cat'   => 'content',
            'badge' => '',
            'url'   => '/tools/headline-analyzer/'
        ],
        'intro-generator' => [
            'name'  => 'Intro Generator',
            'desc'  => 'Craft engaging article introductions that hook readers.',
            'icon'  => '🪝',
            'cat'   => 'content',
            'badge' => '',
            'url'   => '/tools/intro-generator/'
        ],
        'conclusion-writer' => [
            'name'  => 'Conclusion Writer',
            'desc'  => 'Write strong conclusions with a clear call to action.',
            'icon'  => '🏁',
            'cat'   => 'content',
            'badge' => '',
            'url'   => '/tools/conclusion-writer/'
        ],
        'article-rewriter' => [
            'name'  => 'Article Rewriter',
            'desc'  => 'Rewrite content in a fresh voice while preserving meaning.',
            'icon'  => '✏️',
            'cat'   => 'content',
            'badge' => 'new',
            'url'   => '/tools/article-rewriter/'
        ],

        // Keyword Tools
        'lsi-generator' => [
            'name'  => 'LSI Keyword Generator',
            'desc'  => 'Find semantically-related keywords to enrich your content.',
            'icon'  => '🔍',
            'cat'   => 'keyword',
            'badge' => '',
            'url'   => '/tools/lsi-generator/'
        ],
        'long-tail-finder' => [
            'name'  => 'Long-tail Keyword Finder',
            'desc'  => 'Discover low-competition long-tail keyword opportunities.',
            'icon'  => '📈',
            'cat'   => 'keyword',
            'badge' => 'new',
            'url'   => '/tools/long-tail-finder/'
        ],
        'intent-analyzer' => [
            'name'  => 'Search Intent Analyzer',
            'desc'  => 'Classify any keyword by informational, commercial or transactional intent.',
            'icon'  => '🧭',
            'cat'   => 'keyword',
            'badge' => '',
            'url'   => '/tools/intent-analyzer/'
        ],
        'difficulty-estimator' => [
            'name'  => 'Keyword Difficulty Estimator',
            'desc'  => 'Get a quick difficulty score for any keyword.',
            'icon'  => '🏋️',
            'cat'   => 'keyword',
            'badge' => '',
            'url'   => '/tools/difficulty-estimator/'
        ],
        'competitor-spy' => [
            'name'  => 'Competitor Keyword Spy',
            'desc'  => 'Discover which keywords your competitors rank for.',
            'icon'  => '🕵️',
            'cat'   => 'keyword',
            'badge' => 'new',
            'url'   => '/tools/competitor-spy/'
        ],

        // Technical Tools
        'schema-generator' => [
            'name'  => 'Schema Markup Generator',
            'desc'  => 'Generate structured data schema for any content type.',
            'icon'  => '🏗',
            'cat'   => 'technical',
            'badge' => '',
            'url'   => '/tools/schema-generator/'
        ],
        'twitter-card' => [
            'name'  => 'Twitter Card Generator',
            'desc'  => 'Create Twitter card meta tags for better social sharing.',
            'icon'  => '🐦',
            'cat'   => 'technical',
            'badge' => '',
            'url'   => '/tools/twitter-card/'
        ],
        'alt-text-generator' => [
            'name'  => 'Alt Text Generator',
            'desc'  => 'Generate descriptive alt text for images from AI.',
            'icon'  => '🖼',
            'cat'   => 'technical',
            'badge' => 'new',
            'url'   => '/tools/alt-text-generator/'
        ],
        'vitals-advisor' => [
            'name'  => 'Core Web Vitals Advisor',
            'desc'  => 'Get actionable tips to improve LCP, CLS & FID.',
            'icon'  => '⚡',
            'cat'   => 'technical',
            'badge' => '',
            'url'   => '/tools/vitals-advisor/'
        ],
        'hreflang-builder' => [
            'name'  => 'Hreflang Tag Builder',
            'desc'  => 'Build hreflang tags for multilingual SEO.',
            'icon'  => '🌐',
            'cat'   => 'technical',
            'badge' => '',
            'url'   => '/tools/hreflang-builder/'
        ],
        'json-ld-generator' => [
            'name'  => 'JSON-LD Generator',
            'desc'  => 'Create custom JSON-LD structured data snippets.',
            'icon'  => '{ }',
            'cat'   => 'technical',
            'badge' => '',
            'url'   => '/tools/json-ld-generator/'
        ],

        // Social & Copywriting
        'social-caption' => [
            'name'  => 'Social Media Caption Writer',
            'desc'  => 'Write engaging captions for Instagram, Facebook & LinkedIn.',
            'icon'  => '📱',
            'cat'   => 'social',
            'badge' => 'new',
            'url'   => '/tools/social-caption/'
        ],
        'hashtag-generator' => [
            'name'  => 'Hashtag Generator',
            'desc'  => 'Get relevant hashtags for any topic or niche.',
            'icon'  => '#️⃣',
            'cat'   => 'social',
            'badge' => '',
            'url'   => '/tools/hashtag-generator/'
        ],
        'linkedin-writer' => [
            'name'  => 'LinkedIn Post Writer',
            'desc'  => 'Create professional LinkedIn posts that drive engagement.',
            'icon'  => '💼',
            'cat'   => 'social',
            'badge' => '',
            'url'   => '/tools/linkedin-writer/'
        ],
        'twitter-thread' => [
            'name'  => 'Twitter Thread Generator',
            'desc'  => 'Turn any blog post into a compelling Twitter thread.',
            'icon'  => '🧵',
            'cat'   => 'social',
            'badge' => 'new',
            'url'   => '/tools/twitter-thread/'
        ],
        'ad-copy' => [
            'name'  => 'Ad Copy Generator',
            'desc'  => 'Write high-converting Google & Facebook ad copy.',
            'icon'  => '📣',
            'cat'   => 'social',
            'badge' => '',
            'url'   => '/tools/ad-copy/'
        ],
        'email-subject' => [
            'name'  => 'Email Subject Line Writer',
            'desc'  => 'Craft irresistible email subject lines with AI.',
            'icon'  => '📧',
            'cat'   => 'social',
            'badge' => '',
            'url'   => '/tools/email-subject/'
        ],
        'cta-generator' => [
            'name'  => 'Call-to-Action Generator',
            'desc'  => 'Generate powerful CTAs for landing pages and blogs.',
            'icon'  => '👆',
            'cat'   => 'social',
            'badge' => '',
            'url'   => '/tools/cta-generator/'
        ],
    ];
}

/**
 * Get tools by category.
 */
function techorbit_get_tools_by_cat( $cat = 'all' ) {
    $registry = techorbit_get_tools_registry();
    if ( $cat === 'all' ) {
        return $registry;
    }
    return array_filter( $registry, fn($t) => $t['cat'] === $cat );
}

/**
 * Get categories metadata.
 */
function techorbit_get_tool_categories() {
    $registry = techorbit_get_tools_registry();
    return [
        'all'       => ['label'=>'All Tools',      'count'=>count($registry)],
        'seo'       => ['label'=>'SEO',            'count'=>count(array_filter($registry, fn($t)=>$t['cat']==='seo'))],
        'content'   => ['label'=>'Content',        'count'=>count(array_filter($registry, fn($t)=>$t['cat']==='content'))],
        'keyword'   => ['label'=>'Keywords',       'count'=>count(array_filter($registry, fn($t)=>$t['cat']==='keyword'))],
        'technical' => ['label'=>'Technical SEO',  'count'=>count(array_filter($registry, fn($t)=>$t['cat']==='technical'))],
        'social'    => ['label'=>'Social & Copy',  'count'=>count(array_filter($registry, fn($t)=>$t['cat']==='social'))],
    ];
}
