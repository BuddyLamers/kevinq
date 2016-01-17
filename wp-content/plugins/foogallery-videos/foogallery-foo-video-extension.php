<?php

/**

 * Adds video support within FooGallery

 *

 * @package   foo_video

 * @author    CalderaWP, FooPlugins

 * @license   GPL-2.0+

 * @link      http://fooplugins.com

 * @copyright 2015 FooPlugins

 *

 * @wordpress-plugin

 * Plugin Name: FooGallery - Video Extension

 * Description: Adds video support within FooGallery

 * Version:     1.0.7

 * Author:      FooPlugins, CalderaWP

 * Author URI:  http://fooplugins.com

 * License:     GPL-2.0+

 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt

 */



if ( ! class_exists( 'Foo_Video' ) ) {



	define( 'FOO_VIDEO_FILE', __FILE__ );

	define( 'FOO_VIDEO_URL', plugin_dir_url( __FILE__ ) );

	define( 'FOO_VIDEO_PATH', plugin_dir_path( __FILE__ ) );

	define( 'FOO_VIDEO_SLUG', 'foo-video' );

	define( 'FOO_VIDEO_VERSION', '1.0.7' );

	define( 'FOO_VIDEO_BATCH_LIMIT', 10 );

	define( 'FOO_VIDEO_POST_META', '_foovideo_video_data' );

	define( 'FOO_VIDEO_POST_META_VIDEO_COUNT' , '_foovideo_video_count' );

	define( 'FOO_VIDEO_UPDATE_URL', 'http://fooplugins.com/api/foovideo/check'  );

	define( 'FOO_VIDEO_FOOGALLERY_MIN_VERSION', '1.2.6' );



	require_once( 'functions.php' );



	class Foo_Video {

		/**

		 * Wire up everything we need to run the extension

		 */

		function __construct() {



			if ( foogallery_video_plugin_already_initialized() ) {

				//Don't run twice!

				return;

			}



			if ( foogallery_video_plugin_can_run() ) {

				add_filter( 'foogallery_gallery_templates', array( $this, 'add_template' ) );



				add_filter( 'foogallery_gallery_templates_files', array( $this, 'register_myself' ) );

				add_filter( 'foogallery_located_template-foo_video', array( $this, 'enqueue_dependencies' ) );



				//setup script includes

				add_filter( 'wp_enqueue_scripts', array( $this, 'enqueue_dependencies' ) );

				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_stylescripts' ) );



				//add attachment custom fields

				//add_filter( 'foogallery_attachment_custom_fields', array( $this, 'attachment_custom_fields' ) );



				//add extra fields to all templates

				add_filter( 'foogallery_override_gallery_template_fields', array( $this, 'all_template_fields' ) );



				// add aditional templates

				add_action( 'admin_footer', array( $this, 'add_media_templates' ) );



				$this->load_playlist_importers();



				//add atts to front-end anchor

				add_filter( 'foogallery_attachment_html_link_attributes', array( $this, 'alter_video_link_attributes' ), 24, 3 );



				// do search handler

				add_action( 'wp_ajax_foo_video_search', array( $this, 'video_search' ) );



				//add video icon class to galleries

				add_filter( 'foogallery_build_class_attribute', array( $this, 'foogallery_build_class_attribute' ) );



				//intercept gallery save and calculate how many videos are in the gallery

				add_action( 'foogallery_after_save_gallery', array( $this, 'calculate_video_count' ) );



				//change the image count to include videos if they are present in the gallery

				add_filter( 'foogallery_image_count', array( $this, 'include_video_count' ), 10, 2 );



				//check if another gallery is using a video and if so, enque our CSS.

				add_action( 'foogallery_foogallery_instance_after_load', array( $this, 'maybe_load_css_in_other_templates' ) );



				//add settings for video

				add_filter( 'foogallery_admin_settings_override', array( $this, 'include_video_settings' ) );

			}



			//init licensing and update checking

			require_once( FOO_VIDEO_PATH . 'includes/foolic.php' );

			Foo_Video_Licensing_Updates::get_instance();

		}





		/**

		*

		*

		*/

		public function video_search(){

			if( empty( $_POST['q'] ) ){

				exit;

			}

			$page = 1;

			$type = 'youtube';

			$query_str = trim( $_POST['q'] );

			if( !empty( $_POST['vidpage'] ) ){

				$page = (int) $_POST['vidpage'];

			}

			if( !empty( $_POST['type'] ) && in_array( $_POST['type'], array( 'youtube', 'vimeo' ) ) ){

				$type = (string) $_POST['type'];

			}



			if( $type == 'youtube' ){

				//check if videoID

				if( 0 === strpos( $query_str, 'PL' ) ) {

					$query_str = add_query_arg( 'list', $query_str, 'https://www.youtube.com/playlist' );

				}



				if( false === strpos( $query_str , ' ') && strlen( $query_str ) > 10 ){

					// check if its a URL

					if( $is_url = wp_http_validate_url( $query_str ) ){

						$struct = parse_url( $is_url );

						$query = array();

						if( !empty( $struct['query'] ) ){

							parse_str( $struct['query'], $query );

						}



						if( !empty( $query['list'] ) ){

							$data = wp_remote_get( 'http://www.youtube.com/oembed?url=' . urlencode( $query_str ) );

							if( !is_wp_error( $data ) ){

								$url = 'https://www.youtube.com/list_ajax?style=json&action_get_list=true&list=' . $query['list'];

								$isplaylist = json_decode( wp_remote_retrieve_body( $data ), true );

								$isplaylist['playlist_id'] = $query['list'];

							}

						}

					}

				}

				if( empty( $url ) ){

					$url = 'https://www.youtube.com/search_ajax?style=json&embeddable=1&search_query=' . urlencode( $query_str ) . '&page=' . $page;

				}



			}elseif ( $type == 'vimeo' ) {

				if( $is_url = wp_http_validate_url( $query_str ) ){

					// check album or not

					if ( strpos( $query_str, '/album/' ) || strpos( $query_str, '/user' ) ) {

						$isstream = true;

						if ( strpos( $query_str, '/user' ) ) {

							$url = 'https://player.vimeo.com/hubnut/config/user/' . basename( $query_str );

						} else {

							$url = 'https://player.vimeo.com/hubnut/config/album/' . basename( $query_str );

						}

					//} else if ( ) {

					} else {

						$url = 'https://vimeo.com/api/oembed.json?url=' . urlencode( $query_str );

					}

				}else{

					$vidid = 'https%3A//vimeo.com/' . basename( $query_str );

					$url = 'https://vimeo.com/api/oembed.json?url=' . $vidid;

				}



			}

			$data = wp_remote_get( $url );

			if( is_wp_error( $data ) ){

				echo '<div class="notice error"><p>' . $data->get_error_message() . '</p></div>';

				exit;

			}

			$results = json_decode( wp_remote_retrieve_body( $data ), true );



			if( empty( $results['stream'] ) && empty( $results['provider_name'] ) && empty( $results['video'] ) && empty( $results['video_id'] ) ){

				if( $type == 'youtube' ){

					echo '<div class="notice error"><p>' . sprintf( __('No videos found matching "%s"', 'foo-video'), '<strong>' . stripslashes_deep( $query_str ) . '</strong>' ) . '</p></div>';

				}

				if( $type == 'vimeo' ){

					echo '<div class="notice error"><p>' . __('Invalid ID or URL', 'foo-video') . '</p></div>';

				}

				exit;

			}

			// set nonce

			wp_nonce_field( 'foo_video_nonce', 'foo_video_nonce' );



			if( $type == 'vimeo' ){

				if( empty( $isstream ) ){

					$video = $results;

					include FOO_VIDEO_PATH . 'templates/general-single-result.php';

				}else{

					include FOO_VIDEO_PATH . 'templates/vimeo-playlist-result.php';

					foreach( $results['stream']['clips'] as $index => $video ){

						include FOO_VIDEO_PATH . 'templates/vimeo-result.php';

					}

				}



			}else{



				if( !empty( $isplaylist ) ){

					include FOO_VIDEO_PATH . 'templates/youtube-playlist-result.php';

				}

				if( !empty( $results['provider_name'] ) ){

					$video = $results;

					include FOO_VIDEO_PATH . 'templates/youtube-playlist-result.php';

				}

				if( !empty( $results['video'] ) ){

					echo '<span id="import-playlist-id" data-loading="' . esc_attr( __('Importing Video(s)', 'foo-video') ) . '"></span>';

					foreach( $results['video'] as $index => $video ){

						include FOO_VIDEO_PATH . 'templates/youtube-result.php';

					}

				}



				if( !empty( $results['hits'] ) && ( ( $index + 1 ) * $page ) < $results['hits'] ){

					echo '<div class="foovideo-loadmore button" data-page="' . ( $page + 1 ) . '">' . __('Load More', 'foo-video') . '</div>';

				}

			}



			exit;

		}



		/**

		 * Register myself so that all associated JS and CSS files can be found and automatically included

		 * @param $extensions

		 *

		 * @return array

		 */

		function register_myself( $extensions ) {

			$extensions[] = __FILE__;

			return $extensions;

		}



		/**

		 * Enqueue admin styles and scripts

		 */

		function enqueue_admin_stylescripts() {

			$screen = get_current_screen();

			if( !is_object( $screen ) || $screen->id != "foogallery" ){

				return;

			}



			$js = FOO_VIDEO_URL . 'js/admin-gallery-foo_video.js';

			wp_enqueue_script( 'foo_video_admin', $js, array( 'jquery' ), FOO_VIDEO_VERSION );



			$css = FOO_VIDEO_URL . 'css/gallery-foo_video-admin.css';

			wp_enqueue_style( 'foo_video_admin', $css, array(), FOO_VIDEO_VERSION );

		}



		/**

		 * Enqueue any script or stylesheet file dependencies that your gallery template relies on

		 */

		function enqueue_dependencies() {

			$css = FOO_VIDEO_URL . 'css/gallery-foo_video.css';

			wp_enqueue_style( 'foo_video', $css, array(), FOO_VIDEO_VERSION );

		}



		/**

		 * Add the video gallery template to the list of templates available

		 * @param $gallery_templates

		 *

		 * @return array

		 */

		function add_template( $gallery_templates ) {



			$gallery_templates[] = array(

				'slug'        => 'videoslider',

				'name'        => __( 'Video Slider', 'foo-video'),

				'admin_js'	  => FOO_VIDEO_URL . 'js/admin-gallery-videoslider.js',

				'fields'	  => array(

					array(

						'id'      => 'layout',

						'title'   => __('Layout', 'foo-video'),

						'desc'    => __( 'You can choose either a horizontal or vertical layout for your responsive video gallery.', 'foogallery' ),

						'type'    => 'icon',

						'default' => 'rvs-vertical',

						'choices' => array(

							'rvs-vertical' => array( 'label' => __( 'Vertical' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-layout-vertical.png' ),

							'rvs-horizontal' => array( 'label' => __( 'Horizontal' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-layout-horizontal.png' )

						),

					),

					array(

						'id'      => 'theme',

						'title'   => __('Theme', 'foo-video'),

						'default' => '',

						'type'    => 'radio',

						'spacer'  => '<span class="spacer"></span>',

						'choices' => array(

							'' => __( 'Dark', 'foo-video' ),

							'rvs-light' => __( 'Light', 'foo-video' ),

							'rvs-custom' => __( 'Custom', 'foo-video' )

						)

					),

					array(

						'id'      => 'theme_custom_bgcolor',

						'title'   => __('Background Color', 'foo-video'),

						'section' => __( 'Custom Theme Colors', 'foo-video' ),

						'type'    => 'colorpicker',

						'default' => '#000000',

						'opacity' => true

					),

					array(

						'id'      => 'theme_custom_textcolor',

						'title'   => __('Text Color', 'foo-video'),

						'section' => __( 'Custom Theme Colors', 'foo-video' ),

						'type'    => 'colorpicker',

						'default' => '#ffffff',

						'opacity' => true

					),

					array(

						'id'      => 'theme_custom_hovercolor',

						'title'   => __('Hover BG Color', 'foo-video'),

						'section' => __( 'Custom Theme Colors', 'foo-video' ),

						'type'    => 'colorpicker',

						'default' => '#222222',

						'opacity' => true

					),

					array(

						'id'      => 'theme_custom_dividercolor',

						'title'   => __('Divider Color', 'foo-video'),

						'section' => __( 'Custom Theme Colors', 'foo-video' ),

						'type'    => 'colorpicker',

						'default' => '#2e2e2e',

						'opacity' => true

					),

					array(

						'id'      => 'highlight',

						'title'   => __('Highlight', 'foo-video'),

						'desc'    => __('The color that is used to highlight the selected video.', 'foo-video'),

						'default' => '',

						'type'    => 'radio',

						'spacer'  => '<span class="spacer"></span>',

						'choices' => array(

							'' => __( 'Purple', 'foo-video' ),

							'rvs-blue-highlight' => __( 'Blue', 'foo-video' ),

							'rvs-green-highlight' => __( 'Green', 'foo-video' ),

							'rvs-orange-highlight' => __( 'Orange', 'foo-video' ),

							'rvs-red-highlight' => __( 'Red', 'foo-video' ),

							'rvs-custom-highlight' => __( 'Custom', 'foo-video' )

						)

					),

					array(

						'id'      => 'highlight_custom_bgcolor',

						'title'   => __('Background Color', 'foo-video'),

						'section' => __( 'Custom Highlight Colors', 'foo-video' ),

						'type'    => 'colorpicker',

						'default' => '#7816d6',

						'opacity' => true

					),

					array(

						'id'      => 'highlight_custom_textcolor',

						'title'   => __('Text Color', 'foo-video'),

						'section' => __( 'Custom Highlight Colors', 'foo-video' ),

						'type'    => 'colorpicker',

						'default' => 'rgba(255, 255, 255, 1)',

						'opacity' => true

					),

					array(

						'id'      => 'viewport',

						'title'   => __('Use Viewport Width', 'foo-video'),

						'desc'    => __('Use the viewport width instead of the parent element width.', 'foo-video'),

						'default' => '',

						'type'    => 'radio',

						'spacer'  => '<span class="spacer"></span>',

						'choices' => array(

							'' => __( 'No', 'foo-video' ),

							'rvs-use-viewport' => __( 'Yes', 'foo-video' )

						)

					),

				)

			);



			return $gallery_templates;

		}



		/**

		 * Add video specific custom fields.

		 *

		 * @uses "foogallery_attachment_custom_fields" filter

		 * @param array $fields

		 * @return array

		 */

		public function attachment_custom_fields( $fields ) {

			$fields[ 'foovideo_video_id' ] = array(

				'label'       =>  __( 'Video ID', 'foo-video' ),

				'input'       => 'text',

				'helps'       => __( 'LINK TO HOW TO FIND ID!!', 'foo-video' ),

				'exclusions'  => array( 'audio', 'video' ),

			);



			$fields[ 'foovideo_video_type' ] = array(

				'label'       =>   __( 'Video Source', 'foo-video' ),

				'input'       => 'select',

				'options' => array(

					'youtube' => __( 'YouTube', 'foo-video' ),

					'vimeo' => __( 'Vimeo', 'foo-video' )

				),

				'exclusions'  => array( 'audio', 'video' ),

			);



			$fields[ 'foovideo_video_description' ] = array(

				'label'       =>  __( 'Video Description',  'foo-video' ),

				'input'       => 'text',

				'helps'       => __( 'Video description.', 'foo-video' ),

				'exclusions'  => array( 'audio', 'video' ),

			);



			return $fields;



		}



		/**

		 * Add fields to all galleries.

		 *

		 * @uses "foogallery_override_gallery_template_fields"

		 * @param $fields

		 *

		 * @return mixed

		 */

		public function all_template_fields( $fields ) {

			$fields[] = array(

				'id'      => 'foovideo_video_overlay',

				'section' => __( 'Video', 'foo-video' ),

				'title'   => __( 'Video Hover Icon', 'foo-video' ),

				'type'    => 'icon',

				'default' => 'video-icon-default',

				'choices' => array(

					'video-icon-default' => array( 'label' => __( 'Default Icon' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-icon-default.png' ),

					'video-icon-1' => array( 'label' => __( 'Icon 1' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-icon-1.png' ),

					'video-icon-2' => array( 'label' => __( 'Icon 2' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-icon-2.png' ),

					'video-icon-3' => array( 'label' => __( 'Icon 3' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-icon-3.png' ),

					'video-icon-4' => array( 'label' => __( 'Icon 4' , 'foo-video' ), 'img' => FOO_VIDEO_URL . 'assets/video-icon-4.png' )

				)

			);



			$fields[] = array(

				'id'      => 'foovideo_sticky_icon',

				'section' => __( 'Video', 'foo-video' ),

				'title'   => __( 'Sticky Video Icon', 'foo-video' ),

				'desc'    => __( 'Always show the video icon for videos in the gallery, and not only when you hover.', 'foo-video' ),

				'type'    => 'radio',

				'default' => 'no',

				'spacer'  => '<span class="spacer"></span>',

				'choices' => array(

					'video-icon-sticky' => __( 'Yes', 'foo-video' ),

					'' => __( 'No', 'foo-video' )

				)

			);



			$fields[] = array(

				'id'      => 'foovideo_video_size',

				'section' => __( 'Video', 'foo-video' ),

				'title'   => __( 'Video Size', 'foo-video' ),

				'desc'    => __( 'The default video size when opening videos in FooBox. This can be overridden on each individual video by editing the attachment info, and changing the Data Width and Data Height properties.', 'foo-video' ),

				'type'    => 'select',

				'default' => '640x360',

				'choices' => array(

					'640x360' => __( '640 x 360', 'foo-video' ),

					'854x480' => __( '854 x 480', 'foo-video' ),

					'960x540' => __( '960 x 540', 'foo-video' ),

					'1024x576' => __( '1024 x 576', 'foo-video' ),

					'1280x720' => __( '1280 x 720 (HD)', 'foo-video' ),

					'1366x768' => __( '1366 x 768', 'foo-video' ),

					'1600x900' => __( '1600 x 900', 'foo-video' ),

					'1920x1080' => __( '1920 x 1080 (Full HD)', 'foo-video' )

				)

			);



			$fields[] = array(

				'id'      => 'foovideo_autoplay',

				'section' => __( 'Video', 'foo-video' ),

				'title'   => __( 'Autoplay', 'foo-video' ),

				'desc'    => __( 'Try to autoplay the video when opened in a lightbox. This will only work with videos hosted on Youtube or Vimeo.', 'foo-video' ),

				'type'    => 'radio',

				'default' => 'yes',

				'spacer'  => '<span class="spacer"></span>',

				'choices' => array(

					'yes' => __( 'Yes', 'foo-video' ),

					'no' => __( 'No', 'foo-video' )

				)

			);



			return $fields;

		}



		/**

		 * @uses "foogallery_attachment_html_link_attributes" filter

		 *

		 * @param $attr

		 * @param $args

		 * @param object|FooGalleryAttachment $object

		 */

		public function alter_video_link_attributes( $attr, $args, $object ) {



			$video_info = get_post_meta( $object->ID, FOO_VIDEO_POST_META, true );

			if ( $video_info && isset( $video_info['id'] ) ) {

				$video_id = $video_info['id'];

				$type = $video_info['type'];

				$url = foogallery_video_get_video_url_from_attachment( $object );



				if ( ! isset( $attr[ 'class' ] ) ) {

					$attr[ 'class' ] = ' foo-video';

				}else{

					$attr[ 'class' ] .= ' foo-video';

				}



				$lightbox = foogallery_gallery_template_setting( 'lightbox', 'unknown' );



				$attr['href'] = $url;



				//if we have no widths or heights then use video default size

				if ( ! isset( $attr['data-width'] ) ) {

					$size = foogallery_gallery_template_setting( 'foovideo_video_size', '640x360' );

					list( $width, $height ) = explode( 'x', $size );

					$attr['data-width'] = $width;

					$attr['data-height'] = $height;

				}



				if ( class_exists( 'Foobox_Free' ) && ( 'foobox' == $lightbox || 'foobox-free' == $lightbox ) ) {

					//we want to add some JS to the front-end if we are using FooBox Free

					$js = FOO_VIDEO_URL . 'js/foobox.video.min.js';

					wp_enqueue_script( 'foo_video', $js, array('jquery'), FOO_VIDEO_VERSION );

				}



				//if no lightbox is being used then force to open in new tab

				if ( 'unknown' === $lightbox || 'none' === $lightbox ) {

					$attr['target'] = '_blank';

				}

			}



			return $attr;

		}





		public function add_media_templates(){



			$screen = get_current_screen();

			if( !is_object( $screen ) || $screen->id != "foogallery" ){

				return;

			}



			include dirname( __FILE__ ) . '/templates/media-ui.php';



		}



		public function load_playlist_importers() {

			include_once( dirname( __FILE__ ) ) . '/import/class-import-manager.php';

			include_once( dirname( __FILE__ ) ) . '/import/class-import-handler-youtube.php';

			include_once( dirname( __FILE__ ) ) . '/import/class-import-handler-vimeo.php';



			new Foo_Video_Import_Manager();

			new Foo_Video_Import_Handler_YouTube( );

			new Foo_Video_Import_Handler_Vimeo( );

		}



		public function foogallery_build_class_attribute( $classes ) {

			//first determine if the gallery has any videos



			//then get the selected video icon

			$video_hover_icon = foogallery_gallery_template_setting( 'foovideo_video_overlay', 'video-icon-default' );



			//include the video icon class

			$classes[] = $video_hover_icon;



			//get the video icon sticky state

			$video_icon_sticky = foogallery_gallery_template_setting( 'foovideo_sticky_icon', '' );



			//include the video sticky class

			$classes[] = $video_icon_sticky;



			return $classes;

		}



		/**

		 * Load CSS if there are videos

		 *

		 * @uses foogallery_foogallery_instance_after_load

		 *

		 * @param $obj

		 */

		public function maybe_load_css_in_other_templates( $obj ) {

			$ids = $obj->attachment_ids;

			if ( ! empty( $ids ) ) {

				foreach( $ids as $id ) {

					$video_info = get_post_meta( $id, FOO_VIDEO_POST_META, true );

					if ( isset( $video_info['id'] ) && 0 < absint( $video_info[ 'id'] ) ) {

						$css = FOO_VIDEO_URL . 'css/gallery-foo_video.css';

						foogallery_enqueue_style( 'foo_video', $css, array(), FOO_VIDEO_VERSION );

						return;

					}

				}

			}

		}



		public function calculate_video_count($post_id) {

			//calculate the video count

			$video_count = foogallery_video_calculate_gallery_video_count( $post_id );



			//store the video in post meta to save time later

			update_post_meta( $post_id, FOO_VIDEO_POST_META_VIDEO_COUNT, $video_count );

		}



		public function include_video_count( $image_count_text, $gallery ) {

			$count = sizeof( $gallery->attachment_ids );



			$video_count = foogallery_video_get_gallery_video_count( $gallery->ID );



			$image_count = $count - $video_count;



			return foogallery_video_gallery_image_count_text( $count, $image_count, $video_count );

		}



		public function include_video_settings( $settings ) {

			$settings['settings'][] = array(

				'id'      => 'language_video_count_none_text',

				'title'   => __( 'Video Count None Text', 'foo-video' ),

				'type'    => 'text',

				'default' => __( 'No images or videos', 'foo-video' ),

				'tab'     => 'language'

			);



			$settings['settings'][] = array(

				'id'      => 'language_video_count_single_text',

				'title'   => __( 'Video Count Single Text', 'foo-video' ),

				'type'    => 'text',

				'default' => __( '1 video', 'foo-video' ),

				'tab'     => 'language'

			);



			$settings['settings'][] = array(

				'id'      => 'language_video_count_plural_text',

				'title'   => __( 'Video Count Many Text', 'foo-video' ),

				'type'    => 'text',

				'default' => __( '%s videos', 'foo-video' ),

				'tab'     => 'language'

			);



			return $settings;

		}

	}

}

