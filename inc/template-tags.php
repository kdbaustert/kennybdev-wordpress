<?php
/**
 * Small template helpers shared across templates.
 */

function kennyb_reading_time(?int $post_id = null): string
{
    $words = str_word_count(wp_strip_all_tags(get_post_field("post_content", $post_id ?? get_the_ID())));
    $minutes = max(1, (int) ceil($words / 225));

    /* translators: %d: minutes */
    return sprintf(_n("%d min read", "%d min read", $minutes, "kennyb-theme"), $minutes);
}

function kennyb_post_meta(): void
{
    printf(
        '<p class="post-meta"><time datetime="%1$s">%2$s</time><span>%3$s</span></p>',
        esc_attr(get_the_date(DATE_W3C)),
        esc_html(get_the_date()),
        esc_html(kennyb_reading_time())
    );
}

/**
 * paginate_links() as a Bootstrap .pagination list.
 */
function kennyb_pagination(): void
{
    $links = paginate_links([
        "type" => "array",
        "prev_text" => __("Newer", "kennyb-theme"),
        "next_text" => __("Older", "kennyb-theme"),
    ]);

    if (empty($links)) {
        return;
    }

    echo '<nav class="mt-5" aria-label="' . esc_attr__("Posts pagination", "kennyb-theme") . '"><ul class="pagination">';
    foreach ($links as $link) {
        $is_current = str_contains($link, "current");
        $link = str_replace("page-numbers", "page-link", $link);
        printf('<li class="page-item%s">%s</li>', $is_current ? " active" : "", $link);
    }
    echo "</ul></nav>";
}

/**
 * Prints a mount point for a Vue island (see src/js/islands.js).
 *
 * $fallback is server-rendered HTML shown until Vue mounts, and kept for
 * visitors without JS. It is printed as-is, so callers pass markup they have
 * already escaped.
 */
function kennyb_island(string $name, array $props = [], string $fallback = ""): void
{
    printf(
        '<div data-vue="%1$s" data-props="%2$s">%3$s</div>',
        esc_attr($name),
        esc_attr(wp_json_encode($props)),
        $fallback
    );
}

/**
 * Primary menu before one is assigned: the front page's own sections, so a
 * fresh install still has working navigation.
 */
function kennyb_fallback_links(): array
{
    return [
        __("Home", "kennyb-theme") => home_url("/"),
        __("About", "kennyb-theme") => home_url("/#about"),
        __("Projects", "kennyb-theme") => home_url("/#work"),
        __("Services", "kennyb-theme") => home_url("/#services"),
        __("Experience", "kennyb-theme") => home_url("/#experience"),
        __("Contact", "kennyb-theme") => home_url("/#contact"),
    ];
}

function kennyb_menu_fallback(): void
{
    echo '<ul class="navbar-nav ms-auto mb-3 mb-lg-0">';
    foreach (kennyb_fallback_links() as $label => $url) {
        printf('<li class="nav-item"><a class="nav-link" href="%s">%s</a></li>', esc_url($url), esc_html($label));
    }
    echo "</ul>";
}

function kennyb_menu_fallback_plain(): void
{
    echo "<ul>";
    foreach (kennyb_fallback_links() as $label => $url) {
        printf('<li><a href="%s">%s</a></li>', esc_url($url), esc_html($label));
    }
    echo "</ul>";
}
