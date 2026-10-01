<?php $profile = kennyb_profile(); ?>
</main>

<footer class="site-footer">
    <div class="shell">
        <div class="row g-5">
            <div class="col-lg-5">
                <a class="navbar-brand fs-4 fw-bold text-uppercase text-decoration-none" href="<?php echo esc_url(home_url("/")); ?>">
                    <?php bloginfo("name"); ?>
                </a>
                <p class="mt-3 mb-0" style="max-width: 28rem"><?php echo esc_html($profile["availability"]); ?></p>
            </div>

            <div class="col-6 col-lg-3 offset-lg-1">
                <h2><?php esc_html_e("Sitemap", "kennyb-theme"); ?></h2>
                <?php
                wp_nav_menu([
                    "theme_location" => "footer",
                    "container" => false,
                    "depth" => 1,
                    "fallback_cb" => "kennyb_menu_fallback_plain",
                ]);
                ?>
            </div>

            <div class="col-6 col-lg-3">
                <h2><?php esc_html_e("Elsewhere", "kennyb-theme"); ?></h2>
                <ul>
                    <?php foreach ($profile["links"] as $label => $url) : ?>
                        <li><a href="<?php echo esc_url($url); ?>" rel="me noopener" target="_blank"><?php echo esc_html($label); ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="mailto:<?php echo esc_attr($profile["email"]); ?>"><?php echo esc_html($profile["email"]); ?></a></li>
                    <li><a href="<?php echo esc_url(get_bloginfo("rss2_url")); ?>"><?php esc_html_e("Journal RSS", "kennyb-theme"); ?></a></li>
                </ul>
            </div>
        </div>

        <div class="site-footer__base">
            <span>&copy; <?php echo esc_html(wp_date("Y")); ?> <?php bloginfo("name"); ?>, Lakeland, Florida</span>
            <span><?php esc_html_e("Built with WordPress, Bootstrap and Vue", "kennyb-theme"); ?></span>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
