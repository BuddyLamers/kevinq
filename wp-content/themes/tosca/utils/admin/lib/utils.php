<?php

/**
 * Filter URLs from uploaded media fields and replaces them with keywords.
 * This is to keep from storing the site URL in the database to make
 * migrations easier.
 */
function of_filter_save_media_upload($data) {
	if ( ! is_array($data)) return $data;

	foreach ($data as $key => $value) {
		if (is_array($value) && isset($value['url'])) {
			$data[$key]['url'] = str_replace(
				array( site_url('', 'http'), site_url('', 'https') ),
				array('[s_url]', '[ss_url]'),
				$value['url']
			);
		}
	}
	return $data;
}
add_filter('of_options_before_save', 'of_filter_save_media_upload');

/**
 * Filter URLs from uploaded media fields and replaces the site URL keywords
 * with the actual site URL.
 */
function of_filter_load_media_upload($data) {
	if ( ! is_array($data)) return $data;

	foreach ($data as $key => $value) {
		if (is_array($value) && isset($value['url'])) {
			$data[$key]['url'] = str_replace(
				array('[s_url]', '[ss_url]'),
				array( site_url('', 'http'), site_url('', 'https') ),
				$value['url']
			);
		}
	}
	return $data;
}
add_filter('of_options_after_load', 'of_filter_load_media_upload');

/* Admin Init */
function optionsframework_admin_init() {
	global $of_options, $options_machine, $theme_options;
	if (!isset($options_machine)) $options_machine = new Options_Machine($of_options);
	do_action('optionsframework_admin_init_before', array(
		'of_options' => $of_options,
		'options_machine' => $options_machine,
		'smof_data' => $theme_options
	));
	if (empty($theme_options['smof_init'])) {
		of_save_options($options_machine->Defaults);
		of_save_options(date('r'), 'smof_init');
		$theme_options = of_get_options();
		$options_machine = new Options_Machine($of_options);
	}
	do_action('optionsframework_admin_init_after', array(
		'of_options' => $of_options,
		'options_machine' => $options_machine,
		'smof_data' => $theme_options
	));
}

/* Create Options page */
function optionsframework_add_admin() {
	$of_page = add_theme_page(esc_html__('Theme Options', 'tosca'), esc_html__('Theme Options', 'tosca'), 'edit_theme_options', 'themeoptions', 'optionsframework_options_page');
	add_action("admin_print_scripts-$of_page", 'of_load_only');
	add_action("admin_print_styles-$of_page",'of_style_only');
}
function of_style_only() {
	wp_enqueue_style('admin-style', THEME_ADMIN_DIR . 'assets/theme-options.css');
	wp_enqueue_style('wp-color-picker');
	do_action('of_style_only_after');
}
function of_load_only() {
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_script('theme-options', THEME_ADMIN_DIR .'assets/theme-options.js', array('jquery'));
	wp_enqueue_script('wp-color-picker');
	if ( function_exists('wp_enqueue_media') ) {
		wp_enqueue_media();
	}
	do_action('of_load_only_after');
}

/* Build Options page */
function optionsframework_options_page() {
	global $options_machine;
?>

<div id="options_panel" class="wrap">
	<div id="of-popup-save" class="of-save-popup"><?php esc_html_e('Options Updated', 'tosca'); ?></div>
	<div id="of-popup-reset" class="of-save-popup"><?php esc_html_e('Options Reset', 'tosca'); ?></div>
	<div id="of-popup-fail" class="of-save-popup"><div class="of-save-fail"><?php esc_html_e('Error!', 'tosca'); ?></div></div>
	<input type="hidden" id="reset" value="<?php if (isset($_REQUEST['reset'])) echo $_REQUEST['reset']; ?>" />
	<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />
	<form id="of_form" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
		<div id="header"><div id="js-warning"><?php esc_html_e('Warning: This panel will not work properly without JavaScript enabled!', 'tosca'); ?></div></div>
		<div id="info_bar">
			<h3><?php esc_html_e('Theme Options', 'tosca'); ?></h3>
			<button type="button" class="save-options button button-primary"><?php esc_html_e('Save All Changes', 'tosca'); ?></button>
			<span class="spinner"></span>
			<div class="clear"></div>
		</div>
		<div id="main">
			<div id="of-nav">
				<ul><?php echo $options_machine->Menu; // already validated ?></ul>
			</div>
			<div id="content">
				<div class="inner">
					<?php echo $options_machine->Inputs; // already validated ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="save_bar">
			<button type="button" class="save-options button button-primary"><?php esc_html_e('Save All Changes', 'tosca'); ?></button>
			<span class="spinner"></span>
			<button type="button" class="reset-options button button submit-button" ><?php esc_html_e('Reset Options', 'tosca'); ?></button>
			<div class="clear"></div>
		</div>
	</form>
	<div class="clear"></div>
	<div class="temphide">
		<span id="hooks"><?php echo json_encode(of_get_header_classes_array()); ?></span>
		<em id="message-delete-slide"><?php esc_html_e( 'Confirm if you wish to delete this slide?', 'tosca' ); ?></em>
		<em id="message-backup-options"><?php esc_html_e( 'Confirm to backup your current saved options.', 'tosca' ); ?></em>
		<em id="message-backup-restore"><?php esc_html_e( 'Warning: All of your current options will be replaced with the data from your last backup! Proceed?', 'tosca' ); ?></em>
		<em id="message-backup-import"><?php esc_html_e( 'Confirm to import options.', 'tosca' ); ?></em>
		<em id="message-reset-warning"><?php esc_html_e( 'Confirm to reset the options. All settings will be lost and replaced with default settings!', 'tosca' ); ?></em>
		<ul id="sorter-newitem-list">
			<li><div class="slide_header"><strong><?php esc_html_e( 'Slide', 'tosca' ); ?> %1</strong><input type="hidden" class="slide of-input order" name="%2[%1][order]" id="%2_slide_order-%1" value="%1"><a class="slide_edit_button" href="#"><?php esc_html_e( 'Edit', 'tosca' ); ?></a></div><div class="slide_body" style="display:none;"><label><?php esc_html_e( 'Title', 'tosca' ); ?></label><input type="text" class="slide of-input of-slider-title" name="%2[%1][title]" id="%2_%1_slide_title" value=""><label><?php esc_html_e( 'Image URL', 'tosca' ); ?></label><input type="text" class="upload slide of-input" name="%2[%1][url]" id="%2_%1_slide_url" value=""><div class="upload_button_div"><span class="button media_upload_button" id="%2_%1"><?php esc_html_e( 'Upload', 'tosca' ); ?></span><span class="button remove-image hide" id="reset_%2_%1"><?php esc_html_e( 'Remove', 'tosca' ); ?></span></div><div class="screenshot"></div><label><?php esc_html_e( 'Link URL (optional)', 'tosca' ); ?></label><input type="text" class="slide of-input" name="%2[%1][link]" id="%2_%1_slide_link" value=""><label><?php esc_html_e( 'Description (optional)', 'tosca' ); ?></label><textarea class="slide of-input" name="%2[%1][description]" id="%2_%1_slide_description" cols="8" rows="8"></textarea><a class="slide_delete_button" href="#"><?php esc_html_e( 'Delete', 'tosca' ); ?></a><div class="clear"></div></div></li>
		</ul>
	</div>
</div>

<?php
}

/* Ajax Save Options */
function optionsframework_ajax_callback() {
	global $options_machine, $of_options;
	$nonce=$_POST['security'];
	if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1');
	$all = of_get_options();
	$save_type = $_POST['type'];
	if ($save_type == 'upload') {
		$clickedID = $_POST['data']; // acts as the name
		$filename = $_FILES[$clickedID];
		$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']);
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';
		$uploaded_file = wp_handle_upload($filename,$override);
		$upload_tracking[] = $clickedID;
		$upload_image = $all; // preserve current data
		$upload_image[$clickedID] = $uploaded_file['url'];
		of_save_options($upload_image);
		if (!empty($uploaded_file['error'])) {
			esc_html_e('Upload Error: ','tosca') . $uploaded_file['error'];
		} else {
			echo $uploaded_file['url'];
		}
	} elseif ($save_type == 'image_reset') {
		$id = $_POST['data']; // acts as the name
		$delete_image = $all; // preserve rest of data
		$delete_image[$id] = ''; // update array key with empty value
		of_save_options($delete_image ) ;
	} elseif ($save_type == 'backup_options') {
		$backup = $all;
		$backup['backup_log'] = date('r');
		of_save_options($backup, THEME_BACKUPS) ;
		die('1'); 
	} elseif ($save_type == 'restore_options') {
		$theme_options = of_get_options(THEME_BACKUPS);
		of_save_options($theme_options);
		die('1'); 
	} elseif ($save_type == 'import_options') {
		// used only for admins
		$theme_options = unserialize(
			base64_decode(/* 100% safe and escaped, used for hiding options from user when exported/imported options */$_POST['data'])
		);
		of_save_options($theme_options);
		die('1'); 
	} elseif ($save_type == 'save') {
		wp_parse_str(stripslashes($_POST['data']), $theme_options);
		unset($theme_options['security']);
		unset($theme_options['of_save']);
		of_save_options($theme_options);
		die('1');
	} elseif ($save_type == 'reset') {
		of_save_options($options_machine->Defaults);
		die('1');
	}
	die();
}


/* Head Hook */
function of_head() {
	do_action('of_head');
}

/* Add default options upon activation else DB does not exist */
function of_option_setup() {
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);
	if (!of_get_options()) {
		of_save_options($options_machine->Defaults);
	}
}

/* Get header classes */
function of_get_header_classes_array() {
	global $of_options;
	foreach ($of_options as $value) {
		if ($value['type'] == 'heading')
			$hooks[] = str_replace(' ','',strtolower($value['name']));
	}
	return $hooks;
}

/* Get options from the database and process them with the load filter hook. */
function of_get_options($key = null, $data = null) {
	global $theme_options;
	do_action('of_get_options_before', array(
		'key'=>$key,
		'data'=>$data
	));
	if ($key != null) { // Get one specific value
		$data = get_theme_mod($key, $data);
	} else { // Get all values
		$data = get_theme_mods();
	}
	$data = apply_filters('of_options_after_load', $data);
	if ($key == null) {
		$theme_options = $data;
	} else {
		$theme_options[$key] = $data;
	}
	do_action('of_option_setup_before', array(
		'key'=>$key, 'data'=>$data
	));
	return $data;
}

/* Save options to the database after processing them */
function of_save_options($data, $key = null) {
	global $theme_options;
	if (empty($data)) return;

	do_action('of_save_options_before', array(
		'key'=>$key, 'data'=>$data
	));
	$data = apply_filters('of_options_before_save', $data);
	if ($key != null) { // Update one specific value
		if ($key == THEME_BACKUPS) {
			unset($data['smof_init']); // Don't want to change this.
		}
		set_theme_mod($key, $data);
	} else { // Update all values in $data
		foreach ( $data as $k=>$v ) {
			if (!isset($theme_options[$k]) || $theme_options[$k] != $v) { // Only write to the DB when we need to
				set_theme_mod($k, $v);
			} else if (is_array($v)) {
				foreach ($v as $key=>$val) {
					if ($key != $k && $v[$key] == $val) {
						set_theme_mod($k, $v);
						break;
					}
				}
			}
		}
	}
	do_action('of_save_options_after', array(
		'key'=>$key, 'data'=> $data
	));
}

of_get_options();