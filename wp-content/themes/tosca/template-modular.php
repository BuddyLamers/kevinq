<?php

/**

 *	Template Name: Modular Template

 *

 *	The template for displaying page modules using a special builder

 */



get_header();

the_post();

$layout_text = get_post_meta(get_the_ID(), 'module_builder_text', true);

$layout_json = json_decode($layout_text, true);



?>



<section id="content">

<?php



if ( ! post_password_required() ) {

	if (isset($layout_json)) {

		$layout_output = '<div class="module-builder-layout">';

		$module_id = 1;

		foreach ($layout_json as $layout_row) {

			$no_cell = count($layout_row);

			$row_content = '<div class="module-builder-row cells-' . $no_cell . ' clearfix">';

			foreach ($layout_row as $layout_row) {

				$cell_content = '<div class="module-builder-cell">';

				foreach ($layout_row as $layout_module) {

					$module_props = json_decode($layout_module['data'], true);

					$module_extra_classes = '';

					$module_extra_style = '';

					if (isset($module_props['height'])) {

						$module_extra_classes .= ' height-' . esc_attr($module_props['height']);

					} else {

						$module_extra_classes .= ' height-0';

					}

					if (isset($module_props['special_height']) && ! empty($module_props['special_height']) && empty($module_props['title'])) {

						$module_extra_style .= 'height:' . $module_props['special_height'] . ';';

					}

					if (isset($module_props['bgcolor']) && ! empty($module_props['bgcolor'])) {

						$module_extra_style .= 'background-color:' . $module_props['bgcolor'] . ';';

					}

					if (isset($module_props['bgimage']) && ! empty($module_props['bgimage']['url'])) {

						$module_extra_style .= 'background-image:url(' . esc_url($module_props['bgimage']['url']) . ');';

					}

					if (isset($module_props['bgrepeat']) && ! empty($module_props['bgrepeat'])) {

						$module_extra_classes .= ' bgrepeat-' . $module_props['bgrepeat'];

					}

					if (isset($module_props['textcolor']) && ! empty($module_props['textcolor'])) {

						$module_extra_style .= 'color:' . $module_props['textcolor'] . ';';

					}

					if (isset($module_props['textalign'])) {

						$module_extra_style .= 'text-align:' . $module_props['textalign'] . ';';

					}

					if ($module_extra_style) {

						$module_extra_style = ' style="' . rtrim($module_extra_style, ';') . '"';

					}

					$module = '<div id="module-item-' . esc_attr($module_id) . '" class="module-item module-type-' . esc_attr($layout_module['type'] . $module_extra_classes) . '"' . $module_extra_style . '>';

					switch ($layout_module['type']) {

						case 'text':

							$module .= '<div class="wrap vertical-align-' . esc_attr($module_props['textalignvertical']) . '"><div class="inner">';

							if (isset($module_props['title']) && ! empty($module_props['title'])) {

								$module .= '<h3 class="module-title">' . $module_props['title'] . '</h3>';

							}

							if (isset($module_props['module_content_editor']) && ! empty($module_props['module_content_editor'])) {

								$module .= do_shortcode($module_props['module_content_editor']);

							}

							$module .= '</div></div>';

							break;



						case 'image':

							if (isset($module_props['caption']) && ! empty($module_props['caption'])) {

								$caption_style ='';

								if (isset($module_props['captionbgcolor']) && ! empty($module_props['captionbgcolor'])) {

									$caption_style .= 'background-color:' . $module_props['captionbgcolor'] . ';';

								}

								if (isset($module_props['captioncolor']) && ! empty($module_props['captioncolor'])) {

									$caption_style .= 'color:' . $module_props['captioncolor'] . ';';

								}

								if ($caption_style) {

									$caption_style = ' style="' . rtrim($caption_style, ';') . '"';

								}

								$caption = '<span class="caption pos' . esc_attr($module_props['captionpos']) . '"><span><em' . $caption_style . '>' . $module_props['caption'] . '</em></span></span>';

							} else {

								$caption = '';

							}

							if (isset($module_props['url']) && ! empty($module_props['url'])) {

								if (isset($module_props['url_target']) && ! empty($module_props['url_target'])) {

									$link_target = ' target="_blank"';

								} else {

									$link_target = '';

								}

								$module .= '<a href="' . esc_url($module_props['url']) . '"' . $link_target . '>' . $caption . '</a>';

							} else {

								$module .= $caption;

							}

							break;



						case 'video':

							$module .= tosca_get_featured_video($module_props['embed'], ! $module_props['mute'], $module_props['autoplay'], $module_props['loop'], 'module_video_' . $module_id);

							break;



						case 'audio':

							$attribs = '';

							if (isset($module_props['mp3']) && $module_props['mp3']) {

								$attribs .= ' mp3="' . $module_props['mp3'] . '"';

							}

							if (isset($module_props['ogg']) && $module_props['ogg']) {

								$attribs .= ' ogg="' . $module_props['ogg'] . '"';

							}

							if (isset($module_props['wav']) && $module_props['wav']) {

								$attribs .= ' wav="' . $module_props['wav'] . '"';

							}

							if (isset($module_props['loop']) && ! empty($module_props['loop'])) {

								$attribs .= ' loop="true"';

							}

							if (isset($module_props['autoplay']) && ! empty($module_props['autoplay'])) {

								$attribs .= ' autoplay="true"';

							}

							if (isset($module_props['preload']) && empty($module_props['preload'])) {

								$attribs .= ' preload="false"';

							}

							$module .= do_shortcode('[audio' . $attribs . ']');

							break;



						case 'slider':

							$attribs = '';

							if (isset($module_props['autoplay']) && $module_props['autoplay']) {

								$attribs .= ' autoslide="true"';

							}

							if (isset($module_props['controls']) && $module_props['controls']) {

								$attribs .= ' controls="true"';

							} else {

								$attribs .= ' controls="false"';

							}

							if (isset($module_props['pagination']) && $module_props['pagination']) {

								$attribs .= ' pagination="true"';

							}

							if (isset($module_props['autoslide_timer']) && ! empty($module_props['autoslide_timer'])) {

								$attribs .= ' autoslide_timer="' . esc_attr($module_props['autoslide_timer']) . '"';

							}

							if (isset($module_props['autoslide_timer_trans']) && ! empty($module_props['autoslide_timer_trans'])) {

								$attribs .= ' autoslide_timer_trans="' . esc_attr($module_props['autoslide_timer_trans']) . '"';

							}

							$slider_shortcode = '[slider class="cerchez-slider-full-height" align="center center"' . $attribs . ']';

							if (isset($module_props['items']) && count($module_props['items']) > 0) {

								foreach ($module_props['items'] as $image) {

									$slider_item_caption = '';

									if ( isset($image['item_caption']) && ! empty($image['item_caption'])) {

										$slider_item_caption = wp_kses_post($image['item_caption']);

										if ( isset($image['item_caption_url']) && ! empty($image['item_caption_url'])) {

											$slider_item_caption_target = ( isset($image['item_caption_url_target']) && ! empty($image['item_caption_url_target'])) ? " target='_blank'" : '';

											$slider_item_caption = "<a href='" . esc_url($image['item_caption_url']) . "'" . $slider_item_caption_target . ">" . $slider_item_caption . '</a>';

										}

									}

									if ( ! empty($slider_item_caption)) {

										$slider_item_caption = ' caption="' . $slider_item_caption . '"';

									}

									$slider_shortcode .= '[slider-item image="' . $image['item_image']['url'] . '" image_alt="' . $image['item_image']['alt'] .'" image_width="' . $image['item_image']['width'] .'" image_height="' . $image['item_image']['height'] .'"' . $slider_item_caption . '][/slider-item]';

								}

							}

							$slider_shortcode .= '[/slider]';

							$module .= do_shortcode($slider_shortcode);

							break;



						case 'divider':

							if (isset($module_props['title']) && ! empty($module_props['title'])) {

								$module .= '<h4 class="module-title">' . wp_kses_post($module_props['title']) . '</h4>';

							}

							break;



						case 'map':

							if (isset($module_props['type']) && $module_props['type'] == 'address') {

								$module .= '<iframe src="https://maps.google.com/maps?q=' . urlencode($module_props['content']) . '&amp;output=embed" height="600" width="900"></iframe>';

							} else {

								$module .= do_shortcode($module_props['content']);

							}

							break;



						case 'projects':

							$attribs = ' showcase="true" lightbox_title_inside="true"';

							if (isset($module_props['category']) && $module_props['category'] != '0') {

								$attribs .= ' category="' . $module_props['category'] . '"';

							}

							if (isset($module_props['tag']) && $module_props['tag'] != '0') {

								$attribs .= ' tag="' . $module_props['tag'] . '"';

							}

							if (isset($module_props['limit']) && ! empty($module_props['limit'])) {

								$attribs .= ' limit="' . $module_props['limit'] . '"';

							}

							if (isset($module_props['subtitles']) && ! empty($module_props['subtitles'])) {

								$attribs .= ' lightbox_subtitles="' . $module_props['subtitles'] . '"';

							}

							if (isset($module_props['image_width']) && ! empty($module_props['image_width'])) {

								$attribs .= ' image_width="' . $module_props['image_width'] . '"';

							}

							if (isset($module_props['image_height']) && ! empty($module_props['image_height'])) {

								$attribs .= ' image_height="' . $module_props['image_height'] . '"';

							}

							if (isset($module_props['image_effect']) && ! empty($module_props['image_effect'])) {

								$attribs .= ' lightbox_class="' . $module_props['image_effect'] . '"';

							}

							if (isset($module_props['icon']) && ! empty($module_props['icon'])) {

								$attribs .= ' lightbox_icon="' . $module_props['icon'] . '"';

							}

							if (isset($module_props['gallery']) && ! empty($module_props['gallery'])) {

								$attribs .= ' lightbox_gallery="' . $module_props['gallery'] . '"';

							}

							if (isset($module_props['popup']) && empty($module_props['popup'])) {

								$attribs .= ' lightbox_popup="false"';

							}

							$projects_shortcode = '[projects' . $attribs . ']';

							$module .= do_shortcode($projects_shortcode);

							break;

					}

					$module .= '</div>';

					$module_id++;

					$cell_content .= $module;

				}

				$cell_content .= '</div>';

				$row_content .= $cell_content;

			}

			$row_content .= '</div>';

			$layout_output .= $row_content;

		}

		$layout_output .= '</div>';

		echo $layout_output;

	}

} else {

	echo '<div class="module-builder-layout"><div class="module-builder-row cells-1 clearfix"><div class="module-builder-cell"><div class="module-item module-type-text" style="background-color:#fffdf0;text-align:center"><div class="wrap vertical-align-middle"><div class="inner">' . get_the_password_form() . '</div></div></div></div></div></div>';

}



?>



</section>



<?php get_footer(); ?>