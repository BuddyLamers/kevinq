<?php



if ( ! apply_filters('cerchez_post_preview', true)) return;



add_action('add_meta_boxes', 'cerchez_post_preview_metabox');

function cerchez_post_preview_metabox() {

	$custom_post_types = get_post_types(array(

		'public'   => true,

		'_builtin' => false

	), "names", "and"); 

	foreach ( $custom_post_types as $custom_post_type ) {

		add_meta_box('cerchez-quick-preview', __('Quick Preview','cerchez-core'), 'cerchez_post_preview_metabox_callback', $custom_post_type, 'normal', 'high' );

	}



	$screens = array('post', 'page');

	foreach ( $screens as $screen ) {

		add_meta_box('cerchez-quick-preview', __('Quick Preview','cerchez-core'), 'cerchez_post_preview_metabox_callback', $screen, 'normal', 'high' ); 

	}

}



function cerchez_post_preview_metabox_callback() {

	echo '';

}



add_action('init', 'cerchez_post_preview_init');

function cerchez_post_preview_init() {

	$preview_page =  CERCHEZ_PLUGIN_URI . 'utils/post-preview/post-preview-output.php';



	if (is_admin()) {

		global $pagenow;

		if ( (get_user_option('rich_editing') == 'true') && ('post.php' == $pagenow || 'post-new.php' == $pagenow) ) {

			wp_enqueue_style('cerchez-core-post-preview', CERCHEZ_PLUGIN_URI . 'utils/post-preview/post-preview.css');

			wp_enqueue_script("cerchez-core-post-preview", CERCHEZ_PLUGIN_URI . 'utils/post-preview/post-preview.js', array('jquery'));



			wp_localize_script('cerchez-core-post-preview', 'cerchez_post_preview', array(

				'previewNormal' => '<span>' . __('Quick ', 'cerchez-core') . '</span>' . __('Preview', 'cerchez-core'),

				'hiddenElements' => apply_filters('cerchez_post_preview_hidden_elements', ''),

			));

		}

	}

}



add_action('wp_ajax_cerchez_content_preview', 'cerchez_content_preview');

function cerchez_content_preview() {

	$post_ID = (int) $_POST['post_ID'];

	$q_args = array();

	$q_args['preview_id'] = $post_ID;

	$q_args['preview'] = 'true';

	$q_args['preview_nonce'] = wp_create_nonce('post_preview_' . $post_ID);

	$url = add_query_arg($q_args, get_permalink( $post_ID ));

	echo $url;

	die();

}