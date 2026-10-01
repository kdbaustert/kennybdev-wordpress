<?php $services = kennyb_profile()["services"]; ?>
<section class="section" id="services" aria-labelledby="services-title">
    <div class="shell">
        <div class="section__head">
            <div>
                <p class="eyebrow"><span>03</span><span><?php esc_html_e("Services", "kennyb-theme"); ?></span></p>
                <h2 id="services-title" class="section__title"><?php esc_html_e("Core capabilities", "kennyb-theme"); ?></h2>
            </div>
            <p class="section__lede">
                <?php esc_html_e("I build APIs in Laravel and PHP and front ends in Vue or React, with MySQL schemas that keep up as the data grows. I also do WordPress on ACF and WooCommerce, and landing pages built to capture leads. Most projects need two or three of these at once.", "kennyb-theme"); ?>
            </p>
        </div>

        <div class="services">
            <?php $n = 0; ?>
            <?php foreach ($services as $title => $items) : ?>
                <div class="service">
                    <span class="service__num"><?php echo esc_html(sprintf("%02d", ++$n)); ?></span>
                    <h3><?php echo esc_html($title); ?></h3>
                    <ul>
                        <?php foreach ($items as $item) : ?>
                            <li><?php echo esc_html($item); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
