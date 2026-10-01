<?php
/**
 * Front-end assets. Vite writes dist/theme.css and dist/theme.js with fixed
 * names (see vite.config.js); filemtime() gives each build a new version
 * string so browsers drop the cached copy.
 */

function kennyb_asset_version(string $relative): string
{
    $path = KENNYB_DIR . "/" . $relative;

    return file_exists($path) ? (string) filemtime($path) : KENNYB_VERSION;
}

function kennyb_enqueue_assets(): void
{
    if (!file_exists(KENNYB_DIR . "/dist/theme.css")) {
        // A fresh clone with no build looks broken in a confusing way, so say why.
        if (current_user_can("switch_themes")) {
            add_action("wp_footer", static function (): void {
                echo '<p class="container py-3 text-danger">Theme assets missing: run <code>npm run build</code>.</p>';
            });
        }
        return;
    }

    wp_enqueue_style("kennyb-theme", KENNYB_URI . "/dist/theme.css", [], kennyb_asset_version("dist/theme.css"));

    // Vite emits an ES module, so it goes through the script-modules API (WP 6.5+), which prints type="module".
    wp_enqueue_script_module("kennyb-theme", KENNYB_URI . "/dist/theme.js", [], kennyb_asset_version("dist/theme.js"));

    if (is_singular() && comments_open() && get_option("thread_comments")) {
        wp_enqueue_script("comment-reply");
    }
}
add_action("wp_enqueue_scripts", "kennyb_enqueue_assets");
