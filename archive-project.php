<?php
/**
 * The /work/ archive: every project, through the same filterable index as the front page.
 */

get_header();
?>
<div class="shell">
    <header class="page-header">
        <p class="eyebrow"><span><?php esc_html_e("Projects", "kennyb-theme"); ?></span></p>
        <h1 class="page-title"><?php esc_html_e("Selected work", "kennyb-theme"); ?></h1>
    </header>

    <?php get_template_part("template-parts/project-index", null, ["projects" => kennyb_get_projects()]); ?>
</div>
<div class="pb-5 mb-5"></div>
<?php
get_footer();
