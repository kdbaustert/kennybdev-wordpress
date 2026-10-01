<div class="py-5" style="max-width: 36rem">
    <?php if (is_search()) : ?>
        <p><?php esc_html_e("No posts match that search. Try a single word, like “WordPress” or “Vue”.", "kennyb-theme"); ?></p>
        <?php get_search_form(); ?>
    <?php else : ?>
        <p><?php esc_html_e("Nothing has been published here yet.", "kennyb-theme"); ?></p>
        <a class="btn btn-outline-light" href="<?php echo esc_url(home_url("/")); ?>"><?php esc_html_e("Back to the home page", "kennyb-theme"); ?></a>
    <?php endif; ?>
</div>
