<?php



function cerchez_core_admin_head() {

	global $pagenow;



	if( 'post.php' != $pagenow && 'post-new.php' != $pagenow ) return;



	$output = "<script type='text/javascript'>";

	$output .= 'var CERCHEZ_CORE_PLUGIN_PATH_URL="'. CERCHEZ_PLUGIN_URI .'";';



	$button_menu = array(

		'basic' => array(

			'title' => __('Basic', 'cerchez-core'),

			'type' => 'parent',

			'childs' => array (

				'alert' => array(

					'title' => __('Alert', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'box' => array(

					'title' => __('Box', 'cerchez-core'),

					'type' => 'addInsert',

					'before' => '[box]',

					'after' => '[/box]',

				),

				'button' => array(

					'title' => __('Button', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'call_to_action' => array(

					'title' => __('Call-to-action', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'feature' => array(

					'title' => __('Feature', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'highlight' => array(

					'title' => __('Highlight', 'cerchez-core'),

					'type' => 'addInsert',

					'before' => '[highlight]',

					'after' => '[/highlight]',

				),

				'social' => array(

					'title' => __('Social Link', 'cerchez-core'),

					'type' => 'addPopup',

				),

			),

		),

		'interactive' => array(

			'title' => __('Interactive', 'cerchez-core'),

			'type' => 'parent',

			'childs' => array (

				'accordion' => array(

					'title' => __('Accordions', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'accordion_item' => array(

					'title' => __('Accordion Item', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'projects' => array(

					'title' => __('Latest Projects', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'news' => array(

					'title' => __('Latest News', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'pricing' => array(

					'title' => __('Pricing Table', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'slider' => array(

					'title' => __('Slideshow', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'slider_item' => array(

					'title' => __('Slideshow Item', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'tabs' => array(

					'title' => __('Tabs', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'tab' => array(

					'title' => __('Tab Item', 'cerchez-core'),

					'type' => 'addPopup',

				),

			),

		),

		'containers' => array(

			'title' => __('Containers', 'cerchez-core'),

			'type' => 'parent',

			'childs' => array (

				'audio' => array(

					'title' => __('Audio Player', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'lightbox' => array(

					'title' => __('Lightbox', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'map' => array(

					'title' => __('Map Container', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'video' => array(

					'title' => __('Video Container', 'cerchez-core'),

					'type' => 'addPopup',

				),

			),

		),

		'layout' => array(

			'title' => __('Layout', 'cerchez-core'),

			'type' => 'parent',

			'childs' => array (

				'grid' => array(

					'title' => __('Grid Column', 'cerchez-core'),

					'type' => 'addPopup',

				),

				'divider' => array(

					'title' => __('Divider', 'cerchez-core'),

					'type' => 'addInsert',

					'after' => '[divider]',

				),

				'clear' => array(

					'title' => __('Float clearing', 'cerchez-core'),

					'type' => 'addInsert',

					'after' => '[clear]',

				),

			),

		),



	);

	$button_menu = apply_filters('cerchez_core_shortcodes_button_menu', $button_menu);

	$output .= 'var CERCHEZ_CORE_PLUGIN_BUTTON_MENU = ' . json_encode($button_menu) . ';';

	$output .= '</script>';

	echo $output;

}

add_action('admin_head', 'cerchez_core_admin_head');



function cerchez_core_add_shortcodes_button() {

	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) return;

	if ( get_user_option('rich_editing') == 'true' ) {

		add_filter('mce_external_plugins', 'cerchez_core_tmce_plugins');

		add_filter('mce_external_languages', 'cerchez_core_tmce_localisation');

		add_filter('mce_buttons', 'cerchez_core_tmce_buttons');

	}

}

add_action('admin_init', 'cerchez_core_add_shortcodes_button');



function cerchez_core_tmce_plugins( $plugin_array ) {

	global $tinymce_version;

	if (isset($tinymce_version) && $tinymce_version[0] == '3') {

		$plugin_array['cerchez_core_shortcodes_plugin'] = CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/tinymce.utils.js';

	} else {

		$plugin_array['cerchez_core_shortcodes_plugin'] = CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/tinymce.utils4.js';

	}

	return $plugin_array;

}



function cerchez_core_tmce_localisation( $mce_external_languages ) {

	$mce_external_languages[ 'cerchez_core_shortcodes_plugin' ] = plugin_dir_path( __FILE__ ) . 'localisation.php';

	return $mce_external_languages;

}



function cerchez_core_tmce_buttons( $buttons ) {

	array_push($buttons, "|", 'cerchez_core_shortcodes_button');

	return $buttons;

}

