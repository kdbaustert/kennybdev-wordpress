<?php $profile = kennyb_profile(); ?>
<section class="hero">
    <div class="shell">
        <p class="hero__status"><span class="status-dot" aria-hidden="true"></span><?php echo esc_html($profile["status"]); ?></p>

        <h1 class="hero__title">
            <?php foreach ($profile["role"] as $word) : ?>
                <span><?php echo esc_html($word); ?></span>
            <?php endforeach; ?>
        </h1>
        <p class="hero__name"><?php echo esc_html($profile["name"]); ?></p>

        <div class="hero__grid">
            <p class="hero__lede"><?php echo esc_html($profile["lede"]); ?></p>

            <dl class="hero__meta">
                <?php foreach ($profile["meta"] as $item) : ?>
                    <dt><?php echo esc_html($item["label"]); ?></dt>
                    <dd>
                        <?php if (!empty($item["url"])) : ?>
                            <a href="<?php echo esc_url($item["url"]); ?>" rel="me noopener" target="_blank"><?php echo esc_html($item["value"]); ?></a>
                        <?php else : ?>
                            <?php echo esc_html($item["value"]); ?>
                        <?php endif; ?>
                    </dd>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>
