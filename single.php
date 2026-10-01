<?php
get_header();

while (have_posts()) :
    the_post();
    ?>
    <article <?php post_class("shell"); ?>>
        <header class="page-header">
            <?php kennyb_post_meta(); ?>
            <h1 class="page-title mt-3"><?php the_title(); ?></h1>
            <?php $categories = get_the_category(); ?>
            <?php if ($categories) : ?>
                <ul class="chip-list mt-4">
                    <?php foreach ($categories as $category) : ?>
                        <li><a class="chip text-decoration-none" href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo esc_html($category->name); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </header>

        <?php if (has_post_thumbnail()) : ?>
            <div class="post-card__thumb mb-5"><?php the_post_thumbnail("large"); ?></div>
        <?php endif; ?>

        <div class="prose">
            <?php
            the_content();
            wp_link_pages();
            ?>
        </div>

        <?php if (has_tag()) : ?>
            <p class="post-meta mt-5"><?php the_tags("", " ", ""); ?></p>
        <?php endif; ?>

        <nav class="row g-4 my-5 py-4 border-top" aria-label="<?php esc_attr_e("More posts", "kennyb-theme"); ?>">
            <div class="col-md-6"><?php previous_post_link('<span class="eyebrow mb-1">' . esc_html__("Older", "kennyb-theme") . "</span>%link"); ?></div>
            <div class="col-md-6 text-md-end"><?php next_post_link('<span class="eyebrow mb-1 justify-content-md-end">' . esc_html__("Newer", "kennyb-theme") . "</span>%link"); ?></div>
        </nav>

        <?php
        if (comments_open() || get_comments_number()) {
            comments_template();
        }
        ?>
    </article>
    <?php
endwhile;

get_footer();
