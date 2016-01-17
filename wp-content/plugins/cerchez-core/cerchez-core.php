<?php

/*

Plugin Name: Cerchez Core

Plugin URI: http://themeforest.net/user/liviu_cerchez

Description: Core Plugin for Liviu Cerchez Themes (includes shortcodes, widgets, metabox fields, project custom posts and other useful features)

Version: 1.4.2

Author: liviu_cerchez

Author URI: http://themeforest.net/user/liviu_cerchez

*/



if( ! defined('CERCHEZ_PLUGIN_URI') ) define( 'CERCHEZ_PLUGIN_URI', trailingslashit( plugins_url( '', __FILE__ ) ) );



require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'image-resize.php' );

require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . 'shortcodes.php' );

require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'post-preview' . DIRECTORY_SEPARATOR . 'post-preview.php' );

require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'widgets.php' );

require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'post-types.php' );

if ( ! class_exists( 'RW_Meta_Box' ) ) require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'rwmb' . DIRECTORY_SEPARATOR . 'meta-box.php' );

if (is_admin()) {

	$import_theme_data_run_once = get_option('import_theme_demo_data_check');

	if ( ! $import_theme_data_run_once) {

		require_once( plugin_dir_path( __FILE__ ) . 'utils' . DIRECTORY_SEPARATOR . 'importer'  . DIRECTORY_SEPARATOR . 'cerchez-importer.php' );

	}

}



add_action('plugins_loaded', 'cerchez_core_load_textdomain');

function cerchez_core_load_textdomain() {

	load_plugin_textdomain( 'cerchez-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 

}

