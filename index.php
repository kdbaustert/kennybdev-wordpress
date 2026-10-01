<?php
/**
 * Fallback for every listing: the journal (posts page), category/tag/date
 * archives and search results. They differ only in the heading, so one
 * template covers them rather than four near-copies.
 */

get_header();

if (is_home()) {
    $posts_page = (int) get_option("page_for_posts");
    $title = $posts_page ? get_the_title($posts_page) : __("Journal", "kennyb-theme");
} elseif (is_search()) {
    /* translators: %s: search query */
    $title = sprintf(__("Results for “%s”", "kennyb-theme"), get_search_query());
} elseif (is_archive()) {
    $title = get_the_archive_title();
} else {
    $title = __("Journal", "kennyb-theme");
}
?>
<div class="shell">
    <header class="page-header">
        <p class="eyebrow"><span><?php echo esc_html(get_bloginfo("name")); ?></span></p>
        <h1 class="page-title"><?php echo wp_kses_post($title); ?></h1>
        <?php if (is_archive() && get_the_archive_description()) : ?>
            <div class="section__lede mt-3"><?php the_archive_description(); ?></div>
        <?php endif; ?>
    </header>

    <?php
    if (is_home()) {
        kennyb_island("journal-search", ["endpoint" => rest_url("wp/v2/posts")], get_search_form(["echo" => false]));
    }
    ?>

    <?php if (have_posts()) : ?>
        <div class="row g-5">
            <?php while (have_posts()) : the_post(); ?>
                <div class="col-md-6 col-lg-4">
                    <?php get_template_part("template-parts/post-card"); ?>
                </div>
            <?php endwhile; ?>
        </div>
        <?php kennyb_pagination(); ?>
    <?php else : ?>
        <?php get_template_part("template-parts/content-none"); ?>
    <?php endif; ?>
</div>
<div class="pb-5 mb-5"></div>
<?php
get_footer();
