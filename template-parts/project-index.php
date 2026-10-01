<?php
/**
 * Project index. PHP prints the full list, then Vue replaces it with the
 * filterable version. Without JS (or before it loads) visitors still get
 * every project as a working link.
 *
 * @var array $args ["projects" => kennyb_get_projects() result]
 */

$projects = $args["projects"] ?? [];

ob_start();
?>
<ol class="project-index">
    <?php foreach ($projects as $i => $project) : ?>
        <li class="project-row">
            <span class="project-row__num"><?php echo esc_html(str_pad((string) ($i + 1), 2, "0", STR_PAD_LEFT)); ?></span>
            <div>
                <h3 class="project-row__title"><a href="<?php echo esc_url($project["link"]); ?>"><?php echo esc_html($project["title"]); ?></a></h3>
                <span class="project-row__domain"><?php echo esc_html($project["domain"]); ?></span>
            </div>
            <ul class="chip-list project-row__tags">
                <?php foreach ($project["tags"] as $tag) : ?>
                    <li><?php echo kennyb_tech_chip($tag); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside ?></li>
                <?php endforeach; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ol>
<?php
kennyb_island("project-filter", ["projects" => $projects, "techColors" => kennyb_tech_colors()], ob_get_clean());
