<?php



require_once( 'functions' . DIRECTORY_SEPARATOR . 'tinymce-button.php' );

require_once( 'functions' . DIRECTORY_SEPARATOR . 'interface-options.php' );

require_once( 'functions' . DIRECTORY_SEPARATOR . 'interface-shortcodes-generator.php' );



function cerchez_core_admin_enqueue_scripts($hook){

	if( 'post.php' != $hook && 'post-new.php' != $hook ) return;



	wp_enqueue_style('cerchez-core-shortcodes-style', CERCHEZ_PLUGIN_URI . 'utils/shortcodes/css/cerchez-core-popup-style.css');

	wp_enqueue_style('wp-color-picker');

	wp_enqueue_script('wp-color-picker');

	wp_enqueue_script('jquery-ui-sortable');

	wp_enqueue_script('media-upload');

}

add_action('admin_enqueue_scripts', 'cerchez_core_admin_enqueue_scripts');



function cerchez_core_popup_callback() {

	$output = '';

	$output .= '<div class="media-frame-title">';

	$output .= '<h1>' . sprintf( __('Insert %s Shortcode', 'cerchez-core'), $_POST['title']) . '</h1>';

	$output .= '</div>';

	$output .= '<div class="media-frame-content"><div class="media-frame-content-inner">';

	$output .= cerchez_core_shortcodes_options($_POST['id']);

	$output .= '</div></div>';

	$output .= '<div class="media-frame-toolbar"><div class="media-toolbar">';

	$output .= '<div class="media-toolbar-primary">';

	$output .= '<a href="#" class="cerchez-core-popup-submit-button button media-button button-primary button-large media-button-insert" data-shortcode-id="' . $_POST['id'] . '">' . __('Insert Shortcode', 'cerchez-core') . '</a>';

	$output .= '</div>';

	$output .= '<div class="media-toolbar-secondary">';

	$output .= '<a href="#" class="cerchez-core-popup-cancel-button button media-button button-large media-button-cancel">' . __('Cancel', 'cerchez-core') . '</a>';

	$output .= '</div>';

	$output .= '</div></div>';

	$output .= cerchez_core_shortcodes_js_generator($_POST['id']);

	echo $output;

	exit();

}

add_action('wp_ajax_cerchez_core_popup', 'cerchez_core_popup_callback');



function cerchez_core_shortcodes_options($id) {

	global $cerchez_core_shortcodes_options;

	$out = '';

	if (@$cerchez_core_shortcodes_options[$id]) {

		foreach($cerchez_core_shortcodes_options[$id]['options'] as $id => $opt) {

			$opt['id'] = $id;

			if (isset($opt['class'])) {

				$extra_class = ' ' . $opt['class'];

			} else {

				$extra_class = '';

			}

			$out .= '<div class="option-line option-line-' . $opt['type'] . $extra_class . '">' . cerchez_core_shortcodes_options_field($opt) . '</div>';

		}

	}

	return $out;

}



function cerchez_core_shortcodes_options_field($opt, $inside_duplicated=false) {

	$line = '';

	if ($opt['type'] == 'info') {

		$line .= $opt['desc'];

	} else {

		if (isset($opt['title'])) {

			$line .= '<label for="' . $opt['id'] . '" class="option-title">' . $opt['title'] . ':</label>';

		}

		$line .= '<div class="option-content">';



		if (!isset($opt['default'])) $opt['default'] = '';



		switch ($opt['type']) {



			case 'select':

				$line.='<select name="' . $opt['id'] . '" id="' . $opt['id'] . '" class="widefat">';

				foreach ($opt['options'] as $k => $v) {

					$line .= '<option value="' . $k . '"' . ($k == $opt['default'] ? ' selected="selected"' : '') . '>' . $v . '</option>';

				}

				$line .= '</select>';

			break;



			case 'checkbox':

				$line .= '<input type="checkbox" name="' . $opt['id'] . '" id="' . $opt['id'] . '" value="true" ' . ('true' == $opt['default'] ? ' checked="checked"' : '').' />';

			break;



			case 'text':

				$line .= '<input type="text" class="widefat" name="' . $opt['id'] . '" id="' . $opt['id'] . '" value="' . esc_attr($opt['default']) . '" />';

			break;



			case 'textarea':

				$r = 8;

				if (isset($opt['rows']) && $opt['rows']) $r = $opt['rows'];

				$line .= '<textarea class="widefat" rows="' . $r . '" name="' . $opt['id'] . '" id="' . $opt['id'] . '" >' . esc_html($opt['default']) . '</textarea>';

				break;



			case 'color':

				$line .= '<input class="wp-color-picker-field" name="'. $opt['id'] . '" id="' . $opt['id'] . '" type="text" value="' . $opt['default'] . '"  data-default-color="' . $opt['default'] . '" />';

				break;



			case 'image':

				$line .= '<input type="text" class="widefat upload-file" name="' . $opt['id'] . '" id="' . $opt['id'] . '" value="' . esc_attr($opt['default']) . '" /><input type="hidden" class="width" /><input type="hidden" class="height" /><div class="uploads_actions"><span class="button upload-image">' . __('Upload', 'cerchez-core') . '</span><span class="button remove-image hide">' . __('Remove', 'cerchez-core') . '</span></div><div class="screenshot"></div>';

				if (isset($opt['show_alt']) && ($opt['show_alt'] == true) ) {

					$line .= '<label for="' . $opt['id'] . '_alt_text" class="option-title">' . __('Image Alt Attribute', 'cerchez-core') . ':</label>';

					$line .= '<input type="text" class="widefat alt-text" name="' . $opt['id'] . '_alt_text" id="' . $opt['id'] . '_alt_text" />';

				}

				break;



			case 'file':

				$line .= '<input type="text" class="widefat upload-file" name="' . $opt['id'] . '" id="' . $opt['id'] . '" value="' . esc_attr($opt['default']) . '" /><div class="uploads_actions"><span class="button upload-image">' . __('Upload', 'cerchez-core') . '</span><span class="button remove-image hide">' . __('Remove', 'cerchez-core') . '</span></div>';

				break;



			case 'category':

				$args = array(

					'show_option_all' => __('All Categories', 'cerchez-core'),

					'orderby'         => 'NAME',

					'show_count'      => true,

					'hide_empty'      => false,

					'echo'            => false,

					'hierarchical'    => true,

					'selected'        => $opt['default'],

					'name'            => $opt['id'],

					'id'              => $opt['id'],

					'class'           => 'widefat',

					'taxonomy'        => 'category',

				);

				$line .= wp_dropdown_categories( $args );

				break;



			case 'tag':

				$args = array(

					'show_option_all' => __('All Tags', 'cerchez-core'),

					'orderby'         => 'NAME',

					'show_count'      => true,

					'hide_empty'      => false,

					'echo'            => false,

					'selected'        => $opt['default'],

					'name'            => $opt['id'],

					'id'              => $opt['id'],

					'class'           => 'widefat',

					'taxonomy'        => 'post_tag',

				);

				$line .= wp_dropdown_categories( $args );

				break;



			case 'aspect-ratio':

				if (!isset($opt['default_width'])) $opt['default_width'] = '';

				if (!isset($opt['default_height'])) $opt['default_height'] = '';

				$line .= '<input type="text" name="' . $opt['id'] . '_width" id="' . $opt['id'] . '_width" value="' . esc_attr($opt['default_width']) . '" /> : ';

				$line .= '<input type="text" name="' . $opt['id'] . '_height" id="' . $opt['id'] . '_height" value="' . esc_attr($opt['default_height']) . '" />';

			break;



			case 'duplicate':

				if (isset($opt['fields_title'])) {

					$template_title = $opt['fields_title'];

				} else {

					$template_title = __('Item','cerchez-core');

				}

				$template_item = '<div class="ui-state-default template-item"><h3><span class="dashicons dashicons-menu"></span> ' . $template_title . ' </h3><a class="cerchez-core-remove-template" href="#" data-confirm="' . __('Are you sure you want to remove this item?','cerchez-core') . '"><span class="dashicons dashicons-no-alt"></span></a><div class="inner">';

				foreach($opt['fields'] as $new_id => $new_opt) {

					$new_opt['id'] = $new_id . '[0]';

					$template_item .= '<div class="option-line option-line-' . $new_opt['type'] . '">' . cerchez_core_shortcodes_options_field($new_opt, true) . '</div>';

				}

				$template_item .= '</div></div>';

				$item1 = str_replace(array('template-item','[0]'),array('item', '[1]'), $template_item);

				$line .= $template_item . $item1;

				$line .= '<div class="duplicate-add-new"><a href="#" class="cerchez-core-duplicate-template button button-primary button-large">' . __('Add New ','cerchez-core') . $template_title . '</a></div>';

				break;

		}

		if (isset($opt['desc']) && $opt['desc']) {

			$line .= '<div class="option-field-description">' . $opt['desc'] . '</div>';

		}

		$line .= '</div>';

	}

	return apply_filters('cerchez_core_shortcodes_option-' . $opt['id'], $line, $opt);

}