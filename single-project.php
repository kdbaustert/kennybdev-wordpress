<?php
get_header();

while (have_posts()) :
    the_post();
    $url = (string) get_post_meta(get_the_ID(), "project_url", true);
    $terms = get_the_terms(get_the_ID(), "tech");
    ?>
    <article <?php post_class("shell"); ?>>
        <header class="page-header">
            <p class="eyebrow"><a class="text-reset text-decoration-none" href="<?php echo esc_url(get_post_type_archive_link("project")); ?>"><?php esc_html_e("Projects", "kennyb-theme"); ?></a></p>
            <h1 class="page-title"><?php the_title(); ?></h1>

            <div class="d-flex flex-wrap align-items-center gap-4 mt-4">
                <?php if ($url) : ?>
                    <a class="btn btn-primary" href="<?php echo esc_url($url); ?>" rel="noopener" target="_blank">
                        <?php
                        /* translators: %s: site domain */
                        printf(esc_html__("Visit %s", "kennyb-theme"), esc_html(wp_parse_url($url, PHP_URL_HOST)));
                        ?>
                    </a>
                <?php endif; ?>
                <?php if (is_array($terms)) : ?>
                    <ul class="chip-list">
                        <?php foreach ($terms as $term) : ?>
                            <li><?php echo kennyb_tech_chip($term->name); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-card__thumb mb-5"><?php the_post_thumbnail("large"); ?></div>
        <?php endif; ?>

        <div class="prose">
            <?php the_content(); ?>
        </div>

        <nav class="row g-4 my-5 py-4 border-top" aria-label="<?php esc_attr_e("More projects", "kennyb-theme"); ?>">
            <div class="col-md-6"><?php previous_post_link("%link"); ?></div>
            <div class="col-md-6 text-md-end"><?php next_post_link("%link"); ?></div>
        </nav>
    </article>
    <?php
endwhile;

get_footer();
