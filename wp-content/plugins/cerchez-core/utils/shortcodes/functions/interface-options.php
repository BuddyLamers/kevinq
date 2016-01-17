<?php



$cerchez_core_shortcodes_options = array(

	'alert' => array(

		'options' => array(

			'cerchez_core_alert_type' => array(

				'title' => __('Type', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Information', 'cerchez-core'),

					'success' => __('Success', 'cerchez-core'),

					'notice' => __('Notice', 'cerchez-core'),

					'error' => __('Error', 'cerchez-core'),

				),

			),

			'cerchez_core_alert_content' => array(

				'title' => __('Content', 'cerchez-core'),

				'type' => 'textarea',

			),

		)

	),



	'button' => array(

		'options' => array(

			'cerchez_core_button_text' => array(

				'title' => __('Text', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_button_url' => array(

				'title' => __('URL', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_button_target' => array(

				'title' => __('Target', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Open in same tab/window', 'cerchez-core'),

					'blank' => __('Open in new tab/window', 'cerchez-core'),

				),

			),

			'cerchez_core_button_size' => array(

				'title' => __('Size', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'small' => __('Small', 'cerchez-core'),

					'' => __('Normal', 'cerchez-core'),

					'big' => __('Big', 'cerchez-core'),

				),

			),

			'cerchez_core_button_color' => array(

				'title' => __('Color', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Base Color', 'cerchez-core'),

					'light' => __('Light Color', 'cerchez-core'),

					'grey' => __('Grey Color', 'cerchez-core'),

					'dark' => __('Dark Color', 'cerchez-core'),

				),

			),

			'cerchez_core_button_id' => array(

				'title' => __('ID Attribute', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_button_class' => array(

				'title' => __('Class Attribute', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_button_rel' => array(

				'title' => __('Rel Attribute', 'cerchez-core'),

				'type' => 'text',

			),

		)

	),



	'call_to_action' => array(

		'options' => array(

			'cerchez_core_call_to_action_title' => array(

				'title' => __('Title', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_call_to_action_content' => array(

				'title' => __('Content', 'cerchez-core'),

				'type' => 'textarea',

				'default' => '<p class="no-bottom">[button url="#"]Support[/button] [button url="#" color="dark"]Contact Us[/button]</p>',

			),

		)

	),



	'feature' => array(

		'options' => array(

			'cerchez_core_feature_image' => array(

				'title' => __('Image', 'cerchez-core'),

				'type' => 'image',

				'show_alt' => true,

			),

			'cerchez_core_feature_title' => array(

				'title' => __('Title', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_feature_text' => array(

				'title' => __('Text', 'cerchez-core'),

				'type' => 'textarea',

			),

		)

	),



	'social' => array(

		'options' => array(

			'cerchez_core_social_type' => array(

				'title' => __('Type', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'dribbble' => __('Dribbble', 'cerchez-core'),

					'mail' => __('Email', 'cerchez-core'),

					'envato' => __('Envato', 'cerchez-core'),

					'facebook' => __('Facebook', 'cerchez-core'),

					'flickr' => __('Flickr', 'cerchez-core'),

					'github' => __('GitHub', 'cerchez-core'),

					'googleplus' => __('Google+', 'cerchez-core'),

					'instagram' => __('Instagram', 'cerchez-core'),

					'linkedin' => __('LinkedIn', 'cerchez-core'),

					'pinterest' => __('Pinterest', 'cerchez-core'),

					'skype' => __('Skype', 'cerchez-core'),

					'soundcloud' => __('SoundCloud', 'cerchez-core'),

					'tumblr' => __('Tumblr', 'cerchez-core'),

					'twitter' => __('Twitter', 'cerchez-core'),

					'vimeo' => __('Vimeo', 'cerchez-core'),

					'youtube' => __('YouTube', 'cerchez-core'),

				),

				'default' => 'facebook',

			),

			'cerchez_core_social_url' => array(

				'title' => __('URL', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_social_target' => array(

				'title' => __('Target', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Open in same tab/window', 'cerchez-core'),

					'blank' => __('Open in new tab/window', 'cerchez-core'),

				),

				'default' => 'blank',

			),

			'cerchez_core_social_title' => array(

				'title' => __('Title Attribute', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_social_class' => array(

				'title' => __('Class Attribute', 'cerchez-core'),

				'type' => 'text',

			),

		)

	),



	'accordion' => array(

		'options' => array(

			'cerchez_core_accordion_collapse' => array(

				'title' => __('Collapse', 'cerchez-core'),

				'desc' => __('Determines if the accordion has only one item visible at a time.', 'cerchez-core'),

				'type' => 'checkbox',

				'default' => true,

				'class' => 'no-border margin-bottom',

			),

			'cerchez_core_accordion_items' => array(

				'type' => 'duplicate',

				'fields_title' => __('Accordion Item', 'cerchez-core'),

				'fields' => array(

					'cerchez_core_accordion_item_title' => array(

						'title' => __('Title', 'cerchez-core'),

						'type' => 'text',

					),

					'cerchez_core_accordion_item_text' => array(

						'title' => __('Text Content', 'cerchez-core'),

						'type' => 'textarea',

					),

					'cerchez_core_accordion_item_opened' => array(

						'title' => __('Opened', 'cerchez-core'),

						'desc' => __('Determines if the item is opened in initial state.', 'cerchez-core'),

						'type' => 'checkbox',

					),

				)

			),

		)

	),



	'accordion_item' => array(

		'options' => array(

			'cerchez_core_accordion_item_title' => array(

				'title' => __('Title', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_accordion_item_text' => array(

				'title' => __('Text Content', 'cerchez-core'),

				'type' => 'textarea',

			),

			'cerchez_core_accordion_item_opened' => array(

				'title' => __('Opened', 'cerchez-core'),

				'desc' => __('Determines if the item is opened in initial state.', 'cerchez-core'),

				'type' => 'checkbox',

			),

		)

	),



	'audio' => array(

		'options' => array(

			'cerchez_core_audio_mp3' => array(

				'title' => __('MP3', 'cerchez-core'),

				'type' => 'file',

			),

			'cerchez_core_audio_ogg' => array(

				'title' => __('OGG', 'cerchez-core'),

				'type' => 'file',

			),

			'cerchez_core_audio_wav' => array(

				'title' => __('WAV', 'cerchez-core'),

				'type' => 'file',

			),

			'cerchez_core_audio_loop' => array(

				'title' => __('Loop', 'cerchez-core'),

				'desc' => __('Determine if the audio player will loop the file.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_audio_autoplay' => array(

				'title' => __('Autoplay', 'cerchez-core'),

				'desc' => __('Determine if the audio player will autoplay the file &mdash; iOS devices will require mandatory user interaction to play a file.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_audio_preload' => array(

				'title' => __('Preload', 'cerchez-core'),

				'desc' => __('Determine if the audio player preloads the file.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_audio_class' => array(

				'title' => __('Class', 'cerchez-core'),

				'desc' => __('Add extra class values to the container element.', 'cerchez-core'),

				'type' => 'text',

			),

		)

	),



	'projects' => array(

		'options' => array(

			'cerchez_core_projects_category' => array(

				'title' => __('Category', 'cerchez-core'),

				'desc' => __('Restrict portfolio items belonging to a specific category.', 'cerchez-core'),

				'type' => 'category',

			),

			'cerchez_core_projects_tag' => array(

				'title' => __('Tag', 'cerchez-core'),

				'desc' => __('Restrict portfolio items having a specific tag.', 'cerchez-core'),

				'type' => 'tag',

			),

			'cerchez_core_projects_limit' => array(

				'title' => __('Limit', 'cerchez-core'),

				'desc' => __('Number of portfolio items to show in total. Note that some numbers are hidden because they can\'t form a perfect row in the grid system.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('All posts', 'cerchez-core'),

					'1' => '1',

					'2' => '2',

					'3' => '3',

					'4' => '4',

					'6' => '6',

					'8' => '8',

					'9' => '9',

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

			'cerchez_core_projects_per_row' => array(

				'title' => __('Per Row', 'cerchez-core'),

				'desc' => __('Number of portfolio items to show on a single line (will be discarded if a showcase is checked).', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'1' => '1',

					'2' => '2',

					'3' => '3',

					'4' => '4',

					'6' => '6',

					'12' => '12',

				),

				'default' => '3',

			),

			'cerchez_core_projects_showcase' => array(

				'title' => __('Showcase', 'cerchez-core'),

				'desc' => __('Determine if this is a showcase type of gallery.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_projects_filters' => array(

				'title' => __('Filters', 'cerchez-core'),

				'desc' => __('Determine if filters are available for the gallery &mdash; this can be used in combination with the category attribute because filters are basically sub-categories of a specific category.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_projects_image_width' => array(

				'title' => __('Image width', 'cerchez-core'),

				'desc' => __('Image width for the featured image of the portfolio item.', 'cerchez-core'),

				'type' => 'text',

				'default' => '450',

			),

			'cerchez_core_projects_image_height' => array(

				'title' => __('Image height', 'cerchez-core'),

				'desc' => __('Image height for the featured image of the portfolio item.', 'cerchez-core'),

				'type' => 'text',

				'default' => '300',

			),

			'cerchez_core_projects_lightbox_class' => array(

				'title' => __('Image effect', 'cerchez-core'),

				'desc' => __('Determine the type of thumb animation when item is hovered.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'fade' => __('Fade', 'cerchez-core'),

					'directional' => __('Directional', 'cerchez-core'),

				),

				'default' => 'fade',

			),

			'cerchez_core_projects_lightbox_icon' => array(

				'title' => __('Image icon', 'cerchez-core'),

				'desc' => __('Determine the type of icon displayed when item is hovered.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'resize-enlarge' => __('Enlarge', 'cerchez-core'),

					'link' => __('Link', 'cerchez-core'),

					'play' => __('Play', 'cerchez-core'),

					'arrow-right' => __('Right Arrow', 'cerchez-core'),

				),

				'default' => 'resize-enlarge',

			),

			'cerchez_core_projects_lightbox_title_inside' => array(

				'title' => __('Title inside', 'cerchez-core'),

				'desc' => __('Determine if the title and subtitle are displayed inside the thumbnail or outside.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_projects_lightbox_subtitles' => array(

				'title' => __('Subtitles', 'cerchez-core'),

				'desc' => __('Determine if subtitles are retrieved for each item; it can display the categories or the tags each posts belongs to.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Hide subtitles', 'cerchez-core'),

					'categories' => __('Display categories', 'cerchez-core'),

					'tags' => __('Display tags', 'cerchez-core'),

				),

			),

			'cerchez_core_projects_lightbox_gallery' => array(

				'title' => __('Lightbox gallery', 'cerchez-core'),

				'desc' => __('Determine if the lightboxes are all part of a specific gallery.', 'cerchez-core'),

				'type' => 'text',

				'default' => 'projects',

			),

			'cerchez_core_projects_lightbox_popup' => array(

				'title' => __('Lightbox popup', 'cerchez-core'),

				'desc' => __('Determine if the lighboxes get opened into a popup or get redirected to the their url.', 'cerchez-core'),

				'type' => 'checkbox',

				'default' => true,

			),

			'cerchez_core_projects_filter_all_string' => array(

				'title' => __('Filter string for "all" category', 'cerchez-core'),

				'desc' => __('String used for the All category in the filters (Default: All).', 'cerchez-core'),

				'type' => 'text',

			),

		)

	),



	'news' => array(

		'options' => array(

			'cerchez_core_news_category' => array(

				'title' => __('Category', 'cerchez-core'),

				'desc' => __('Restrict posts belonging to a specific category.', 'cerchez-core'),

				'type' => 'category',

			),

			'cerchez_core_news_tag' => array(

				'title' => __('Tag', 'cerchez-core'),

				'desc' => __('Restrict posts having a specific tag.', 'cerchez-core'),

				'type' => 'tag',

			),

			'cerchez_core_news_limit' => array(

				'title' => __('Limit', 'cerchez-core'),

				'desc' => __('Number of posts to show in total.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'-1' => __('All posts', 'cerchez-core'),

					'1' => '1',

					'2' => '2',

					'3' => '3',

					'4' => '4',

					'5' => '5',

					'6' => '6',

					'7' => '7',

					'8' => '8',

					'9' => '9',

					'10' => '10',

					'11' => '11',

					'12' => '12',

				),

				'default' => '3',

			),

			'cerchez_core_news_image_width' => array(

				'title' => __('Image width', 'cerchez-core'),

				'desc' => __('Image width for the featured image of the post.', 'cerchez-core'),

				'type' => 'text',

				'default' => '450',

			),

			'cerchez_core_news_image_height' => array(

				'title' => __('Image height', 'cerchez-core'),

				'desc' => __('Image height for the featured image of the post.', 'cerchez-core'),

				'type' => 'text',

				'default' => '300',

			),

		)

	),



	'lightbox' => array(

		'options' => array(

			'cerchez_core_lightbox_url' => array(

				'title' => __('URL', 'cerchez-core'),

				'desc' => __('Link for the big version of the image, video from YouTube, Vimeo, Metacafe, DailyMotion, TwitVid, GMap.', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_lightbox_class' => array(

				'title' => __('Image effect', 'cerchez-core'),

				'desc' => __('Determine the type of thumb animation when item is hovered.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'fade' => __('Fade', 'cerchez-core'),

					'directional' => __('Directional', 'cerchez-core'),

				),

				'default' => 'fade',

			),

			'cerchez_core_lightbox_icon' => array(

				'title' => __('Image icon', 'cerchez-core'),

				'desc' => __('Determine the type of icon displayed when item is hovered.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'resize-enlarge' => __('Enlarge', 'cerchez-core'),

					'link' => __('Link', 'cerchez-core'),

					'play' => __('Play', 'cerchez-core'),

					'arrow-right' => __('Right Arrow', 'cerchez-core'),

				),

				'default' => 'resize-enlarge',

			),

			'cerchez_core_lightbox_title' => array(

				'title' => __('Title', 'cerchez-core'),

				'desc' => __('Set a title to be displayed along the lightbox.', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_lightbox_subtitle' => array(

				'title' => __('Subtitle', 'cerchez-core'),

				'desc' => __('Set a tag to be displayed along the title', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_lightbox_title_inside' => array(

				'title' => __('Title inside', 'cerchez-core'),

				'desc' => __('Determine if the title and subtitle are displayed inside the thumbnail or outside.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_lightbox_gallery' => array(

				'title' => __('Gallery', 'cerchez-core'),

				'desc' => __('Determine if the lightboxe is part of a specific gallery.', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_lightbox_popup' => array(

				'title' => __('Popup', 'cerchez-core'),

				'desc' => __('Determine if the lighboxe gets opened into a popup or gets redirected to the specified url.', 'cerchez-core'),

				'type' => 'checkbox',

				'default' => true,

			),

		)

	),



	'map' => array(

		'options' => array(

			'cerchez_core_map_type' => array(

				'title' => __('Type', 'cerchez-core'),

				'desc' => __('Determine the type used for interpreting the content box.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'address' => __('Address', 'cerchez-core'),

					'embed_code' => __('Embed code', 'cerchez-core'),

				),

				'default' => 'embed_code',

			),

			'cerchez_core_map_content' => array(

				'title' => __('Content', 'cerchez-core'),

				'type' => 'textarea',

			),

		)

	),



	'pricing' => array(

		'options' => array(

			'cerchez_core_pricing_items' => array(

				'type' => 'duplicate',

				'fields_title' => __('Pricing Column', 'cerchez-core'),

				'fields' => array(

					'cerchez_core_pricing_item_title' => array(

						'title' => __('Title', 'cerchez-core'),

						'type' => 'text',

					),

					'cerchez_core_pricing_item_cost' => array(

						'title' => __('Cost', 'cerchez-core'),

						'type' => 'text',

					),

					'cerchez_core_pricing_item_cost_after' => array(

						'title' => __('Cost After', 'cerchez-core'),

						'type' => 'text',

						'default' => __('per month', 'cerchez-core'),

					),

					'cerchez_core_pricing_item_highlight' => array(

						'title' => __('Highlight ', 'cerchez-core'),

						'desc' => __('Determine if it\'s the higlighted pricing column.', 'cerchez-core'),

						'type' => 'checkbox',

					),

					'cerchez_core_pricing_item_content' => array(

						'title' => __('Content', 'cerchez-core'),

						'desc' => __('Set the HTML that will be placed inside the pricing column.', 'cerchez-core'),

						'type' => 'textarea',

						'default' => '<ul>

<li>Feature1</li>

<li>Feature2</li>

</ul>',

					),

				)

			),

		)

	),



	'slider' => array(

		'options' => array(

			'cerchez_core_slider_autoslide' => array(

				'title' => __('Autoslide', 'cerchez-core'),

				'desc' => __('Determines if the slider autoslides.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_slider_autoslide_timer' => array(

				'title' => __('Autoslide Timer', 'cerchez-core'),

				'desc' => __('Time (in miliseconds) between autoslides.', 'cerchez-core'),

				'type' => 'text',

				'default' => '5000',

			),

			'cerchez_core_slider_autoslide_timer_trans' => array(

				'title' => __('Autoslide Timer Transition', 'cerchez-core'),

				'desc' => __('Determine the speed (in miliseconds) of the slide animation.', 'cerchez-core'),

				'type' => 'text',

				'default' => '750',

			),

			'cerchez_core_slider_arrows' => array(

				'title' => __('Control Arrows', 'cerchez-core'),

				'desc' => __('Determines if the slider next/prev arrow controls are visible.', 'cerchez-core'),

				'type' => 'checkbox',

				'default' => true,

			),

			'cerchez_core_slider_pagination' => array(

				'title' => __('Pagination', 'cerchez-core'),

				'desc' => __('Determines if the slider pagination is visible.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_slider_aspect_ratio' => array(

				'title' => __('Aspect Ratio', 'cerchez-core'),

				'desc' => __('Set aspect ratio of the images displayed inside the slider (will also determine the height of the slider).', 'cerchez-core'),

				'type' => 'aspect-ratio',

				'default_width' => '16',

				'default_height' => '9',

			),

			'cerchez_core_slider_class' => array(

				'title' => __('Class', 'cerchez-core'),

				'desc' => __('Add extra class values to the slider container element.', 'cerchez-core'),

				'type' => 'text',

				'class' => 'no-border margin-bottom',

			),

			'cerchez_core_slider_items' => array(

				'type' => 'duplicate',

				'fields_title' => __('Slide', 'cerchez-core'),

				'fields' => array(

					'cerchez_core_slider_item_image' => array(

						'title' => __('Image', 'cerchez-core'),

						'type' => 'image',

						'show_alt' => true,

					),

					'cerchez_core_slider_item_caption' => array(

						'title' => __('Caption', 'cerchez-core'),

						'type' => 'text',

					),

					'cerchez_core_slider_item_caption_url' => array(

						'title' => __('Caption URL', 'cerchez-core'),

						'type' => 'text',

					),

					'cerchez_core_slider_item_caption_url_target' => array(

						'title' => __('Caption URL Target', 'cerchez-core'),

						'type' => 'select',

						'options' => array(

							'' => __('Open in same tab/window', 'cerchez-core'),

							'blank' => __('Open in new tab/window', 'cerchez-core'),

						),

					),

				)

			),

		)

	),



	'slider_item' => array(

		'options' => array(

			'cerchez_core_slider_item_image' => array(

				'title' => __('Image', 'cerchez-core'),

				'type' => 'image',

				'show_alt' => true,

			),

			'cerchez_core_slider_item_caption' => array(

				'title' => __('Caption', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_slider_item_caption_url' => array(

				'title' => __('Caption URL', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_slider_item_caption_url_target' => array(

				'title' => __('Caption URL Target', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Open in same tab/window', 'cerchez-core'),

					'blank' => __('Open in new tab/window', 'cerchez-core'),

				),

			),

		)

	),



	'tabs' => array(

		'options' => array(

			'cerchez_core_tabs_id' => array(

				'title' => __('ID', 'cerchez-core'),

				'desc' => __('Determine the method for naming the URL for each tab.', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'' => __('Auto generated number', 'cerchez-core'),

					'name' => __('Name from title attribute', 'cerchez-core'),

				),

				'class' => 'no-border margin-bottom',

			),

			'cerchez_core_tabs_items' => array(

				'type' => 'duplicate',

				'fields_title' => __('Tab', 'cerchez-core'),

				'fields' => array(

					'cerchez_core_tab_item_title' => array(

						'title' => __('Title', 'cerchez-core'),

						'type' => 'text',

					),

					'cerchez_core_tab_item_content' => array(

						'title' => __('Content', 'cerchez-core'),

						'type' => 'textarea',

					),

					'cerchez_core_tab_item_active' => array(

						'title' => __('Active', 'cerchez-core'),

						'type' => 'checkbox',

					),

				)

			),

		)

	),



	'tab' => array(

		'options' => array(

			'cerchez_core_tab_item_title' => array(

				'title' => __('Title', 'cerchez-core'),

				'type' => 'text',

			),

			'cerchez_core_tab_item_content' => array(

				'title' => __('Content', 'cerchez-core'),

				'type' => 'textarea',

			),

			'cerchez_core_tab_item_active' => array(

				'title' => __('Active', 'cerchez-core'),

				'type' => 'checkbox',

			),

		)

	),



	'video' => array(

		'options' => array(

			'cerchez_core_video_content' => array(

				'title' => __('Embed code', 'cerchez-core'),

				'type' => 'textarea',

			),

		)

	),



	'grid' => array(

		'options' => array(

			'cerchez_core_grid_info' => array(

				'type' => 'info',

				'desc' => __('Create custom layouts by arranging elements into grids (columns). A row is divided in a 12-column based grid system, where 6 means half the content area and 4 is one third.', 'cerchez-core'),

			),

			'cerchez_core_grid_no' => array(

				'title' => __('No. of columns', 'cerchez-core'),

				'type' => 'select',

				'options' => array(

					'1' => '1',

					'2' => '2',

					'3' => __('3 - one fourth', 'cerchez-core'),

					'4' => __('4 - one third', 'cerchez-core'),

					'5' => '5',

					'6' => __('6 - one half', 'cerchez-core'),

					'7' => '7',

					'8' => __('8 - two thirds', 'cerchez-core'),

					'9' => '9',

					'10' => '10',

					'11' => '11',

					'12' => __('12 - full-width', 'cerchez-core'),

				),

			),

			'cerchez_core_grid_first' => array(

				'title' => __('First', 'cerchez-core'),

				'desc' => __('Mark this if the grid column is the first in a row.', 'cerchez-core'),

				'type' => 'checkbox',

			),

			'cerchez_core_grid_last' => array(

				'title' => __('Last', 'cerchez-core'),

				'desc' => __('Mark this if the grid column is the last in a row.', 'cerchez-core'),

				'type' => 'checkbox',

			),

		)

	),



);

