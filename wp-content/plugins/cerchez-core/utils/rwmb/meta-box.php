<?php

defined('ABSPATH') || exit;

define('RWMB_VER', '4.3.8');

if ( ! defined('RWMB_URL') ) define('RWMB_URL', plugin_dir_url( __FILE__ ) );
define('RWMB_JS_URL', trailingslashit( RWMB_URL . 'js') );
define('RWMB_CSS_URL', trailingslashit( RWMB_URL . 'css') );

if ( ! defined('RWMB_DIR') ) define('RWMB_DIR', plugin_dir_path( __FILE__ ) );
define('RWMB_INC_DIR', trailingslashit( RWMB_DIR . 'inc') );
define('RWMB_FIELDS_DIR', trailingslashit( RWMB_INC_DIR . 'fields') );

require_once RWMB_INC_DIR . 'helpers.php';

if ( is_admin() ) {
	require_once RWMB_INC_DIR . 'field.php';
	foreach ( glob( RWMB_FIELDS_DIR . '*.php') as $file ) {
		require_once $file;
	}
	require_once RWMB_INC_DIR . 'meta-box.php';
}
