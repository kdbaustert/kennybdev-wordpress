<?php $profile = kennyb_profile(); ?>
<section class="section" id="about" aria-labelledby="about-title">
    <div class="shell">
        <p class="eyebrow"><span>01</span><span><?php esc_html_e("About", "kennyb-theme"); ?></span></p>
        <h2 id="about-title" class="visually-hidden"><?php esc_html_e("About Kenny Baustert, full stack software engineer", "kennyb-theme"); ?></h2>

        <p class="statement"><?php echo esc_html($profile["about"]); ?></p>

        <dl class="capabilities">
            <?php foreach ($profile["capabilities"] as $label => $value) : ?>
                <div>
                    <dt><?php echo esc_html($label); ?></dt>
                    <dd><?php echo esc_html($value); ?></dd>
                </div>
            <?php endforeach; ?>
        </dl>
    </div>
</section>
