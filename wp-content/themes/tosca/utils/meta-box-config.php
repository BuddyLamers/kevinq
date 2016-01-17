<?php



/* Register meta boxes */



global $tosca_meta_boxes;

$tosca_meta_boxes = array();



$tosca_meta_boxes[] = array(

	'id' => 'page_slider_options',

	'title' => esc_html__('Featured Slideshow Images', 'tosca'),

	'pages' => array('page', 'post', 'cerchez-project', 'product'),

	'fields' => array(

		array(

			'name' => '',

			'desc' => esc_html__('Slideshow that will replace the featured image of the header (edit each image caption and description fields for additional information).', 'tosca'),

			'id'   => 'header_slideshow',

			'type' => 'image_advanced',

		),

		array(

			'name' => esc_html__('Autoplay Slideshow', 'tosca'),

			'desc' => esc_html__('Determines if the slidershow autoslides.', 'tosca'),

			'id'   => 'header_slideshow_autoplay',

			'type' => 'checkbox',

			'std' => false,

		),

		array(

			'name' => esc_html__('Autoplay Timer', 'tosca'),

			'desc' => esc_html__('Determines the time (in miliseconds) between autoslides (default: 5000).', 'tosca'),

			'id'   => 'header_slideshow_autoplay_timer',

			'type' => 'text',

			'placeholder' => '5000',

			'size' => 10,

		),

		array(

			'name' => esc_html__('Transition Timer', 'tosca'),

			'desc' => esc_html__('Determines the speed (in miliseconds) of the slide animation (default: 750).', 'tosca'),

			'id'   => 'header_slideshow_transition',

			'type' => 'text',

			'placeholder' => '750',

			'size' => 10,

		),

	)

);



$tosca_meta_boxes[] = array(

	'id' => 'page_video_background',

	'title' => esc_html__('Featured Video', 'tosca'),

	'pages' => array('page', 'post', 'cerchez-project', 'product'),

	'fields' => array(

		array(

			'name' => '',

			'desc' => esc_html__('Link/embed from YouTube or Vimeo that will replace the featured image from the header. Here is an example: ', 'tosca') . '<a href="https://gist.github.com/liviucerchez/100472bbc708c21496b1" target="_blank">gist.github.com snippet</a>',

			'id' => 'header_video',

			'type' => 'textarea',

			'rows' => 6,

			'std' => '',

		),

		array(

			'name' => esc_html__('Don\'t mute audio', 'tosca'),

			'id'   => 'header_video_dont_mute',

			'type' => 'checkbox',

			'std' => false,

		),

	)

);



$tosca_meta_boxes[] = array(

	'id' => 'featured_image_options',

	'title' => esc_html__('Featured Image Options', 'tosca'),

	'pages' => array('page', 'post', 'cerchez-project', 'product'),

	'context' => 'side',

	'priority' => 'low',

	'fields' => array(

		array(

			'name' => 'Featured Image Position',

			'desc' => '',

			'id' => 'featured_image_pos',

			'type' => 'select',

			'options' => array(

				''              => esc_html__('default', 'tosca'),

				'left top'      => esc_html__('left top', 'tosca'),

				'left center'   => esc_html__('left center', 'tosca'),

				'left bottom'   => esc_html__('left bottom', 'tosca'),

				'right top'     => esc_html__('right top', 'tosca'),

				'right center'  => esc_html__('right center', 'tosca'),

				'right bottom'  => esc_html__('right bottom', 'tosca'),

				'center top'    => esc_html__('center top', 'tosca'),

				'center center' => esc_html__('center center', 'tosca'),

				'center bottom' => esc_html__('center bottom', 'tosca'),

			),

			'class' => 'widefat',

			'std' => '',

		),

		array(

			'name' => 'Featured Image Overlay Color',

			'desc' => '',

			'id' => 'featured_image_overlay_color',

			'type' => 'color',

			'std' => '',

		),

		array(

			'name' => 'Featured Image Overlay Opacity',

			'desc' => esc_html__('Percentage number between 0 and 100 (leave empty for default).', 'tosca'),

			'id' => 'featured_image_overlay_opacity',

			'type' => 'number',

			'min' => 0,

			'max' => 100,

			'class' => 'widefat'

		),

		array(

			'name' => 'Heading Size',

			'desc' => esc_html__('Overrides the default Heading Size setting from Theme Options.', 'tosca'),

			'id' => 'heading_size',

			'type' => 'select',

			'options' => array(

				''       => esc_html__('Default', 'tosca'),

				'small'  => esc_html__('Small', 'tosca'),

				'medium' => esc_html__('Medium', 'tosca'),

				'full'   => esc_html__('Full Height', 'tosca'),

				'auto'   => esc_html__('Auto', 'tosca'),

				'hide'   => esc_html__('Force Hidden', 'tosca'),

			),

			'class' => 'widefat',

			'std' => '',

		),

	)

);



$tosca_meta_boxes[] = array(

	'id' => 'page_custom_background',

	'title' => esc_html__('Custom Featured Code', 'tosca'),

	'pages' => array('page', 'post', 'cerchez-project', 'product'),

	'context' => 'normal',

	'fields' => array(

		array(

			'name' => '',

			'desc' => esc_html__('This custom code will be added directly to the page instead of the featured image, slideshow or video. You are responsible of styling and positioning it to fit the theme\'s appearance.', 'tosca'),

			'id' => 'header_custom_code',

			'type' => 'wysiwyg',

			'options' => array(

				'textarea_rows' => 10

			),

		),

	)

);



$tosca_meta_boxes[] = array(

	'id' => 'page_heading_text',

	'title' => esc_html__('Featured Heading Caption', 'tosca'),

	'pages' => array('page', 'post', 'cerchez-project', 'product'),

	'context' => 'normal',

	'fields' => array(

		array(

			'name' => '',

			'desc' => esc_html__('Set the caption to be displayed in the heading featured area above any image, slideshow or video (overrides any existent image description displayed).', 'tosca'),

			'id' => 'header_caption',

			'type' => 'textarea',

			'rows' => 3,

		),

		array(

			'name' => esc_html__('Caption Position', 'tosca'),

			'desc' => esc_html__('Determines if the style of the caption (overrides Theme Options setting).', 'tosca'),

			'id' => 'header_caption_pos',

			'type' => 'select',

			'options' => array(

				''                => esc_html__('Default', 'tosca'),

				'centered'        => esc_html__('Simple - Middle Centered', 'tosca'),

				'bottom-left'     => esc_html__('Simple - Bottom Left', 'tosca'),

				'bottom-centered' => esc_html__('Simple - Bottom Centered', 'tosca'),

				'bottom-right'    => esc_html__('Simple - Bottom Right', 'tosca'),

				'special'         => esc_html__('Special - Centered', 'tosca'),

			),

			'std' => '',

		),

	)

);



$fields = array();



if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php') || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php') ) {

	if ( ! empty( $_GET['post'] ) || ! empty( $_POST['post_ID'] ) ) {

		// check for a template type

		$post_id = ( ! empty( $_GET['post'] ) ) ? $_GET['post'] : $_POST['post_ID'] ;

		$template_file = get_post_meta( $post_id, '_wp_page_template', TRUE );



		if ( strpos($template_file, 'template-blog') !== false) {

			$categories = array(0 => esc_html__('All categories', 'tosca'));

			$of_categories_obj = get_categories('hide_empty=0');

			foreach( $of_categories_obj as $of_cat ) {

				$categories[ $of_cat->cat_ID ] = $of_cat->cat_name;

			}

			$fields[] = array(

				'name' => esc_html__('Blog Category', 'tosca'),

				'desc' => esc_html__('This will filter the displayed posts based on a specific category (sub-category posts will be displayed as well).', 'tosca'),

				'id' => 'base_category',

				'type' => 'select',

				'options' => $categories

			);

			if ($template_file == 'template-blog-modern.php') {

				$fields[] = array(

					'name' => esc_html__('Image Size', 'tosca'),

				'desc' => esc_html__('Sets the featured image size of the post item.', 'tosca'),

					'id' => 'post_image_size',

					'type' => 'select',

					'options' => array(

						'half' => esc_html__('Half width', 'tosca'),

						'full' => esc_html__('Full width', 'tosca'),

					),

				);

			}

		}

		if ( strpos($template_file, 'template-blog') !== false || $template_file == 'template-sidebar.php' || (class_exists('WooCommerce') && get_option('woocommerce_shop_page_id') == $post_id) ) {

			$positions = array(

				'left' => esc_html__('Left', 'tosca'),

				'right' => esc_html__('Right', 'tosca'),

			);

			if (strpos($template_file, 'template-blog') !== false || (class_exists('WooCommerce') && get_option('woocommerce_shop_page_id') == $post_id) ) {

				$positions['none'] = esc_html__('None', 'tosca' );

			}

			$tosca_meta_boxes[] = array(

				'id' => 'page_sidebar_options',

				'title' => esc_html__('Sidebar Position', 'tosca'),

				'pages' => array('page'),

				'context' => 'side',

				'priority' => 'low',

				'fields' => array(

					array(

						'name' => '',

						'desc' => '',

						'id' => 'sidebar_position',

						'type' => 'select',

						'options' => $positions,

						'class' => 'widefat',

						'std' => 'right',

					)

				)

			);

		}

	}

}



if ( ! isset($template_file) || (isset($template_file) && $template_file != 'template-modular.php' && $template_file != 'template-under-construction.php')) {

	$fields[] = array(

		'name' => esc_html__('Hide Post Title', 'tosca'),

		'desc' => esc_html__('Determine if the title of the post is hidden (it is displayed if left unchecked).', 'tosca'),

		'id' => 'hide_post_title',

		'std' => false,

		'type' => 'checkbox',

	);

}



if (count($fields) > 0) {

	$tosca_meta_boxes[] = array(

		'id' => 'page_extra_options',

		'title' => esc_html__('Additional Properties', 'tosca'),

		'pages' => array('page', 'post', 'cerchez-project'),

		'fields' => $fields,

	);

}



$lightbox_icons = array(

	0                => 'default',

	'link'           => 'link',

	'resize-enlarge' => 'resize-enlarge',

	'play'           => 'play',

	'arrow-right'    => 'arrow-right',

);



$lightbox_popup = array(

	0 => esc_html__('Default', 'tosca'),

	1 => esc_html__('Open in lightbox', 'tosca'),

	2 => esc_html__('Open as link', 'tosca'),

	3 => esc_html__('Open as external link', 'tosca'),

);



$tosca_meta_boxes[] = array(

	'id' => 'project_options',

	'title' => esc_html__('Project Options', 'tosca'),

	'pages' => array('cerchez-project'),

	'context' => 'normal',

	'fields' => array(

		array(

			'name' => esc_html__('Override lightbox link', 'tosca'),

			'desc' => esc_html__('Use an external link for the lightbox generated by the [projects] shortcode. This can be a YouTube video or an URL to any external website.', 'tosca'),

			'id' => 'project_lightbox_link',

			'type' => 'text',

			'std' => '',

			'class' => 'widefat',

		),

		array(

			'name' => esc_html__('Override lightbox icon', 'tosca'),

			'desc' => esc_html__('Override the icon of the lightbox element generated by the [projects] shortcode.', 'tosca'),

			'id' => 'project_lightbox_icon',

			'type' => 'select',

			'options' => $lightbox_icons,

		),

		array(

			'name' => esc_html__('Override lightbox popup', 'tosca'),

			'desc' => esc_html__('Override the behaviour of the lightbox element generated by the [projects] shortcode.', 'tosca'),

			'id' => 'project_lightbox_popup',

			'type' => 'select',

			'options' => $lightbox_popup,

		),

	)

);



/* register meta properties */

function tosca_register_meta_boxes() {

	if ( ! class_exists('RW_Meta_Box') ) return;

	global $tosca_meta_boxes;

	foreach ( $tosca_meta_boxes as $meta_box ) {

		new RW_Meta_Box( $meta_box );

	}

}

add_action('admin_init', 'tosca_register_meta_boxes');



/* some theme page templates don't require the default editor */

function tosca_edit_form_after_title($post) {

	if (isset($post) && is_object($post) && isset($post->ID)) {

		$template_file = get_post_meta($post->ID, '_wp_page_template', TRUE);

		if (isset($template_file) && in_array($template_file, array('template-blog.php', 'template-blog-modern.php', 'template-under-construction.php', 'template-modular.php'))) {

			global $_wp_post_type_features;

			unset($_wp_post_type_features[$post->post_type]['editor']);

		}

	}

}

add_action('edit_form_after_title', 'tosca_edit_form_after_title');