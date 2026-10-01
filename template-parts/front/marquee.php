<?php $words = kennyb_profile()["marquee"]; ?>
<div class="marquee" aria-label="<?php echo esc_attr(implode(", ", $words)); ?>">
    <div class="marquee__track" aria-hidden="true">
        <?php for ($copy = 0; $copy < 2; $copy++) : ?>
            <ul class="marquee__list">
                <?php foreach ($words as $word) : ?>
                    <li><?php echo esc_html($word); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endfor; ?>
    </div>
</div>
