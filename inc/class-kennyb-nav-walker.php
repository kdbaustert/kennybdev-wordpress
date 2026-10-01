<?php
/**
 * Renders wp_nav_menu() as Bootstrap 5 navbar markup: nav-item / nav-link on
 * the top level, dropdown-menu / dropdown-item one level down. Menus deeper
 * than two levels are flattened by passing depth => 2 to wp_nav_menu().
 */

class Kennyb_Nav_Walker extends Walker_Nav_Menu
{
    public function start_lvl(&$output, $depth = 0, $args = null): void
    {
        $output .= '<ul class="dropdown-menu">';
    }

    public function end_lvl(&$output, $depth = 0, $args = null): void
    {
        $output .= "</ul>";
    }

    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0): void
    {
        $item = $data_object;
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array("menu-item-has-children", $classes, true);
        // WordPress drops the #fragment before comparing URLs, so every "/#section" link
        // would count as current on the front page. Only whole-page links can be active.
        $is_current = !str_contains($item->url, "#")
            && array_intersect($classes, ["current-menu-item", "current-menu-ancestor", "current_page_parent"]);

        $li_classes = $depth === 0 ? ["nav-item"] : [];
        if ($has_children && $depth === 0) {
            $li_classes[] = "dropdown";
        }
        $output .= '<li class="' . esc_attr(implode(" ", $li_classes)) . '">';

        $atts = [
            "href" => $item->url ?: "#",
            "class" => $depth === 0 ? "nav-link" : "dropdown-item",
            "target" => $item->target ?: null,
            "rel" => $item->xfn ?: null,
            "title" => $item->attr_title ?: null,
        ];

        if ($is_current) {
            $atts["class"] .= " active";
            $atts["aria-current"] = "page";
        }

        if ($has_children && $depth === 0) {
            $atts["class"] .= " dropdown-toggle";
            $atts["role"] = "button";
            $atts["data-bs-toggle"] = "dropdown";
            $atts["aria-expanded"] = "false";
        }

        $html_atts = "";
        foreach ($atts as $name => $value) {
            if ($value !== null) {
                $value = $name === "href" ? esc_url($value) : esc_attr($value);
                $html_atts .= " {$name}=\"{$value}\"";
            }
        }

        $title = apply_filters("nav_menu_item_title", $item->title, $item, $args, $depth);
        $output .= "<a{$html_atts}>" . esc_html($title) . "</a>";
    }

    public function end_el(&$output, $data_object, $depth = 0, $args = null): void
    {
        $output .= "</li>";
    }
}
