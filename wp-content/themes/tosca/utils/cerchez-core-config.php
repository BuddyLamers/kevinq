<?php

/* Configure settings for Cerchez Core plugin */

if (is_admin()) {

// remove some attribute not required in the theme
global $cerchez_core_shortcodes_options;

if (isset($cerchez_core_shortcodes_options['grid'])) {
	unset($cerchez_core_shortcodes_options['grid']['options']['cerchez_core_grid_first']);
}

if (isset($cerchez_core_shortcodes_options['feature'])) {
	unset($cerchez_core_shortcodes_options['feature']);
}

if (isset($cerchez_core_shortcodes_options['news'])) {
	unset($cerchez_core_shortcodes_options['news']['options']['cerchez_core_news_image_width']);
	unset($cerchez_core_shortcodes_options['news']['options']['cerchez_core_news_image_height']);
}

if (isset($cerchez_core_shortcodes_options['social'])) {
	$cerchez_core_shortcodes_options['social']['options']['cerchez_core_social_type']['options']['location'] = esc_html__('Map Location', 'tosca');
	$cerchez_core_shortcodes_options['social']['options']['cerchez_core_social_type']['options']['phone'] = esc_html__('Phone Number', 'tosca');
}

add_filter('cerchez_core_shortcodes_button_menu','cerchez_core_shortcodes_button_menu', 10, 3);
function cerchez_core_shortcodes_button_menu($button_menu) {
	if (isset($button_menu['basic']['childs']['feature'])) {
		unset($button_menu['basic']['childs']['feature']);
	}
	return $button_menu;
}

} // end if is_admin()

/* adjust news shortcode html output */
add_filter('cerchez_news_shortcode_output', 'tosca_news_shortcode_output', 10, 4);
function tosca_news_shortcode_output($output, $args, $content, $query) {
	// rewind query
	$query->current_post = -1;
	if ( $query->post_count > 0 ) {
		$query->post = $query->posts[0];
	}

	if ($query->have_posts()) {
		$output = '<div id="post-list">';
		while ($query->have_posts()) {
			$query->the_post();
			$output .= '<article id="post-' . get_the_ID() . '" class="' . join(' ', get_post_class()) . '">';
			$image_html = '<em></em>';
			if ( has_post_thumbnail() ) {
				$image_html = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
			}
			$output .= '<h3><a href="' . esc_url(get_permalink()) . '" class="title">' . $image_html . '<span>' . get_the_title() . '</span></a><span class="meta">';
			if ( ! post_password_required() && comments_open() ) {
				$output .= '<a class="comment-no"><em class="icon-comments"></em> ';
				ob_start();
				comments_number();
				$output .= ob_get_contents();
				ob_end_clean();
				$output .= '</a>';
			}
			$output .= '<a><em class="icon-clock"></em> ' . get_the_time(get_option('date_format')) . '</a>';
			$output .= '</span></h3></article>';
		} // while
		$output .= '</div>';
	} else {
		$output = '';
	} // if (have_posts()

	return $output;
}

add_filter('cerchez_lightbox_shortcode_class', 'tosca_lightbox_shortcode_class', 10, 1);
function tosca_lightbox_shortcode_class($class) {
	if ($class) {
		$class .= ' animate-in-view';
	} else {
		$class = 'animate-in-view';
	}
	return $class;
}