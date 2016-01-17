<?php



add_action('init', 'cerchez_register_project_custom_post', 5);



function cerchez_register_project_custom_post() {

	$labels = array(

		'name' => apply_filters('cerchez_custom_type_project_name', __('Projects','cerchez-core')),

		'singular_name' => apply_filters('cerchez_custom_type_project_singular_name', __('Project','cerchez-core')),

		'add_new_item' => apply_filters('cerchez_custom_type_project_add_new_item', __('Add New Project','cerchez-core')),

		'edit_item' => apply_filters('cerchez_custom_type_project_edit_item', __('Edit Project','cerchez-core')),

	);

	register_post_type('cerchez-project',

		array(

			'labels' => $labels,

			'supports' => array('title', 'excerpt', 'editor', 'page-attributes', 'thumbnail', 'category', 'revisions', 'comments'),

			'taxonomies' => array('category', 'post_tag'),

			'rewrite' => array('slug' => apply_filters('cerchez_custom_type_project_slug', __('project','cerchez-core'))),

			'public' => true,

			'query_var' => true,

			'menu_position' => 20,

			'menu_icon'=> 'dashicons-portfolio',

		)

	);

}



add_action( 'pre_get_posts', 'cerchez_add_post_type_to_query' );



function cerchez_add_post_type_to_query( $query ) {

	if ( ! is_admin() && ! is_preview() && $query->is_main_query() && (is_search() || is_category() || is_tag()) ) {

		if ( empty($query->query_vars['post_type']) ) {

			$query->query_vars['post_type'] = array('post','cerchez-project');

		} elseif ( 'any' == $query->query_vars['post_type'] ) {

			return;

		} else {

			$query->query_vars['post_type'] = (array) $query->query_vars['post_type'];

			$query->query_vars['post_type'][] = 'cerchez-project';

		}

	}

}