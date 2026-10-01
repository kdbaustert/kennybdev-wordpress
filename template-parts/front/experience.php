<?php $jobs = kennyb_profile()["experience"]; ?>
<section class="section" id="experience" aria-labelledby="experience-title">
    <div class="shell">
        <div class="section__head">
            <div>
                <p class="eyebrow"><span>04</span><span><?php esc_html_e("Experience", "kennyb-theme"); ?></span></p>
                <h2 id="experience-title" class="section__title"><?php esc_html_e("Career to date", "kennyb-theme"); ?></h2>
            </div>
            <p class="section__lede">
                <?php esc_html_e("I've done web development for 10 years, at agencies and studios, on front-end contracts and on in-house product teams.", "kennyb-theme"); ?>
            </p>
        </div>

        <ol class="timeline">
            <?php foreach ($jobs as [$from, $to, $role, $company, $where]) : ?>
                <li class="timeline__item">
                    <span class="timeline__period"><?php echo esc_html("{$from} – {$to}"); ?></span>
                    <div>
                        <h3 class="timeline__role"><?php echo esc_html($role); ?></h3>
                        <span class="timeline__company"><?php echo esc_html($company); ?></span>
                    </div>
                    <span class="timeline__where"><?php echo esc_html($where); ?></span>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>
