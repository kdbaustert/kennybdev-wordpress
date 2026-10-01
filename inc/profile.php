<?php
/**
 * Fixed profile copy for the front page, taken from kennybdev's
 * src/data/content.js and src/data/copy.js. On a client site these would be
 * ACF option fields; here they are plain arrays so the theme runs with no
 * plugins installed.
 */

function kennyb_profile(): array
{
    return [
        "name" => "Kenny Baustert",
        "role" => ["Software", "Engineer"],
        "status" => __("Available for work", "kennyb-theme"),
        "lede" => __(
            "I'm the kind of developer who gets into the animation and interaction details. I like a hard problem, and I keep learning newer front-end and back-end tools.",
            "kennyb-theme"
        ),
        "meta" => [
            ["label" => __("Focus", "kennyb-theme"), "value" => "JavaScript, Systems Applications, SQL, PHP"],
            ["label" => __("Based", "kennyb-theme"), "value" => "Lakeland, Florida"],
            ["label" => __("Education", "kennyb-theme"), "value" => "Bachelor's degree, Full Sail University"],
            ["label" => __("Code", "kennyb-theme"), "value" => "github.com/kdbaustert", "url" => "https://github.com/kdbaustert"],
        ],
        "about" => __(
            "I've done full stack work for 10 years, most of it on the parts that never make the demo. It's mainly Laravel and PHP, usually with Vue and MySQL, and WordPress when a client wants to manage their own content. I tend to own the whole build, schema and deploy included. I've worked that way at agencies and on in-house teams, and a claims operation still runs on my code every day.",
            "kennyb-theme"
        ),
        "availability" => __(
            "I'm available now for full-time roles and contract work, remote or hybrid around Lakeland, Tampa and Orlando.",
            "kennyb-theme"
        ),
        "marquee" => ["Full Stack Engineer", "PHP", "JavaScript", "SQL", "Backend", "Front End", "WordPress", "Maintenance"],
        "capabilities" => [
            "Languages" => "PHP, JavaScript, SQL",
            "Backend" => "PHP, Laravel, WordPress, MVC, REST APIs",
            "Front End" => "Vue, React, GSAP, SCSS",
            "Data" => "MySQL, schema design, migrations",
            "Servers" => "Nginx, Apache, LAMP",
            "Tooling" => "Git, code review",
            "Conversion" => "Sales funnels, landing pages, Google Analytics",
        ],
        "services" => [
            "Backend" => ["PHP / Laravel", "REST APIs", "MySQL schema design", "Third-party integrations"],
            "Front End" => ["Vue", "React / TypeScript", "GSAP / ScrollTrigger", "Responsive UI"],
            "WordPress" => ["Custom themes", "ACF", "WooCommerce", "Custom plugins"],
            "Deployment & Maintenance" => ["LAMP / DigitalOcean", "Query tuning", "Speed & SEO", "Code review"],
            "Landing Pages" => ["Landing pages", "Lead capture forms", "CRM handoff", "A/B variants"],
        ],
        "experience" => [
            ["Sep 2023", "Oct 2026", "Software Developer", "CNC Catastrophe & National Claims", "Remote"],
            ["May 2023", "Jul 2023", "Full Stack Engineer", "Green Group Studio", "Remote"],
            ["Dec 2022", "Jan 2023", "WordPress Developer", "ModMed", "Remote"],
            ["May 2022", "Nov 2022", "ReactJS Developer", "RADcube, Rapid Technology Solutions, Lilly Pharmaceutical", "Remote"],
            ["Sep 2021", "Dec 2021", "Senior Full Stack Engineer", "Designzillas", "Hybrid"],
            ["Jul 2018", "Sep 2021", "Lead Full Stack Engineer", "OM Performance Marketers", "Remote"],
            ["Dec 2016", "Feb 2019", "Full Stack Developer", "Sling Ads", "On-site"],
        ],
        "email" => "kenny@kennyb.dev",
        "links" => [
            "GitHub" => "https://github.com/kdbaustert",
            "LinkedIn" => "https://www.linkedin.com/in/kennybjr/",
        ],
    ];
}

/**
 * Per-technology chip colours, from kennybdev's src/data/techColors.js.
 */
function kennyb_tech_colors(): array
{
    return [
        "PHP" => "#a9b1e8",
        "JavaScript" => "#f0d43a",
        "Laravel" => "#ff5f52",
        "Vue" => "#41d1a0",
        "WordPress" => "#55b6e8",
        "Custom WordPress" => "#55b6e8",
        "ACF" => "#f472b6",
        "Bootstrap" => "#a06cf5",
        "MySQL" => "#f2a33c",
        "Shopify" => "#95d15c",
        "Custom Shopify Theme" => "#95d15c",
        "SCSS" => "#cf649a",
        "Custom Plugins" => "#5ce1e6",
        "WP Rig" => "#5ce1e6",
    ];
}

function kennyb_tech_chip(string $tag): string
{
    $color = kennyb_tech_colors()[$tag] ?? null;
    $style = $color ? ' style="--chip: ' . esc_attr($color) . '"' : "";

    return '<span class="chip"' . $style . ">" . esc_html($tag) . "</span>";
}
