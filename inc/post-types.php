<?php
/**
 * The "project" post type and its "tech" taxonomy, so portfolio entries are
 * edited in wp-admin like any other content.
 *
 * On a client build this would live in a plugin, so the projects survive a
 * theme change. It is in the theme here to keep the example in one folder.
 */

function kennyb_register_content_types(): void
{
    register_post_type("project", [
        "labels" => [
            "name" => __("Projects", "kennyb-theme"),
            "singular_name" => __("Project", "kennyb-theme"),
            "add_new_item" => __("Add project", "kennyb-theme"),
            "edit_item" => __("Edit project", "kennyb-theme"),
        ],
        "public" => true,
        "has_archive" => "work",
        "rewrite" => ["slug" => "work", "with_front" => false],
        "menu_icon" => "dashicons-portfolio",
        "menu_position" => 5,
        "show_in_rest" => true,
        "supports" => ["title", "editor", "excerpt", "thumbnail", "page-attributes"],
    ]);

    register_taxonomy("tech", ["project"], [
        "labels" => [
            "name" => __("Tech", "kennyb-theme"),
            "singular_name" => __("Tech", "kennyb-theme"),
        ],
        "public" => true,
        "hierarchical" => false,
        "show_in_rest" => true,
        "show_admin_column" => true,
        "rewrite" => ["slug" => "tech"],
    ]);

    register_post_meta("project", "project_url", [
        "type" => "string",
        "single" => true,
        "show_in_rest" => true,
        "sanitize_callback" => "esc_url_raw",
    ]);
}
add_action("init", "kennyb_register_content_types");

/**
 * The /work/ URLs only exist after rewrite rules are rebuilt, so do it once
 * when the theme is activated rather than asking for a trip to Permalinks.
 */
function kennyb_flush_rewrites(): void
{
    kennyb_register_content_types();
    flush_rewrite_rules();
}
add_action("after_switch_theme", "kennyb_flush_rewrites");

/**
 * Projects ordered by menu_order, shaped for the ProjectFilter Vue island.
 *
 * @return array<int, array{id: int, title: string, link: string, url: string, domain: string, summary: string, tags: string[]}>
 */
function kennyb_get_projects(int $limit = -1): array
{
    $query = new WP_Query([
        "post_type" => "project",
        "posts_per_page" => $limit,
        "orderby" => ["menu_order" => "ASC", "date" => "DESC"],
        "no_found_rows" => true,
    ]);

    return array_map(static function (WP_Post $post): array {
        $url = (string) get_post_meta($post->ID, "project_url", true);
        $terms = get_the_terms($post, "tech");

        return [
            "id" => $post->ID,
            "title" => get_the_title($post),
            "link" => get_permalink($post),
            "url" => $url,
            "domain" => $url ? (string) wp_parse_url($url, PHP_URL_HOST) : "",
            "summary" => get_the_excerpt($post),
            "tags" => is_array($terms) ? wp_list_pluck($terms, "name") : [],
        ];
    }, $query->posts);
}

/**
 * A plain meta box for the live URL. register_post_meta() exposes the field
 * to the REST API but gives it no editor UI, and a block-editor sidebar panel
 * would need its own JS build for one text field.
 */
function kennyb_project_meta_box(): void
{
    add_meta_box("kennyb-project-url", __("Live site", "kennyb-theme"), "kennyb_render_project_meta_box", "project", "side");
}
add_action("add_meta_boxes", "kennyb_project_meta_box");

function kennyb_render_project_meta_box(WP_Post $post): void
{
    wp_nonce_field("kennyb_project_url", "kennyb_project_url_nonce");
    printf(
        '<label for="kennyb-project-url-field">%1$s</label><input type="url" id="kennyb-project-url-field" name="project_url" value="%2$s" class="widefat" placeholder="https://">',
        esc_html__("URL", "kennyb-theme"),
        esc_attr(get_post_meta($post->ID, "project_url", true))
    );
}

function kennyb_save_project_meta(int $post_id): void
{
    $nonce = $_POST["kennyb_project_url_nonce"] ?? "";

    if (!wp_verify_nonce(sanitize_text_field(wp_unslash($nonce)), "kennyb_project_url")) {
        return;
    }
    if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can("edit_post", $post_id)) {
        return;
    }

    $url = esc_url_raw(wp_unslash($_POST["project_url"] ?? ""));
    update_post_meta($post_id, "project_url", $url);
}
add_action("save_post_project", "kennyb_save_project_meta");
