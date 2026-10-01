<article <?php post_class("post-card"); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-card__thumb"><?php the_post_thumbnail("kennyb-card", ["loading" => "lazy"]); ?></div>
    <?php endif; ?>

    <?php kennyb_post_meta(); ?>

    <h2 class="post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p class="post-card__excerpt"><?php echo esc_html(get_the_excerpt()); ?></p>
</article>
