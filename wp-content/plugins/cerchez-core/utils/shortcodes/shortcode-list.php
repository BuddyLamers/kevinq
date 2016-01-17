<?php



/* allow shortcodes in widgets */

add_filter('widget_text', 'do_shortcode');



/* remove empty p tags only for our custom shortcodes */

add_filter("the_content", "cerchez_shortcodes_content_filter");

function cerchez_shortcodes_content_filter( $content ) {

	// apply to our own shortcodes that require the fix 

	$block = "raw|row|grid|responsive-box|box|alert|pricing-table|pricing-column|call-to-action|accordion|accordion-item|tabs|tab|slider|slider-item|feature|lightbox|include-theme-lightbox-script";

	// opening tag

	$rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);

	// closing tag

	$rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);

	return $rep;

}



/* extract boolean attribute values from shortcodes */

function cerchez_string_to_bool( $value ) {

	return filter_var( $value, FILTER_VALIDATE_BOOLEAN );

}



/* current year */

function cerchez_the_year_shortcode( $atts ) {

	return date('Y');

}

add_shortcode('the-year', 'cerchez_the_year_shortcode');



/* site title */

function cerchez_site_title_shortcode( $atts, $content = null ) {

	return get_bloginfo('name');

}

add_shortcode('site-title', 'cerchez_site_title_shortcode');



/* site url */

function cerchez_site_url_shortcode( $atts, $content = null ) {

	return home_url('/');

}

add_shortcode('site-url', 'cerchez_site_url_shortcode');



/* highlight */

function cerchez_highlight_shortcode( $atts, $content = null ) {

	return '<span class="highlight">' . $content . '</span>';

}

add_shortcode('highlight', 'cerchez_highlight_shortcode');



/* separator */

function cerchez_sep_shortcode( $atts, $content = null ) {

	return '<div class="sep"></div>';

}

add_shortcode('divider', 'cerchez_sep_shortcode');



/* raw content - remove <p> and <br /> */

function cerchez_raw_shortcode( $atts, $content = null ) {

	return do_shortcode( $content );

}

add_shortcode('raw', 'cerchez_raw_shortcode');



/* responsive container for videos or embeds */

function cerchez_responsive_box_shortcode( $atts, $content = null ) {

	return '<div class="responsive-container"><div class="responsive-wrapper">' . do_shortcode( $content ) . '</div></div>';

}

add_shortcode('responsive-box', 'cerchez_responsive_box_shortcode');



/* box container */

function cerchez_box_container_shortcode( $atts, $content = null ) {

	return '<div class="box">' . do_shortcode( $content ) . '</div>';

}

add_shortcode('box', 'cerchez_box_container_shortcode');



/* alert */

function cerchez_alert_shortcode( $atts, $content = null ) {

	$args = shortcode_atts(array(

		'type' => ''

	), $atts, 'alert');



	/* clean attributes */

	if ( $args['type'] ) {

		$type = ' ' .  esc_attr( $args['type'] );

	} else {

		$type = '';

	}

	return '<div class="alert' . $type . '">' . do_shortcode( $content ) . '</div>';

}

add_shortcode('alert', 'cerchez_alert_shortcode');



/* social button */

function cerchez_social_link_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'type' => 'cross',

		'url' => '',

		'title' => '',

		'class' => 'social-link',

		'target' => 'blank',

	), $atts, 'social');



	/* clean attributes */

	if ( $args['type'] ) {

		$type = 'icon-' .  esc_attr( $args['type'] );

	} else {

		$type = '';

	}

	if ( $args['url'] ) {

		$url = ' href="' . $args['url'] . '"';

	} else {

		$url = ' href="#"';

	}

	if ( $args['title'] ) {

		$title = ' title="' . esc_attr( $args['title'] ) . '"';

	} else {

		$title = '';

	}

	$target = $args['target'];

	switch( $target ) {

		case 'blank':

		case '_blank':

			$target = ' target="_blank"';

			break;

		default:

			$target = '';

			break;

	}

	$class = esc_attr( $args['class'] );



	if ( strpos( $class,'social-link') === false ) {

		$class .= ' social-link';

		$class = trim($class);

	}

	return '<a class="' . $class . ' ' . $type . '"' . $url . $target . $title . '></a>';

}

add_shortcode('social', 'cerchez_social_link_shortcode');



/* row */

function cerchez_row_shortcode( $atts, $content = null ) {

	return '<div class="container">' . do_shortcode( $content ) . '</div>';

}

add_shortcode('row', 'cerchez_row_shortcode');



/* grid */

function cerchez_grid_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'number' => 12,

		'first' => false,

		'last' => false,

		'class' => '',

		'percentage' => true,

	), $atts, 'grid');



	/* clean attributes */

	if ( $args['number'] ) {

		$number = (int) esc_attr( $args['number'] );

	} else {

		$number = 12;

	}

	if ( cerchez_string_to_bool( esc_attr( $args['first'] ) ) ) {

		$first = ' alpha';

	} else {

		$first = '';

	}

	if ( cerchez_string_to_bool( esc_attr( $args['last'] ) ) ) {

		$last = ' omega';

	} else {

		$last = '';

	}

	if ( $args['class'] ) {

		$class = ' ' . esc_attr( $args['class'] );

	} else {

		$class = '';

	}

	if ( cerchez_string_to_bool( esc_attr( $args['percentage'] ) ) ) {

		$percentage = ' pct';

	} else {

		$percentage = '';

	}



	return '<div class="col grid' . $number . $first . $last . $percentage . $class . '">' . do_shortcode( $content ) . '</div>';

}

add_shortcode('grid', 'cerchez_grid_shortcode');



/* clear grid floating */

function cerchez_clear_shortcode( $atts, $content = null ) {

	return '<div class="clear"></div>';

}

add_shortcode('clear', 'cerchez_clear_shortcode');



/* pricing table */

function cerchez_pricing_table_shortcode( $atts, $content = null ) {

	return '<div class="pricing-table">' . do_shortcode( $content ) . '</div>';

}

add_shortcode('pricing-table', 'cerchez_pricing_table_shortcode');



/* pricing table column */

function cerchez_pricing_column_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'title' => '',

		'cost' => '',

		'cost_after' => __('per month','cerchez-core'),

		'highlight' => false

	), $atts, 'pricing-column');



	/* clean attributes */

	if ( $args['title'] ) {

		$title = '<h3 class="price-title">' . esc_attr( $args['title'] ) . '</h3>';

	} else {

		$title = '';

	}

	$cost = esc_attr( $args['cost'] );

	if ( $args['cost_after'] ) {

		$cost_after = ' <span>' . esc_attr( $args['cost_after'] ) . '</span>';

	} else {

		$cost_after = '';

	}

	if ( cerchez_string_to_bool( esc_attr( $args['highlight'] ) ) ) {

		$extra_class = ' special';

	} else {

		$extra_class = '';

	}

	return '<div class="price-item' . $extra_class . '">' . $title . '<strong class="price-tag">' . $cost . $cost_after . '</strong>' . do_shortcode( $content ) . '</div>';

}

add_shortcode('pricing-column', 'cerchez_pricing_column_shortcode');



/* button */

function cerchez_button_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'url' => '',

		'size' => '',

		'color' => '',

		'target' => '',

		'rel' => '',

		'id' => '',

		'class' => '',

	), $atts, 'button');



	/* clean attributes */

	if ( $args['url'] ) {

		$href = ' href="' . esc_url( $args['url'] ) . '"';

	} else {

		$href = '';

	}

	$class = 'button';

	if ( $args['class'] ) {

		$class .= ' ' . esc_attr( $args['class'] );

	}

	if ( $args['size'] ) {

		$class .= ' ' . esc_attr( $args['size'] );

	}

	if ( $args['color'] ) {

		$class .= ' ' . esc_attr( $args['color'] );

	}

	$target = $args['target'];

	switch( $target ) {

		case 'blank':

		case '_blank':

			$target = ' target="_blank"';

			break;

		default:

			$target = '';

	}

	if ( $args['rel'] ) {

		$rel = ' rel="' . esc_attr( $args['rel'] ) . '"';

	} else {

		$rel = '';

	}

	if ( $args['id'] ) {

		$id = ' id="' . esc_attr( $args['id'] ) . '"';

	} else {

		$id = '';

	}



	return '<a' . $id . ' class="' . $class . '"' . $href . $target . $rel .'>' . $content . '</a>';

}

add_shortcode('button', 'cerchez_button_shortcode');



/* call to action box */

function cerchez_call_to_action_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'title' => '',

		'class' => '',

	), $atts, 'call-to-action');



	/* clean attributes */

	if ( $args['title'] ) {

		$title = '<h3>' . esc_attr( $args['title'] ) . '</h3>';

	} else {

		$title = '';

	}

	if ( $args['class'] ) {

		$class = ' ' . esc_attr( $args['class'] );

	} else {

		$class = '';

	}



	return '<div class="call-to-action' . $class . '">' . $title . do_shortcode( $content ) . '</div>';

}

add_shortcode('call-to-action', 'cerchez_call_to_action_shortcode');



/* audio */

$GLOBALS['cerchez_audio_added_in_ajax_context'] = false;

function cerchez_audio_shortcode($atts, $content = null) {

	$args = shortcode_atts( array(

		'src' => '',

		'mp3' => '',

		'ogg' => '',

		'wav' => '',

		'loop' => false,

		'autoplay' => false,

		'preload' => true,

		'class' => '',

	), $atts, 'audio');



	/* clean attributes */

	if ( $args['src'] ) {

		$src = ' src="' . esc_url( $args['src'] ) . '"';

	} else {

		$src = '';

	}

	if ( $args['mp3'] ) {

		$mp3 = '<source src="' . esc_url( $args['mp3'] ) . '" type="audio/mpeg">';

	} else {

		$mp3 = '';

	}

	if ( $args['ogg'] ) {

		$ogg = '<source src="' . esc_url( $args['ogg'] ) . '" type="audio/ogg">';

	} else {

		$ogg = '';

	}

	if ( $args['wav'] ) {

		$wav = '<source src="' . esc_url( $args['wav'] ) . '" type="audio/wave">';

	} else {

		$wav = '';

	}

	if ( cerchez_string_to_bool( esc_attr( $args['loop'] ) ) ) {

		$loop = ' loop';

	} else {

		$loop = '';

	}

	if ( cerchez_string_to_bool( esc_attr( $args['autoplay'] ) ) ) {

		$autoplay = ' autoplay';

	} else {

		$autoplay = '';

	}

	if ( cerchez_string_to_bool( esc_attr( $args['preload'] ) ) ) {

		$preload = ' preload="auto"';

	} else {

		$preload = ' preload="none"';

	}



	$class = '';

	if ( $args['class'] ) {

		$class = ' ' . esc_attr( $args['class'] );

	}



	wp_enqueue_script('cerchez_audio_js', CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/audio.min.js', array('jquery'), false, true);



	if ( isset($GLOBALS['cerchez_audio_added_in_ajax_context']) && ! $GLOBALS['cerchez_audio_added_in_ajax_context'] && ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

		// script must be added under each component in AJAX context, not only in footer (because AJAX context cuts header and footer)

		echo "<script type='text/javascript' src='" . CERCHEZ_PLUGIN_URI . "utils/shortcodes/js/audio.min.js'></script>";

		$GLOBALS['cerchez_audio_added_in_ajax_context'] = true;

	}



	return '<audio' . $src . $loop . $autoplay . $preload . ' class="cerchez-audio' . $class . '">' . $mp3 . $ogg . $wav . '</audio>';

}

add_shortcode('audio', 'cerchez_audio_shortcode');



/* accordion container */

function cerchez_accordion_shortcode( $atts, $content = null) {

	$args = shortcode_atts( array(

		'collapse' => true,

	), $atts, 'accordion');



	/* clean attributes */

	if ( cerchez_string_to_bool( esc_attr( $args['collapse'] ) ) ) {

		$collapse = ' only-one-visible';

	} else {

		$collapse = '';

	}

	return '<ul class="accordion' . $collapse . '">' . do_shortcode( $content ) . '</ul>';

}

add_shortcode('accordion', 'cerchez_accordion_shortcode');



/* accordion item */

function cerchez_accordion_item_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'title' => 'Accordion title',

		'opened' => false,

	), $atts, 'accordion-item');



	/* clean attributes */

	$title = esc_attr( $args['title'] );

	if ( cerchez_string_to_bool( esc_attr( $args['opened'] ) ) ) {

		$opened = ' class="active"';

	} else {

		$opened = '';

	}



	return '<li' . $opened .'><h5 class="accordion-title">' . $title . '</h5><div class="accordion-content">' . do_shortcode( $content ) . '</div></li>';

}

add_shortcode('accordion-item', 'cerchez_accordion_item_shortcode');



/* tab container */

$GLOBALS['cerchez_tab_count'] = 0;

function cerchez_tabs_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'id' => 'number',

	), $atts, 'tabs');



	$id = esc_attr( $args['id'] );



	$tabid = $GLOBALS['cerchez_tab_count'];



	do_shortcode( $content );



	if( is_array( $GLOBALS['tabs'] ) ) {

		foreach( $GLOBALS['tabs'] as $tab ) {

			switch( $id ) {

				case "name":

					$tabid = sanitize_title( $tab['title'] );

					break;

				case "number":

					$tabid += 1;

					break;

				default:

					break;

			}

			$opened = ($tab['active']) ? ' class="active"' : '';

			$style = ($tab['active']) ? ' style="display:block"' : ' style="display:none"';

			$tabs[] = '<li' . $opened . '><a href="#tab-' . $tabid . '">' . $tab['title'] . '</a></li>';

			$panes[] = '<div id="tab-' . $tabid . '" class="tab_content"' . $style . '>' . $tab['content'] . '</div>';

		}

		$return = '<div class="tab-container"><ul class="tabs clearfix">' . implode( "\n", $tabs ) . '</ul>' . "\n" . implode( "\n", $panes ) . '</div>' . "\n";

	}

	// Reset the variables in the event we use multiple tabs on single page

	$GLOBALS['tabs'] = null;

	return $return;

}

add_shortcode('tabs', 'cerchez_tabs_shortcode');



/* tab item */

function cerchez_tab_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'title' => 'Tab',

		'active' => false,

	), $atts, 'tab');



	$active = cerchez_string_to_bool( esc_attr( $args['active'] ) );

	$title = esc_attr( sprintf( $args['title'], $GLOBALS['cerchez_tab_count'] ) );



	$x = $GLOBALS['cerchez_tab_count'];

	$GLOBALS['tabs'][$x] = array(

		'title' => $title,

		'active' => $active,

		'content' => do_shortcode($content)

	);

	$GLOBALS['cerchez_tab_count']++;

}

add_shortcode('tab', 'cerchez_tab_shortcode');



/* slider */

$GLOBALS['cerchez_slider_count'] = 0;

$GLOBALS['cerchez_slider_added_in_ajax_context'] = false;

function cerchez_slider_shortcode( $atts, $content = null ) {

	$args = shortcode_atts(

		apply_filters('cerchez_slider_shortcode_attrs_default', array(

			'class' => '',

			'style' => '',

			'autoslide' => false,

			'autoslide_timer' => '',

			'autoslide_timer_trans' => '',

			'pagination' => false,

			'controls' => true,

			'align' => '',

		)

	), $atts, 'slider');



	/* clean attributes */

	if ( $args['class'] ) {

		$class = ' ' . esc_attr( $args['class'] );

	} else {

		$class = '';

	}

	if ( $args['style'] ) {

		$style = ' style="' . esc_attr( $args['style'] ) . '"';

	} else {

		$style = '';

	}

	if ( $args['align'] ) {

		$style .= ' data-image-align="' . esc_attr( $args['align'] ) . '"';

	} else {

		$style .= '';

	}

	if ( cerchez_string_to_bool( $args['autoslide'] ) ) {

		$autoslide = ' data-autoslide="1"';

	} else {

		$autoslide = '';

	}

	if ( $args['autoslide_timer'] ) {

		$autoslide_timer = ' data-autoslide-timer="' . esc_attr( $args['autoslide_timer'] ) . '"';

	} else {

		$autoslide_timer = '';

	}

	if ( $args['autoslide_timer_trans'] ) {

		$autoslide_timer_trans = ' data-autoslide-timer-trans="' . esc_attr( $args['autoslide_timer_trans'] ) . '"';

	} else {

		$autoslide_timer_trans = '';

	}



	wp_enqueue_script('cerchez_slider_js', CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/jquery.cerchezslider.min.js', array('jquery'), false, true);



	if( isset($GLOBALS['cerchez_slider_added_in_ajax_context']) && ! $GLOBALS['cerchez_slider_added_in_ajax_context'] && ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

		// script must be added under each component in AJAX context, not only in footer (because AJAX context cuts header and footer)

		echo "<script type='text/javascript' src='" . CERCHEZ_PLUGIN_URI . "utils/shortcodes/js/jquery.cerchezslider.min.js'></script>";

		$GLOBALS['cerchez_slider_added_in_ajax_context'] = true;

	}



	$GLOBALS['cerchez_slider_count'] = 0;

	$content = do_shortcode( $content );

	$pagination = '';

	if ( cerchez_string_to_bool( $args['pagination'] ) ) {

		$count = (int) $GLOBALS['cerchez_slider_count'];

		if ($count > 1) {

			$pagination .= '<div class="pagination">';

			for ($i=1; $i <= $count; $i++) {

				if ($i == 1) {

					$pagination .= '<div class="page active"><em></em></div>';

				} else {

					$pagination .= '<div class="page"><em></em></div>';

				}

			}

			$pagination .= '</div>';

			$class .= ' show-pagination';

		}

	}

	$controls = '';

	if ( cerchez_string_to_bool( $args['controls'] ) ) {

		$controls = '<div class="controls"><div class="prev"><em></em><span>' . __('Prev','cerchez-core') . '</span></div><div class="next"><em></em><span>' . __('Next','cerchez-core') . '</span></div></div>';

	}



	return '<div class="cerchez-slider-container' . $class . '"' . $style . '><div class="cerchez-slider"' . $autoslide . $autoslide_timer . $autoslide_timer_trans . '><div class="slider">' . $content . '</div>' . $controls . '</div>' . $pagination . '</div>';

}

add_shortcode('slider', apply_filters('cerchez_slider_shortcode','cerchez_slider_shortcode'));



/* slider item */

function cerchez_slider_item_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'caption' => '',

		'caption_url' => '',

		'caption_url_target' => '',

		'image' => '',

		'image_alt' => '',

		'image_width' => '',

		'image_height' => '',

		'extra_attribs' => '',

	), $atts, 'slider-item');



	/* clean attributes */

	if ( $args['caption'] ) {

		$title = '<div class="text">' . $args['caption'] . '</div>';

		if ( $args['caption_url'] ) {

			$target = $args['caption_url_target'];

			switch( $target ) {

				case 'blank':

				case '_blank':

					$target = ' target="_blank"';

					break;

				default:

					$target = '';

			}

			$caption = '<div class="caption"><a href="' . esc_url( $args['caption_url'] ) . '"' . $target . '>' . $title . '</a></div>';

		} else {

			$caption = '<div class="caption">' . $title . '</div>';

		}

	} else {

		$caption = '';

	}

	$GLOBALS['cerchez_slider_count']++;



	if ( $args['image'] ) {

		global $theme_options;

		if ( $args['image_width'] && is_numeric($args['image_width']) ) {

			if ( $theme_options && ! empty($theme_options['retina_images']) ) {

				 $args['image_width'] = round((int) $args['image_width'] / 2);

			}

			$image_width = ' width="' . $args['image_width'] . '"';

		} else {

			$image_width = '';

		}

		if ( $args['image_height'] && is_numeric($args['image_height']) ) {

			if ( $theme_options && ! empty($theme_options['retina_images']) ) {

				 $args['image_height'] = round((int) $args['image_height'] / 2);

			}

			$image_height = ' height="' . $args['image_height'] . '"';

		} else {

			$image_height = '';

		}



		$extra_attribs = $args['extra_attribs'];

		if (strpos($extra_attribs,'~$~') !== false) {

			$extra_attribs = str_replace('~$~', '"', $extra_attribs);

		} else {

			$extra_attribs = '';

		}



		return '<div class="item"><img src="' . esc_url( $args['image'] ) . '"' . $image_width . $image_height . ' alt="' . esc_attr( $args['image_alt'] ) . '" />' . $extra_attribs . $caption . '</div>';

	} else {

		return '<div class="item">' . do_shortcode( $content ) . $caption . '</div>';

	}

}

add_shortcode('slider-item', 'cerchez_slider_item_shortcode');



/* feature item */

function cerchez_feature_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'title' => '',

		'text' => '',

		'image' => '',

		'image_alt' => '',

		'image_width' => '',

		'image_height' => '',

	), $atts, 'feature');



	/* clean attributes */

	if ( $args['title'] ) {

		$title = '<h3>' . esc_attr( $args['title'] ) . '</h3>';

	} else {

		$title = '';

	}

	if ( $args['text'] ) {

		$text = '<p class="small">' . esc_attr( $args['text'] ) . '</p>';

	} else {

		$text = '';

	}



	if ( $args['image'] ) {

		global $theme_options;

		if ( $args['image_width'] && is_numeric($args['image_width']) ) {

			if ( $theme_options && ! empty($theme_options['retina_images']) ) {

				 $args['image_width'] = round((int) $args['image_width'] / 2);

			}

			$image_width = ' width="' . $args['image_width'] . '"';

		} else {

			$image_width = '';

		}

		if ( $args['image_height'] && is_numeric($args['image_height']) ) {

			if ( $theme_options && ! empty($theme_options['retina_images']) ) {

				 $args['image_height'] = round((int) $args['image_height'] / 2);

			}

			$image_height = ' height="' . $args['image_height'] . '"';

		} else {

			$image_height = '';

		}

		return '<div class="feature"><img src="' . esc_url( $args['image'] ) . '"' . $image_width . $image_height . ' alt="' . esc_attr( $args['image_alt'] ) . '" />' . $title . $text . '</div>';

	} else {

		return '<div class="feature">' . do_shortcode( $content ) . $title . $text . '</div>';

	}

}

add_shortcode('feature', 'cerchez_feature_shortcode');



/* lightbox element */

function cerchez_lightbox_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'url' => '',

		'class' => 'fade', // fade, directional, switch 

		'icon' => 'resize-enlarge',

		'title' => '',

		'subtitle' => '',

		'title_inside' => false,

		'gallery' => '',

		'popup' => true,

		'extra_attribs' => '',

		'post_id' => '',

		'url_target' => '',

	), $atts, 'lightbox');



	/* clean attributes */

	if ( $args['class'] ) {

		$class = ' ' . esc_attr( $args['class'] );

		if ( strpos( $class, 'fade') === false && strpos( $class, 'directional') === false ) {

			$class .= ' fade';

		}

	} else {

		$class = '';

	}

	if ( $args['url'] ) {

		$url = ' href="' . esc_url( $args['url'] ) . '"';

		if ( $args['url_target'] ) {

			$url .= ' target="' . esc_attr( $args['url_target'] ) . '"';

		}

	} else {

		$url = '';

	}

	if ( cerchez_string_to_bool( $args['title_inside'] ) ) {

		$outside = '';

		if ( $args['title'] ) {

			$icon_class = " bottom";

			if ( $args['subtitle'] ) {

				$subtitle = '<em class="tagline">' . esc_attr( $args['subtitle'] ) . '</em>';

			} else {

				$subtitle = '';

			}

			$inside = '<strong class="title">' . esc_attr( $args['title'] ) .'</strong>' . $subtitle;

		} else {

			$icon_class = "";

			$inside = '';

		}

		if ( $args['icon'] ) {

			$icon = '<span class="info">' . $inside . '<span class="icon-' . esc_attr( $args['icon'] ) . $icon_class . '"></span></span>';

		} else {

			$icon = '';

		}

	} else {

		if ( $args['icon'] ) {

			$icon = '<span class="info"><span class="icon-' . esc_attr( $args['icon'] ) .'"></span></span>';

		} else {

			$icon = '';

		}

		if ( $args['title'] ) {

			if ( $args['subtitle'] ) {

				$title_class = '';

				$subtitle = '<p class="type">' . esc_attr( $args['subtitle'] ) . '</p>';

			} else {

				$title_class = ' class="padding-bottom"';

				$subtitle = '';

			}

			$outside = '<h4' . $title_class . '>' . esc_attr( $args['title'] ) .'</h4>' . $subtitle;

		} else {

			$outside = '';

		}

	}

	if ( cerchez_string_to_bool( $args['popup'] ) ) {

		if ( isset($args['gallery']) && !empty($args['gallery']) ) {

			$gallery = esc_attr( $args['gallery'] );

		} else {

			$gallery = '';

		}

		$popup = ' rel="lightbox' . $gallery . '"';

	} else {

		$popup = '';

	}



	// internal way of passing extra attributes from [projects]

	$extra_attribs = $args['extra_attribs'];

	if (strpos($extra_attribs,'~$~') !== false) {

		$extra_attribs = str_replace('~$~', '"', $extra_attribs);

	} else {

		$extra_attribs = '';

	}



	global $theme_options;

	if ( $theme_options && ! empty($theme_options['use_theme_lightbox']) ) {

		$popup = str_replace('rel="lightbox','class="lightbox" data-fancybox-group="', $popup);

		cerchez_lightbox_include_script();

	}



	$class = apply_filters('cerchez_lightbox_shortcode_class', $class);



	$output = '<div class="thumb' . $class . '"' . $extra_attribs . '><div class="photo"><a' . $url . $popup . '>' . do_shortcode( $content ) . $icon . '</a></div>' . $outside . '</div>';

	$output = apply_filters('cerchez_lightbox_shortcode_output', $output, $args, $content);

	return $output;

}

add_shortcode('lightbox', 'cerchez_lightbox_shortcode');



$GLOBALS['cerchez_lightbox_added_in_ajax_context'] = false;

function cerchez_lightbox_include_script( $atts = null, $content = null ) {

	wp_enqueue_script('cerchez_lightbox_js', CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/jquery.fancybox.min.js', array('jquery'), false, true);



	if( isset($GLOBALS['cerchez_lightbox_added_in_ajax_context']) && ! $GLOBALS['cerchez_lightbox_added_in_ajax_context'] && ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

		// script must be added under each component in AJAX context, not only in footer (because AJAX context cuts header and footer)

		echo "<script type='text/javascript' src='" . CERCHEZ_PLUGIN_URI . "utils/shortcodes/js/jquery.fancybox.min.js'></script>";

		$GLOBALS['cerchez_lightbox_added_in_ajax_context'] = true;

	}

}

add_shortcode('include-theme-lightbox-script', 'cerchez_lightbox_include_script');



/* add lightbox script when [gallery] shortcode is present */

add_filter('post_gallery', 'cerchez_post_gallery');

function cerchez_post_gallery() {

	global $theme_options;

	if ( $theme_options && ! empty($theme_options['use_theme_lightbox']) ) {

		cerchez_lightbox_include_script();

	}

}



/* projects */

$GLOBALS['cerchez_project_inside_flag'] = false;

$GLOBALS['cerchez_quicksand_added_in_ajax_context'] = false;

function cerchez_projects_shortcode( $atts, $content = null ) {

	$GLOBALS['cerchez_project_inside_flag'] = true;

	$args = shortcode_atts( array(

		'category' => '',

		'tag' => '',

		'limit' => -1,

		'per_row' => 3,

		'showcase' => false,

		'filters' => false,

		'image_width' => 450,

		'image_height' => 300,

		'lightbox_class' => 'fade',

		'lightbox_icon' => 'resize-enlarge',

		'lightbox_title_inside' => false,

		'lightbox_subtitles' => '', // categories, tags

		'lightbox_gallery' => '',

		'lightbox_popup' => true,

		'filter_all_string' => '',

	), $atts, 'projects');



	$query_args = array(

		'post_type' => 'cerchez-project',

		'post_status' => 'publish',

		'orderby' => 'menu_order date',

	);

	if ( isset($args['category']) && $args['category'] != "" && $args['category'] != "0" ) {

		if (is_numeric( $args['category'] )) {

			$query_args['cat'] = (int) $args['category'];

		} else {

			$query_args['category_name'] = $args['category'];

		}

	}

	if ( isset($args['tag']) && $args['tag'] != "" && $args['tag'] != "0" ) {

		if (is_numeric( $args['tag'] )) {

			$query_args['tag_id'] = (int) $args['tag'];

		} else {

			$query_args['tag'] = $args['tag'];

		}

	}

	if ( isset($args['limit']) ) {

		$query_args['posts_per_page'] = (int) $args['limit'];

	} else {

		$query_args['posts_per_page'] = -1;

	}



	$query = new WP_Query( $query_args );



	if ( isset($args['per_row']) && is_numeric( $args['per_row'] ) ) {

		$per_row = (int) $args['per_row'];

		if ($per_row == 0) $per_row = 1;

	} else {

		$per_row = 3;

	}

	$grid_number = (int) (12 / $per_row);



	if ($query->have_posts()) {

		$current = 0;

		global $theme_options;

		if ( $theme_options && ! empty($theme_options["thumb_align"]) ) {

			$image_align = $theme_options["thumb_align"];

		} else {

			$image_align = '';

		}

		if ( $theme_options && ! empty($theme_options["retina_images"]) ) {

			$image_retina = true;

		} else {

			$image_retina = false;

		}

		if ( isset($args['image_width']) ) {

			$image_width = (int) $args['image_width'];

		} else {

			$image_width = 450;

		}

		if ( isset($args['image_height']) ) {

			$image_height = (int) $args['image_height'];

		} else {

			$image_height = 300;

		}

		$lightbox_class = $args['lightbox_class'];

		$lightbox_title_inside = cerchez_string_to_bool( $args['lightbox_title_inside'] );

		$lightbox_subtitles = esc_attr( $args['lightbox_subtitles'] );

		$show_filters = cerchez_string_to_bool( $args['filters'] );

		$showcase = cerchez_string_to_bool( $args['showcase'] );

		$output = '';



		if ($show_filters) {

			$cat_query = array(

				'type' => 'cerchez-project',

				'hide_empty' => 1

			);

			if ( isset($args['category']) && $args['category'] != "0" ) {

				if (is_numeric( $args['category'] )) {

					$cat_query['child_of'] = (int) $args['category'];

				} else {

					$idObj = get_category_by_slug($args['category']);

					if (isset($idObj) && isset($idObj->term_id)) $cat_query['child_of'] = $idObj->term_id;

				}

			}

			$categories = get_categories($cat_query);

			$category_count = count($categories);

			if ( $category_count > 1 ) {

				wp_enqueue_script('cerchez_quicksand_js', CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/jquery.quicksand.min.js', array('jquery'), false, true);

				if( isset($GLOBALS['cerchez_quicksand_added_in_ajax_context']) && ! $GLOBALS['cerchez_quicksand_added_in_ajax_context'] && ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

					// script must be added under each component in AJAX context, not only in footer (because AJAX context cuts header and footer)

					echo "<script type='text/javascript' src='" . CERCHEZ_PLUGIN_URI . "utils/shortcodes/js/jquery.quicksand.min.js'></script>";

					$GLOBALS['cerchez_quicksand_added_in_ajax_context'] = true;

				}

				if (!isset($GLOBALS['cerchez_project_filters'])) {

					$GLOBALS['cerchez_project_filters'] = 0;

				}

				$GLOBALS['cerchez_project_filters']++;

				$filters_output = '<p class="cerchez-filter-selectors" data-container="cerchez-project-filter' . $GLOBALS['cerchez_project_filters'] . '" data-columns="' . $per_row . '">';

				if ( $args['filter_all_string'] ) {

					$filter_all_string = $args['filter_all_string'];

				} else {

					$filter_all_string = __('All','cerchez-core');

				}

				$filters_output .= '<a href="#" class="active" data-filter="all">' . $filter_all_string . '</a>';

				foreach ($categories as $key => $value) {

					$filters_output .= '<a href="#" data-filter="category-' . $value->slug . '">' . $value->name . '</a>';

				}

				$filters_output .= '</p>';

				$output .= apply_filters('cerchez_projects_filters_shortcode_output', $filters_output, $categories, $per_row, $filter_all_string);

				$output .= '<div class="clear"></div><div class="cerchez-filter-container clearfix" id="cerchez-project-filter' . $GLOBALS['cerchez_project_filters'] . '">';

			}

		}



		if ($showcase) {

			$output .= '<div class="portfolio-showcase">';

		}



		while ($query->have_posts()) {

			$query->the_post();

			$inner = '';

			$url = '';

			if ( has_post_thumbnail() ) {

				$attachment_id = get_post_thumbnail_id();

				$full_image_url = wp_get_attachment_url($attachment_id, 'full');

				$image_alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));

				if ( ! empty($full_image_url)) {

					if (function_exists('cerchez_image_resize')) {

						$thumb_image_url = cerchez_image_resize($full_image_url, $image_width, $image_height, true, $image_align, $image_retina);

						$inner = '<img src="' . $thumb_image_url . '" width="' . $image_width . '" height="' . $image_height . '" alt="' . $image_alt . '" />';

					} else {

						$inner = wp_get_attachment_image($attachment_id, 'medium');

					}

				}

				$url = $full_image_url;

			}



			$lightbox_icon = $args['lightbox_icon'];

			$lightbox_gallery = $args['lightbox_gallery'];

			$lightbox_popup = cerchez_string_to_bool( $args['lightbox_popup'] );

			$lightbox_url_target = '';



			if ( ! $lightbox_popup ) {

				$url = get_permalink();

			}



			// check if overrides are available via meta-box properties

			if ( function_exists ('rwmb_meta') ) {

				$override_lightbox_link = rwmb_meta("project_lightbox_link");

				if (isset($override_lightbox_link) && $override_lightbox_link) {

					$url = $override_lightbox_link;

				}

				$override_lightbox_icon = rwmb_meta("project_lightbox_icon");

				if (isset($override_lightbox_icon) && $override_lightbox_icon) {

					$lightbox_icon = $override_lightbox_icon;

				}

				$override_lightbox_popup = rwmb_meta("project_lightbox_popup");

				if (isset($override_lightbox_popup) && $override_lightbox_popup) {

					if ($override_lightbox_popup == 1) {

						$lightbox_popup = true;

					} else if ($override_lightbox_popup == 2) {

						$lightbox_popup = false;

						$lightbox_gallery = ''; // disable gallery feature for external link

					} else if ($override_lightbox_popup == 3) {

						$lightbox_popup = false;

						$lightbox_gallery = '';

						$lightbox_url_target = ' url_target="_blank"';

					}

				}

			}



			$lightbox_popup = ($lightbox_popup) ? 'true' : 'false';



			$subtitle = '';

			switch ($lightbox_subtitles) {

				case 'categories':

					$post_categories = get_the_category();

					if ($post_categories) {

						foreach ($post_categories as $category) {

							if ((isset($query_args['cat']) && $query_args['cat'] == $category->cat_ID) || (isset($query_args['category_name']) && $query_args['category_name'] == $category->category_nicename )) {

								// skip the parent category

							} else {

								$subtitle .= $category->name . ', ';

							}

						}

						$subtitle = rtrim($subtitle, ', ');

					}

					break;



				case 'tags':

					$post_tags = get_the_tags();

					if ($post_tags) {

						foreach ($post_tags as $tag) {

							if ((isset($query_args['tag_id']) && $query_args['tag_id'] == $tag->term_id) || (isset($query_args['tag']) && $query_args['tag'] == $tag->slug )) {

								// skip the parent tag

							} else {

								$subtitle .= $tag->name . ', ';

							}

						}

						$subtitle = rtrim($subtitle, ', ');

					}

					break;



				default:

					$subtitle = '';

					break;

			}



			if ($show_filters) {

				$post_categories = get_the_category();

				$filter_attr = '';

				foreach ($post_categories as $category_value) {

					$filter_attr .= 'category-' . $category_value->slug . ' ';

				}

				$filter_attr = ' data-id="' . get_the_id() . '" data-type="' . trim($filter_attr) . '"';

			} else {

				$filter_attr = '';

			}

			if ($showcase) {

				$extra_attribs = str_replace('"', '~$~', $filter_attr);

				$output .= '[lightbox url="' . $url . '" title="' . get_the_title() . '" class="' . $lightbox_class . '" icon="' . $lightbox_icon . '" gallery="' . $lightbox_gallery . '" title_inside="' . $lightbox_title_inside . '" subtitle="' . $subtitle . '" popup="' . $lightbox_popup . '" extra_attribs="' . $extra_attribs . '" post_id="' . get_the_ID() . '"' . $lightbox_url_target .']' . $inner . '[/lightbox]';

			} else {

				if ( $current % $per_row == 0 ) {

					$first = ' alpha';

				} else {

					$first = '';

				}

				if ( $current % $per_row == ($per_row - 1) ) {

					$last = ' omega';

				} else {

					$last = '';

				}

				$output .= '<div class="col grid' . $grid_number . $first . $last . ' pct"' . $filter_attr . '>[lightbox url="' . $url . '" title="' . get_the_title() . '" class="' . $lightbox_class . '" icon="' . $lightbox_icon . '" gallery="' . $lightbox_gallery . '" title_inside="' . $lightbox_title_inside  . '" subtitle="' . $subtitle . '" popup="' . $lightbox_popup . '" post_id="' . get_the_ID() . '"' . $lightbox_url_target .']' . $inner . '[/lightbox]</div>';

				$current++;

			}

		} // while

		$output .= '<div class="clear"></div>';

		if ($showcase) {

			$output .= '</div>';

		}

		if ($show_filters && $category_count > 1 ) {

			$output .= '</div>';

		}

	} else {

		$output = '';

	} // if (have_posts()



	wp_reset_postdata();



	$output = do_shortcode( $output );

	$output = apply_filters('cerchez_projects_shortcode_output', $output, $args, $content);

	$GLOBALS['cerchez_project_inside_flag'] = false;

	return $output;

}

add_shortcode('projects', 'cerchez_projects_shortcode');



/* news */

function cerchez_news_shortcode( $atts, $content = null ) {

	$args = shortcode_atts( array(

		'category' => '',

		'tag' => '',

		'limit' => 3,

		'image_width' => 450,

		'image_height' => 300,

	), $atts, 'news');



	$query_args = array(

		'post_type' => 'post',

		'post_status' => 'publish',

	);

	if ( isset($args['category']) && $args['category'] != "" && $args['category'] != "0" ) {

		if (is_numeric( $args['category'] )) {

			$query_args['cat'] = (int) $args['category'];

		} else {

			$query_args['category_name'] = $args['category'];

		}

	}

	if ( isset($args['tag']) && $args['tag'] != "" && $args['tag'] != "0" ) {

		if (is_numeric( $args['tag'] )) {

			$query_args['tag_id'] = (int) $args['tag'];

		} else {

			$query_args['tag'] = $args['tag'];

		}

	}

	if ( isset($args['limit']) ) {

		$query_args['posts_per_page'] = (int) $args['limit'];

	} else {

		$query_args['posts_per_page'] = 3;

	}



	$query = new WP_Query( $query_args );

	if ($query->have_posts()) {

		global $theme_options;

		if ( $theme_options && ! empty($theme_options["thumb_align"]) ) {

			$image_align = $theme_options["thumb_align"];

		} else {

			$image_align = '';

		}

		if ( $theme_options && ! empty($theme_options["retina_images"]) ) {

			$image_retina = true;

		} else {

			$image_retina = false;

		}

		if ( isset($args['image_width']) ) {

			$image_width = (int) $args['image_width'];

		} else {

			$image_width = 450;

		}

		if ( isset($args['image_height']) ) {

			$image_height = (int) $args['image_height'];

		} else {

			$image_height = 300;

		}

		$output = '';



		while ($query->have_posts()) {

			$query->the_post();

			if ( has_post_thumbnail() ) {

				$attachment_id = get_post_thumbnail_id();

				$full_image_url = wp_get_attachment_url( $attachment_id, 'full');

				$image_alt = trim(strip_tags( get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ));

				if ( ! empty($full_image_url)) {

					if ( function_exists('cerchez_image_resize') ) {

						$thumb_image_url = cerchez_image_resize( $full_image_url, $image_width, $image_height, true, $image_align, $image_retina );

					} else {

						$thumb_image_url = $full_image_url;

					}

				}

				if ( ! isset($thumb_image_url)) $thumb_image_url= '';

				$inner = '<img src="' . $thumb_image_url . '" alt="' . $image_alt . '">';

				$output .= '<div class="col grid3 alpha pct">[lightbox url="' . get_permalink() . '" icon="link" popup="false"]<img src="' . $thumb_image_url . '" alt="' . $image_alt . '">[/lightbox]</div>';

			} else {

				$output .= '<div class="col grid3 alpha pct">&nbsp;</div>';

			}

			if ( $theme_options && empty($theme_options['theme_comments']) && ! post_password_required() && comments_open() ) {

				$comments_no = get_comments_number();

				if ( $comments_no > 1 ) {

					$comments_output = str_replace('%', number_format_i18n($comments_no), __('% Comments', 'cerchez-core'));

				} elseif ( $comments_no == 0 ) {

					$comments_output = __('No Comments', 'cerchez-core');

				} else {

					$comments_output = __('1 Comment', 'cerchez-core');

				}

				$comments = ' <em class="meta"><span class="icon-comment"></span> ' . $comments_output . '</em>';

			} else {

				$comments = '';

			}

			$meta = '<em class="meta"><span class="icon-calendar"></span> ' . get_the_date() . '</em> <em class="meta"><span class="icon-user"></span> ' . get_the_author() . '</em>' . $comments;

			$output .= '<div class="col grid9 omega pct post-info"><h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>' . $meta . '<p class="small">' . get_the_excerpt() . '</p></div>';

			$output .= '<div class="clear"></div>';

		} // while

		$output .= '<div class="clear"></div>';

	} else {

		$output = '';

	} // if (have_posts()



	wp_reset_postdata();



	$output = do_shortcode( $output );

	$output = apply_filters('cerchez_news_shortcode_output', $output, $args, $content, $query);

	return $output;

}

add_shortcode('news', 'cerchez_news_shortcode');

