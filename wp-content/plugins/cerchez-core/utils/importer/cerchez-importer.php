<?php

/* This class provides the capability to import demo content as well as theme options, widgets and menus */
class Cerchez_Theme_Importer {
	public $theme_versions = array();
	public $file_theme_options;
	public $file_theme_options_name = 'theme-options.txt';
	public $file_widgets;
	public $file_widgets_name = 'widgets.json';
	public $file_data_xml;
	public $file_data_xml_name = 'content.xml';
	public $flag_as_imported = array();
	public $demo_files_url = '';

	public function __construct() {
		$this->file_theme_options = $this->demo_files_path . $this->file_theme_options_name;
		$this->file_widgets = $this->demo_files_path . $this->file_widgets_name;
		$this->file_data_xml = $this->demo_files_path . $this->file_data_xml_name;
		add_action('admin_menu', array($this, 'add_admin'));
	}

	public function add_admin() {
		add_theme_page(__('Import Demo Data', 'cerchez-core'), __('Import Demo Data', 'cerchez-core'), 'edit_theme_options', 'importdemo', array($this, 'demo_installer'));
	}

	public function demo_installer() {
?>
		<div class="wrap">
			<h2><?php _e('Import Demo Data', 'cerchez-core'); ?></h2>
<?php
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
	if ('import-demo-data' != $action) : ?>
			<div style="margin-bottom:20px;">
				<p><?php _e('Before you begin, make sure all the required/recommended plugins are activated.', 'cerchez-core'); ?></p>
				<p><?php _e('Importing the demo data is the easiest way to setup your theme and quickly make it look like the preview (instead of creating content from scratch). There are a couple of things you should know about this process:', 'cerchez-core'); ?></p>
				<ul style="padding-left:15px;list-style-position:inside;list-style-type:square;">
					<li><?php _e('No personal WordPress settings will be modified;', 'cerchez-core'); ?></li>
					<li><?php _e('No existing posts, pages, categories, tags, images, custom post types will be deleted or modified;', 'cerchez-core'); ?></li>
					<li><?php _e('The import option will only be available once, so wait until it properly finishes - it can take a couple of minutes, so please be patient.', 'cerchez-core'); ?></li>
				</ul>
			</div>
			<form method="post" id="cerchez-import-form">
<?php if (property_exists($this,'theme_versions') && count($this->theme_versions) > 0) : ?>
				<p><?php _e('Please select your prefered demo version:', 'cerchez-core'); ?></p>
<?php $select_first = false;
		foreach ($this->theme_versions as $key => $value) : ?>
				<label for="version_<?php echo $key; ?>"<?php if ( ! $select_first) echo ' class="selected"'; ?>>
					<input type="radio" name="version" id="version_<?php echo $key; ?>" value="<?php echo $key; ?>"<?php if ( ! $select_first) { echo ' checked'; $select_first = true; } ?> />
					<img src="<?php echo $this->demo_files_url . $key . '/preview.png'; ?>" width="155" height="115" alt="<?php echo $value; ?>"><span><?php echo $value; ?></span>
				</label>
<?php endforeach; ?>
				<style type="text/css">
					#cerchez-import-form label { float: left; width: 155px; margin: 0 20px 20px 0; position: relative; }
					#cerchez-import-form label input { visibility: hidden; position: absolute; }
					#cerchez-import-form label img { border-radius: 2px 2px 0 0; }
					#cerchez-import-form label img, #cerchez-import-form label span { display: block; border: 3px solid #e4e4e4; cursor: pointer; margin: 0; }
					#cerchez-import-form label span { width: 145px; text-align: center; padding: 0 5px 6px; background-color: #e4e4e4; cursor: pointer; border-radius: 0 0 2px 2px; }
					#cerchez-import-form label.selected img, #cerchez-import-form label.selected span { border-color: #222; }
					#cerchez-import-form label.selected img, #cerchez-import-form label.selected span, #cerchez-import-form label input:checked + img { border-color: #222; }
					#cerchez-import-form label.selected span { background-color: #222; color: #fff; }
					#cerchez-import-form label input:checked + img + span { background-color: #222; color: #fff; }
					.no-js #cerchez-import-form label { display: block; float: none; width: auto; margin: 0 0 20px; }
					.no-js #cerchez-import-form label input { visibility: visible; position: static; }
					.no-js #cerchez-import-form label img { display: none; }
					html body.no-js #cerchez-import-form label span { display: inline; background-color: inherit; color: inherit; border: 0; width: auto; text-align: inherit; padding: 0; }
				</style>
<?php endif; ?>
				<input type="hidden" name="action" value="import-demo-data" />
				<input type="hidden" name="demononce" value="<?php echo wp_create_nonce('cerchez-demo-code'); ?>" />
				<div class="clear"></div>
				<input name="reset" class="button button-primary button-hero" type="submit" value="<?php esc_attr_e('Import Demo Data', 'cerchez-core'); ?>" style="float:left" />
				<span class="spinner" style="float:left;margin-top:1.04em"></span>
				<div class="clear"></div>
			</form>
			<script>
				jQuery(document).on('submit', "#cerchez-import-form", function(e) {
					jQuery('#cerchez-import-form .button').attr('disabled', 'disabled');
					jQuery('#cerchez-import-form .spinner').addClass('is-active').fadeIn();
				});
				jQuery('#cerchez-import-form label').click(function(e) {
					jQuery('#cerchez-import-form label').not(this).removeClass('selected');
					jQuery(this).addClass('selected');
				});
			</script>
<?php endif; ?>
		</div>
<?php
		if ('import-demo-data' == $action && check_admin_referer('cerchez-demo-code' , 'demononce')) {
			if (isset($_REQUEST['version'])) {
				$this->demo_files_path = $this->demo_files_path . $_REQUEST['version'] . DIRECTORY_SEPARATOR;
				$this->file_theme_options = $this->demo_files_path . $this->file_theme_options_name;
				$this->file_widgets = $this->demo_files_path . $this->file_widgets_name;
				$this->file_data_xml = $this->demo_files_path . $this->file_data_xml_name;
			}
			$this->import_options_data($this->file_theme_options);
			$this->import_widgets_data($this->file_widgets);
			$this->import_demo_xml_data($this->file_data_xml);
			$this->import_other_theme_data();
			update_option('import_theme_demo_data_check', true);
		}
	}

	public function add_widget_to_sidebar($sidebar_slug, $widget_slug, $count_mod, $widget_settings = array()) {
		$sidebars_widgets = get_option('sidebars_widgets');
		if( ! isset($sidebars_widgets[$sidebar_slug])) {
			$sidebars_widgets[$sidebar_slug] = array('_multiwidget' => 1);
		}
		$newWidget = get_option('widget_' . $widget_slug);
		if( ! is_array($newWidget)) {
			$newWidget = array();
		}
		$count = count($newWidget) + 1 + $count_mod;
		$sidebars_widgets[$sidebar_slug][] = $widget_slug . '-' . $count;
		$newWidget[$count] = $widget_settings;
		update_option('sidebars_widgets', $sidebars_widgets);
		update_option('widget_'.$widget_slug, $newWidget);
	}

	public function import_demo_xml_data($file) {
		if ( ! defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		require_once ABSPATH . 'wp-admin/includes/import.php';
		$importer_error = false;
		if ( ! class_exists('WP_Importer') ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
			if (file_exists($class_wp_importer)) {
				require_once($class_wp_importer);
			} else {
				$importer_error = true;
			}
		}
		if ( ! class_exists('Cerchez_WP_Import') ) {
			$class_wp_import = dirname( __FILE__ ) .'/wordpress-importer.php';
			if ( file_exists( $class_wp_import ) ) {
				require_once($class_wp_import);
			} else {
				$importer_error = true;
			}
		}
		if ($importer_error) {
			wp_die( __( 'Error on import.', 'cerchez-core' ), '', array( 'back_link' => true ) );
		} else {
			if ( ! is_file( $file )) {
				echo '<p><strong>' . __( 'Sorry, there has been an error.', 'cerchez-core' ) . '</strong><br />';
				echo __( 'The XML file containing the dummy content is not available or could not be read.', 'cerchez-core' ) . '</p>';
			} else {
				echo '<p>' . __('Importing post data...', 'cerchez-core') . '</p>';
				$wp_import = new Cerchez_WP_Import();
				$wp_import->fetch_attachments = true;
				$wp_import->import( $file );
			}
		}
	}

	public function import_options_data( $file ) {
		if ( ! file_exists( $file ) ) {
			wp_die( __( 'Theme options Import file could not be found. Please try again.', 'cerchez-core' ), '', array( 'back_link' => true ) );
		}
		$data = file_get_contents($file);
		$data = unserialize(base64_decode(/* 100% safe and escaped, used to disable user from seeing the exported/imported options */$data));
		if ( empty($data) || ! is_array($data) ) {
			wp_die( __( 'Theme options import data could not be read. Please try a different file.', 'cerchez-core' ), '', array( 'back_link' => true ) );
		}

		$data = apply_filters('cerchez_theme_import_options', $data);
		foreach ( $data as $k => $v ) {
			if (is_array($v)) {
				foreach ($v as $key => $val) {
					if ($key != $k && $v[$key] == $val) {
						set_theme_mod($k, $v);
						break;
					}
				}
			} else {
				set_theme_mod($k, $v);
			} 
		}

		echo '<p>' . __('Theme Options imported successfully.', 'cerchez-core') . '</p>';
	}

	public function import_other_theme_data() { }

	function available_widgets() {
		global $wp_registered_widget_controls;
		$widget_controls = $wp_registered_widget_controls;
		$available_widgets = array();
		foreach ( $widget_controls as $widget ) {
			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) {
				$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
				$available_widgets[$widget['id_base']]['name'] = $widget['name'];
			}
		}

		return apply_filters('cerchez_theme_import_available_widgets', $available_widgets);
	}

	function import_widgets_data( $file ) {
		if ( ! file_exists($file) ) {
			wp_die( __( 'Widget import file could not be found.', 'cerchez-core' ), '', array( 'back_link' => true ) );
		}
		$data = file_get_contents($file);
		$data = json_decode($data);
		$this->widget_import_results = $this->import_widgets($data);
	}

	public function import_widgets( $data ) {
		global $wp_registered_sidebars;
		if ( empty( $data ) || ! is_object( $data ) ) {
			wp_die( __( 'Widget import data could not be read.', 'cerchez-core' ), '', array( 'back_link' => true ) );
		}
		$data = apply_filters( 'cerchez_theme_import_widget_data', $data );
		$available_widgets = $this->available_widgets();
		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {
			$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
		}
		$results = array();

		foreach ( $data as $sidebar_id => $widgets ) {
			if ( 'wp_inactive_widgets' == $sidebar_id ) continue;

			if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
				$sidebar_available = true;
				$use_sidebar_id = $sidebar_id;
				$sidebar_message_type = 'success';
				$sidebar_message = '';
			} else {
				$sidebar_available = false;
				$use_sidebar_id = 'wp_inactive_widgets';
				$sidebar_message_type = 'error';
				$sidebar_message = __('Sidebar does not exist in theme (using Inactive)', 'cerchez-core');
			}

			$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id;
			$results[$sidebar_id]['message_type'] = $sidebar_message_type;
			$results[$sidebar_id]['message'] = $sidebar_message;
			$results[$sidebar_id]['widgets'] = array();

			foreach ( $widgets as $widget_instance_id => $widget ) {
				$fail = false;
				$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
				$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );
				if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
					$fail = true;
					$widget_message_type = 'error';
					$widget_message = __('Site does not support widget', 'cerchez-core');
				}

				$widget = apply_filters('cerchez_theme_import_widget_settings', $widget);
				if ( ! $fail && isset( $widget_instances[$id_base] ) ) {
					$sidebars_widgets = get_option( 'sidebars_widgets' );
					$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array();
					$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
					foreach ( $single_widget_instances as $check_id => $check_widget ) {
						if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {
							$fail = true;
							$widget_message_type = 'warning';
							$widget_message = __( 'Widget already exists', 'cerchez-core' );
							break;
						}
					}
				}

				if ( ! $fail ) {
					$single_widget_instances = get_option( 'widget_' . $id_base );
					$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 );
					$single_widget_instances[] = (array) $widget;
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					update_option( 'widget_' . $id_base, $single_widget_instances );

					$sidebars_widgets = get_option( 'sidebars_widgets' ); 
					$new_instance_id = $id_base . '-' . $new_instance_id_number;
					$sidebars_widgets[$use_sidebar_id][] = $new_instance_id;
					update_option( 'sidebars_widgets', $sidebars_widgets );

					if ( $sidebar_available ) {
						$widget_message_type = 'success';
						$widget_message = __( 'Imported', 'cerchez-core' );
					} else {
						$widget_message_type = 'warning';
						$widget_message = __( 'Imported to Inactive', 'cerchez-core' );
					}
				}

				$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base;
				$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : __( 'No Title', 'cerchez-core' );
				$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
				$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;
			}
		}

		do_action('cerchez_theme_import_widget_after_import');

		echo '<p>' . __('Widgets imported successfully.', 'cerchez-core') . '</p>';

		return apply_filters('cerchez_theme_import_widget_results', $results);
	}

}
