<?php

define('THEME_BACKUPS', 'backups');
define('THEME_ADMIN_PATH', get_template_directory() . '/utils/admin/');
define('THEME_ADMIN_DIR', get_template_directory_uri() . '/utils/admin/');

require_once(THEME_ADMIN_PATH . 'options.php');
require_once(THEME_ADMIN_PATH . 'lib/utils.php');
require_once(THEME_ADMIN_PATH . 'lib/machine.php');

add_action('admin_init', 'optionsframework_admin_init');
add_action('admin_menu', 'optionsframework_add_admin');
add_action('wp_ajax_of_ajax_post_action', 'optionsframework_ajax_callback');