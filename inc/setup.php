<?php
/**
 * Theme supports, menus, image sizes and widget areas.
 */

function kennyb_setup(): void
{
    load_theme_textdomain("kennyb-theme", KENNYB_DIR . "/languages");

    add_theme_support("title-tag");
    add_theme_support("automatic-feed-links");
    add_theme_support("post-thumbnails");
    add_theme_support("responsive-embeds");
    add_theme_support("custom-logo", ["height" => 40, "width" => 40, "flex-width" => true]);
    add_theme_support("html5", ["search-form", "comment-form", "comment-list", "gallery", "caption", "style", "script"]);

    add_image_size("kennyb-card", 720, 450, true);

    register_nav_menus([
        "primary" => __("Primary navigation", "kennyb-theme"),
        "footer" => __("Footer links", "kennyb-theme"),
    ]);
}
add_action("after_setup_theme", "kennyb_setup");

function kennyb_excerpt_length(): int
{
    return 28;
}
add_filter("excerpt_length", "kennyb_excerpt_length");

function kennyb_excerpt_more(): string
{
    return "…";
}
add_filter("excerpt_more", "kennyb_excerpt_more");
