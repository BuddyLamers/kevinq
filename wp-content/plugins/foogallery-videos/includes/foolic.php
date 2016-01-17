<?php

/**

 * Foo_Video_Licensing_Updates class to init licensing and plugin updates with FooPlugins.com

 *

 * @author    Brad Vincent

 * @version   1

 */



if (!class_exists('Foo_Video_Licensing_Updates')) {



	class Foo_Video_Licensing_Updates {



		/**

		 * Instance of this class.

		 *

		 * @since    1.0.0

		 *

		 * @var      object

		 */

		protected static $instance = null;



		private function __construct() {



			if ( is_admin() ) {

				//Settings page

				add_filter( 'foogallery_admin_settings_override', array( $this, 'create_settings' ) );

				add_action( FOOGALLERY_SLUG . '_admin_settings_custom_type_render_setting', array( $this, 'license_setting' ) );



				//FooGallery version check

				add_action( 'admin_notices', array( $this, 'foogallery_version_check' ) );



				//required files

				require_once( FOO_VIDEO_PATH . 'includes/foolic_update_checker.php' );

				require_once( FOO_VIDEO_PATH . 'includes/foolic_validation.php' );



				$license_key = get_site_option( FOO_VIDEO_SLUG . '_licensekey' );



				//initialize plugin update checks with fooplugins.com

				new foolic_update_checker_v1_6(

					FOO_VIDEO_FILE, //the plugin file

					FOO_VIDEO_UPDATE_URL, //the URL to check for updates

					FOO_VIDEO_SLUG, //the plugin slug

					$license_key //the stored license key

				);



				//initialize license key validation with fooplugins.com

				new foolic_validation_v1_4(

					FOO_VIDEO_UPDATE_URL, //the URL to validate

					FOO_VIDEO_SLUG

				);



				add_filter( 'foolic_validation_include_css-' . FOO_VIDEO_SLUG, array( $this, 'include_foolic_files' ) );

				add_filter( 'foolic_validation_include_js-' . FOO_VIDEO_SLUG, array( $this, 'include_foolic_files' ) );

			}

		}



		function create_settings( $settings ) {



			$settings['settings'][] = array(

				'id'           => 'foo-video-license',

				'title'        => __( 'FooVideo License Key', 'foo-video' ),

				'desc'         => __( 'The license key is used to access automatic updates and support for the FooVideo plugin.', 'foo-video' ),

				'type'         => 'license',

				'tab'          => 'extensions',

				'setting_name' => 'foo-video_licensekey',

				'update_url'   => FOO_VIDEO_UPDATE_URL

			);



			return $settings;

		}



		function license_setting( $args ) {

			if ( 'license' === $args['type'] ) {

				$data = apply_filters( 'foolic_get_validation_data-' . FOO_VIDEO_SLUG, false );

				if ($data === false) return;

				echo $data['html'];

			}

		}



		function foogallery_version_check() {

			if ( current_user_can( 'activate_plugins' ) &&

			     version_compare( FOOGALLERY_VERSION, FOO_VIDEO_FOOGALLERY_MIN_VERSION ) < 0 ) { ?>

				<div class="error">

				<h3><?php _e('FooVideo Extension Error', 'foo-video'); ?></h3>

				<p><?php printf( __('The FooVideo extension plugin for FooGallery requires at least version %s of FooGallery to function correctly. Please update to the latest version of FooGallery!', 'foo-video'), FOO_VIDEO_FOOGALLERY_MIN_VERSION ); ?></p>

				</div><?php

			}

		}



		//make sure the foo license validation CSS & JS are included on the correct page

		function include_foolic_files($screen) {

			return $screen->id === 'foogallery_page_foogallery-settings';

		}



		/**

		 * Return an instance of this class.

		 *

		 * @since     1.0.0

		 * @return    object    A single instance of this class.

		 */

		public static function get_instance() {



			// If the single instance hasn't been set, set it now.

			if ( null == self::$instance ) {

				self::$instance = new self();

			} // end if



			return self::$instance;



		} // end get_instance

	}

}