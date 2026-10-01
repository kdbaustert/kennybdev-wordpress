<?php
$latest = new WP_Query([
    "posts_per_page" => 3,
    "ignore_sticky_posts" => true,
    "no_found_rows" => true,
]);

if (!$latest->have_posts()) {
    return;
}

$journal_url = get_option("page_for_posts") ? get_permalink((int) get_option("page_for_posts")) : home_url("/");
?>
<section class="section" id="journal" aria-labelledby="journal-title">
    <div class="shell">
        <div class="section__head">
            <div>
                <p class="eyebrow"><span>05</span><span><?php esc_html_e("Journal", "kennyb-theme"); ?></span></p>
                <h2 id="journal-title" class="section__title"><?php esc_html_e("Notes from the work", "kennyb-theme"); ?></h2>
            </div>
            <p class="section__lede">
                <a class="btn btn-outline-light" href="<?php echo esc_url($journal_url); ?>"><?php esc_html_e("Read the journal", "kennyb-theme"); ?></a>
            </p>
        </div>

        <div class="row g-5">
            <?php while ($latest->have_posts()) : $latest->the_post(); ?>
                <div class="col-md-6 col-lg-4">
                    <?php get_template_part("template-parts/post-card"); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php
wp_reset_postdata();
