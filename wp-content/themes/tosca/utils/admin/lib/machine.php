<?php

class Options_Machine {

	function __construct($options) {
		$return = $this->optionsframework_machine($options);
		$this->Inputs = $return[0];
		$this->Menu = $return[1];
		$this->Defaults = $return[2];
	}

	/* Sanitize & returns default option values if don't exist */
	static function sanitize_option( $value ) {
		$defaults = array(
			"name" => "",
			"desc" => "",
			"id" => "",
			"std" => "",
			"mod" => "",
			"type" => ""
		);
		$value = wp_parse_args( $value, $defaults );
		return $value;
	}

	/* Process options data and build option fields */
	public static function optionsframework_machine($options) {
		global $theme_options;
		if (empty($options)) return;
		if (empty($theme_options)) $theme_options = of_get_options();
		$data = $theme_options;

		$defaults = array();   
		$counter = 0;
		$menu = '';
		$output = '';
		$update_data = false;

		do_action('optionsframework_machine_before', array('options' => $options, 'smof_data' => $theme_options));

		foreach ($options as $value) {
			if ($value['type'] != "heading") $value = self::sanitize_option($value);
			$counter++;
			$val = '';

			/* create array of defaults */
			if ($value['type'] == 'multicheck') {
				if (is_array($value['std'])) {
					foreach($value['std'] as $i=>$key) {
						$defaults[$value['id']][$key] = true;
					}
				} else {
						$defaults[$value['id']][$value['std']] = true;
				}
			} else {
				if (isset($value['id'])) $defaults[$value['id']] = $value['std'];
			}

			/* condition start */
			if (!empty($theme_options) || !empty($data)) {
				if (array_key_exists('id', $value) && !isset($theme_options[$value['id']])) {
					$theme_options[$value['id']] = $value['std'];
					if ($value['type'] == "checkbox" && $value['std'] == 0) {
						$theme_options[$value['id']] = 0;
					} else {
						$update_data = true;
					}
				}

			/* start heading */
			if ( $value['type'] != "heading" ) {
				$class = '';
				if (isset( $value['class'] )) {
					$class = $value['class'];
				}

				// hide items in checkbox group
				$fold = '';
				if (array_key_exists('fold', $value) && isset($theme_options[$value['fold']])) {
					$fold_value = false;
					if (is_array($theme_options[$value['fold']])) {
						$image = $theme_options[$value['fold']];
						if ($image && ! empty ($image['url'])) {
							$fold_value = true;
						}
					} else if ($theme_options[$value['fold']]) {
						$fold_value = true;
					}
					if ($fold_value) {
						$fold = "f_" . $value['fold'] . " ";
					} else {
						$fold = "f_" . $value['fold'] . " temphide ";
					}
				}
				$output .= '<div id="section-' . $value['id'] . '" class="' . $fold . 'section section-' . $value['type'] . ' ' . $class . '">';
				if ($value['name']) $output .= '<h3 class="heading">'. $value['name'] .'</h3>';
				$output .= '<div class="option">' . '<div class="controls">';
			}

			switch ( $value['type'] ) {

				case 'text': // text input
					$t_value = '';
					$t_value = stripslashes($theme_options[$value['id']]);
					$output .= '<input type="'. esc_attr($value['type']) .'" class="of-input" name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) .'" value="' . esc_attr($t_value) .'" />';
					break;

				case 'select': // select option
					$output .= '<select class="select of-input" name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) .'">';
					foreach ($value['options'] as $select_ID => $option) {
						$theValue = $option;
						if ( ! is_numeric($select_ID)) $theValue = $select_ID;
						$output .= '<option id="' . esc_attr($select_ID) . '" value="' . esc_attr($theValue) . '" ' . selected($theme_options[$value['id']], $theValue, false) . ' />'.$option.'</option>';
					}
					$output .= '</select>';
					break;

				case 'textarea': // textarea option
				case 'textarea-full':
					$cols = '8';
					$rows = '8';
					$ta_value = '';
					if ( isset($value['options']) ) {
						$ta_options = $value['options'];
						if (isset($ta_options['cols'])) $cols = $ta_options['cols'];
						if (isset($ta_options['rows'])) $rows = $ta_options['rows'];
					}
					$ta_value = stripslashes($theme_options[$value['id']]);
					$output .= '<textarea class="of-input" name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) .'" cols="'. esc_attr($cols) .'" rows="' . esc_attr($rows) . '">' . $ta_value . '</textarea>';
					break;

				case "radio": // radiobox option
					$checked = (isset($theme_options[$value['id']])) ? checked($theme_options[$value['id']], $option, false) : '';
					foreach($value['options'] as $option=>$name) {
						$output .= '<input class="of-input of-radio" name="' . esc_attr($value['id']) . '" type="radio" value="' . esc_attr($option) . '" ' . checked($theme_options[$value['id']], $option, false) . ' /><label class="radio">' . $name . '</label><br/>';
					}
					break;

				case 'checkbox': // checkbox option
					if (!isset($theme_options[$value['id']])) $theme_options[$value['id']] = 0;
					$fold = '';
					if (array_key_exists("folds", $value)) $fold = "fld ";
					$output .= '<input type="hidden" class="' . $fold . 'checkbox of-input" name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) . '" value="0"/>';
					$output .= '<input type="checkbox" class="' . $fold . 'checkbox of-input" name="' . esc_attr($value['id']) . '" id="'. esc_attr($value['id']) . '" value="1" '. checked($theme_options[$value['id']], 1, false) .' />';
					break;

				case 'multicheck': // multiple checkbox option
					if (isset($theme_options[$value['id']])) {
						$multi_stored = $theme_options[$value['id']];
					} else {
						$multi_stored="";
					}
					foreach ($value['options'] as $key => $option) {
						if (!isset($multi_stored[$key])) {$multi_stored[$key] = '';}
						$of_key_string = $value['id'] . '_' . $key;
						$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'['.$key.']'.'" id="'. esc_attr($of_key_string) .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label class="multicheck" for="'. esc_attr($of_key_string) .'">'. $option .'</label><br />';
					}
					break;

				case "color": // color picker
					$default_color = '';
					if ( isset($value['std']) ) $default_color = ' data-default-color="' .$value['std'] . '" ';
					$output .= '<input name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) . '" class="of-color"  type="text" value="' . esc_attr($theme_options[$value['id']]) . '"' . $default_color .' />';
					break;

				case "image":
					$src = $value['std'];
					$output .= '<img src="' . esc_url($src) . '">';
					break;

				case 'images': // images checkbox - use image as checkboxes
					$i = 0;
					$select_value = (isset($theme_options[$value['id']])) ? $theme_options[$value['id']] : '';
					foreach ($value['options'] as $key => $option) {
						$i++;
						$checked = '';
						$selected = '';
						if ( NULL!=checked($select_value, $key, false) ) {
							$checked = checked($select_value, $key, false);
							$selected = 'of-radio-img-selected';  
						}
						$output .= '<span>';
						$output .= '<input type="radio" id="of-radio-img-' . esc_attr($value['id'] . $i) . '" class="checkbox of-radio-img-radio" value="'.$key.'" name="' . esc_attr($value['id']) . '" ' . $checked . '>';
						$output .= '<div class="of-radio-img-label">'. $key .'</div>';
						$output .= '<img src="' . esc_url($option) . '" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. esc_js($value['id'] . $i) . '\').checked = true;" />';
						$output .= '</span>';
					}
					break;

				case "info": // info box
					$info_text = $value['std'];
					$output .= '<div class="of-info">' . $info_text . '</div>';
					break;

				case 'heading': // tab heading
					if ($counter >= 2) $output .= '</div>';
					$class = (isset($value['class'])) ? $value['class'] : $value['name'];
					$header_class = str_replace(' ','',strtolower($class));
					$jquery_click_hook = str_replace(' ', '', strtolower($value['name']) );
					$jquery_click_hook = "tab-" . trim(preg_replace('/ +/', '', preg_replace('/[^A-Za-z0-9 ]/', '', urldecode(html_entity_decode(strip_tags($jquery_click_hook))))));
					
					$menu .= '<li class="'. esc_attr($header_class) .'"><a href="#' .  esc_attr($jquery_click_hook)  .'"><span>'.  $value['name'] .'</span></a></li>';
					$output .= '<div class="group" id="'. esc_attr($jquery_click_hook)  .'"><h2>'.$value['name'].'</h2>';
					break;

				case 'slider': // drag & drop slide manager
					$output .= '<div class="slider"><ul id="' . esc_attr($value['id']) . '">';
					$slides = $theme_options[$value['id']];
					$count = count($slides);
					if ($count < 2) {
						$oldorder = 1;
						$order = 1;
						$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order);
					} else {
						$i = 0;
						foreach ($slides as $slide) {
							$oldorder = $slide['order'];
							$i++;
							$order = $i;
							$output .= Options_Machine::optionsframework_slider_function($value['id'],$value['std'],$oldorder,$order);
						}
					}
					$output .= '</ul>';
					$output .= '<a href="#" class="button slide_add_button">' . esc_html__('Add New Slide','tosca') . '</a></div>';
					break;

				case 'sorter': // drag & drop block manager
					// make sure to get list of all the default blocks first
					$all_blocks = $value['std'];
					$temp = array(); // holds default blocks
					$temp2 = array(); // holds saved blocks
					foreach($all_blocks as $blocks) {
						$temp = array_merge($temp, $blocks);
					}
					$sortlists = isset($data[$value['id']]) && !empty($data[$value['id']]) ? $data[$value['id']] : $value['std'];
					foreach( $sortlists as $sortlist ) {
						$temp2 = array_merge($temp2, $sortlist);
					}
					// now let's compare if we have anything missing
					foreach($temp as $k => $v) {
						if (!array_key_exists($k, $temp2)) $sortlists['disabled'][$k] = $v;
					}
					// now check if saved blocks has blocks not registered under default blocks
					foreach( $sortlists as $key => $sortlist ) {
						foreach($sortlist as $k => $v) {
							if (!array_key_exists($k, $temp)) unset($sortlist[$k]);
						}
						$sortlists[$key] = $sortlist;
					}
					// assuming all sync'ed, now get the correct naming for each block
					foreach( $sortlists as $key => $sortlist ) {
						foreach($sortlist as $k => $v) {
							$sortlist[$k] = $temp[$k];
						}
						$sortlists[$key] = $sortlist;
					}

					$output .= '<div id="' . esc_attr($value['id']) . '" class="sorter">';
					if ($sortlists) {
						foreach ($sortlists as $group=>$sortlist) {
							$output .= '<ul id="' . esc_attr($value['id'] . '_' . $group) . '" class="sortlist_' . esc_attr($value['id']) . '">';
							$output .= '<h3>'.$group.'</h3>';
							foreach ($sortlist as $key => $list) {
								$output .= '<input class="sorter-placebo" type="hidden" name="' . $value['id'].'['.$group.'][placebo]" value="placebo">';
								if ($key != "placebo") {
									$output .= '<li id="' . $key . '" class="sortee">';
									$output .= '<input class="position" type="hidden" name="'.$value['id'].'['.$group.']['.$key.']" value="' . esc_attr($list) . '">';
									$output .= $list;
									$output .= '</li>';
								}
							}
							$output .= '</ul>';
						}
					}
					$output .= '</div>';
					break;

				case 'tiles': // background images option
					$i = 0;
					$select_value = isset($theme_options[$value['id']]) && !empty($theme_options[$value['id']]) ? $theme_options[$value['id']] : '';
					if (is_array($value['options'])) {
						foreach ($value['options'] as $key => $option) { 
							$i++;
							$checked = '';
							$selected = '';
							if (NULL!=checked($select_value, $option, false)) {
								$checked = checked($select_value, $option, false);
								$selected = 'of-radio-tile-selected';  
							}
							$output .= '<span>';
							$output .= '<input type="radio" id="of-radio-tile-' . $value['id'] . $i . '" class="checkbox of-radio-tile-radio" value="'.$option.'" name="'.$value['id'].'" '.$checked.' />';
							$output .= '<div class="of-radio-tile-img '. $selected .'" style="background: url('. esc_url($option) . ')" onClick="document.getElementById(\'of-radio-tile-'. esc_js($value['id'] . $i) . '\').checked = true;"></div>';
							$output .= '</span>';
						}
					}
					break;

				case 'backup': // backup and restore options data
					$instructions = $value['desc'];
					$backup = of_get_options(THEME_BACKUPS);
					$init = of_get_options('smof_init');
					if ( ! isset($backup['backup_log'])) {
						$log = esc_html__('No backups yet', 'tosca');
					} else {
						$log = $backup['backup_log'];
					}
					$output .= '<div class="backup-box">';
					$output .= '<div class="instructions">' . $instructions;
					$output .= '<p><strong>' . esc_html__('Last Backup','tosca') . ': <span class="backup-log">' . $log . '</span></strong></p></div>';
					$output .= '<a href="#" id="of_backup_button" class="button">' . esc_html__('Backup Options','tosca') . '</a>';
					$output .= '<a href="#" id="of_restore_button" class="button">' . esc_html__('Restore Options','tosca') . '</a>';
					$output .= '</div>';
					break;

				case 'transfer': // export or import data between different installs
					$instructions = $value['desc'];
					$output .= '<div class="transfer-box">';
					$output .= '<div class="instructions">' . $instructions . '</div>';
					$exported_options = array();
					foreach ($options as $key => $value) {
						if (isset($value['type']) && $value['type'] == 'info' && isset($theme_options[$value['id']])) {
							unset($theme_options[$value['id']]);
							unset($theme_options['backups'][$value['id']]);
						}
						if (isset($value['id']) && isset($theme_options[$value['id']])) {
							$exported_options[$value['id']] = $theme_options[$value['id']];
						}
					}
					if (isset($theme_options['0'])) {
						unset($theme_options['0']);
					}
					if (isset($theme_options['backups']['0'])) {
						unset($theme_options['backups']['0']);
					}
					if (isset($theme_options['backups'])) {
						unset($theme_options['backups']);
					}
					if (isset($exported_options['backup_options'])) {
						unset($exported_options['backup_options']);
					}
					if (isset($exported_options['transfer_options'])) {
						unset($exported_options['transfer_options']);
					}
					$output .= '<textarea id="export_data" rows="7">' .
						base64_encode(/* 100% safe and escaped, used for hiding options from user when exported/imported options */serialize($exported_options)) . '</textarea>';
					$output .= '<a href="#" id="of_import_button" class="button">' . esc_html__('Import Options','tosca') . '</a>';
					$output .= '</div>';
					break;

				case 'googlefont': // smart google font field
					$output .= '<div class="half"><select class="select of-input font-family" name="' . $value['id'] . '[family]" id="' . esc_attr($value['id']) . '_family" data-id="' . esc_attr($value['id']) . '">';
					if ( isset($theme_options[$value['id']]) ) {
						$current_font = $theme_options[$value['id']];
					} else {
						$current_font = array();
					}
					$current_font_variants = '';
					$current_font_subsets = '';
					foreach ($value['options'] as $font) {
						$font_details = preg_split("/\|/", $font);
						if ( ! isset($font_details[1]) ) $font_details[1] = '';
						if ( ! isset($font_details[2]) ) $font_details[2] = '';
						if ( isset($current_font['family']) && $current_font['family'] == $font_details[0] ) {
							$selected = ' selected="selected"';
							$current_variants = preg_split("/,/", $font_details[1]);
							foreach ($current_variants as $variant) {
								if ($variant) {
									$current_font_variants .= '<option value="' . esc_attr($variant) . '"' . selected((isset($current_font['variant'])) ? $current_font['variant'] : "", $variant, false) . '>' . $variant . '</option>';
								}
							}
							$current_subsets = preg_split("/,/", $font_details[2]);
							foreach ($current_subsets as $subset) {
								if ($subset) {
									$current_font_subsets .= '<option value="'. esc_attr($subset) . '"' . selected((isset($current_font['subset'])) ? $current_font['subset'] : "", $subset, false) . '>' . $subset . '</option>';
								}
							}
						} else {
							$selected = '';
						}
						$output .= '<option value="'. esc_attr($font_details[0]) . '"' . $selected . ' data-variants="' . esc_attr($font_details[1]) . '" data-subsets="' . esc_attr($font_details[2]) . '">' . $font_details[0] . '</option>';
					}
					$output .= '</select></div>';
					$output .= '<div class="forth"><select class="select of-input font-variants" name="' . esc_attr($value['id']) . '[variant]" id="' . esc_attr($value['id']) . '_variant" data-id="' . esc_attr($value['id']) . '">' . $current_font_variants . '</select></div>';
					$output .= '<div class="forth last"><select class="select of-input font-subsets" name="' . esc_attr($value['id']) . '[subset]" id="' . esc_attr($value['id']) . '_subset" data-id="' . esc_attr($value['id']) . '">' . $current_font_subsets . '</select></div><div class="clear"></div>';
					if (isset($value['preview']['text'])){
						$g_text = $value['preview']['text'];
					} else {
						$g_text = 'The quick brown fox jumps over the lazy dog.';
					}
					if (isset($value['preview']['style'])) {
						$g_style = ' style="'. $value['preview']['style'] .'"';
					} else { 
						$g_style = '';
					}
					$output .= '<p class="' . esc_attr($value['id']) . '_ggf_previewer font_preview"' . $g_style . '>' . $g_text . '</p>';
					break;

				case 'sliderui': // JQuery UI Slider
					$s_val = $s_min = $s_max = $s_step = $s_edit = '';
					$s_val = stripslashes($theme_options[$value['id']]);
					if (!isset($value['min'])) {
						$s_min  = '0';
					} else {
						$s_min = $value['min'];
					}
					if (!isset($value['max'])) {
						$s_max  = $s_min + 1;
					} else {
						$s_max = $value['max'];
					}
					if (!isset($value['step'])) {
						$s_step  = '1';
					} else {
						$s_step = $value['step'];
					}
					if (!isset($value['edit'])) { 
						$s_edit  = ' readonly="readonly"'; 
					} else {
						$s_edit  = '';
					}
					if ($s_val == '') {
						$s_val = $s_min;
					}
					$s_data = 'data-id="' . esc_attr($value['id']) . '" data-val="' . esc_attr($s_val) . '" data-min="' . esc_attr($s_min) . '" data-max="' . esc_attr($s_max) . '" data-step="' . esc_attr($s_step) . '"';
					$output .= '<input type="text" name="' . esc_attr($value['id']) . '" id="' . esc_attr($value['id']) . '" value="' . esc_attr($s_val) .'" class="mini" ' . $s_edit .' />';
					$output .= '<div id="' . esc_attr($value['id']) . '-slider" class="smof_sliderui" '. $s_data .'></div>';
					break;

				case 'switch': // switch option
					if (!isset($theme_options[$value['id']])) $theme_options[$value['id']] = 0;
					$fold = '';
					if (array_key_exists("folds", $value)) $fold = "s_fld ";
					$cb_enabled = $cb_disabled = '';
					if ($theme_options[$value['id']] == 1) {
						$cb_enabled = ' selected';
						$cb_disabled = '';
					} else {
						$cb_enabled = '';
						$cb_disabled = ' selected';
					}
					if (!isset($value['on'])) {
						$on = esc_html__('On','tosca');
					} else {
						$on = $value['on'];
					}
					if (!isset($value['off'])) {
						$off = esc_html__('Off','tosca');
					} else {
						$off = $value['off'];
					}
					$output .= '<p class="switch-options">';
					$output .= '<label class="' . $fold . 'cb-enable' . $cb_enabled . '" data-id="'.$value['id'].'"><span>'. $on .'</span></label>';
					$output .= '<label class="' . $fold . 'cb-disable' . $cb_disabled . '" data-id="'.$value['id'].'"><span>' . $off . '</span></label>';
					$output .= '<input type="hidden" class="' . $fold . 'checkbox of-input" name="' . $value['id'] . '" id="' . $value['id'] . '" value="0"/>';
					$output .= '<input type="checkbox" id="' . $value['id'] . '" class="' . $fold . 'checkbox of-input main_checkbox" name="' . $value['id'] . '"  value="1" ' . checked($theme_options[$value['id']], 1, false) . ' />';
					$output .= '</p>';
					break;

				case "upload": // Uploader 3.5
				case "media":
					$output .= Options_Machine::optionsframework_media_uploader_function($value);
					break;
			}

			do_action('optionsframework_machine_loop', array(
				'options'	=> $options,
				'smof_data'	=> $theme_options,
				'defaults'	=> $defaults,
				'counter'	=> $counter,
				'menu'		=> $menu,
				'output'	=> $output,
				'value'		=> $value
			));

			// description of each option
			if ($value['type'] != 'googlefont') {
				if ($value['type'] != 'heading') {
					if ( ! isset($value['desc'])) {
						$explain_value = '';
					} else { 
						$explain_value = '<div class="explain">'. $value['desc'] .'</div>'; 
					} 
					$output .= '</div>'.$explain_value;
					$output .= '<div class="clear"></div></div></div>';
				}
			} else {
				$output .= '</div></div></div>';
			}
			} /* condition empty end */
		}

		if ($update_data == true) {
			of_save_options($theme_options);
		}
		$output .= '</div>';

		do_action('optionsframework_machine_after', array(
			'options'		=> $options,
			'smof_data'		=> $theme_options,
			'defaults'		=> $defaults,
			'counter'		=> $counter,
			'menu'			=> $menu,
			'output'			=> $output,
			'value'			=> $value
		));
		return array($output,$menu,$defaults);
	}

	/* Native media library uploader */
	public static function optionsframework_media_uploader_function($value) {
		$theme_options = of_get_options();
		$uploader = '';
		$id = $value['id'];
		if (isset($theme_options[$id]) && ! empty($theme_options[$id])) {
			if (is_array($theme_options[$id])) {
				$image = $theme_options[$id];
			} else {
				$image = array('url' => $theme_options[$id]);
			}
		} else {
			$image = array();
		}
		if ( ! isset($image['url'])) $image['url'] = '';
		if ( ! isset($image['width'])) $image['width'] = '';
		if ( ! isset($image['height'])) $image['height'] = '';
		if ( ! isset($image['alt'])) $image['alt'] = '';
		$hide = 'hide';
		$fold = '';
		if (array_key_exists("folds", $value)) $fold = "i_fld ";
		$uploader .= '<input type="text" class="' . $fold . $hide . ' upload of-input" name="'. $id .'[url]" id="'. $id .'_upload" value="'. $image['url'] .'" data-id="' . $id . '" />';
		$uploader .= '<input type="hidden" class="width" name="'. $id .'[width]" value="'. $image['width'] .'" />';
		$uploader .= '<input type="hidden" class="height" name="'. $id .'[height]" value="'. $image['height'] .'" />';
		$uploader .= '<input type="hidden" class="alt" name="'. $id .'[alt]" value="'. $image['alt'] .'" />';
		$uploader .= '<div class="upload_button_div">';
		if ( function_exists('wp_enqueue_media') ) {
			$uploader .= '<span class="button media_upload_button" id="' . $id . '">' . esc_html__('Upload','tosca') . '</span>';
			if ( !empty($image['url']) ) {
				$hide = '';
			} else {
				$hide = 'hide';
			}
			$uploader .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'">' . esc_html__('Remove','tosca') . '</span>';
		}
		$uploader .='</div>';
		$uploader .= '<div class="screenshot">';
		if ( !empty($image['url']) ) {
			$uploader .= '<img class="of-option-image" id="image_' . $id . '" src="' . esc_url($image['url']) . '" alt="" />';
		}
		$uploader .= '</div>';
		$uploader .= '<div class="clear"></div>'; 
		return $uploader;
	}

	/* Drag and drop slides manager */
	public static function optionsframework_slider_function($id,$std,$oldorder,$order){
		$data = of_get_options();
		$theme_options = of_get_options();
		$slider = '';
		$slide = array();
		if (isset($theme_options[$id])) $slide = $theme_options[$id];
		if (isset($slide[$oldorder])) {
			$val = $slide[$oldorder];
		} else {
			$val = $std;
		}
		$slidevars = array('title','url','link','description');
		foreach ($slidevars as $slidevar) {
			if (!isset($val[$slidevar])) {
				$val[$slidevar] = '';
			}
		}
		if (!empty($val['title'])) {
			$slider .= '<li><div class="slide_header"><strong>'.stripslashes($val['title']).'</strong>';
		} else {
			$slider .= '<li><div class="slide_header"><strong>' . esc_html__('Slide','tosca') . ' '.$order.'</strong>';
		}
		$slider .= '<input type="hidden" class="slide of-input order" name="'. $id .'['.$order.'][order]" id="'. $id.'_'.$order .'_slide_order" value="'.$order.'" />';
		$slider .= '<a class="slide_edit_button" href="#">' . esc_html__('Edit','tosca') . '</a></div>';
		$slider .= '<div class="slide_body">';
		$slider .= '<label>' . esc_html__('Title','tosca') . '</label>';
		$slider .= '<input type="text" class="slide of-input of-slider-title" name="'. $id .'['.$order.'][title]" id="'. $id .'_'.$order .'_slide_title" value="'. stripslashes($val['title']) .'" />';
		$slider .= '<label>' . esc_html__('Image URL','tosca') . '</label>';
		$slider .= '<input type="text" class="upload slide of-input" name="'. $id .'['.$order.'][url]" id="'. $id .'_'.$order .'_slide_url" value="'. $val['url'] .'" />';
		$slider .= '<div class="upload_button_div"><span class="button media_upload_button" id="'.$id.'_'.$order .'">' . esc_html__('Upload','tosca') . '</span>';
		if (!empty($val['url'])) {
			$hide = '';
		} else {
			$hide = 'hide';
		}
		$slider .= '<span class="button remove-image '. $hide.'" id="reset_'. $id .'_'.$order .'" title="' . $id . '_'.$order .'">' . esc_html__('Remove','tosca') . '</span>';
		$slider .='</div>';
		$slider .= '<div class="screenshot">';
		if (!empty($val['url'])){
			$slider .= '<a class="of-uploaded-image" href="'. esc_url($val['url']) . '">';
			$slider .= '<img class="of-option-image" id="image_'.$id.'_'.$order .'" src="' . esc_url($val['url']). '" alt="" />';
			$slider .= '</a>';
			}
		$slider .= '</div>';
		$slider .= '<label>' . esc_html__('Link URL (optional)','tosca') . '</label>';
		$slider .= '<input type="text" class="slide of-input" name="'. $id .'['.$order.'][link]" id="'. $id .'_'.$order .'_slide_link" value="'. $val['link'] .'" />';
		$slider .= '<label>' . esc_html__('Description (optional)','tosca') . '</label>';
		$slider .= '<textarea class="slide of-input" name="'. $id .'['.$order.'][description]" id="'. $id .'_'.$order .'_slide_description" cols="8" rows="8">'.stripslashes($val['description']).'</textarea>';
		$slider .= '<a class="slide_delete_button button-primary" href="#">' . esc_html__('Delete','tosca') . '</a>';
		$slider .= '<div class="clear"></div>';
		$slider .= '</div>';
		$slider .= '</li>';
		return $slider;
	}
}
