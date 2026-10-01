<!doctype html>
<html <?php language_attributes(); ?> data-bs-theme="dark">
<head>
    <meta charset="<?php bloginfo("charset"); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="dark">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link visually-hidden-focusable" href="#main"><?php esc_html_e("Skip to content", "kennyb-theme"); ?></a>

<header class="site-header">
    <nav class="navbar navbar-expand-lg shell" aria-label="<?php esc_attr_e("Primary", "kennyb-theme"); ?>">
        <?php if (has_custom_logo()) : ?>
            <?php the_custom_logo(); ?>
        <?php else : ?>
            <a class="navbar-brand" href="<?php echo esc_url(home_url("/")); ?>" rel="home"><?php bloginfo("name"); ?></a>
        <?php endif; ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#primary-nav"
                aria-controls="primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e("Toggle navigation", "kennyb-theme"); ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="primary-nav">
            <?php
            wp_nav_menu([
                "theme_location" => "primary",
                "container" => false,
                "menu_class" => "navbar-nav ms-auto mb-3 mb-lg-0",
                "depth" => 2,
                "walker" => new Kennyb_Nav_Walker(),
                "fallback_cb" => "kennyb_menu_fallback",
            ]);
            ?>
            <a class="btn btn-primary btn-sm ms-lg-3" href="<?php echo esc_url(home_url("/#contact")); ?>">
                <?php esc_html_e("Get in touch", "kennyb-theme"); ?>
            </a>
        </div>
    </nav>
</header>

<main id="main" tabindex="-1">
