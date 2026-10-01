<?php
/**
 * Seeds a fresh install with the portfolio content so the theme looks like a
 * real site straight away. Safe to run more than once: anything that already
 * exists (matched by slug or menu name) is left alone.
 *
 *     wp theme activate kennyb-theme
 *     wp eval-file wp-content/themes/kennyb-theme/demo/seed.php
 *
 * Project copy comes from kennybdev's src/data/content.js. The journal posts
 * are demo content written for this theme.
 */

if (!defined("ABSPATH")) {
    exit("Run this through WP-CLI: wp eval-file demo/seed.php\n");
}

if (!post_type_exists("project")) {
    WP_CLI::error("Activate the theme first (wp theme activate kennyb-theme); it registers the project post type.");
}

// wp_create_category() lives in an admin include that WP-CLI does not load.
require_once ABSPATH . "wp-admin/includes/taxonomy.php";

/**
 * Turns [["p", "text"], ["h2", "text"], ["code", "text"]] into block markup,
 * so seeded posts open cleanly in the block editor.
 */
function kennyb_seed_blocks(array $blocks): string
{
    $html = [];
    foreach ($blocks as [$type, $text]) {
        $html[] = match ($type) {
            "h2" => "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">" . esc_html($text) . "</h2>\n<!-- /wp:heading -->",
            "code" => "<!-- wp:code -->\n<pre class=\"wp-block-code\"><code>" . esc_html($text) . "</code></pre>\n<!-- /wp:code -->",
            default => "<!-- wp:paragraph -->\n<p>" . wp_kses_post($text) . "</p>\n<!-- /wp:paragraph -->",
        };
    }

    return implode("\n\n", $html);
}

function kennyb_seed_post(array $post): int
{
    $existing = get_page_by_path($post["post_name"], OBJECT, $post["post_type"] ?? "post");
    if ($existing) {
        return $existing->ID;
    }

    $id = wp_insert_post($post + ["post_status" => "publish"], true);
    if (is_wp_error($id)) {
        WP_CLI::warning($post["post_title"] . ": " . $id->get_error_message());
        return 0;
    }

    return $id;
}

// Site identity and reading settings.
update_option("blogname", "Kenny B");
update_option("blogdescription", "Software Engineer in Lakeland, Florida");
update_option("permalink_structure", "/%postname%/");

$home = kennyb_seed_post(["post_type" => "page", "post_name" => "home", "post_title" => "Home", "post_content" => ""]);
$journal = kennyb_seed_post(["post_type" => "page", "post_name" => "journal", "post_title" => "Journal", "post_content" => ""]);

update_option("show_on_front", "page");
update_option("page_on_front", $home);
update_option("page_for_posts", $journal);

// Projects, in the order kennybdev lists them.
$projects = [
    ["Orlando Marketers", "https://growwithom.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "A custom WordPress theme I built on ACF for a performance marketing agency. Every section is editable, so campaign pages went out without a developer."],
    ["Vaxcare", "https://vaxcare.com", ["PHP", "ACF", "WordPress", "Custom Plugins", "SCSS", "Bootstrap"],
        "A custom WordPress build for a healthcare platform company. ACF drives the templates, and I kept the features in plugins instead of the theme."],
    ["Mend", "https://mend.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "A custom WordPress theme I built on ACF for a behavioral health software company, so marketing could run the site without a developer."],
    ["Orlando Tree Trek Adventure", "https://orlandotreetrek.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "A custom WordPress theme for an Orlando adventure park. Admissions, hours and course info can be edited in ACF without waiting on a deploy."],
    ["The Villages", "https://www.thevillages.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "I put a 55+ community's listings, news and lifestyle pages behind ACF in a custom WordPress build, so the layout holds up to daily editing."],
    ["Tampa Magazines", "https://tampamagazines.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "A custom WordPress theme for a regional lifestyle magazine, with article templates and issue archives built around how the editors work."],
    ["Community Dental Partners", "https://www.communitydentalpartners.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "My custom WordPress build for a dental support organization, where the recruiting and patient paths are edited separately in ACF."],
    ["World Wide Corals", "https://worldwidecorals.com", ["PHP", "ACF", "WordPress", "WP Rig", "SCSS"],
        "A WordPress build on WP Rig for a saltwater aquarium retailer, with a lean front end for a photo-heavy livestock catalog and ACF for editing."],
    ["RipIt Sports", "https://www.ripit.com", ["Custom Shopify Theme", "Shopify", "SCSS"],
        "A custom Shopify theme in Liquid and SCSS for a women's athletic gear brand, with navigation that splits by sport before product."],
    ["Abby Connect", "https://www.abby.com", ["PHP", "ACF", "Custom WordPress", "SCSS", "Bootstrap"],
        "A custom WordPress site on ACF for a virtual receptionist service. Its marketing team can make landing pages without engineering's help."],
];

foreach ($projects as $order => [$title, $url, $tags, $summary]) {
    $id = kennyb_seed_post([
        "post_type" => "project",
        "post_name" => sanitize_title($title),
        "post_title" => $title,
        "post_excerpt" => $summary,
        "post_content" => kennyb_seed_blocks([["p", $summary]]),
        "menu_order" => $order,
    ]);

    if ($id) {
        update_post_meta($id, "project_url", $url);
        wp_set_object_terms($id, $tags, "tech");
    }
}

// Journal posts, a week apart so the dates read naturally.
$posts = [
    [
        "mounting-vue-in-a-wordpress-theme",
        "Mounting Vue inside a WordPress theme without going headless",
        "Development",
        [
            ["p", "Going headless means rebuilding routing, previews and SEO that WordPress already does. Most client sites need one or two interactive pieces, not a single-page app, so this theme keeps PHP in charge of the page and mounts Vue only where it earns its place."],
            ["h2", "Islands, not an app"],
            ["p", "PHP prints a plain div with a data attribute naming the component and its props as JSON. A twenty-line script finds those divs on load and mounts a small Vue app on each one."],
            ["code", "<div data-vue=\"project-filter\" data-props='{\"projects\":[...]}'>\n  <!-- server-rendered list, shown until Vue mounts -->\n</div>"],
            ["p", "Whatever PHP put inside the div stays there until Vue takes over. Search engines, slow phones and anyone with JavaScript off still get a working page."],
            ["h2", "Passing data in"],
            ["p", "Props come from <code>wp_json_encode()</code> wrapped in <code>esc_attr()</code>, so there's no global <code>window</code> object to keep in sync and no second request on load. When a component needs fresh data, like the journal search, it calls the REST API instead."],
        ],
    ],
    [
        "bootstrap-5-sass-only-what-you-use",
        "Compiling only the parts of Bootstrap you use",
        "Front End",
        [
            ["p", "Importing bootstrap.scss whole is the quickest start and the reason a lot of themes ship a carousel nobody uses. Bootstrap's own docs show the alternative: import its functions, then your overrides, then its variables, and then just the components you need."],
            ["h2", "Order matters"],
            ["p", "Every Bootstrap variable is declared with <code>!default</code>, so a value you set first wins. That only works if your overrides load after the functions they call and before the variables they replace."],
            ["code", "@import \"bootstrap/scss/functions\";\n@import \"abstracts/bootstrap-overrides\";\n@import \"bootstrap/scss/variables\";\n@import \"bootstrap/scss/variables-dark\";\n@import \"bootstrap/scss/maps\";\n@import \"bootstrap/scss/mixins\";\n@import \"bootstrap/scss/utilities\";"],
            ["p", "After that, list the components one by one. Removing a line is how you remove a component, and the diff shows exactly what changed."],
            ["h2", "The Sass warnings"],
            ["p", "Current Dart Sass prints deprecation warnings for Bootstrap 5's <code>@import</code> on every build. They're about Bootstrap's source rather than yours, so the Vite config silences those specific ones and leaves everything else loud."],
        ],
    ],
    [
        "keep-features-out-of-the-theme",
        "Keep the features out of the theme",
        "WordPress",
        [
            ["p", "A theme should decide how things look. When it also registers the post types, the shortcodes and the form handlers, switching themes wipes out content the client thinks they own."],
            ["p", "On client builds I keep custom post types, ACF field groups and integrations in a small site plugin. The theme can be replaced, and the projects, locations and team members are still there afterward."],
            ["h2", "The exception here"],
            ["p", "This demo theme does register its project post type, because it has to run on its own as a single folder. On a real site that file would move into a plugin with no other changes."],
        ],
    ],
];

$date = strtotime("-3 weeks");
foreach ($posts as [$slug, $title, $category, $blocks]) {
    kennyb_seed_post([
        "post_name" => $slug,
        "post_title" => $title,
        "post_content" => kennyb_seed_blocks($blocks),
        "post_category" => [wp_create_category($category)],
        "post_date" => wp_date("Y-m-d H:i:s", $date),
    ]);
    $date += WEEK_IN_SECONDS;
}

// Menus. Front-page sections are custom links; the journal and work archive are real URLs.
function kennyb_seed_menu(string $name, array $links): int
{
    $menu = wp_get_nav_menu_object($name);
    if ($menu) {
        return $menu->term_id;
    }

    $menu_id = wp_create_nav_menu($name);
    foreach ($links as $title => $url) {
        wp_update_nav_menu_item($menu_id, 0, [
            "menu-item-title" => $title,
            "menu-item-url" => $url,
            "menu-item-status" => "publish",
        ]);
    }

    return $menu_id;
}

$primary = kennyb_seed_menu("Primary", [
    "Home" => home_url("/"),
    "About" => home_url("/#about"),
    "Projects" => home_url("/work/"),
    "Services" => home_url("/#services"),
    "Journal" => get_permalink($journal),
    "Contact" => home_url("/#contact"),
]);

$footer = kennyb_seed_menu("Footer", [
    "Home" => home_url("/"),
    "Projects" => home_url("/work/"),
    "Journal" => get_permalink($journal),
    "Experience" => home_url("/#experience"),
]);

set_theme_mod("nav_menu_locations", ["primary" => $primary, "footer" => $footer]);

flush_rewrite_rules();

WP_CLI::success("Seeded pages, " . count($projects) . " projects, " . count($posts) . " posts and 2 menus.");
