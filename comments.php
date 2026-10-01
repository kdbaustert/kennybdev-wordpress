<?php
if (post_password_required()) {
    return;
}
?>
<section id="comments" class="prose pb-5 mb-5">
    <?php if (have_comments()) : ?>
        <h2>
            <?php
            /* translators: %d: number of comments */
            printf(esc_html(_n("%d comment", "%d comments", get_comments_number(), "kennyb-theme")), (int) get_comments_number());
            ?>
        </h2>
        <ol class="list-unstyled">
            <?php wp_list_comments(["style" => "ol", "avatar_size" => 40, "short_ping" => true]); ?>
        </ol>
        <?php the_comments_navigation(); ?>
    <?php endif; ?>

    <?php
    comment_form([
        "class_form" => "d-grid gap-3",
        "class_submit" => "btn btn-primary",
        "title_reply_before" => '<h2 id="reply-title">',
        "title_reply_after" => "</h2>",
        "comment_field" => '<p><label class="form-label" for="comment">' . esc_html__("Comment", "kennyb-theme")
            . '</label><textarea id="comment" name="comment" class="form-control" style="border-radius: .75rem" rows="5" required></textarea></p>',
    ]);
    ?>
</section>
