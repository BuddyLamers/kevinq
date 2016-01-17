<?php



$module_builder_options = array(

	'text' => array(

		'title'   => esc_html__('Text', 'tosca'),

		'desc'    => esc_html__('Output a text based module.', 'tosca'),

		'icon'    => 'dashicons-admin-page',

		'options' => array(

			'title' => array(

				'type'  => 'text',

				'title' => esc_html__('Title', 'tosca'),

			),

			'module_content_editor' => array(

				'type'  => 'editor',

				'title' => esc_html__('Content', 'tosca'),

			),

			'bgcolor' => array(

				'type'    => 'color',

				'title'   => esc_html__('Background color', 'tosca'),

				'default' => '',

			),

			'bgimage' => array(

				'type'     => 'image',

				'title'    => esc_html__('Background image', 'tosca'),

				'show_alt' => false,

			),

			'bgrepeat' => array(

				'type'    => 'select',

				'title'   => esc_html__('Background repeat', 'tosca'),

				'options' => array(

					'cover'  => esc_html__('Cover', 'tosca'),

					'repeat' => esc_html__('Repeat', 'tosca'),

				),

			),

			'textcolor' => array(

				'type'  => 'color',

				'title' => esc_html__('Text color', 'tosca'),

			),

			'textalign' => array(

				'type'    => 'select',

				'title'   => esc_html__('Horizontal text alignment', 'tosca'),

				'options' => array(

					'left'   => esc_html__('Left', 'tosca'),

					'center' => esc_html__('Center', 'tosca'),

					'right'  => esc_html__('Right', 'tosca'),

				),

				'default' => 'center',

			),

			'textalignvertical' => array(

				'type'    => 'select',

				'title'   => esc_html__('Vertical text alignment', 'tosca'),

				'desc'    => esc_html__('Available only in a multi-column row (on desktops).', 'tosca'),

				'options' => array(

					'top'    => esc_html__('Top', 'tosca'),

					'middle' => esc_html__('Middle', 'tosca'),

					'bottom' => esc_html__('Bottom', 'tosca'),

				),

				'default' => 'middle',

			),

			'height' => array(

				'type'    => 'select',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height is expressed in proportion to the width of the module.', 'tosca'),

				'options' => array(

					'1' => '25%',

					'2' => '50%',

					'3' => '75%',

					'4' => '100%',

					'5' => '125%',

					'6' => '150%',

					'0' => esc_html__('Auto', 'tosca'),

				),

				'default' => '2',

			),

		),

	),

	'image' => array(

		'title'   => esc_html__('Image', 'tosca'),

		'desc'    => esc_html__('Output an image based module.', 'tosca'),

		'icon'    => 'dashicons-format-image',

		'options' => array(

			'bgimage' => array(

				'type'     => 'image',

				'title'    => esc_html__('Image', 'tosca'),

				'show_alt' => false,

			),

			'caption' => array(

				'type'  => 'text',

				'title' => esc_html__('Caption', 'tosca'),

			),

			'captionbgcolor' => array(

				'type'    => 'color',

				'title'   => esc_html__('Caption background color', 'tosca'),

				'default' => '',

			),

			'captioncolor' => array(

				'type'    => 'color',

				'title'   => esc_html__('Caption text color', 'tosca'),

				'default' => '',

			),

			'captionpos' => array(

				'type'    => 'select',

				'title'   => esc_html__('Caption position', 'tosca'),

				'options' => array(

					'1' => esc_html__('Top left', 'tosca'),

					'2' => esc_html__('Top center', 'tosca'),

					'3' => esc_html__('Top right', 'tosca'),

					'4' => esc_html__('Middle left', 'tosca'),

					'5' => esc_html__('Middle center', 'tosca'),

					'6' => esc_html__('Middle right', 'tosca'),

					'7' => esc_html__('Bottom left', 'tosca'),

					'8' => esc_html__('Bottom center', 'tosca'),

					'9' => esc_html__('Bottom right', 'tosca'),

				),

				'default' => '9',

			),

			'url' => array(

				'type'  => 'url',

				'title' => esc_html__('URL', 'tosca'),

			),

			'url_target' => array(

				'type'    => 'select',

				'title'   => esc_html__('URL Target', 'tosca'),

				'options' => array(

					''      => esc_html__('Open in same tab/window', 'tosca'),

					'blank' => esc_html__('Open in new tab/window', 'tosca'),

				),

			),

			'height' => array(

				'type'    => 'select',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height is expressed in proportion to the width of the module.', 'tosca'),

				'options' => array(

					'1' => '25%',

					'2' => '50%',

					'3' => '75%',

					'4' => '100%',

					'5' => '125%',

					'6' => '150%',

					'0' => esc_html__('Auto', 'tosca'),

				),

				'default' => '2',

			),

		),

	),

	'slider' => array(

		'title'   => esc_html__('Slider', 'tosca'),

		'desc'    => esc_html__('Output a slider based module.', 'tosca'),

		'icon'    => 'dashicons-format-gallery',

		'options' => array(

			'autoplay' => array(

				'type'    => 'checkbox',

				'title'   => esc_html__('Autoslide', 'tosca'),

				'desc'    => esc_html__('Determines if the slider autoslides.', 'tosca'),

			),

			'autoslide_timer' => array(

				'type'    => 'text',

				'title'   => esc_html__('Autoslide Timer', 'tosca'),

				'desc'    => esc_html__('Time (in miliseconds) between autoslides.', 'tosca'),

				'default' => '5000',

			),

			'autoslide_timer_trans' => array(

				'type'    => 'text',

				'title'   => esc_html__('Autoslide Timer Transition', 'tosca'),

				'desc'    => esc_html__('Determine the speed (in miliseconds) of the slide animation.', 'tosca'),

				'default' => '750',

			),

			'controls' => array(

				'type'  => 'checkbox',

				'title' => esc_html__('Controls', 'tosca'),

				'desc'  => esc_html__('Determines if the slider controls are visible.', 'tosca'),

			),

			'pagination' => array(

				'type'  => 'checkbox',

				'title' => esc_html__('Pagination', 'tosca'),

				'desc'  => esc_html__('Determines if the slider pagination is visible.', 'tosca'),

			),

			'items' => array(

				'type'           => 'duplicate',

				'fields_title'   => esc_html__('Slide', 'tosca'),

				'fields_base_id' => 'item_',

				'fields'         => array(

					'item_image' => array(

						'type'     => 'image',

						'title'    => esc_html__('Image', 'tosca'),

						'show_alt' => true,

					),

					'item_caption' => array(

						'type'  => 'text',

						'title' => esc_html__('Caption', 'tosca'),

					),

					'item_caption_url' => array(

						'type'  => 'text',

						'title' => esc_html__('Caption URL', 'tosca'),

					),

					'item_caption_url_target' => array(

						'type'    => 'select',

						'title'   => esc_html__('Caption URL Target', 'tosca'),

						'options' => array(

							''      => esc_html__('Open in same tab/window', 'tosca'),

							'blank' => esc_html__('Open in new tab/window', 'tosca'),

						),

					),

				),

			),

			'height' => array(

				'type'    => 'select',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height is expressed in proportion to the width of the module.', 'tosca'),

				'options' => array(

					'1' => '25%',

					'2' => '50%',

					'3' => '75%',

					'4' => '100%',

					'5' => '125%',

					'6' => '150%',

				),

				'default' => '2',

			),

		),

	),

	'video' => array(

		'title'   => esc_html__('Video', 'tosca'),

		'desc'    => esc_html__('Output a video based module.', 'tosca'),

		'icon'    => 'dashicons-video-alt2',

		'options' => array(

			'embed' => array(

				'type'  => 'textarea',

				'title' => esc_html__('Link/embed code', 'tosca'),

				'desc'  => esc_html__('Link/embed from YouTube or Vimeo, example: ', 'tosca') . '<a href="https://gist.github.com/liviucerchez/100472bbc708c21496b1" target="_blank">gist.github.com snippet</a>',

				'rows'  => 4,

			),

			'autoplay' => array(

				'type'    => 'checkbox',

				'title'   => esc_html__('Autoplay', 'tosca'),

				'desc'    => esc_html__('Applies only for YouTube or Vimeo videos.', 'tosca'),

				'default' => true,

			),

			'loop' => array(

				'type'    => 'checkbox',

				'title'   => esc_html__('Loop', 'tosca'),

				'desc'    => esc_html__('Applies only for YouTube or Vimeo videos.', 'tosca'),

				'default' => true,

			),

			'mute' => array(

				'type'    => 'checkbox',

				'title'   => esc_html__('Mute audio', 'tosca'),

				'desc'    => esc_html__('Applies only for YouTube or Vimeo videos.', 'tosca'),

				'default' => true,

			),

			'bgcolor' => array(

				'type'    => 'readonly',

				'default' => '#000',

			),

			'height' => array(

				'type'    => 'select',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height is expressed in proportion to the width of the module.', 'tosca'),

				'options' => array(

					'1'    => '25%',

					'2'    => '50%',

					'3'    => '75%',

					'4'    => '100%',

					'5'    => '125%',

					'6'    => '150%',

					'16-9' => '16:9',

				),

				'default' => '2',

			),

		),

	),

	'audio' => array(

		'title'   => esc_html__('Audio', 'tosca'),

		'desc'    => esc_html__('Output an audio based module.', 'tosca'),

		'icon'    => 'dashicons-format-audio',

		'options' => array(

			'mp3' => array(

				'type'  => 'file',

				'title' => esc_html__('MP3', 'tosca'),

			),

			'ogg' => array(

				'type'  => 'file',

				'title' => esc_html__('OGG', 'tosca'),

			),

			'wav' => array(

				'type'  => 'file',

				'title' => esc_html__('WAV', 'tosca'),

			),

			'loop' => array(

				'type'  => 'checkbox',

				'title' => esc_html__('Loop', 'tosca'),

				'desc'  => esc_html__('Determine if the audio player will loop the file.', 'tosca'),

			),

			'autoplay' => array(

				'type'  => 'checkbox',

				'title' => esc_html__('Autoplay', 'tosca'),

				'desc'  => esc_html__('Determine if the audio player will autoplay the file &mdash; iOS devices will require mandatory user interaction to play a file.', 'tosca'),

			),

			'preload' => array(

				'type'    => 'checkbox',

				'title'   => esc_html__('Preload', 'tosca'),

				'desc'    => esc_html__('Determine if the audio player preloads the file when the page loads.', 'tosca'),

				'default' => true,

			),

			'bgcolor' => array(

				'type'    => 'color',

				'title'   => esc_html__('Background color', 'tosca'),

				'default' => '',

			),

			'bgimage' => array(

				'type'     => 'image',

				'title'    => esc_html__('Background image', 'tosca'),

				'show_alt' => true,

			),

			'bgrepeat' => array(

				'type'    => 'select',

				'title'   => esc_html__('Background repeat', 'tosca'),

				'options' => array(

					'cover'  => esc_html__('Cover', 'tosca'),

					'repeat' => esc_html__('Repeat', 'tosca'),

				),

			),

			'textcolor' => array(

				'type'    => 'color',

				'title'   => esc_html__('Controls color', 'tosca'),

			),

			'height' => array(

				'type'    => 'select',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height is expressed in proportion to the width of the module.', 'tosca'),

				'options' => array(

					'1' => '25%',

					'2' => '50%',

					'3' => '75%',

					'4' => '100%',

					'5' => '125%',

					'6' => '150%',

				),

				'default' => '2',

			),

		),

	),

	'map' => array(

		'title'   => esc_html__('Map', 'tosca'),

		'desc'    => esc_html__('Output a map based module.', 'tosca'),

		'icon'    => 'dashicons-location-alt',

		'options' => array(

			'type' => array(

				'type'    => 'select',

				'title'   => esc_html__('Type', 'tosca'),

				'desc'    => esc_html__('Determine the type used for interpreting the content box.', 'tosca'),

				'options' => array(

					'address'    => esc_html__('Address', 'tosca'),

					'embed_code' => esc_html__('Embed code', 'tosca'),

				),

				'default' => 'embed_code',

			),

			'content' => array(

				'type'  => 'textarea',

				'title' => esc_html__('Content', 'tosca'),

				'rows'  => 4,

			),

			'height' => array(

				'type'    => 'select',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height is expressed in proportion to the width of the module.', 'tosca'),

				'options' => array(

					'1' => '25%',

					'2' => '50%',

					'3' => '75%',

					'4' => '100%',

					'5' => '125%',

					'6' => '150%',

				),

				'default' => '2',

			),

		),

	),

	'projects' => array(

		'title'   => esc_html__('Projects', 'tosca'),

		'desc'    => esc_html__('Output a project showcase based module.', 'tosca'),

		'icon'    => 'dashicons-portfolio',

		'options' => array(

			'category' => array(

				'type'  => 'category',

				'title' => esc_html__('Category', 'tosca'),

				'desc'  => esc_html__('Restrict portfolio items belonging to a specific category.', 'tosca'),

			),

			'tag' => array(

				'type'  => 'tag',

				'title' => esc_html__('Tag', 'tosca'),

				'desc'  => esc_html__('Restrict portfolio items having a specific tag.', 'tosca'),

			),

			'limit' => array(

				'type'    => 'select',

				'title'   => esc_html__('Limit', 'tosca'),

				'desc'    => esc_html__('Number of portfolio items to show in total. Note that some numbers are hidden because they can\'t form a perfect row in the grid system.', 'tosca'),

				'options' => array(

					''   => esc_html__('All posts', 'tosca'),

					'1'  => '1',

					'2'  => '2',

					'3'  => '3',

					'4'  => '4',

					'6'  => '6',

					'8'  => '8',

					'9'  => '9',

					'10' => '10',

					'12' => '12',

					'14' => '14',

					'16' => '16',

					'18' => '18',

					'20' => '20',

					'21' => '21',

					'22' => '22',

					'24' => '24',

					'26' => '26',

					'27' => '27',

					'28' => '28',

					'30' => '30',

				),

			),

			'subtitles' => array(

				'type'    => 'select',

				'title'   => esc_html__('Subtitles', 'tosca'),

				'desc'    => esc_html__('Determine if subtitles are retrieved for each item; it can display the categories or the tags each posts belongs to.', 'tosca'),

				'options' => array(

					''           => esc_html__('Hide subtitles', 'tosca'),

					'categories' => esc_html__('Display categories', 'tosca'),

					'tags'       => esc_html__('Display tags', 'tosca'),

				),

			),

			'image_width' => array(

				'type' => 'text',

				'title' => esc_html__('Image width', 'tosca'),

				'desc' => esc_html__('Image width for the featured image of the portfolio item.', 'tosca'),

				'default' => '450',

			),

			'image_height' => array(

				'type' => 'text',

				'title' => esc_html__('Image height', 'tosca'),

				'desc' => esc_html__('Image height for the featured image of the portfolio item.', 'tosca'),

				'default' => '300',

			),

			'image_effect' => array(

				'type'    => 'select',

				'title'   => esc_html__('Image effect', 'tosca'),

				'desc'    => esc_html__('Determine the type of thumb animation when item is hovered.', 'tosca'),

				'options' => array(

					'fade'        => esc_html__('Fade', 'tosca'),

					'directional' => esc_html__('Directional', 'tosca'),

				),

				'default' => 'fade',

			),

			'icon' => array(

				'type'    => 'select',

				'title'   => esc_html__('Lightbox icon', 'tosca'),

				'desc'    => esc_html__('Determine the type of icon displayed when item is hovered.', 'tosca'),

				'options' => array(

					'resize-enlarge' => esc_html__('Enlarge', 'tosca'),

					'link'           => esc_html__('Link', 'tosca'),

					'play'           => esc_html__('Play', 'tosca'),

					'arrow-right'    => esc_html__('Right Arrow', 'tosca'),

				),

				'default' => 'resize-enlarge',

			),

			'gallery' => array(

				'type'    => 'text',

				'title'   => esc_html__('Lightbox gallery', 'tosca'),

				'desc'    => esc_html__('Determine if the lightboxes are all part of a specific gallery.', 'tosca'),

				'default' => 'projects',

			),

			'popup' => array(

				'type'    => 'checkbox',

				'title'   => esc_html__('Lightbox popup', 'tosca'),

				'desc'    => esc_html__('Determine if the lighboxes get opened into a popup or get redirected to the their url.', 'tosca'),

				'default' => true,

			),

		),

	),

	'divider' => array(

		'title'   => esc_html__('Divider', 'tosca'),

		'desc'    => esc_html__('Output a divider based module.', 'tosca'),

		'icon'    => 'dashicons-minus',

		'options' => array(

			'title' => array(

				'type'  => 'text',

				'title' => esc_html__('Title', 'tosca'),

			),

			'bgcolor' => array(

				'type'    => 'color',

				'title'   => esc_html__('Background color', 'tosca'),

			),

			'bgimage' => array(

				'type'     => 'image',

				'title'    => esc_html__('Background image', 'tosca'),

				'show_alt' => true,

			),

			'bgrepeat' => array(

				'type'    => 'select',

				'title'   => esc_html__('Background repeat', 'tosca'),

				'options' => array(

					'cover'  => esc_html__('Cover', 'tosca'),

					'repeat' => esc_html__('Repeat', 'tosca'),

				),

			),

			'textcolor' => array(

				'type'  => 'color',

				'title' => esc_html__('Text color', 'tosca'),

			),

			'textalign' => array(

				'type'    => 'readonly',

				'default' => 'center',

			),

			'special_height' => array(

				'type'    => 'text',

				'title'   => esc_html__('Module height', 'tosca'),

				'desc'    => esc_html__('Height expressed in px, em or % (applied only when title field is empty).', 'tosca'),

				'default' => '2px',

			),

		),

	),

);



/* setup the modules builder to display only when editing a page */

add_action('load-post.php', 'tosca_module_builder_setup');



function tosca_module_builder_setup() {

	add_action('add_meta_boxes', 'tosca_add_module_builder');

	add_action('save_post', 'tosca_save_module_builder', 10, 2);

}



/* add page builder meta data on theme's special template */

function tosca_add_module_builder() {

	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : false);

	if ($post_id) {

		$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);

		if (isset($template_file) && $template_file == 'template-modular.php') {

			add_meta_box(

				'tosca_module_builder_meta',

				esc_html__('Module Builder', 'tosca'),

				'tosca_module_builder_html',

				'page',

				'normal',

				'high'

			);

			add_filter('wp_post_revision_meta_keys', function ($keys) {

				$keys[] = 'tosca_module_builder_html';

				return $keys;

			});

		}

	}

}



function tosca_module_builder_html($object, $box) {

	wp_nonce_field(basename(__FILE__), 'tosca_module_builder_nonce');

	global $post, $module_builder_options;

	$layout_text = get_post_meta($object->ID, 'module_builder_text', true);

	$layout_json = json_decode($layout_text, true);

	?>



	<div id="module-builder-container" class="ui-sortable">

		<?php

			if (isset($layout_json)) {

				foreach ($layout_json as $layout_row) {

					$row_content = '';

					$no_cell = count($layout_row);

					foreach ($layout_row as $layout_row) {

						$cell_content = '';

						foreach ($layout_row as $layout_module) {

							$cell_content .= tosca_module_builder_module_html(false, $layout_module['type'], $layout_module['data']);

						}

						$row_content .= tosca_module_builder_cell_html(false, $cell_content, ' style="width:' . (100 / $no_cell) . '%"');

					}

					echo tosca_module_builder_row_html(false, $row_content, $no_cell);

				}

			}

		?>



		<a href="#" id="module-builder-add-row" class="button button-secondary"><em class="dashicons dashicons-plus"></em> <?php esc_html_e('Add Row', 'tosca'); ?></a>

	</div>



	<?php

		echo tosca_module_builder_row_html();

		echo tosca_module_builder_cell_html();

		echo tosca_module_builder_module_html();

		echo tosca_module_builder_new_module_html();

	?>



	<div class="module-builder-remove-item-template module-builder-remove-item">

		<div class="module-builder-remove-item-wrapper"><?php esc_html_e('Column is not empty.', 'tosca'); ?><br><span class="module-builder-remove-item-confirm"><?php esc_html_e('Remove', 'tosca'); ?></span> <span class="module-builder-remove-item-dismiss"><?php esc_html_e('Dismiss', 'tosca'); ?></span></div>

	</div>



	<noscript><div class="module-builder-js-alert"><?php esc_html_e('Enable JavaScript in your browser to use this part of the page.', 'tosca'); ?></div></noscript>



	<textarea name="module_builder_text" id="module_builder_text" class="widefat screen-reader-text"><?php echo esc_attr(get_post_meta($object->ID, 'module_builder_text', true)); ?></textarea>



<?php if (get_user_option('rich_editing') == 'true') : ?>

	<div class="hidden-module-builder-editor screen-reader-text">

		<?php

			wp_editor('', 'module_content_editor', array(

				'textarea_rows' => 10,

			));

		?>



	</div>

<?php endif; ?>



<?php

}



function tosca_module_builder_row_html($is_template=TRUE, $content='', $no_cell = 2) {

	$row_class = ($is_template) ? 'module-builder-new-row-template ' : '';

	$toolbar_add_class = ($no_cell > 3) ? ' toolbar-button-disabled' : '';

	$toolbar_remove_class = ($no_cell < 2) ? ' toolbar-button-disabled' : '';

	return '

	<div class="' . $row_class . 'module-builder-row ui-draggable">

		<div class="module-builder-row-toolbar module-builder-dropdown">

			<span class="toolbar-button row-add-column' . $toolbar_add_class . '" title="' . esc_html__('Add new column', 'tosca') . '"><em class="dashicons dashicons-plus"></em></span>

			<span class="toolbar-button row-remove-column' . $toolbar_remove_class . '" title="' . esc_html__('Remove last column', 'tosca') . '"><em class="dashicons dashicons-minus"></em></span>

			<div class="module-builder-dropdown-wrapper">

				<span class="toolbar-button module-builder-dropdown-toggle row-settings"><em class="dashicons dashicons-admin-generic"></em></span>

				<div class="module-builder-dropdown-gap"></div>

				<ul class="module-builder-dropdown-menu">

					<li><span class="module-builder-duplicate-row">' . esc_html__('Duplicate row', 'tosca') . '</span></li>

					<li><span class="module-builder-remove-row"><em>' . esc_html__('Remove row', 'tosca') . '</em><strong>' . esc_html__('Are you sure?', 'tosca') . '</strong></li>

				</ul>

			</div>

			<span class="toolbar-button row-move ui-sortable-handle"><em class="dashicons dashicons-menu"></em></span>

		</div>

		<div class="module-builder-row-content">' . $content . '</div>

	</div>';

}



function tosca_module_builder_cell_html($is_template=TRUE, $content='', $width='') {

	$cell_class = ($is_template) ? 'module-builder-cell-template ' : '';

	$cell_new_item = ($is_template) ? '' : tosca_module_builder_new_module_html(false);

	return '

	<div class="' . $cell_class .'module-builder-cell"' . $width . '>

		<div class="module-builder-cell-wrapper ui-sortable">' . $content . '</div>' . $cell_new_item . '

	</div>';

}



function tosca_module_builder_module_html($is_template=TRUE, $type='', $value='') {

	global $module_builder_options;

	$module_class = ($is_template) ? 'module-builder-item-template ' : '';

	$module_extra_class = 'module-height-1 ';

	if ( ! $is_template) {

		$title = $module_builder_options[$type]['title'];

		$description = $module_builder_options[$type]['desc'];

		$json_values = json_decode($value, true);

		if (isset($json_values['title']) && ! empty($json_values['title'])) {

			$title = $json_values['title'];

		}

		if (isset($json_values['height']) && ! empty($json_values['height'])) {

			$module_extra_class = 'module-height-' . $json_values['height'] . ' ';

		}

	} else {

		$title = $description = '';

	}

	return '

	<div class="' . $module_class . $module_extra_class . 'module-builder-item ui-draggable">

		<div class="module-builder-item-wrapper">

			<div class="module-title">

				<h4>' . $title . '</h4>

				<span class="actions">

					<a href="#" class="module-builder-item-edit">' . esc_html__('Edit', 'tosca') . '</a>

					<a href="#" class="module-builder-item-duplicate">' . esc_html__('Duplicate', 'tosca') . '</a>

					<a href="#" class="module-builder-item-delete">' . esc_html__('Delete', 'tosca') . '</a>

				</span>

			</div>

			<span class="module-description">' . $description . '</span>

			<input type="hidden" class="module-value widefat" data-type="' . $type .'" value="' . esc_attr($value) .'" />

		</div>

	</div>';

}



function tosca_module_builder_new_module_html($is_template=TRUE) {

	global $post, $module_builder_options;

	$module_class = ($is_template) ? 'module-builder-new-item-template ' : '';

	$module_types = '';

	$module_types_col = 0;

	foreach ($module_builder_options as $module_name => $module_options) {

		$module_types_col++;

		$module_types_col_class = ($module_types_col % 2==1) ? 'first' : 'last';

		$module_types .= '<li class="' . $module_types_col_class . '"><span data-type="' . esc_attr($module_name) . '"><em class="dashicons ' . esc_attr($module_options['icon']) . '"></em>' . $module_options['title'] . '</span></li>';

	}

	return '

	<div class="' . $module_class . 'module-builder-new-item">

		<div class="module-builder-dropdown">

			<div class="module-builder-dropdown-wrapper">

				<span class="module-builder-add-new-module module-builder-dropdown-toggle"><em class="dashicons dashicons-plus"></em> ' . esc_html__('Add Module', 'tosca') . '</span>

				<div class="module-builder-dropdown-gap"></div>

				<ul class="module-builder-dropdown-menu type-' . $post->post_type . '">' . $module_types . '</ul>

			</div>

		</div>

	</div>';

}



function tosca_save_module_builder($post_id, $post) {

	if ( ! isset( $_POST['tosca_module_builder_nonce'] ) || ! wp_verify_nonce( $_POST['tosca_module_builder_nonce'], basename( __FILE__ ) ) ) {

		return $post_id;

	}



	$post_type = get_post_type_object( $post->post_type );

	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {

		return $post_id;

	}

	$new_meta_value = ( isset( $_POST['module_builder_text'] ) ? $_POST['module_builder_text'] : '' );



	$meta_key = 'module_builder_text';

	$meta_value = get_post_meta($post_id, $meta_key, true);



	if ($new_meta_value && '' == $meta_value) {

		add_post_meta($post_id, $meta_key, $new_meta_value, true);

	} else if ($new_meta_value && $new_meta_value != $meta_value) {

		update_post_meta( $post_id, $meta_key, $new_meta_value );

	} else if ('' == $new_meta_value && $meta_value) {

		delete_post_meta($post_id, $meta_key, $meta_value);

	}

}



function tosca_module_builder_assets() {

	$post_id = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : false);

	if ($post_id) {

		$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);

		if ( $template_file == 'template-modular.php') {

			wp_enqueue_style('tosca-module-builder-css', get_template_directory_uri() . '/utils/module-builder/module-builder.css');

			wp_enqueue_script('tosca-module-builder-js', get_template_directory_uri() . '/utils/module-builder/module-builder.js', array('jquery'), false, true);

			wp_enqueue_script('json2');

			wp_enqueue_style('wp-color-picker');

			wp_enqueue_script('wp-color-picker');

			wp_enqueue_script('jquery-ui-sortable');

			wp_enqueue_script('media-upload');

		}

	}

}

add_action('admin_enqueue_scripts', 'tosca_module_builder_assets', 99);



function tosca_module_builder_ajax_popup_callback() {

	global $module_builder_options;

	$module_type = $_POST['type'];

	$module_title = $module_builder_options[$module_type]['title'];

	$module_desc = $module_builder_options[$module_type]['desc'];

	$module_options = (isset($_POST['options']) && is_array($_POST['options'])) ? $_POST['options'] : false;

	$module_operation = ( ! $module_options) ? esc_html__('Insert', 'tosca') : esc_html__('Update', 'tosca');

	$output = '';

	$output .= '<div class="media-frame-title">';

	$output .= '<h1>' . sprintf( esc_html__('%s %s Module', 'tosca'), $module_operation, $module_title) . '</h1>';

	$output .= '</div>';

	$output .= '<div class="media-frame-content"><div class="media-frame-content-inner">';

	$output .= tosca_module_builder_populate_options($module_type, $module_options);

	$output .= '</div></div>';

	$output .= '<div class="media-frame-toolbar"><div class="media-toolbar">';

	$output .= '<div class="media-toolbar-primary">';

	$media_button_class = ( ! $module_options) ? 'insert' : 'update';

	$output .= '<a href="#" class="module-builder-popup-submit-button button media-button button-primary button-large media-button-' . $media_button_class . '" data-module-type="' . $module_type . '" data-module-title="' . $module_title . '" data-module-description="' . $module_desc . '">' . sprintf( esc_html__('%s Module', 'tosca'), $module_operation) . '</a>';

	$output .= '</div>';

	$output .= '<div class="media-toolbar-secondary">';

	$output .= '<a href="#" class="module-builder-popup-cancel-button button media-button button-large media-button-cancel">' . esc_html__('Cancel', 'tosca') . '</a>';

	$output .= '</div>';

	$output .= '</div></div>';

	echo $output;

	exit();

}

add_action('wp_ajax_module_builder_ajax_popup', 'tosca_module_builder_ajax_popup_callback');



function tosca_module_builder_populate_options($module_type, $module_options) {

	global $module_builder_options;

	$out = '';

	if ( ! isset($module_builder_options[$module_type]) ) return '';

	foreach($module_builder_options[$module_type]['options'] as $type => $opt) {

		$opt['id'] = $type;

		if (isset($opt['class'])) {

			$extra_class = ' ' . $opt['class'];

		} else {

			$extra_class = '';

		}

		$out .= '<div class="option-line option-line-' . $opt['type'] . $extra_class . '">' . tosca_module_builder_populate_options_field($opt, $module_options) . '</div>';

	}

	return $out;

}



function tosca_module_builder_populate_options_field($opt, $module_options) {

	$line = '';

	if ($opt['type'] == 'info') {

		$line .= $opt['desc'];

	} else {

		if (isset($opt['title'])) {

			$line .= '<label for="' . esc_attr($opt['id']) . '" class="option-title">' . $opt['title'] . ':</label>';

		}

		$line .= '<div class="option-content">';



		if (isset($module_options[$opt['id']])) {

			if (is_array($module_options[$opt['id']])) {

				$opt['default'] = $module_options[$opt['id']];

			} else {

				$opt['default'] = stripslashes($module_options[$opt['id']]);

			}

		}



		if ( ! isset($opt['default'])) $opt['default'] = '';



		switch ($opt['type']) {



			case 'select':

				$line.='<select name="' . $opt['id'] . '" id="' . $opt['id'] . '" class="widefat">';

				foreach ($opt['options'] as $k => $v) {

					$line .= '<option value="' . esc_attr($k) . '"' . ($k == $opt['default'] ? ' selected' : '') . '>' . $v . '</option>';

				}

				$line .= '</select>';

			break;



			case 'checkbox':

				$line .= '<input type="checkbox" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" value="true" ' . ('true' == $opt['default'] ? ' checked' : '').'>';

			break;



			case 'text':

				$line .= '<input type="text" class="widefat" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" value="' . esc_attr($opt['default']) . '">';

			break;



			case 'readonly':

				$line .= '<input type="text" class="widefat" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" value="' . esc_attr($opt['default']) . '" readonly>';

			break;



			case 'url':

				$line .= '<input type="url" class="widefat" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" value="' . esc_attr($opt['default']) . '">';

			break;



			case 'textarea':

				$r = 8;

				if (isset($opt['rows']) && $opt['rows']) $r = $opt['rows'];

				$line .= '<textarea class="widefat" rows="' . esc_attr($r) . '" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" >' . esc_html($opt['default']) . '</textarea>';

				break;



			case 'editor':

				$r = 6;

				if (isset($opt['rows']) && $opt['rows']) $r = $opt['rows'];

				$line .= '<textarea class="widefat" rows="' . esc_attr($r) . '" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" >' . esc_html($opt['default']) . '</textarea>';

				if (get_user_option('rich_editing') == 'true') {

					$line .= '<div class="editor-placeholder"></div>';

				}

				break;



			case 'color':

				$line .= '<input class="wp-color-picker-field" name="'. esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" type="text" value="' . esc_attr($opt['default']) . '"  data-default-color="' . esc_attr($opt['default']) . '">';

				break;



			case 'image':

				if (empty($opt['default'])) {

					$opt['default'] = array('url' => '', 'width' => '', 'height' => '', 'alt' => '');

				}

				$hide_class = empty($opt['default']['url']) ? ' hide' : '';

				$screenshot = empty($opt['default']['url']) ? '' : '<img src="' . esc_url($opt['default']['url']) . '">';

				$line .= '<input type="text" class="widefat upload-file upload-image" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" value="' . esc_attr($opt['default']['url']) . '"><input type="hidden" class="width" value="' . esc_attr($opt['default']['width']) . '"><input type="hidden" class="height" value="' . esc_attr($opt['default']['height']) . '"><div class="uploads_actions"><span class="button upload-image">' . esc_html__('Upload', 'tosca') . '</span><span class="button remove-image' . $hide_class . '">' . esc_html__('Remove', 'tosca') . '</span></div><div class="screenshot">' . $screenshot . '</div><div class="clear"></div>';

				if ( isset($opt['show_alt']) && ($opt['show_alt'] == true) ) {

					$line .= '<label for="' . esc_attr($opt['id']) . '_alt_text" class="option-title">' . $opt['title'] . esc_html__(' alt attribute', 'tosca') . ':</label>';

					$line .= '<input type="text" class="widefat alt-text" name="' . esc_attr($opt['id']) . '_alt_text" id="' . esc_attr($opt['id']) . '_alt_text" value="' . esc_attr($opt['default']['alt']) . '">';

				}

				break;



			case 'file':

				$hide_class = empty($opt['default']) ? ' hide' : '';

				$line .= '<input type="text" class="widefat upload-file" name="' . esc_attr($opt['id']) . '" id="' . esc_attr($opt['id']) . '" value="' . esc_attr($opt['default']) . '"><div class="uploads_actions"><span class="button upload-image">' . esc_html__('Upload', 'tosca') . '</span><span class="button remove-image' . $hide_class . '">' . esc_html__('Remove', 'tosca') . '</span></div>';

				break;



			case 'category':

				$args = array(

					'show_option_all' => esc_html__('All Categories', 'tosca'),

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

					'show_option_all' => esc_html__('All Tags', 'tosca'),

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



			case 'duplicate':

				if (empty($opt['default'])) {

					$opt['default'][0] = array(

						'caption'            => '',

						'caption_url'        => '',

						'caption_url_target' => '',

						'image'              => array(

							'url'    => '',

							'width'  => '',

							'height' => '',

							'alt'    => ''

						)

					);

				}

				$opt['default'] = array_merge(array(

					'new' => array(

						'caption'            => '',

						'caption_url'        => '',

						'caption_url_target' => '',

						'image'              => array(

							'url'    => '',

							'width'  => '',

							'height' => '',

							'alt'    => ''

						)

					)

				), $opt['default']);



				if (isset($opt['fields_title'])) {

					$template_title = $opt['fields_title'];

				} else {

					$template_title = esc_html__('Item', 'tosca');

				}



				foreach ($opt['default'] as $item_key => $item_value) {

					$is_template = ( ! is_numeric($item_key));

					if ($is_template) {

						$line .= '<div class="ui-state-default template-item" data-inputname="' . $opt['id'] . '" data-baseid="' . $opt['fields_base_id'] . '">';

					} else {

						$line .= '<div class="ui-state-default item">';

					}

					$line .= '<h3><span class="dashicons dashicons-menu"></span> ' . $template_title . ' </h3><a class="module-builder-remove-template" href="#" data-confirm="' . esc_html__('Are you sure you want to remove this item?', 'tosca') . '"><span class="dashicons dashicons-no-alt"></span></a><div class="inner">';

					foreach($opt['fields'] as $new_id => $new_opt) {

						$new_opt['id'] = $new_id . '[' . $item_key . ']';

						$new_opt_values = array();

						if ( ! $is_template) {

							if (isset($item_value[$new_id])) {

								$new_opt_values[$new_opt['id']] = $item_value[$new_id];

							} else {

								$new_opt_values[$new_opt['id']] = '';

							}

						}

						$line .= '<div class="option-line option-line-' . $new_opt['type'] . '">' . tosca_module_builder_populate_options_field($new_opt, $new_opt_values) . '</div>';

					}

					$line .= '</div></div>';

				}

				$line .= '<div class="duplicate-add-new"><a href="#" class="module-builder-duplicate-template button button-primary button-large">' . esc_html__('Add New ','tosca') . $template_title . '</a></div>';

				break;

		}

		if (isset($opt['desc']) && $opt['desc']) {

			$line .= '<div class="option-field-description">' . $opt['desc'] . '</div>';

		}

		$line .= '</div>';

	}

	return $line;

}

