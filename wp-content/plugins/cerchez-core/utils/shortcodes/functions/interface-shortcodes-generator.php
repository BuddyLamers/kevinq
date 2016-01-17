<?php



$cerchez_core_shortcodes_generators = array();



$cerchez_core_shortcodes_generators['alert'] = <<<EOF

	var type = $('#cerchez_core_alert_type').val();

	if (type != '') type = ' type="' + type + '"';

	var content = $('#cerchez_core_alert_content').val();

	if (content != '') {

		code.before = '[alert' + type + ']' + content + '[/alert]';

	} else {

		code.before = '[alert' + type + ']';

		code.after = '[/alert]';

	}

EOF;



$cerchez_core_shortcodes_generators['button'] = <<<EOF

	var text = $('#cerchez_core_button_text').val();

	var url = $('#cerchez_core_button_url').val();

	var target = $('#cerchez_core_button_target').val();

	if (target != '') target = ' target="' + target + '"';

	var size = $('#cerchez_core_button_size').val();

	if (size != '') size = ' size="' + size + '"';

	var color = $('#cerchez_core_button_color').val();

	if (color != '') color = ' color="' + color + '"';

	var el_id = $('#cerchez_core_button_id').val();

	if (el_id != '') el_id = ' id="' + cerchez_core_attr_esc(el_id) + '"';

	var el_class = $('#cerchez_core_button_class').val();

	if (el_class != '') el_class = ' class="' + cerchez_core_attr_esc(el_class) + '"';

	var el_rel = $('#cerchez_core_button_rel').val();

	if (el_rel != '') el_rel = ' rel="' + cerchez_core_attr_esc(el_rel) + '"';

	if (text != '') {

		code.before = '[button url="' + url + '"' + target + size + color + el_id + el_class + el_rel + ']' + text + '[/button]';

	} else {

		code.before = '[button url="' + url + '"' + target + size + color + el_id + el_class + el_rel + ']';

	}

EOF;



$cerchez_core_shortcodes_generators['call_to_action'] = <<<EOF

	var title = $('#cerchez_core_call_to_action_title').val();

	if (title != '') title = ' title="' + cerchez_core_attr_esc(title) + '"';

	var content = $('#cerchez_core_call_to_action_content').val();

	if (title != '') {

		code.before = '[call-to-action' + title + ']' + content + '[/call-to-action]';

	} else {

		code.before = '[call-to-action' + title + ']';

		code.after = '[/call-to-action]';

	}

EOF;



$cerchez_core_shortcodes_generators['feature'] = <<<EOF

	var title = $('#cerchez_core_feature_title').val();

	if (title != '') title = ' title="' + cerchez_core_attr_esc(title) + '"';

	var text = $('#cerchez_core_feature_text').val();

	if (text != '') text = ' text="' + cerchez_core_attr_esc(text) + '"';

	var image = $('#cerchez_core_feature_image').val();

	var image_alt = $('#cerchez_core_feature_image_alt_text').val();

	var image_width = $('#cerchez_core_feature_image').nextAll('input[type=hidden].width').val();

	var image_height = $('#cerchez_core_feature_image').nextAll('input[type=hidden].height').val();

	if (image != '') {

		if (image_alt != '') {

			image_alt = ' image_alt="' + image_alt + '"';

		} else {

			image_alt = '';

		}

		if (image_width != '') {

			image_width = ' image_width="' + image_width + '"';

		} else {

			image_width = '';

		}

		if (image_height != '') {

			image_height = ' image_height="' + image_height + '"';

		} else {

			image_height = '';

		}

		image = ' image="' + image + '"' + image_alt + image_width + image_height;

		code.before = '[feature' + title + text + image + '][/feature]';

	} else {

		code.before = '[feature' + title + text + ']';

		code.after = '[/feature]';

	}

EOF;



$cerchez_core_shortcodes_generators['social'] = <<<EOF

	var el_type = $('#cerchez_core_social_type').val();

	var url = $('#cerchez_core_social_url').val();

	var target = $('#cerchez_core_social_target').val();

	if (target != '') target = ' target="' + target + '"';

	var title = $('#cerchez_core_social_title').val();

	if (title != '') title = ' title="' + cerchez_core_attr_esc(title) + '"';

	var el_class = cerchez_core_attr_esc($('#cerchez_core_button_class').val());

	if (el_class != '') el_class = ' class="' + el_class + '"';

	var el_rel = $('#cerchez_core_button_rel').val();

	if (el_rel != '') el_rel = ' rel="' + cerchez_core_attr_esc(el_rel) + '"';

	code.before = '[social type="' + el_type + '" url="' + url + '"' + target + title + el_class + ']';

EOF;



$cerchez_core_shortcodes_generators['accordion'] = <<<EOF

	var collapse = '';

	if (!$('#cerchez_core_accordion_collapse').is(':checked')) {

		collapse = ' collapse="false"';

	}

	var items = '';

	$('.cerchez-core-shortcodes-modal .option-line-duplicate .item').each(function() {

		var title = $(this).find("input[id^='cerchez_core_accordion_item_title']").val();

		if (title != '') title = ' title="' + title + '"';

		var text = $(this).find("textarea[id^='cerchez_core_accordion_item_text']").val();

		if ($(this).find("input[id^='cerchez_core_accordion_item_opened']").is(':checked')) {

			opened = ' opened="true"';

		} else {

			opened = '';

		}

		items = items + '[accordion-item' + title + opened + ']' + text + '[/accordion-item]';

	});

	if (items != '') {

		code.before = '[accordion' + collapse + ']' + items + '[/accordion]';

	} else {

		code.before = '[accordion' + collapse + ']';

		code.after = '[/accordion]';

	}

EOF;



$cerchez_core_shortcodes_generators['accordion_item'] = <<<EOF

	var title = $('#cerchez_core_accordion_item_title').val();

	if (title != '') title = ' title="' + title + '"';

	var text = $('#cerchez_core_accordion_item_text').val();

	if ($('#cerchez_core_accordion_item_opened').is(':checked')) {

		opened = ' opened="true"';

	} else {

		opened = '';

	}

	if (text != '') {

		code.before = '[accordion-item' + title + opened + ']' + text + '[/accordion-item]';

	} else {

		code.before = '[accordion-item' + title + opened + ']';

		code.after = '[/accordion-item]';

	}

EOF;



$cerchez_core_shortcodes_generators['projects'] = <<<EOF

	var category = $('#cerchez_core_projects_category').val();

	if (category != '0') {

		category = ' category="' + category + '"';

	} else {

		category = '';

	}

	var tag = $('#cerchez_core_projects_tag').val();

	if (tag != '0' && tag !== null) {

		tag = ' tag="' + tag + '"';

	} else {

		tag = '';

	}

	var limit = $('#cerchez_core_projects_limit').val();

	if (limit != '') limit = ' limit="' + limit + '"';

	var per_row = $('#cerchez_core_projects_per_row').val();

	if (per_row != '') per_row = ' per_row="' + per_row + '"';

	var showcase = '';

	if ($('#cerchez_core_projects_showcase').is(':checked')) {

		showcase = ' showcase="true"';

	}

	var filters = '';

	if ($('#cerchez_core_projects_filters').is(':checked')) {

		filters = ' filters="true"';

	}

	var image_width = $('#cerchez_core_projects_image_width').val();

	if (image_width != '' && !isNaN(image_width) && image_width != '450') {

		image_width = ' image_width="' + image_width + '"';

	} else {

		image_width = '';

	}

	var image_height = $('#cerchez_core_projects_image_height').val();

	if (image_height != '' && !isNaN(image_height) && image_height != '300') {

		image_height = ' image_height="' + image_height + '"';

	} else {

		image_height = '';

	}

	var lightbox_class = $('#cerchez_core_projects_lightbox_class').val();

	if (lightbox_class != '' && lightbox_class != "fade" && typeof lightbox_class != "undefined") {

		lightbox_class = ' lightbox_class="' + lightbox_class + '"';

	} else {

		lightbox_class = '';

	}

	var lightbox_icon = $('#cerchez_core_projects_lightbox_icon').val();

	if (lightbox_icon != '' && lightbox_icon != "resize-enlarge" && typeof lightbox_icon != "undefined") {

		lightbox_icon = ' lightbox_icon="' + lightbox_icon + '"';

	} else {

		lightbox_icon = '';

	}

	var lightbox_title_inside = '';

	if ($('#cerchez_core_projects_lightbox_title_inside').is(':checked')) {

		lightbox_title_inside = ' lightbox_title_inside="true"';

	}

	var lightbox_subtitles = $('#cerchez_core_projects_lightbox_subtitles').val();

	if (lightbox_subtitles != '' && typeof lightbox_subtitles != "undefined") {

		lightbox_subtitles = ' lightbox_subtitles="' + lightbox_subtitles + '"';

	} else {

		lightbox_subtitles = '';

	}

	var lightbox_gallery = $('#cerchez_core_projects_lightbox_gallery').val();

	if (lightbox_gallery != '') lightbox_gallery = ' lightbox_gallery="' + cerchez_core_attr_esc(lightbox_gallery) + '"';

	var lightbox_popup = '';

	if (!$('#cerchez_core_projects_lightbox_popup').is(':checked')) {

		lightbox_popup = ' lightbox_popup="false"';

	}

	var filter_all_string = $('#cerchez_core_projects_filter_all_string').val();

	if (filter_all_string != '') filter_all_string = ' filter_all_string="' + cerchez_core_attr_esc(filter_all_string) + '"';

	code.before = '[projects' + category + tag + limit + per_row + showcase + filters + image_width + image_height + lightbox_class + lightbox_icon + lightbox_title_inside + lightbox_subtitles + lightbox_gallery + lightbox_popup + filter_all_string + '][clear]';

EOF;



$cerchez_core_shortcodes_generators['news'] = <<<EOF

	var category = $('#cerchez_core_news_category').val();

	if (category != '0') {

		category = ' category="' + category + '"';

	} else {

		category = '';

	}

	var tag = $('#cerchez_core_news_tag').val();

	if (tag != '0' && tag !== null) {

		tag = ' tag="' + tag + '"';

	} else {

		tag = '';

	}

	var limit = $('#cerchez_core_news_limit').val();

	if (limit != '') limit = ' limit="' + limit + '"';

	var image_width = $('#cerchez_core_news_image_width').val();

	if (image_width != '' && !isNaN(image_width) && image_width != '450') {

		image_width = ' image_width="' + image_width + '"';

	} else {

		image_width = '';

	}

	var image_height = $('#cerchez_core_news_image_height').val();

	if (image_height != '' && !isNaN(image_height) && image_height != '300') {

		image_height = ' image_height="' + image_height + '"';

	} else {

		image_height = '';

	}

	code.before = '[news' + category + tag + limit + image_width + image_height + ']';

EOF;



$cerchez_core_shortcodes_generators['pricing'] = <<<EOF

	var items = '';

	var column_count = $('.cerchez-core-shortcodes-modal .option-line-duplicate .item').length;

	var i = 0;

	$('.cerchez-core-shortcodes-modal .option-line-duplicate .item').each(function() {

		var title = $(this).find("input[id^='cerchez_core_pricing_item_title']").val();

		if (title != '') title = ' title="' + title + '"';

		var cost = $(this).find("input[id^='cerchez_core_pricing_item_cost']").val();

		if (cost != '') cost = ' cost="' + cost + '"';

		var cost_after = $(this).find("input[id^='cerchez_core_pricing_item_cost_after']").val();

		if (cost_after != '' && cost_after != 'per month') {

			cost_after = ' cost_after="' + cost_after + '"';

		} else {

			cost_after = '';

		}

		if ($(this).find("input[id^='cerchez_core_pricing_item_highlight']").is(':checked')) {

			highlight = ' highlight="true"';

		} else {

			highlight = '';

		}

		var content = $(this).find("textarea[id^='cerchez_core_pricing_item_content']").val();

		extra_attr = '';

		if (i % column_count == 0) {

			extra_attr = ' first="true"';

		}

		if (i % column_count == (column_count-1)) {

			extra_attr = ' last="true"';

		}

		i++;

		items = items + '[grid number="' + Math.round(12/column_count) + '"' + extra_attr + ']';

		items = items + '[pricing-column' + title + cost + cost_after + highlight + ']' + content + '[/pricing-column]';

		items = items + '[/grid]';

	});

	code.before = '[pricing-table]' + items + '[clear][/pricing-table]';

EOF;



$cerchez_core_shortcodes_generators['slider'] = <<<EOF

	var autoslide = '';

	if ($("#cerchez_core_slider_autoslide").is(':checked')) {

		autoslide = ' autoslide="true"';

	}

	var autoslide_timer = $('#cerchez_core_slider_autoslide_timer').val();

	if (autoslide_timer != '' && autoslide_timer != '5000') {

		autoslide_timer = ' autoslide_timer="' + autoslide_timer + '"';

	} else {

		autoslide_timer = '';

	}

	var autoslide_timer_trans = $('#cerchez_core_slider_autoslide_timer_trans').val();

	if (autoslide_timer_trans != '' && autoslide_timer_trans != '750') {

		autoslide_timer_trans = ' autoslide_timer_trans="' + autoslide_timer_trans + '"';

	} else {

		autoslide_timer_trans = '';

	}

	var ratio_width = $('#cerchez_core_slider_aspect_ratio_width').val();

	var ratio_height = $('#cerchez_core_slider_aspect_ratio_height').val();

	if (ratio_width != '' && ratio_height != '' && ! (ratio_width == '16' && ratio_height == '9') ) {

		if (ratio_height == '0') ratio_height = '1';

		var ratio = ratio_height/ratio_width*100;

		extra_style = ' style="padding-bottom:' + ratio.toFixed(4) + '%"';

	} else {

		extra_style = '';

	}

	var slider_class = $('#cerchez_core_slider_class').val();

	if (slider_class != '') slider_class = ' class="' + slider_class + '"';

	var arrow_controls = '';

	if ( ! $("#cerchez_core_slider_arrows").is(':checked')) {

		arrow_controls = ' controls="false"';

	}

	var pagination = '';

	if ($("#cerchez_core_slider_pagination").is(':checked')) {

		pagination = ' pagination="true"';

	}

	var items = '';

	$('.cerchez-core-shortcodes-modal .option-line-duplicate .item').each(function() {

		var image = $(this).find("input[id^='cerchez_core_slider_item_image']").val();

		var image_alt = $(this).find("input[id^='cerchez_core_slider_item_image']").nextAll("input[id^='cerchez_core_slider_item_image']").val();

		var image_width = $(this).find("input[id^='cerchez_core_slider_item_image']").nextAll('input[type=hidden].width').val();

		var image_height = $(this).find("input[id^='cerchez_core_slider_item_image']").nextAll('input[type=hidden].height').val();

		if (image != '') {

			if (image_alt != '') {

				image_alt = ' image_alt="' + image_alt + '"';

			} else {

				image_alt = '';

			}

			if (image_width != '') {

				image_width = ' image_width="' + image_width + '"';

			} else {

				image_width = '';

			}

			if (image_height != '') {

				image_height = ' image_height="' + image_height + '"';

			} else {

				image_height = '';

			}

			image = ' image="' + image + '"' + image_alt + image_width + image_height;

		}

		var caption = $(this).find("input[id^='cerchez_core_slider_item_caption']").val();

		var caption_url = $(this).find("input[id^='cerchez_core_slider_item_caption_url']").val();

		var caption_url_target = $(this).find("input[id^='cerchez_core_slider_item_caption_url_target']").val();

		if (caption != '') {

			caption = ' caption="' + caption + '"';

			if (caption_url != '') {

				caption = caption + ' caption_url="' + caption_url + '"';

				if (typeof caption_url_target !== "undefined" && caption_url_target != '') {

					caption = caption + ' caption_url_target="' + caption_url_target + '"';

				}

			}

		}

		items = items + '[slider-item' + image + caption + '][/slider-item]';

	});

	code.before = '[slider' + autoslide + autoslide_timer + autoslide_timer_trans + extra_style + slider_class + arrow_controls + pagination + ']' + items + '[/slider]';

EOF;



$cerchez_core_shortcodes_generators['slider_item'] = <<<EOF

	var image = $('#cerchez_core_slider_item_image').val();

	var image_alt = $('#cerchez_core_slider_item_image_alt_text').val();

	var image_width = $('#cerchez_core_slider_item_image').nextAll('input[type=hidden].width').val();

	var image_height = $('#cerchez_core_slider_item_image').nextAll('input[type=hidden].height').val();

	if (image != '') {

		if (image_alt != '') {

			image_alt = ' image_alt="' + image_alt + '"';

		} else {

			image_alt = '';

		}

		if (image_width != '') {

			image_width = ' image_width="' + image_width + '"';

		} else {

			image_width = '';

		}

		if (image_height != '') {

			image_height = ' image_height="' + image_height + '"';

		} else {

			image_height = '';

		}

		image = ' image="' + image + '"' + image_alt + image_width + image_height;

	}

	var caption = $('#cerchez_core_slider_item_caption').val();

	var caption_url = $('#cerchez_core_slider_item_caption_url').val();

	var caption_url_target = $('#cerchez_core_slider_item_caption_url_target').val();

	if (caption != '') {

		caption = ' caption="' + caption + '"';

		if (caption_url != '') {

			caption = caption + ' caption_url="' + caption_url + '"';

			if (typeof caption_url_target !== "undefined" && caption_url_target != '') {

				caption = caption + ' caption_url_target="' + caption_url_target + '"';

			}

		}

	}

	code.before = '[slider-item' + image + caption + '][/slider-item]';

EOF;



$cerchez_core_shortcodes_generators['tabs'] = <<<EOF

	var tabs_id = $('#cerchez_core_tabs_id').val();

	if (tabs_id != '') tabs_id = ' id="' + tabs_id + '"';

	var items = '';

	var already_opened = false;

	if ($(".cerchez-core-shortcodes-modal .option-line-duplicate .item input[id^='cerchez_core_tab_item_active']:checked").length > 0) {

		var mark_first_opened = false;

	} else {

		var mark_first_opened = true;

	}

	$('.cerchez-core-shortcodes-modal .option-line-duplicate .item').each(function() {

		var title = $(this).find("input[id^='cerchez_core_tab_item_title']").val();

		if (title != '') title = ' title="' + title + '"';

		if ($(this).find("input[id^='cerchez_core_tab_item_active']").is(':checked') && ! already_opened) {

			active = ' active="true"';

			already_opened = true;

		} else {

			active = '';

		}

		if (mark_first_opened && !already_opened) {

			active = ' active="true"';

			already_opened = true;

		}

		var content = $(this).find("textarea[id^='cerchez_core_tab_item_content']").val();

		items = items + '[tab' + title + active + ']' + content + '[/tab]';

	});

	code.before = '[tabs' + tabs_id + ']' + items + '[/tabs]';

EOF;



$cerchez_core_shortcodes_generators['tab'] = <<<EOF

	var title = $('#cerchez_core_tab_item_title').val();

	if (title != '') title = ' title="' + title + '"';

	if ($('#cerchez_core_tab_item_active').is(':checked') && ! already_opened) {

		active = ' active="true"';

	} else {

		active = '';

	}

	var content = $('#cerchez_core_tab_item_content').val();

	code.before = '[tab' + title + active + ']' + content + '[/tab]';

EOF;



$cerchez_core_shortcodes_generators['audio'] = <<<EOF

	var mp3 = $('#cerchez_core_audio_mp3').val();

	if (mp3 != '') mp3 = ' mp3="' + mp3 + '"';

	var ogg = $('#cerchez_core_audio_ogg').val();

	if (ogg != '') ogg = ' ogg="' + ogg + '"';

	var wav = $('#cerchez_core_audio_wav').val();

	if (wav != '') wav = ' wav="' + wav + '"';

	var loop = '';

	if ($('#cerchez_core_audio_loop').is(':checked')) {

		loop = ' loop="true"';

	}

	var autoplay = '';

	if ($('#cerchez_core_audio_autoplay').is(':checked')) {

		autoplay = ' autoplay="true"';

	}

	var preload = '';

	if ($('#cerchez_core_audio_preload').is(':checked')) {

		preload = ' preload="true"';

	}

	var el_class = $('#cerchez_core_audio_class').val();

	if (el_class != '') el_class = ' class="' + el_class + '"';

	code.before = '[audio' + mp3 + ogg + wav + loop + autoplay + preload + el_class + ']';

EOF;



$cerchez_core_shortcodes_generators['lightbox'] = <<<EOF

	var url = $('#cerchez_core_lightbox_url').val();

	if (url != '') url = ' url="' + url + '"';

	var title = $('#cerchez_core_lightbox_title').val();

	if (title != '') title = ' title="' + title + '"';

	var subtitle = $('#cerchez_core_lightbox_subtitle').val();

	if (subtitle != '') subtitle = ' subtitle="' + subtitle + '"';

	var lightbox_class = $('#cerchez_core_lightbox_class').val();

	if (lightbox_class != '' && lightbox_class != "fade") {

		lightbox_class = ' class="' + lightbox_class + '"';

	} else {

		lightbox_class = '';

	}

	var icon = $('#cerchez_core_lightbox_icon').val();

	if (icon != '' && icon != "resize-enlarge") {

		icon = ' icon="' + icon + '"';

	} else {

		icon = '';

	}

	var gallery = $('#cerchez_core_lightbox_gallery').val();

	if (gallery != '') gallery = ' gallery="' + cerchez_core_attr_esc(gallery) + '"';

	var title_inside = '';

	if ($('#cerchez_core_lightbox_title_inside').is(':checked')) {

		title_inside = ' title_inside="true"';

	}

	var popup = '';

	if (!$('#cerchez_core_lightbox_popup').is(':checked')) {

		popup = ' popup="false"';

	}

	code.before = '[lightbox' + url + lightbox_class + icon + title + subtitle + title_inside + gallery + popup + '][/lightbox]';

EOF;



$cerchez_core_shortcodes_generators['map'] = <<<EOF

	var map_type = $('#cerchez_core_map_type').val();

	var map_content = $('#cerchez_core_map_content').val();

	if (map_content != '') {

		if (map_type == 'address') {

			map_content = '<iframe src="https://maps.google.com/maps?q=' + encodeURI(map_content) + '&amp;output=embed" height="600" width="900"></iframe>';

		}

		code.before = '[responsive-box]' + map_content + '[/responsive-box]';

	} else {

		code.before = '[responsive-box]';

		code.after = '[/responsive-box]';

	}

EOF;



$cerchez_core_shortcodes_generators['video'] = <<<EOF

	var content = $('#cerchez_core_video_content').val();

	if (content != '') {

		code.before = '[responsive-box]' + content + '[/responsive-box]';

	} else {

		code.before = '[responsive-box]';

		code.after = '[/responsive-box]';

	}

EOF;



$cerchez_core_shortcodes_generators['grid'] = <<<EOF

	var grid_no = $('#cerchez_core_grid_no').val();

	var grid_first = '';

	var grid_last = '';

	if ($('#cerchez_core_grid_first').is(':checked')) {

		grid_first = ' first="true"';

	}

	if ($('#cerchez_core_grid_last').is(':checked')) {

		grid_last = ' last="true"';

	}

	code.before = '[grid number="' + grid_no + '"' + grid_first + grid_last + ']';

	code.after = '[/grid]';

EOF;



function cerchez_core_shortcodes_generators_modify() {

	global $cerchez_core_shortcodes_generators;

	$cerchez_core_shortcodes_generators = apply_filters('cerchez_core_shortcodes_generators', $cerchez_core_shortcodes_generators);

}

add_action('init', 'cerchez_core_shortcodes_generators_modify');



function cerchez_core_shortcodes_js_generator($shortcode_id) {

	global $cerchez_core_shortcodes_generators;

	$js = '<script type="text/javascript">function cerchez_core_shortcode_generator_' . $shortcode_id . '(){var $=jQuery;var code={before:"", after: ""};';

	if (isset($cerchez_core_shortcodes_generators[$shortcode_id]))

		$js .= $cerchez_core_shortcodes_generators[$shortcode_id];

	$js .= 'return code;}</script>';

	return $js;

}