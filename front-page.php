<?php
/**
 * Front page. Each section is a template part under template-parts/front/,
 * in the same order as kennybdev's App.vue.
 */

get_header();

foreach (["hero", "marquee", "about", "projects", "services", "experience", "journal", "contact"] as $section) {
    get_template_part("template-parts/front/" . $section);
}

get_footer();
