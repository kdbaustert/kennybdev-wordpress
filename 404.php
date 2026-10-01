<?php get_header(); ?>
<div class="shell">
    <header class="page-header">
        <p class="eyebrow"><span>404</span></p>
        <h1 class="page-title"><?php esc_html_e("Page not found", "kennyb-theme"); ?></h1>
    </header>

    <div class="pb-5 mb-5" style="max-width: 36rem">
        <p><?php esc_html_e("That address doesn't point to anything on this site. It may have moved when the projects got their own pages.", "kennyb-theme"); ?></p>
        <div class="d-flex flex-wrap gap-3 mt-4">
            <a class="btn btn-primary" href="<?php echo esc_url(home_url("/")); ?>"><?php esc_html_e("Go to the home page", "kennyb-theme"); ?></a>
            <a class="btn btn-outline-light" href="<?php echo esc_url(get_post_type_archive_link("project")); ?>"><?php esc_html_e("See all projects", "kennyb-theme"); ?></a>
        </div>
    </div>
</div>
<?php
get_footer();
