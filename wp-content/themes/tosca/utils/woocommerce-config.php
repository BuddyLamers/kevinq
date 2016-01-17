<?php



/* Settings and hooks for the WooCommerce plugin */



add_action('after_setup_theme', 'tosca_woo_support');

function tosca_woo_support() {

	add_theme_support('woocommerce');

}



global $theme_options;



/* sidebar widgets */

function tosca_woo_widgets_init() {

	register_sidebar( array(

		'name' =>  esc_html__('WooCommerce Sidebar', 'tosca'),

		'id' => 'woo-sidebar',

		'description' =>  esc_html__('The default widget area for the WooCommerce shop.', 'tosca'),

		'before_widget' => '<div class="widget %2$s">',

		'after_widget' => '</div>',

		'before_title' => '<h3 class="widget-title">',

		'after_title' => '</h3>',

	) );

}

add_action('widgets_init', 'tosca_woo_widgets_init', 9);



/* disable default plugin style */

add_filter('woocommerce_enqueue_styles', '__return_empty_array');



/* use own theme custom style */

function tosca_woo_scripts_and_style() {

	wp_register_style('tosca-woo', get_template_directory_uri() . '/style-woo.css');

	wp_enqueue_style('tosca-woo');

	if (is_product()) {

		wp_enqueue_script('tosca-zoom-image', get_template_directory_uri() . '/js/zoom.min.js', array('jquery'), false, true);

		global $theme_options;

		if ( ! empty($theme_options['use_theme_lightbox']) && defined('CERCHEZ_PLUGIN_URI') ) {

			// improves woocommerce lightbox with personal one (only if user wants to, via theme options)

			wp_dequeue_script('prettyPhoto');

			wp_dequeue_script('prettyPhoto-init');

			wp_enqueue_script('cerchez_lightbox_js', CERCHEZ_PLUGIN_URI . 'utils/shortcodes/js/jquery.fancybox.min.js', array('jquery'), false, true);

		}

	}

}

add_action('wp_enqueue_scripts', 'tosca_woo_scripts_and_style', 11);



/* override layout with proper hooks */

remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

remove_action('wp_footer','woocommerce_demo_store');

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);



if ( isset($theme_options['woo_hide_shop_sorting_pagination']) && ! empty($theme_options['woo_hide_shop_sorting_pagination'])) {

	remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

}



if ( isset($theme_options['woo_hide_add_to_shop']) && ! empty($theme_options['woo_hide_add_to_shop'])) {

	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

}



if ( isset($theme_options['woo_hide_shop_breadcrumb']) && ! empty($theme_options['woo_hide_shop_breadcrumb'])) {

	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

}



/* Modify pagination arguments */

function tosca_woo_pagination_args($args) {

	$args['type'] = 'plain';

	return $args;

}

add_filter('woocommerce_pagination_args', 'tosca_woo_pagination_args');



/* Remove page title at user's discretion */

function tosca_woo_show_page_title() {

	$hide_heading_title = true;

	if ( is_shop() ) {

		$temp_id = get_option('woocommerce_shop_page_id');

		if ($temp_id) {

		$hide_heading_title = false;

			$tosca_post_id = $temp_id;

		}

		$hide_heading_title = rwmb_meta('hide_post_title', array(), $tosca_post_id);

		$hide_heading_title = ($hide_heading_title == 1);

	}

	return ( ! $hide_heading_title );

}

add_filter('woocommerce_show_page_title', 'tosca_woo_show_page_title');



/* Before Content - wraps all WooCommerce content in wrappers which match the theme markup and add a left sidebar (if any) */

function tosca_woo_before_content() {

	global $theme_options;

	$is_sidebar_active = is_active_sidebar('woo-sidebar');

	$is_sidebar_allowed = is_shop() || is_product_category() || is_product_tag() || (is_product() && isset($theme_options['woo_show_sidebar_single']) && ! empty($theme_options['woo_show_sidebar_single']));

	$sidebar_position = 'right';

	if ( is_shop() ) {

		$temp_id = get_option('woocommerce_shop_page_id');

		if ($temp_id) {

			$tosca_post_id = $temp_id;

		}

		$sidebar_position = rwmb_meta('sidebar_position', array(), $tosca_post_id);

		if (empty($sidebar_position)) $sidebar_position = 'right';

	}

?>

<section id="content">

	<div class="container">

<?php

	woocommerce_demo_store();

	if ( ! is_checkout() ) {

		echo wp_kses_post( do_shortcode( '[woocommerce_messages]' ) );

	}

	if ( $is_sidebar_active && $is_sidebar_allowed && ! empty($sidebar_position) && $sidebar_position == 'left' ) :

		get_sidebar('left'); ?>

		<div class="col grid9 omega">



<?php endif;

		if ( $is_sidebar_active && $is_sidebar_allowed && ! empty($sidebar_position) && $sidebar_position == 'right' ) : ?>

		<div class="col grid9">

<?php endif;

}

add_action('woocommerce_before_main_content', 'tosca_woo_before_content', 10);



/* After Content - closes the wrapping divs and add a right sidebar (if any) */

function tosca_woo_after_content() {

	global $theme_options;

	$is_sidebar_active = is_active_sidebar('woo-sidebar');

	$is_sidebar_allowed = is_shop() || is_product_category() || is_product_tag() || (is_product() && isset($theme_options['woo_show_sidebar_single']) && ! empty($theme_options['woo_show_sidebar_single']));

	$sidebar_position = 'right';

	if ( is_shop() ) {

		$temp_id = get_option('woocommerce_shop_page_id');

		if ($temp_id) {

			$tosca_post_id = $temp_id;

		}

		$sidebar_position = rwmb_meta('sidebar_position', array(), $tosca_post_id);

		if (empty($sidebar_position)) $sidebar_position = 'right';

	}

	if ( $is_sidebar_active && $is_sidebar_allowed && ! empty($sidebar_position) && $sidebar_position == 'right' ) : ?>

		</div>

		<?php get_sidebar(); ?>

<?php endif;

?>

	</div>

</section>

<?php

}

add_action('woocommerce_after_main_content', 'tosca_woo_after_content', 10);



/* Add column class to product listings so we can arrange items in columns */

if ( ! function_exists('woocommerce_product_loop_start')) {

	function woocommerce_product_loop_start() {

		global $woocommerce_loop;

		if (empty($woocommerce_loop['columns'])) {

			$woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 3);

		}

		echo '<ul class="products clearfix columns-' . esc_attr($woocommerce_loop['columns']) . '">';

	}

}



if ( ! function_exists('woocommerce_product_loop_end')) {

	function woocommerce_product_loop_end() {

		echo '</ul>';

	}

}



if ( ! function_exists('woocommerce_template_loop_add_to_cart')) {

	function woocommerce_template_loop_add_to_cart() {

		global $product;

		if ( ! $product->is_in_stock()) {

			echo '<span class="out-of-stock">' .  esc_html__('Out of stock', 'tosca') . '</span>';

			return;

		}

		woocommerce_get_template('loop/add-to-cart.php');

	}

}



/* Set products per page and per row */

function tosca_woo_shop_per_page() {

	global $theme_options;

	if (isset($theme_options['woo_loop_per_page'])) {

		if (is_numeric($theme_options['woo_loop_per_page'])) {

			return $theme_options['woo_loop_per_page'];

		} else {

			return -1;

		}

	} else {

		return 12;

	}

}

add_filter('loop_shop_per_page', 'tosca_woo_shop_per_page');



function tosca_woo_shop_columns() {

	global $theme_options;

	if (isset($theme_options['woo_loop_columns'])) {

		return $theme_options['woo_loop_columns'];

	} else {

		return 3;

	}

}

add_filter('loop_shop_columns', 'tosca_woo_shop_columns');



function tosca_woo_output_related_products_args() {

	return array(

		'posts_per_page' => tosca_woo_shop_columns(),

		'columns' => tosca_woo_shop_columns(),

		'orderby' => 'rand'

	);

}

add_filter('woocommerce_output_related_products_args', 'tosca_woo_output_related_products_args');



global $theme_options;

if ( ! empty($theme_options['woo_header_cart']) ) {



	function tosca_menu_cart_output() {

		global $woocommerce;

		$cartItems = '';

		$cartItemsTotal = '';

		$cartItemClass = '';

		if ($woocommerce->cart->get_cart_contents_count() > 0) {

			$cartItemsTotal = ' (' . $woocommerce->cart->get_cart_total() . ')';

			if ( ! is_cart() && ! is_checkout() ) {

				$cartItemClass = ' menu-item-has-children';

				$cartItems = '<ul class="sub-menu">';

				foreach($woocommerce->cart->cart_contents as $cart_item) {

					$attach_id = get_post_thumbnail_id($cart_item['product_id']);

					if ($attach_id) {

						$product_image = '<img src="' . wp_get_attachment_thumb_url($attach_id) . '" alt="' . $cart_item['data']->post->post_title . '" />';

					} else {

						$product_image = '';

					}

					$cartItems .= '<li class="menu-item"><a href="' . esc_url(get_permalink($cart_item['product_id'])) . '" class="clearfix">' . $product_image . ' ' . $cart_item['quantity'] . ' <span class="icon-cross"></span> ' . $woocommerce->cart->get_product_subtotal($cart_item['data'], 1) . ' <span class="equals">=</span> <strong>' . $woocommerce->cart->get_product_subtotal($cart_item['data'], $cart_item['quantity']) . '</strong></a></li>';

				}

				$cartItems .= '<li class="menu-item checkout-link"><a href="' . esc_url($woocommerce->cart->get_checkout_url()) . '">' .  esc_html__( 'Checkout', 'tosca' ) . ' <em class="icon-arrow-right"></em></a></li>';

				$cartItems .= '</ul>';

			}

		}



		return '<li id="tosca-menu-cart" class="menu-item' . $cartItemClass . '"><a href="' . esc_url($woocommerce->cart->get_cart_url()) . '"><em class="icon-cart"></em> <span class="cart-text">' .  esc_html__('Cart', 'tosca') . '</span>' . $cartItemsTotal . '</a>' . $cartItems . '</li>';

	}



	add_filter('wp_nav_menu_items', 'tosca_nav_menu_add_cart', 10, 2);

	function tosca_nav_menu_add_cart($items, $args) {

		if ( ( has_nav_menu('logo_menu') && $args->theme_location == 'logo_menu') || ( ! has_nav_menu('logo_menu') && $args->theme_location == 'main_menu') ) {

			return $items . tosca_menu_cart_output();

		} else {

			return $items;

		}

	}



	add_filter('wp_page_menu', 'tosca_page_menu_add_cart', 10, 2);

	function tosca_page_menu_add_cart($menu, $args) {

		return str_replace('</ul></div>', '', $menu) . tosca_menu_cart_output() . '</ul></div>';

	}



	/* ensure cart contents update when products are added to the cart via AJAX */

	function tosca_header_add_to_cart_fragment( $fragments ) {

		$fragments['#tosca-menu-cart'] = tosca_menu_cart_output();

		return $fragments;

	}



	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {

		add_filter('woocommerce_add_to_cart_fragments', 'tosca_header_add_to_cart_fragment');

	} else {

		add_filter('add_to_cart_fragments', 'tosca_header_add_to_cart_fragment');

	}



} // end if woo_menu_cart check



/* add container around product thumbnail */

function tosca_woo_before_shop_loop_item($a) {

	echo '<div class="thumb switch animate-in-view"><span class="photo">';

}

add_action('woocommerce_before_shop_loop_item', 'tosca_woo_before_shop_loop_item', 9, 1 );



function tosca_woo_before_shop_loop_item_title() {

	echo '</a></span><a href="' . esc_url(get_permalink()) . '" class="title">';

}

add_action('woocommerce_before_shop_loop_item_title', 'tosca_woo_before_shop_loop_item_title', 20);



function tosca_woo_after_shop_loop_item() {

	echo '</div>';

}

add_action('woocommerce_after_shop_loop_item', 'tosca_woo_after_shop_loop_item', 15);



remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);



function tosca_woo_template_loop_product_title() {

	global $product;

	$price = '';

	if ( $price_html = $product->get_price_html() ) {

		$price = '<span class="price">' . $price_html . '</span>';

	}

	echo '<span class="title">' . get_the_title() . '</span><hr class="special">' . $price;

}

add_action('woocommerce_shop_loop_item_title', 'tosca_woo_template_loop_product_title', 10);



/* add second image for products, if any exists */

function tosca_woo_template_loop_second_product_thumbnail() {

	global $product, $woocommerce;

	$attachment_ids = $product->get_gallery_attachment_ids();

	if ( $attachment_ids && $product->is_in_stock() ) {

		$secondary_image_id = $attachment_ids['0'];

		echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'secondary attachment-shop_catalog' ) );

	}

}

add_action( 'woocommerce_before_shop_loop_item_title', 'tosca_woo_template_loop_second_product_thumbnail', 15 );



/* Customize product thumbnail style */

function tosca_woo_single_product_image_html($output, $post_ID) {

	global $theme_options;

	if ( ! empty($theme_options['use_theme_lightbox']) && defined('CERCHEZ_PLUGIN_URI') ) {

		$output = str_replace('woocommerce-main-image', 'woocommerce-main-image lightbox image-zoom', $output);

		$output = str_replace('data-rel="', 'data-fancybox-group="', $output);

	}

	return '<div class="box white">' . $output . '</div>';

}

add_filter('woocommerce_single_product_image_html', 'tosca_woo_single_product_image_html', 10, 2);



function tosca_woo_single_product_image_thumbnail_html($output, $attachment_id, $post_ID, $image_class) {

	global $theme_options;

	$last_class = (strpos($image_class, 'last') !== false) ? ' last' : '';

	if ( ! empty($theme_options['use_theme_lightbox']) && defined('CERCHEZ_PLUGIN_URI') ) {

		$output = str_replace('class="' . $image_class . '"', 'class="lightbox ' . $image_class . '"', $output);

		$output = str_replace('data-rel="', 'data-fancybox-group="', $output);

	}

	return '<div class="box white' . $last_class . '">' . $output . '</div>';

}

add_filter('woocommerce_single_product_image_thumbnail_html', 'tosca_woo_single_product_image_thumbnail_html', 10, 4);



function tosca_woo_composited_product_image_html($output, $post_ID) {

	global $theme_options;

	if ( ! empty($theme_options['use_theme_lightbox']) && defined('CERCHEZ_PLUGIN_URI') ) {

		$output = str_replace('class="composited_product_image', 'class="composited_product_image lightbox', $output);

		$output = str_replace('data-rel="', 'data-fancybox-group="', $output);

	}

	return $output;

}

add_filter('woocommerce_composited_product_image_html', 'tosca_woo_composited_product_image_html', 10, 2);



function tosca_woo_before_single_product_summary_before() {

	echo '<div class="col grid4">';

}

add_action('woocommerce_before_single_product_summary', 'tosca_woo_before_single_product_summary_before', 5);

function tosca_woo_before_single_product_summary_after() {

	echo '<div class="clear"></div></div><div class="col grid8 omega">';

}

add_action('woocommerce_before_single_product_summary', 'tosca_woo_before_single_product_summary_after', 22);

function tosca_woo_after_single_product_summary() {

	echo '</div><div class="clear"></div>';

}

add_action('woocommerce_after_single_product_summary', 'tosca_woo_after_single_product_summary', 5);



function tosca_woo_sale_flash($message, $post, $product) {



	$saving_amount = 0;

	// check if variable product

	if ( $product->has_child() ) {

		foreach ( $product->get_children() as $child_id ) {

			$regular_price = get_post_meta( $child_id, '_regular_price', true );

			$sale_price = get_post_meta( $child_id, '_sale_price', true );

			if ( $regular_price != '' && $sale_price != '' && $regular_price > $sale_price ) {

				$new_saving_amount = $regular_price - $sale_price;

				if( $new_saving_amount > $saving_amount ) {

					$saving_amount = $new_saving_amount;

				}

			}

		}

		$button_text =  esc_html__('Save up to ', 'tosca');

	} else {

		// Fetch prices for simple products

		$regular_price = get_post_meta( $post->ID, '_regular_price', true );

		$sale_price = get_post_meta( $post->ID, '_sale_price', true );

		if ( $regular_price != '' && $sale_price != '' && $regular_price > $sale_price ) {

			$saving_amount = $regular_price - $sale_price;

		}

		$button_text =  esc_html__('Save ', 'tosca');

	}



	// Only modify badge if saving amount is larger than 0

	if ( $saving_amount > 0 ) {

		$saving_price = woocommerce_price($saving_amount);

		$message = '<span class="onsale">' . $button_text . $saving_price . '</span>';

	}



	return $message;

}

add_filter('woocommerce_sale_flash', 'tosca_woo_sale_flash', 10, 3);



remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

add_action('woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 4);



function tosca_woo_product_search_form($echo) {

	$form = '<form action="' . esc_url( home_url( '/'  ) ) . '" method="get" class="woocommerce-product-search searchform"><input type="text" value="' . get_search_query() . '" name="s" placeholder="' .  esc_html__('Search products&hellip;', 'tosca') . '"><input type="submit" value="&#xe602;"><input type="hidden" name="post_type" value="product"></form>';

	if ( $echo ) {

		echo $form;

	} else {

		return $form;

	}

}

add_filter('get_product_search_form', 'tosca_woo_product_search_form', 10, 1);

