<?php
/**
 * Theme bootstrap. Each concern lives in its own file under inc/.
 */

if (!defined("ABSPATH")) {
    exit;
}

define("KENNYB_VERSION", "1.0.0");
define("KENNYB_DIR", get_template_directory());
define("KENNYB_URI", get_template_directory_uri());

require KENNYB_DIR . "/inc/setup.php";
require KENNYB_DIR . "/inc/assets.php";
require KENNYB_DIR . "/inc/class-kennyb-nav-walker.php";
require KENNYB_DIR . "/inc/template-tags.php";
require KENNYB_DIR . "/inc/post-types.php";
require KENNYB_DIR . "/inc/profile.php";
