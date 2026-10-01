<?php $projects = kennyb_get_projects(); ?>
<section class="section" id="work" aria-labelledby="work-title">
    <div class="shell">
        <div class="section__head">
            <div>
                <p class="eyebrow"><span>02</span><span><?php esc_html_e("Projects", "kennyb-theme"); ?></span></p>
                <h2 id="work-title" class="section__title"><?php esc_html_e("Recent builds", "kennyb-theme"); ?></h2>
            </div>
            <p class="section__lede">
                <?php esc_html_e("Over 10 years I've shipped claims software, campaign reporting and a regulatory application, with WordPress work in between.", "kennyb-theme"); ?>
            </p>
        </div>

        <?php if ($projects) : ?>
            <?php get_template_part("template-parts/project-index", null, ["projects" => $projects]); ?>
        <?php else : ?>
            <p class="project-empty">
                <?php esc_html_e("No projects yet. Add one under Projects in wp-admin, or run demo/seed.php.", "kennyb-theme"); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
