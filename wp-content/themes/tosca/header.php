<?php

/**

 * The template for displaying the header

 *

 * Displays all of the head element and featured media area (hero section).

 *

 */



?><!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js<?php global $theme_options; if (isset($theme_options['page_border']) && ! empty($theme_options['page_border'])) echo ' page-border'; ?>" <?php tosca_html_tag_schema(); ?>>

<head>

<meta charset="<?php bloginfo('charset'); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php



$featured_area = isset($theme_options['custom_heading']) && ! empty($theme_options['custom_heading']);

$featured_area = apply_filters('tosca_featured_area', $featured_area, $featured_area);

$featured_image = tosca_get_featured_image();

$featured_image_pos = isset($theme_options['custom_heading_image_position']) ? $theme_options['custom_heading_image_position'] : 'center top';

$featured_slideshow = '';

$featured_video = '';

$featured_custom_code = '';

$featured_caption = '';

$featured_caption_pos = isset($theme_options['custom_heading_caption_position']) ? $theme_options['custom_heading_caption_position'] : 'small-left';

$force_featured_area_hidden = false;

// obtain slideshow of video if singular meta data is available

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

	$featured_custom_code = rwmb_meta('header_custom_code', array(), $tosca_post_id);

	$featured_slideshow = rwmb_meta('header_slideshow', array('type' => 'image_advanced', 'size' => 'full'), $tosca_post_id);

	$featured_slideshow_autoplay = rwmb_meta('header_slideshow_autoplay', array(), $tosca_post_id);

	$featured_slideshow_autoplay_timer = rwmb_meta('header_slideshow_autoplay_timer', array(), $tosca_post_id);

	$featured_slideshow_transition = rwmb_meta('header_slideshow_transition', array(), $tosca_post_id);

	$featured_video = rwmb_meta('header_video', array(), $tosca_post_id);

	$featured_video_dont_mute = rwmb_meta('header_video_dont_mute', array(), $tosca_post_id);

	$new_featured_image_pos = rwmb_meta('featured_image_pos', array(), $tosca_post_id);

	if ( ! empty($new_featured_image_pos)) $featured_image_pos = $new_featured_image_pos;

	$featured_caption = rwmb_meta('header_caption', array(), $tosca_post_id);

	$new_featured_caption_pos = rwmb_meta('header_caption_pos', array(), $tosca_post_id);

	if ( ! empty($new_featured_caption_pos)) $featured_caption_pos = $new_featured_caption_pos;

	$new_heading_size = rwmb_meta('heading_size', array(), $tosca_post_id);

	if ( ! empty($new_heading_size)) {

		if ($new_heading_size == 'hide') {

			$force_featured_area_hidden = true;

		}

	}

}

if ( ! $featured_caption && class_exists('WooCommerce') && is_product_category() ) {

	$featured_caption = woocommerce_page_title(false);

}

$no_featured_media = ( ! $featured_area || $force_featured_area_hidden || (empty($featured_custom_code) && ! isset($featured_image['url']) && empty($featured_slideshow) && empty($featured_video)));



?>

<header id="header"<?php if ($no_featured_media) echo ' class="no-featured-media"'; ?>>

	<div class="container"><div class="wrapper">



		<div id="logo">

			<?php if (isset($theme_options['logo_image']) && ! empty($theme_options['logo_image']) && ! empty($theme_options['logo_image']['url'])) :

		?><h1><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><img src="<?php echo esc_url($theme_options['logo_image']['url']); ?>"<?php

			$logo_width = $theme_options['logo_image']['width'];

			$logo_height = $theme_options['logo_image']['height'];

			if ( ! empty($logo_width) && ! empty($logo_height)) {

				echo ' width="'. esc_attr($logo_width) .'" height="' . esc_attr($logo_height) . '"';

			} ?> alt="<?php bloginfo('name'); ?>"/></a></h1>

		<?php else :

			?><h1 class="text"><a href="<?php echo esc_url( home_url('/') ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>

		<?php endif; ?></div>

<?php if ( ! is_page_template('template-under-construction.php') ) : ?>

		<?php if ( has_nav_menu('logo_menu') ) : ?>

		<div id="logo-menu" class="clearfix">

			<div class="menu-wrapper">

			<?php

				wp_nav_menu(array(

					'theme_location' => 'logo_menu',

					'container' => false,

					'items_wrap' => '<ul>%3$s</ul>',

				)); ?>



			</div>

		</div>

		<?php endif; ?>



		<div id="menu" class="clearfix">

			<div class="menu-wrapper">

			<?php

				wp_nav_menu(array(

					'theme_location' => 'main_menu',

					'container' => false,

					'items_wrap' => '<ul>%3$s</ul>',

				)); ?>



			</div>

<?php endif; ?>



		</div>



		<noscript><div class="alert notice"><?php esc_html_e('Javascript is disabled in your web browser. Make sure you enable it in order for this site to function properly.', 'tosca'); ?></div></noscript>



	</div></div>

</header>



<?php

/* determine if what type of featured content to display */

if ( ! $no_featured_media && $featured_area && ! $force_featured_area_hidden) : ?>

	<div id="featured-media"<?php if ( ! empty($theme_options['custom_heading_parallax']) && empty($featured_custom_code)) echo ' data-parallax-ratio="' . esc_attr($theme_options['custom_heading_parallax_ratio']  / 100) . '"'; if ($featured_caption_pos) echo ' class="caption-' . esc_attr($featured_caption_pos) . '"'; ?>>

<?php

if ( ! empty($featured_custom_code)) {

	echo '<div class="featured-custom-code">' . do_shortcode(strtr($featured_custom_code, array('<p>[' => '[', ']</p>' => ']', ']<br />' => ']', '<p><div' => '<div', '/div></p>' => '/div>', '<p></p>' => ''))) . '</div>';

	if ( $featured_caption ) echo '<div class="featured-caption"><div class="text"><div class="inner">' . do_shortcode($featured_caption) . '</div></div></div>';

} else {

if (isset($featured_image['url']) && empty($featured_slideshow) && empty($featured_video)) : ?>

		<img class="featured-image" src="<?php echo esc_url($featured_image['url']); ?>" width="<?php echo esc_attr($featured_image['width']); ?>" height="<?php echo esc_attr($featured_image['height']); ?>" alt="<?php echo esc_attr($featured_image['alt']); ?>" data-image-align="<?php echo esc_attr($featured_image_pos); ?>" itemprop="image"<?php if (isset($featured_image['srcset']) && ! empty($featured_image['srcset'])) echo ' srcset="' . esc_attr($featured_image['srcset']) . '"'; if (isset($featured_image['sizes']) && ! empty($featured_image['sizes'])) echo ' sizes="' . esc_attr($featured_image['sizes']) . '"'; ?>>

<?php if ( isset($theme_options['heading_image_overlay_opacity']) && isset($theme_options['heading_image_overlay_color']) ) : ?>

		<svg class="overlay" pointer-events="none"></svg>

<?php endif; ?>

<?php if ( ($featured_caption && ! empty($featured_caption)) || (isset($featured_image['description']) && ! empty($featured_image['description'])) ) : ?>

		<div class="featured-caption"><div class="text"><div class="inner"><?php

			if ($featured_caption && ! empty($featured_caption)) {

				echo wp_kses_post($featured_caption);

			} else {

				if ( isset($featured_image['description']) && ! empty($featured_image['description']) ) echo wp_kses_post($featured_image['description']);

			}

		?></div></div></div>

<?php endif; ?>

<?php endif;

		if ( ! empty($featured_slideshow) && empty($featured_video)) {

			$attribs = '';

			if ( ! empty($featured_slideshow_autoplay)) {

				$attribs .= ' autoslide="true"';

			}

			if ( ! empty($featured_slideshow_autoplay_timer) && is_numeric($featured_slideshow_autoplay_timer)) {

				$attribs .= ' autoslide_timer="' . $featured_slideshow_autoplay_timer . '"';

			}

			if ( ! empty($featured_slideshow_transition) && is_numeric($featured_slideshow_transition)) {

				$attribs .= ' autoslide_timer_trans="' . $featured_slideshow_transition . '"';

			}

			$slider_shortcode = '[slider class="cerchez-slider-full-height" align="' . $featured_image_pos . '"' . $attribs . ']';

			$slider_item_extra = '';

			if ( isset($theme_options['heading_image_overlay_opacity']) && isset($theme_options['heading_image_overlay_color']) ) {

				$slider_item_extra = ' extra_attribs="<svg class=~$~overlay~$~ pointer-events=~$~none~$~></svg>"';

			}

			foreach ($featured_slideshow as $image) {

				$slider_item_caption = '';

				if ( ! empty($image['description']) && isset($image['description'])) {

					$slider_item_caption = "<div class='inner'>" . wp_kses_post($image['description']) . '</div>';

				}

				if ( ! empty($slider_item_caption)) {

					$slider_item_caption = ' caption="' . $slider_item_caption . '"';

				}

				// build shortcode, data is validated/escaped properly when the shortcode is processed

				$slider_shortcode .= '[slider-item image="' . $image['full_url'] . '" image_alt="' . $image['alt'] . '" image_width="' . $image['width'] .'" image_height="' . $image['height'] .'"' . $slider_item_caption . $slider_item_extra . '][/slider-item]';

			}

			$slider_shortcode .= '[/slider]';

			echo do_shortcode($slider_shortcode);

		}

		if ( ! empty($featured_video)) {



?>

			<div class="featured-video" data-image-align="<?php echo esc_attr($featured_image_pos); ?>">

				<?php echo tosca_get_featured_video($featured_video, $featured_video_dont_mute); ?>

			</div>

			<?php

			if ( $featured_caption ) {

				echo '<div class="featured-caption"><div class="text"><div class="inner">' . do_shortcode($featured_caption) . '</div></div></div>';

			} ?>

<?php if ( isset($theme_options['heading_image_overlay_opacity']) && isset($theme_options['heading_image_overlay_color']) ) : ?>

			<svg class="overlay" pointer-events="none"></svg>

<?php endif; ?>

<?php } ?>

<?php if ( empty($featured_custom_code)) : ?>

			<span class="loader"><em class="icon-refresh"></em></span>

<?php endif;

} ?>

	</div>

<?php endif; ?>