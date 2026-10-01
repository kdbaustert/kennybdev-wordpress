<?php
get_header();

while (have_posts()) :
    the_post();
    ?>
    <article <?php post_class("shell"); ?>>
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div class="prose pb-5 mb-5">
            <?php
            the_content();
            wp_link_pages();
            ?>
        </div>
    </article>
    <?php
endwhile;

get_footer();
