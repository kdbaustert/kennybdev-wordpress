<?php $profile = kennyb_profile(); ?>
<section class="section" id="contact" aria-labelledby="contact-title">
    <div class="shell">
        <p class="eyebrow"><span>06</span><span><?php esc_html_e("Contact", "kennyb-theme"); ?></span></p>
        <h2 id="contact-title" class="visually-hidden"><?php esc_html_e("Contact", "kennyb-theme"); ?></h2>

        <div class="availability">
            <p class="hero__status mb-0"><span class="status-dot" aria-hidden="true"></span><?php echo esc_html($profile["status"]); ?></p>
            <p class="mb-0"><?php echo esc_html($profile["availability"]); ?></p>
        </div>

        <a class="contact__email" href="mailto:<?php echo esc_attr($profile["email"]); ?>"><?php echo esc_html($profile["email"]); ?></a>

        <ul class="chip-list">
            <?php foreach ($profile["links"] as $label => $url) : ?>
                <li><a class="btn btn-outline-light btn-sm" href="<?php echo esc_url($url); ?>" rel="me noopener" target="_blank"><?php echo esc_html($label); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
