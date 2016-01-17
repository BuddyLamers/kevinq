<?php

/**

 * Tosca theme functions and definitions

 * Set up the theme and provides some helper functions.

 *

 */



add_action('after_setup_theme', 'tosca_theme_setup');



function tosca_theme_setup() {



	/**

	 * Set the content width based on the theme's design and stylesheet.

	 */

	if ( ! isset( $content_width ) ) $content_width = 640;



	/**

	 * Make theme available for translation.

	 * Translations can be placed in the /languages/ directory.

	 */

	load_theme_textdomain('tosca', get_template_directory() . '/languages');



	/* set theme supported features */

	add_theme_support('post-thumbnails');

	add_theme_support('automatic-feed-links');

	add_theme_support('title-tag');

	add_theme_support('post-formats', array('gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

	add_theme_support('html5', array('gallery', 'caption'));

	add_theme_support('admin-bar', array('callback' => '__return_false'));



	add_action('init', 'tosca_register_menus');

	add_action('widgets_init', 'tosca_widgets_init', 8);

	add_action('wp_enqueue_scripts', 'tosca_scripts_and_style_function');

	add_action('wp_before_admin_bar_render', 'tosca_wp_admin_bar_menu');



	add_filter('body_class', 'tosca_body_class');

	add_filter('wp_nav_menu_items', 'tosca_nav_menu_items', 10, 2);

	add_filter('next_posts_link_attributes', 'tosca_next_posts_link_attributes', 10, 3);

	add_filter('edit_comment_link', 'tosca_edit_comment_link');

	add_filter('excerpt_length', 'tosca_excerpt_length', 99);

	add_filter('excerpt_more', 'tosca_excerpt_more');



	/* load some custom editor styling from editor-style.css */

	add_editor_style();

}



/* register main header menu */

function tosca_register_menus() {

	register_nav_menus( array(

		'main_menu' => esc_html__('Main Menu', 'tosca')

	) );

	register_nav_menus( array(

		'logo_menu' => esc_html__('Logo Menu', 'tosca')

	) );

}



/* sidebar widgets */

function tosca_widgets_init() {

	register_sidebar(array(

		'name' => esc_html__('Default Sidebar', 'tosca'),

		'id' => 'default-sidebar',

		'description' => esc_html__('The default widget area for the theme sidebar.', 'tosca'),

		'before_widget' => '<div class="widget %2$s">',

		'after_widget' => '</div>',

		'before_title' => '<h3 class="widget-title">',

		'after_title' => '</h3>',

	));

}



/* add Theme Options link in the top admin bar */

function tosca_wp_admin_bar_menu() {

	global $wp_admin_bar;

	if ( ! is_admin_bar_showing() || ! is_object($wp_admin_bar) || ! current_user_can('edit_theme_options') || is_admin() ) return false;



	$wp_admin_bar->add_menu( array( 'parent' => 'appearance', 'id' => 'theme-options', 'title' => esc_html__('Theme Options', 'tosca'), 'href' => admin_url('themes.php?page=themeoptions'), 'menu_position' => 2 ) );

}



/* enqueue resources */

function tosca_scripts_and_style_function() {



	global $theme_options;

	global $is_IE;



	// gatter font options (family names, weights and subsets)

	$fonts = array();

	$subsets = array();

	if ( isset($theme_options['font_body']) && ! empty($theme_options['font_body']) && ! empty($theme_options['font_body']['family']) ) {

		$fonts[$theme_options['font_body']['family']]['variants'][$theme_options['font_body']['variant']] = $theme_options['font_body']['variant'];

		$fonts[$theme_options['font_body']['family']]['subsets'][$theme_options['font_body']['subset']] = $theme_options['font_body']['subset'];

		$subsets[$theme_options['font_body']['subset']] = $theme_options['font_body']['subset'];

	}

	if ( isset($theme_options['font_headings']) && ! empty($theme_options['font_headings']) && ! empty($theme_options['font_headings']['family']) ) {

		$fonts[$theme_options['font_headings']['family']]['variants'][$theme_options['font_headings']['variant']] = $theme_options['font_headings']['variant'];

		$fonts[$theme_options['font_headings']['family']]['subsets'][$theme_options['font_headings']['subset']] = $theme_options['font_headings']['subset'];

		$subsets[$theme_options['font_headings']['subset']] = $theme_options['font_headings']['subset'];

	}

	// enqueue google fonts based on the previous collected options

	if (count($fonts) > 0) {

		$fonts_protocol = is_ssl() ? 'https' : 'http';

		$fonts_url = '';

		// check if we can make a single google font request, instead of having 2 separate ones

		if (count($subsets) < 2) { // we got ourself an optimization boost

			$fonts_to_load = '';

			foreach ($fonts as $font_name => $font_properties) {

				$fonts_to_load .= '|' . $font_name . ':' . implode(',', $font_properties['variants']);

			}

			$subsets_to_load = current($subsets);

			$font_subset_ext_pos = strpos($subsets_to_load, '-ext');

			if ($font_subset_ext_pos !== false) {

				$subsets_to_load = substr($subsets_to_load, 0, $font_subset_ext_pos) . ',' . $subsets_to_load;

			}

			$fonts_to_load = ltrim($fonts_to_load, '|');

			$fonts_url = add_query_arg(array(

				'family' => urlencode($fonts_to_load),

				'subset' => urlencode($subsets_to_load)

			), "//fonts.googleapis.com/css");

		} else { // load each font separately

			$count = 0;

			foreach ($fonts as $font_name => $font_properties) {

				$count++;

				$fonts_to_load = $font_name . ':' . implode(',', $font_properties['variants']);

				$subsets_to_load = current($font_properties['subsets']);

				$font_subset_ext_pos = strpos($subsets_to_load, '-ext');

				if ($font_subset_ext_pos !== false) {

					$subsets_to_load = substr($subsets_to_load, 0, $font_subset_ext_pos) . ',' . $subsets_to_load;

				}

			}

			$fonts_url = add_query_arg(array(

				'family' => urlencode($fonts_to_load),

				'subset' => urlencode($subsets_to_load)

			), "//fonts.googleapis.com/css");

		}

		if ($fonts_url) {

			wp_enqueue_style('tosca-google-fonts', $fonts_url, array(), null);

		}

	}



	if ( ! empty($theme_options['smooth_scroll']) && ! $is_IE && ! is_page_template('template-under-construction.php') ) {

		wp_enqueue_script('tosca-smooth-scroll', get_template_directory_uri() . '/js/smoothscroll.js', false, false, true);

	}



	wp_enqueue_style('tosca-main', get_template_directory_uri() . '/style.css');



	if ( ! empty($theme_options['custom_heading']) && ! empty($theme_options['custom_heading_parallax']) && ! is_page_template('template-under-construction.php') ) {

		wp_enqueue_script('tosca-parallax', get_template_directory_uri() . '/js/parallax.js', array('jquery'), false, true);

	}



	wp_enqueue_script('tosca-site', get_template_directory_uri() . '/js/site.js', array('jquery'), false, true);



	if ( is_singular() && comments_open() && get_option('thread_comments') ) {

		wp_enqueue_script('comment-reply');

	}



	/* add gravity forms custom css when necessary */

	if ( class_exists('GFForms') ) {

		if ( is_singular() ) {

			$post = get_post();

			if ( has_shortcode($post->post_content, 'gravityform') ) {

				wp_enqueue_style('tosca-gforms', get_template_directory_uri() . '/style-gforms.css');

			}

		}

	}



	/* avoid using contact-form-7 script when unecessary */

	if ( class_exists('WPCF7_ContactForm') ) {

		$load_scripts = false;

		if ( is_singular() ) {

			$post = get_post();

			if ( has_shortcode($post->post_content, 'contact-form-7') ) {

				$load_scripts = true;

			}

		}

		if ( ! $load_scripts ) {

			wp_dequeue_script('contact-form-7');

			wp_dequeue_style('contact-form-7');

		}

	}



	/* add Custom CSS via wp_add_inline_style */

	$additional_css = '';

	if ( isset($theme_options['font_body']) && ! empty($theme_options['font_body']) && ! empty($theme_options['font_body']['family']) ) {

		if (isset($theme_options['font_body']['variant'])) {

			if ($theme_options['font_body']['variant'] != 'regular') {

				$body_font_weight = ';font-weight:' . $theme_options['font_body']['variant'];

			} else {

				$body_font_weight = ';font-weight:400';

			}

		} else {

			$body_font_weight = '';

		}

		$additional_css .= 'body,#post-list h3 .meta,.woocommerce .product .thumb a .price{font-family:"' . $theme_options['font_body']['family'] . '",Arial,sans-serif' . $body_font_weight . ';}';

	}

	if ( isset($theme_options['font_headings']) && ! empty($theme_options['font_headings']) && ! empty($theme_options['font_headings']['family']) ) {

		if (isset($theme_options['font_headings']['variant']) && $theme_options['font_headings']['variant'] != 'regular') {

			if ($theme_options['font_headings']['variant'] != 'regular') {

				$headings_font_weight = ';font-weight:' . $theme_options['font_headings']['variant'];

			} else {

				$headings_font_weight = ';font-weight:400';

			}

		} else {

			$headings_font_weight = '';

		}

		$additional_selectors = '';

		if (class_exists('WooCommerce')) {

			$additional_selectors = ',.woocommerce .product .thumb a';

		}

		$additional_css .= 'h1,h2,h3,h4,h5,h6,.cerchez-filter-selectors a,.thumb .photo .info .title' . $additional_selectors . '{font-family:"' . $theme_options['font_headings']['family'] . '",Arial,sans-serif' . $headings_font_weight . ';}';

	}



	$featured_image_overlay_color = isset($theme_options['heading_image_overlay_color']) ? $theme_options['heading_image_overlay_color'] : '';

	$featured_image_overlay_opacity = isset($theme_options['heading_image_overlay_opacity']) ? $theme_options['heading_image_overlay_opacity'] : 0;



	global $wp_query;

	if ($wp_query->is_singular) {

		$tosca_post_id = $wp_query->queried_object_id;

	}

	if ( class_exists('WooCommerce') && is_shop() ) {

		$temp_id = get_option('woocommerce_shop_page_id');

		if ($temp_id) {

			$tosca_post_id = $temp_id;

		}

	}

	if ( isset($tosca_post_id) && function_exists('rwmb_meta') ) {

		$new_featured_image_overlay_color = rwmb_meta('featured_image_overlay_color', array(), $tosca_post_id);

		if ( ! empty($new_featured_image_overlay_color)) $featured_image_overlay_color = $new_featured_image_overlay_color;

		$new_featured_image_overlay_opacity = rwmb_meta('featured_image_overlay_opacity', array(), $tosca_post_id);

		if ( isset($new_featured_image_overlay_opacity) && $new_featured_image_overlay_opacity != '') $featured_image_overlay_opacity = $new_featured_image_overlay_opacity;

	}



	if ($featured_image_overlay_color && $featured_image_overlay_opacity) {

		$additional_css .= '#featured-media .overlay{background-color:' . $featured_image_overlay_color . ';opacity:' . $featured_image_overlay_opacity / 100 . ';}';

	}



	if (isset($theme_options['custom_css'])) {

		$custom_css = $additional_css . $theme_options['custom_css'];

	} else {

		$custom_css = $additional_css;

	}



	if ( ! empty($custom_css) ) {

		wp_add_inline_style('tosca-main', wp_kses($custom_css, array( '\'', '\"' ) ));

	}



}



function tosca_html_tag_schema() {

	$schema = 'http://schema.org/';

	$type   = 'WebPage';



	// Is single post

	if ( is_singular( 'post' ) ) {

		$type = 'Article';

	}



	// Is author page

	elseif ( is_author() ) {

		$type = 'ProfilePage';

	}



	// Is search results page

	elseif ( is_search() ) {

		$type = 'SearchResultsPage';

	}



	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( $type ) . '"';

}



function tosca_get_featured_image() {

	$featured_image = array();

	global $theme_options;

	if (isset($theme_options['custom_heading_image']) && ! empty($theme_options['custom_heading_image']) && ! empty($theme_options['custom_heading_image']['url'])) {

		$featured_image = $theme_options['custom_heading_image'];

	}

	// override header image from post/page

	global $wp_query;

	if ($wp_query->is_singular && has_post_thumbnail($wp_query->queried_object_id)) {

		$tosca_post_id = $wp_query->queried_object_id;

	}

	if ( class_exists('WooCommerce') && is_shop() ) {

		$temp_id = get_option('woocommerce_shop_page_id');

		if ($temp_id) {

			$tosca_post_id = $temp_id;

		}

	}

	if (isset($tosca_post_id)) {

		$featured_image_id = get_post_thumbnail_id($tosca_post_id);

		$featured_image_data = wp_get_attachment_image_src($featured_image_id, 'full');

		$featured_image['url'] = $featured_image_data[0];

		$featured_image['width'] = $featured_image_data[1];

		$featured_image['height'] = $featured_image_data[2];

	} else if ( class_exists('WooCommerce') && is_product_category() ) {

		global $wp_query;

		$cat = $wp_query->get_queried_object();

		$featured_image_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);

		$featured_image_data = wp_get_attachment_image_src($featured_image_id, 'full');

		if ($featured_image_data) {

			$featured_image['url'] = $featured_image_data[0];

			$featured_image['width'] = $featured_image_data[1];

			$featured_image['height'] = $featured_image_data[2];

		}

	}



	/* obtain image caption and description using generic wpdb */

	if (isset($featured_image['url'])) {

		$parsed_url = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $featured_image['url'] );

		$this_host = str_ireplace( 'www.', '', parse_url( home_url(), PHP_URL_HOST ) );

		$file_host = str_ireplace( 'www.', '', parse_url( $featured_image['url'], PHP_URL_HOST ) );

		if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {

			return $featured_image;

		}

		$parsed_url[1] = preg_replace('/-[0-9]{1,4}x[0-9]{1,4}\.(jpg|jpeg|png|gif|bmp)$/i', '.$1', $parsed_url[1] );

		global $wpdb;

		$attachment = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_content, post_excerpt FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );

		if (isset($attachment[0]) && property_exists($attachment[0],'ID') && ! empty($attachment[0]->post_content)) {

			$featured_image['description'] = $attachment[0]->post_content;

		}

		if ( ! isset($featured_image_id) && isset($attachment[0]) && property_exists($attachment[0],'ID') ) {

			$featured_image_id = $attachment[0]->ID;

		}

	}



	if (isset($featured_image_id)) {

		$featured_image['alt'] = trim(strip_tags( get_post_meta($featured_image_id, '_wp_attachment_image_alt', true) ));

		if (function_exists('wp_get_attachment_image_srcset') && function_exists('wp_get_attachment_image_sizes')) {

			$featured_image['srcset'] = wp_get_attachment_image_srcset($featured_image_id, 'full');

			if (isset($featured_image['width'])) {

				$featured_image['sizes'] = wp_get_attachment_image_sizes( $featured_image_id, 'full', $featured_image['width']);

			}

		}

	}



	return $featured_image;

}



function tosca_get_featured_video($featured_video, $dont_mute = false, $autoplay = true, $loop = true, $featured_video_id = 'featuredplayer') {

	global $theme_options;

	if (strpos($featured_video, 'iframe') !== FALSE) {

		// retrieve the video url

		$anchorRegex = '/src="(.*)?"/isU';

		$results = array();

		if (preg_match($anchorRegex, $featured_video, $results)) {

			$video_link = trim($results[1]);

		}

	} else {

		// we already have a url

		$video_link = $featured_video;

	}

	// if we have a URL, parse it down

	if ( ! empty($video_link)) {

		// initial values

		$video_id = NULL;

		$videoIdRegex = NULL;

		$results = array();

		// check for type of youtube link

		if (strpos($video_link, 'youtu') !== FALSE) {

			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_link, $match)) {

				$video_protocol = 'https';

				$video_link = '<iframe id="yt_' . $featured_video_id . '" src="' . $video_protocol . '://www.youtube.com/embed/%1$s?playlist=%1$s&amp;enablejsapi=1&amp;%2$s%3$splayerapiid=yt_' . $featured_video_id . '&amp;controls=0&amp;modestbranding=1&amp;rel=0&amp;showinfo=0&amp;color=white&amp;iv_load_policy=3&amp;theme=light&amp;wmode=transparent" class="youtube%4$s"></iframe>';

				wp_enqueue_script('youtube-iframeapi', $video_protocol . '://www.youtube.com/iframe_api', false, false, true); // queued in footer

				$video_id = $match[1];

			}

		} else if (strpos($video_link, 'vimeo') !== FALSE) {

			// handle vimeo videos

			if (strpos($video_link, 'player.vimeo.com') !== FALSE) {

				$videoIdRegex = '/player.vimeo.com\/video\/([0-9]+)\??/i';

			} else {

				$videoIdRegex = '/vimeo.com\/([0-9]+)\??/i';

			}

			if ($videoIdRegex !== NULL) {

				if (preg_match($videoIdRegex, $video_link, $results)) {

					$video_protocol = is_ssl() ? 'https' : 'http';

					$video_link = '<iframe id="vm_' . $featured_video_id . '" src="' . $video_protocol . '://player.vimeo.com/video/%1$s?%2$s%3$sapi=1&amp;player_id=vm_' . $featured_video_id . '&amp;controls=0&amp;title=0&amp;byline=0&amp;badge=0" class="vimeo%4$s"></iframe>';

					wp_enqueue_script('vimeo-froogaloop2', $video_protocol . '://a.vimeocdn.com/js/froogaloop2.min.js', false, false, true); // queued in footer

					$video_id = $results[1];

				}

			}

		}

		if ( ! empty($video_id)) {

			if ($autoplay) {

				$featured_video_autoplay = 'autoplay=1&amp;';

			} else {

				$featured_video_autoplay = '';

			}

			if ($loop) {

				$featured_video_loop = 'loop=1&amp;';

			} else {

				$featured_video_loop = '';

			}

			$extra_class = ($dont_mute) ? '' : ' mute';

			$featured_video = sprintf($video_link, $video_id, $featured_video_autoplay, $featured_video_loop, $extra_class);

		}

	}

	return $featured_video;

}



// remove spaces and new lines between menu items to avoid any CSS space problems (applied only to theme specific menu)

function tosca_nav_menu_items($menu, $args) {

	if ($args->theme_location == 'main_menu' || $args->theme_location == 'logo_menu') {

		return preg_replace('/>(\s|\n|\r)+</', '><', $menu);

	} else {

		return $menu;

	}

}



/* style edit comments links */

function tosca_edit_comment_link($link) {

	$pos = strpos($link, 'comment-edit-link');

	return substr_replace($link, 'button small ', $pos, 0);

}



/* set post excerpt options */

function tosca_excerpt_length($length) {

	return 30;

}

function tosca_excerpt_more($more) {

	return ' <a href="' . esc_url(get_the_permalink()) .'" class="more-link">[&#8230;]</a>';

}



/* pagination utils */

function tosca_next_posts_link_attributes() {

	return 'class="button"';

}



function tosca_pagination_links() {

	global $wp_query, $paged, $theme_options;

	$max = $wp_query->max_num_pages;

	if ( $max > 1 ) {

		$current = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

		if ( ! $paged ) $paged = $current;

		$current = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

		if ( ! $paged ) $paged = $current;

		$a['base'] = str_replace(9999999, '%#%', get_pagenum_link(9999999));

		$a['total'] = $max;

		$a['current'] = $current;

		$a['mid_size'] = 1;

		$a['prev_text'] = '<em class="icon-arrow-left"></em>';

		$a['next_text'] = '<em class="icon-arrow-right"></em>';

		echo '<div class="pagination animate-in-view">' . paginate_links($a) . '</div>';

	}

}



/* add some useful classes to the body DOM element */

function tosca_body_class($classes = '') {

	global $theme_options;

	$classes[] = 'hide-background';

	if (isset($theme_options['menu_separators']) && ! empty($theme_options['menu_separators'])) {

		$classes[] = 'menu-separators';

	}

	if (isset($theme_options['animate_in_view_elements']) && ! empty($theme_options['animate_in_view_elements'])) {

		$classes[] = 'animate-elems-in-view';

	}

	if (isset($theme_options['sticky_header']) && ! empty($theme_options['sticky_header'])) {

		$classes[] = 'has-sticky-header';

	}



	$custom_heading_size = isset($theme_options['custom_heading_size']) ? $theme_options['custom_heading_size'] : 'full';

	$centered_heading_caption = false;

	global $wp_query;

	if ($wp_query->is_singular) {

		$tosca_post_id = $wp_query->queried_object_id;

	}

	if ( class_exists('WooCommerce') && is_shop() ) {

		$temp_id = get_option('woocommerce_shop_page_id');

		if ($temp_id) {

			$tosca_post_id = $temp_id;

		}

	}

	if ( isset($tosca_post_id) && function_exists('rwmb_meta') ) {

		$new_custom_heading_size = rwmb_meta('heading_size', array(), $tosca_post_id);

		if ( ! empty($new_custom_heading_size)) {

			$custom_heading_size = $new_custom_heading_size;

		}

		$new_centered_heading_caption = rwmb_meta('header_caption_centered', array(), $tosca_post_id);

		if ( ! empty($new_centered_heading_caption)) {

			$centered_heading_caption = true;

		}

	} else if ( class_exists('WooCommerce') && is_product_category() ) {

		$centered_heading_caption = true;

	}



	if ( is_page_template('template-under-construction.php') ) {

		$custom_heading_size = 'full';

	}



	if ($custom_heading_size) {

		$classes[] = 'featured-header-' . esc_attr($custom_heading_size);

	}



	if ($centered_heading_caption) {

		$classes[] = 'heading-caption-centered';

	}



	if ( class_exists('GFForms') ) {

		$classes[] = 'gf-forms-plugin';

	}



	return $classes;

}



/* load admin panel options */

define('ADMIN_PATH', get_template_directory() . '/utils/admin/');

define('ADMIN_DIR', get_template_directory_uri() . '/utils/admin/');

if ( file_exists( get_template_directory() . '/utils/admin/index.php' )) {

	require_once('utils/admin/index.php');

} else {

	wp_die( esc_html__('Please reinstall the theme, one of the main files is missing.', 'tosca') );

}



/* add core configuration */

if ( file_exists( get_template_directory() . '/utils/cerchez-core-config.php' )) {

	require_once('utils/cerchez-core-config.php');

}



/* add extra metaboxes */

if ( class_exists('RW_Meta_Box') && file_exists( get_template_directory() . '/utils/meta-box-config.php' )) {

	require_once('utils/meta-box-config.php');

}



/* add modules builder */

if ( is_admin() && file_exists( get_template_directory() . '/utils/module-builder/module-builder.php' )) {

	require_once('utils/module-builder/module-builder.php');

}



/* add woocommerce integration */

if ( class_exists('WooCommerce') && file_exists( get_template_directory() . '/utils/woocommerce-config.php' )) {

	require_once('utils/woocommerce-config.php');

}



/* suggest plugins with the TGM Plugin Activation class */

if ( is_admin() && file_exists( get_template_directory() . '/utils/class-tgm-plugin-activation.php') ) {



	require_once('utils/class-tgm-plugin-activation.php');



	add_action('tgmpa_register', 'tosca_register_required_plugins');

	function tosca_register_required_plugins() {

		$plugins = array(

			array(

				'name' => 'Cerchez Core',

				'slug' => 'cerchez-core',

				'source' => get_template_directory() . '/utils/plugins/cerchez-core.zip',

				'version' => '1.4.2',

				'required' => true,

				'force_activation' => true,

			),

			array(

				'name' => 'WooCommerce',

				'slug' => 'woocommerce',

				'required' => false,

			),

			array(

				'name' => 'Contact Form 7',

				'slug' => 'contact-form-7',

				'required' => false,

			),

			array(

				'name' => 'Simple Page Sidebars',

				'slug' => 'simple-page-sidebars',

				'required' => false,

			),

		);



		tgmpa( $plugins );

	}

}



/* add importer functionality - cerchez core plugin must be active */

$import_theme_data_run_once = get_option('import_theme_demo_data_check');

if ( class_exists('Cerchez_Theme_Importer') && ! $import_theme_data_run_once && file_exists( get_template_directory() . '/utils/cerchez-importer-init.php' )) {

	require_once('utils/cerchez-importer-init.php');

}

// clear existent widgets during import

add_action('cerchez_theme_import_widget_data', 'tosca_import_widget_data');

function tosca_import_widget_data($data) {

	update_option('sidebars_widgets', null);

	return $data;

}



/* add support for image resizing/cropping */

if ( ! function_exists('theme_thumb') ) {

	function theme_thumb( $url, $width, $height = 0, $align = '', $retina = false ) {

		if ( function_exists('cerchez_image_resize') ) {

			global $theme_options;

			if ( $align == '' && ! empty($theme_options["thumb_align"]) ) $align = esc_attr($theme_options["thumb_align"]);

			return cerchez_image_resize( $url, $width, $height, true, $align, $retina );

		} else {

			return $url;

		}

	}

}



/* comments section */

if ( ! function_exists('tosca_comments') ) {



	function tosca_comments( $comment, $args, $depth ) {

		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :

			case 'pingback' :

			case 'trackback' :

			// Display trackbacks differently than normal comments.

		?>

			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

					<p><?php esc_html_e('Pingback:', 'tosca'); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__('(Edit)', 'tosca') ); ?></p>

<?php

				break;



			default :

			// Proceed with normal comments.

			global $post; ?>



			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">

				<div class="clearfix">

					<div class="comment-author"><?php echo get_avatar( $comment, 120 ); ?></div>

					<div class="comment-body">

						<h6><?php echo get_comment_author_link( $comment->comment_ID ); ?> <?php comment_reply_link( array_merge( $args, array('reply_text' => esc_html__('(reply)', 'tosca'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></h6>

						<p class="comment-date"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php /* 1: date, 2: time */

							printf( esc_html__('%1$s at %2$s', 'tosca'), get_comment_date(), get_comment_time() ); ?></a></p>

						<div class="comment_body_text">

							<?php comment_text(); ?>

						</div>

						<div class="comment-actions">

							<?php if ( $comment->comment_approved == '0' ) : ?>

							<span class="button small filled"><?php esc_html_e('Comment is awaiting moderation', 'tosca'); ?></span>

							<?php endif; ?>

							<?php edit_comment_link( esc_html__('Edit', 'tosca') ); ?>

						</div>

					</div>

				</div>

<?php

			break;

		endswitch; // end comment_type check

	}



} // function_exists ('tosca_comments')

