<?php

/* Set up the options for the theme */

if ( ! function_exists('tosca_load_theme_options')) {

function tosca_load_theme_options() {

global $of_options;
$of_options = array();
$google_fonts = tosca_google_fonts();

$of_options[] = array(
	"name" => esc_html__('General Options', 'tosca'),
	"class" => "general",
	"type" => "heading"
);

$of_options[] = array(
	"name" => esc_html__('Logo image', 'tosca'),
	"desc" => esc_html__('Select an image that will represent your website\'s logo (used instead of the text version).', 'tosca') . ' <span style="color:#d52">' . esc_html__('Recommanded size: 170 x 26)', 'tosca') . '</span>',
	"id" => "logo_image",
	"type" => "media",
);

$of_options[] = array(
	"name" => esc_html__('Sticky Header', 'tosca'),
	"desc" => esc_html__('Determine if the header always remains visible, even when scrolling down the page.', 'tosca'),
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "sticky_header",
	"type" => "switch",
	"std" => 0
);

$of_options[] = array(
	"name" => esc_html__('Featured Media in Header', 'tosca'),
	"desc" => esc_html__('Determine if the heading area of a page will be featured by an image, slideshow, video or custom code.', 'tosca'),
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "custom_heading",
	"type" => "switch",
	"folds" => true,
	"std" => true
);

$heading_sizes = array(
	'small'  => esc_html__('Small', 'tosca'),
	'medium' => esc_html__('Medium', 'tosca'),
	'full'   => esc_html__('Full Height', 'tosca'),
	'auto'   => esc_html__('Auto', 'tosca'),
);
$of_options[] = array(
	"name" => esc_html__('Heading Size', 'tosca'),
	"desc" => esc_html__('Select the size of the heading image  (you\'ll be able to override it for each post/page or via Custom CSS).', 'tosca'),
	"id" => "custom_heading_size",
	"type" => "select",
	"fold" => "custom_heading",
	"options" => $heading_sizes,
	"std" => 'medium'
);

$of_options[] = array(
	"name" => esc_html__('Heading image', 'tosca'),
	"desc" => esc_html__('Upload an image that will represent your website\'s general heading image (you\'ll be able to override it for each post/page by editing the featured image, slideshow, video or custom code).', 'tosca'),
	"id" => "custom_heading_image",
	"type" => "media",
	"fold" => "custom_heading"
);

$background_image_pos = array(
	'left top'      => esc_html__('left top', 'tosca'),
	'left center'   => esc_html__('left center', 'tosca'),
	'left bottom'   => esc_html__('left bottom', 'tosca'),
	'right top'     => esc_html__('right top', 'tosca'),
	'right center'  => esc_html__('right center', 'tosca'),
	'right bottom'  => esc_html__('right bottom', 'tosca'),
	'center top'    => esc_html__('center top', 'tosca'),
	'center center' => esc_html__('center center', 'tosca'),
	'center bottom' => esc_html__('center bottom', 'tosca'),
);
$of_options[] = array(
	"name" => esc_html__('Heading image position', 'tosca'),
	"desc" => esc_html__('Select position method used for the heading image drawing process. This setting will also be used if a slideshow or video is displayed in the header section (you\'ll be able to override it for each post/page).', 'tosca'),
	"id" => "custom_heading_image_position",
	"type" => "select",
	"fold" => "custom_heading",
	"options" => $background_image_pos,
	"std" => 'center center'
);

$of_options[] = array(
	"name" => esc_html__('Heading image parallax', 'tosca'),
	"desc" => esc_html__('Determine if the heading area has a parallax effect (image smoothly moves after scrolling position).', 'tosca') . ' <span style="color:#d52">' . esc_html__('Available only on desktop screens (for performance reasons).', 'tosca') . '</span>',
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "custom_heading_parallax",
	"type" => "switch",
	"std" => false,
	"fold" => "custom_heading"
);

$of_options[] = array(
	"name" => esc_html__('Heading image parallax ratio', 'tosca'),
	"desc" => esc_html__('Set the parallax effect ratio that is relative to the natural scroll speed, so a ratio of 50 would cause the element to scroll at half-speed, a ratio of 100 would have no effect.', 'tosca'),
	"id" => "custom_heading_parallax_ratio",
	"type" => "sliderui",
	"fold" => "custom_heading",
	"min" => 0,
	"max" => 100,
	"step" => 5,
	"std" => 50
);

$of_options[] = array(
	"name" => esc_html__('Heading image overlay color', 'tosca'),
	"desc" => esc_html__('Select the overlay background color used for the featured image in the heading section of the theme (you\'ll be able to override it for each post/page).', 'tosca'),
	"id" => "heading_image_overlay_color",
	"type" => "color",
	"fold" => "custom_heading",
	"std" => '#111213'
);

$of_options[] = array(
	"name" => esc_html__('Heading image overlay opacity', 'tosca'),
	"desc" => esc_html__("Set the opacity of the overlay color that is displayed over the heading image - if it is set to 0 then it won't be added to the page (you'll be able to override it for each post/page).", 'tosca'),
	"id" => "heading_image_overlay_opacity",
	"type" => "sliderui",
	"fold" => "custom_heading",
	"min" => 0,
	"max" => 100,
	"step" => 1,
	"std" => 50
);

$heading_caption_pos = array(
	'centered'        => esc_html__('Simple - Middle Centered', 'tosca'),
	'bottom-left'     => esc_html__('Simple - Bottom Left', 'tosca'),
	'bottom-centered' => esc_html__('Simple - Bottom Centered', 'tosca'),
	'bottom-right'    => esc_html__('Simple - Bottom Right', 'tosca'),
	'special'         => esc_html__('Special - Centered', 'tosca'),
);
$of_options[] = array(
	"name" => esc_html__('Heading caption position', 'tosca'),
	"desc" => esc_html__('Select position method used for the heading caption box (you\'ll be able to override it for each post/page).', 'tosca'),
	"id" => "custom_heading_caption_position",
	"type" => "select",
	"fold" => "custom_heading",
	"options" => $heading_caption_pos,
	"std" => 'centered'
);

// Style
$of_options[] = array(
	"name" => esc_html__('Other Options', 'tosca'),
	"class" => "style",
	"type" => "heading"
);

if ( function_exists ('cerchez_lightbox_shortcode') ) {

	$of_options[] = array(
		"name" => esc_html__('Use built-in lightbox', 'tosca'),
		"desc" => esc_html__('Determine if the default theme lightbox is loaded.', 'tosca') . '<br>' . esc_html__('Enable it if you don\'t have any other lightbox solution installed, like ', 'tosca') . '<a href="http://wordpress.org/plugins/responsive-lightbox/">' . esc_html__('Responsive Lightbox Plugin', 'tosca') . '</a>.',
		"on" => esc_html__("Yes", 'tosca'),
		"off" => esc_html__("No", 'tosca'),
		"id" => "use_theme_lightbox",
		"type" => "switch",
		"std" => true
	);

}

$of_options[] = array(
	"name" => esc_html__('Page border', 'tosca'),
	"desc" => esc_html__("Determine if a border effect is displayed for the whole page.", 'tosca'),
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "page_border",
	"type" => "switch",
	"std" => true
);

$of_options[] = array(
	"name" => esc_html__('Menu separators', 'tosca'),
	"desc" => esc_html__("Determine if line separators are displayed in the main menu.", 'tosca'),
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "menu_separators",
	"type" => "switch",
	"std" => false
);

$of_options[] = array(
	"name" => esc_html__('In-View Animations', 'tosca'),
	"desc" => esc_html__('Determine if smooth animations are created for certain elements when they appear in the viewport of the page (project items, gallery images or elements marked with an <code>animate-in-view</code> class).', 'tosca'),
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "animate_in_view_elements",
	"type" => "switch",
	"std" => 0
);

$of_options[] = array(
	"name" => esc_html__('Page Smooth Scroll', 'tosca'),
	"desc" => esc_html__('Determine if the smooth scroll script is loaded (available in WebKit based browsers like Chrome and Safari).', 'tosca'),
	"on" => esc_html__("Yes", 'tosca'),
	"off" => esc_html__("No", 'tosca'),
	"id" => "smooth_scroll",
	"type" => "switch",
	"std" => 0
);

$of_options[] = array(
	"name" => esc_html__('Scroll To Top', 'tosca'),
	"desc" => esc_html__('Determine if a scroll-to-top button is available when scrolling down the page.', 'tosca'),
	"on" => esc_html__('Show', 'tosca'),
	"off" => esc_html__('Hide', 'tosca'),
	"id" => "scroll_to_top",
	"type" => "switch",
	"std" => false
);

$of_options[] = array(
	"name" => esc_html__('Footer Text', 'tosca'),
	"desc" => esc_html__('Input your copyright statement displayed in the footer. The following shortcodes may be useful: [the-year] [site-title] [site-url]', 'tosca'),
	"id" => "footer_text",
	"options" => array("rows" => 4),
	"std" => esc_html__('&#38;copy; [site-title]. All Rights Reserved.', 'tosca'),
	"type" => "textarea"
);

if ( function_exists ('cerchez_image_resize') ) {

	$thumb_align_values = array(
		'c'  => esc_html__('Center', 'tosca'),
		't'  => esc_html__('Align Top', 'tosca'),
		'tr' => esc_html__('Align Top Right', 'tosca'),
		'tl' => esc_html__('Align Top Left', 'tosca'),
		'b'  => esc_html__('Align Bottom', 'tosca'),
		'br' => esc_html__('Align Bottom Right', 'tosca'),
		'bl' => esc_html__('Align Bottom Left', 'tosca'),
		'l'  => esc_html__('Align Left', 'tosca'),
		'r'  => esc_html__('Align Right', 'tosca'),
	);
	$of_options[] = array(
		"name" => esc_html__('Thumbnail crop alignment', 'tosca'),
		"desc" => esc_html__("Set positional cropping, which allows you to control how project thumbnail images are cropped.", 'tosca'),
		"id" => "thumb_align",
		"type" => "select",
		"options" => $thumb_align_values,
		"std" => 'c',
	);

} // function_exists ('cerchez_image_resize')

// woocommerce settings
if ( class_exists('Woocommerce') ) {

	$page_columns = array(
		'2' => '2',
		'3' => '3',
		'4' => '4',
	);

	$per_page = array(
		'4' => '4',
		'6' => '6',
		'8' => '8',
		'9' => '9',
		'10' => '10',
		'12' => '12',
		'14' => '14',
		'15' => '15',
		'16' => '16',
		'18' => '18',
		'20' => '20',
		'21' => '21',
		'24' => '24',
		'all' => esc_html__('All Products', 'tosca'),
	);

	$of_options[] = array(
		"name" => esc_html__('WooCommerce', 'tosca'),
		"class" => "woo",
		"type" => "heading"
	);

	$of_options[] = array(
		"name" => esc_html__('Shopping cart in header', 'tosca'),
		"desc" => esc_html__("Determine if the cart item is added in the header menu section.", 'tosca'),
		"id" => "woo_header_cart",
		"on" => esc_html__("Yes", 'tosca'),
		"off" => esc_html__("No", 'tosca'),
		"std" => 0,
		"type" => "switch"
	);

	$of_options[] = array(
		"name" => esc_html__('Column layout', 'tosca'),
		"desc" => esc_html__('Determine the number of products showed per row in the shop page.', 'tosca'),
		"id" => "woo_loop_columns",
		"std" => "3",
		"type" => "select",
		"options" => $page_columns,
	);

	$of_options[] = array(
		"name" => esc_html__('Products per page', 'tosca'),
		"desc" => esc_html__('Determine the number of products showed per page in the shop page.', 'tosca'),
		"id" => "woo_loop_per_page",
		"std" => "12",
		"type" => "select",
		"options" => $per_page,
	);

	$of_options[] = array(
		"name" => esc_html__('Hide breadcrumb', 'tosca'),
		"desc" => esc_html__('Determine if the breadcrumb element is hidden for a more minimal look.', 'tosca'),
		"id" => "woo_hide_shop_breadcrumb",
		"on" => esc_html__("Yes", 'tosca'),
		"off" => esc_html__("No", 'tosca'),
		"std" => 0,
		"type" => "switch"
	);

	$of_options[] = array(
		"name" => esc_html__('Hide sorting and pagination info', 'tosca'),
		"desc" => esc_html__('Determine if the sorting select box and results info element are hidden for a more minimal look.', 'tosca'),
		"id" => "woo_hide_shop_sorting_pagination",
		"on" => esc_html__("Yes", 'tosca'),
		"off" => esc_html__("No", 'tosca'),
		"std" => 0,
		"type" => "switch"
	);

	$of_options[] = array(
		"name" => esc_html__('Hide Add to cart buttons', 'tosca'),
		"desc" => esc_html__('Determine if the Add to cart buttons in the shop page are hidden for a more minimal look.', 'tosca'),
		"id" => "woo_hide_add_to_shop",
		"on" => esc_html__("Yes", 'tosca'),
		"off" => esc_html__("No", 'tosca'),
		"std" => 0,
		"type" => "switch"
	);

	$of_options[] = array(
		"name" => esc_html__('Show sidebar in single product page', 'tosca'),
		"desc" => esc_html__('Determine if the WooCommerce sidebar is displayed in the single page of all products.', 'tosca'),
		"id" => "woo_show_sidebar_single",
		"on" => esc_html__("Yes", 'tosca'),
		"off" => esc_html__("No", 'tosca'),
		"std" => 0,
		"type" => "switch"
	);

}

// Fonts
$of_options[] = array(
	"name" => esc_html__('Custom Fonts', 'tosca'),
	"class" => "fonts",
	"type" => "heading"
);

$of_options[] = array(
	"name" => esc_html__('Font used on all page elements', 'tosca'),
	"id" => "font_body",
	"type" => "googlefont",
	"preview" => array("style" => "font-size:16px", "text" => "How razorback-jumping frogs can level six piqued gymnasts: 1234567890$."),
	/*"std" => array(
		"family" => 'Inconsolata',
		"variant" => 'regular',
		"subset" => 'latin',
	),*/
	"options" => $google_fonts
);

$of_options[] = array(
	"name" => esc_html__('Font used on heading elements (h1,h2,h3,...)', 'tosca'),
	"id" => "font_headings",
	"type" => "googlefont",
	"preview" => array("style" => "font-size:26px"),
	/*"std" => array(
		"family" => 'Oswald',
		"variant" => '300',
		"subset" => 'latin',
	),*/
	"options" => $google_fonts
);

// Custom CSS
$of_options[] = array(
	"name" => esc_html__('Custom CSS', 'tosca'),
	"class" => "custom_css",
	"type" => "heading"
);

$of_options[] = array(
	"id" => "custom_css_info",
	"std" => esc_html__('Quickly add some CSS to your theme by editing it here.', 'tosca') . '<br>' . esc_html__('This is the recommanded way to quickly customize the theme style by avoiding to modify the core files directly.', 'tosca'),
	"type" => "info"
);
$of_options[] = array(
	"id" => "custom_css",
	"options" => array("rows" => "15"),
	"type" => "textarea-full"
);

// Support
$of_options[] = array(
	"name" => esc_html__('Theme Support', 'tosca'),
	"class" => "support",
	"type" => "heading"
);

$of_options[] = array(
	"name" => esc_html__('Support', 'tosca'),
	"id" => "support_info",
	"type" => "info",
	"std" => '<strong>' . esc_html__('When encountering any issue please consult the documentation of this theme and do a quick internet search related to the issue - it might be a WordPress issue and not theme related.', 'tosca') . '</strong><br><br><a class="button-primary" href="http://docs.liviucerchez.com/tosca/" target="_blank">' . esc_html__('Online theme documentation', 'tosca') . '</a><br><br>' . esc_html__('If you have no luck then send me a message via ThemeForest so I can validate your purchase first - please include your preview URL or temporary access to your WordPress admin in order for me to take a look as quick as possible. I\'ll do my best to help out.', 'tosca') . '<br><br><a class="button-primary" href="http://themeforest.net/user/liviu_cerchez#content" target="_blank">' . esc_html__('Send me a private message', 'tosca') . '</a> <a class="button-secondary rate" href="http://themeforest.net/downloads" target="_blank">' . esc_html__('Rate the theme', 'tosca') . '</a>'
);

// Backup Options
$of_options[] = array(
	"name" => esc_html__('Backup Options', 'tosca'),
	"class" => "backup",
	"type" => "heading"
);

$of_options[] = array(
	"name" => esc_html__('Backup and restore options', 'tosca'),
	"desc" => esc_html__('You can use the two buttons below to backup your current options and restore them back at a later time. This is useful if you want to experiment with the options, but would like to keep a stable version in case you make a mistake.', 'tosca'),
	"id" => "backup_options",
	"type" => "backup"
);

$of_options[] = array(
	"name" => esc_html__('Transfer Theme Options', 'tosca'),
	"desc" => esc_html__('You can tranfer the saved options data between different installs by copying the text inside this textbox. To import data from another install, replace the data in the textbox with the one from the other install and click the "Import Options" button.', 'tosca'),
	"id" => "transfer_options",
	"type" => "transfer"
);

}

function tosca_google_fonts() {
	return array('','ABeeZee|regular|latin','Abel|regular|latin','Abril Fatface|regular|latin,latin-ext','Aclonica|regular|latin','Acme|regular|latin','Actor|regular|latin','Adamina|regular|latin','Advent Pro|100,200,300,regular,500,600,700|latin,greek,latin-ext','Aguafina Script|regular|latin,latin-ext','Akronim|regular|latin,latin-ext','Aladin|regular|latin,latin-ext','Aldrich|regular|latin','Alef|regular,700|latin','Alegreya|regular,700,900|latin,latin-ext','Alegreya SC|regular,700,900|latin,latin-ext','Alegreya Sans|100,300,regular,500,700,800,900|latin,vietnamese,latin-ext','Alegreya Sans SC|100,300,regular,500,700,800,900|latin,vietnamese,latin-ext','Alex Brush|regular|latin,latin-ext','Alfa Slab One|regular|latin','Alice|regular|latin','Alike|regular|latin','Alike Angular|regular|latin','Allan|regular,700|latin,latin-ext','Allerta|regular|latin','Allerta Stencil|regular|latin','Allura|regular|latin,latin-ext','Almendra|regular,700|latin,latin-ext','Almendra Display|regular|latin,latin-ext','Almendra SC|regular|latin','Amarante|regular|latin,latin-ext','Amaranth|regular,700|latin','Amatic SC|regular,700|latin','Amethysta|regular|latin','Anaheim|regular|latin,latin-ext','Andada|regular|latin,latin-ext','Andika|regular|latin,latin-ext,cyrillic,cyrillic-ext','Angkor|regular|khmer','Annie Use Your Telescope|regular|latin','Anonymous Pro|regular,700|latin,greek,latin-ext,cyrillic','Antic|regular|latin','Antic Didone|regular|latin','Antic Slab|regular|latin','Anton|regular|latin,latin-ext','Arapey|regular|latin','Arbutus|regular|latin,latin-ext','Arbutus Slab|regular|latin,latin-ext','Architects Daughter|regular|latin','Archivo Black|regular|latin,latin-ext','Archivo Narrow|regular,700|latin,latin-ext','Arimo|regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Arizonia|regular|latin,latin-ext','Armata|regular|latin,latin-ext','Artifika|regular|latin','Arvo|regular,700|latin','Asap|regular,700|latin,latin-ext','Asset|regular|latin','Astloch|regular,700|latin','Asul|regular,700|latin','Atomic Age|regular|latin','Aubrey|regular|latin','Audiowide|regular|latin,latin-ext','Autour One|regular|latin,latin-ext','Average|regular|latin,latin-ext','Average Sans|regular|latin,latin-ext','Averia Gruesa Libre|regular|latin,latin-ext','Averia Libre|300,regular,700|latin','Averia Sans Libre|300,regular,700|latin','Averia Serif Libre|300,regular,700|latin','Bad Script|regular|latin,cyrillic','Balthazar|regular|latin','Bangers|regular|latin','Basic|regular|latin,latin-ext','Battambang|regular,700|khmer','Baumans|regular|latin','Bayon|regular|khmer','Belgrano|regular|latin','Belleza|regular|latin,latin-ext','BenchNine|300,regular,700|latin,latin-ext','Bentham|regular|latin','Berkshire Swash|regular|latin,latin-ext','Bevan|regular|latin','Bigelow Rules|regular|latin,latin-ext','Bigshot One|regular|latin','Bilbo|regular|latin,latin-ext','Bilbo Swash Caps|regular|latin,latin-ext','Bitter|regular,700|latin,latin-ext','Black Ops One|regular|latin,latin-ext','Bokor|regular|khmer','Bonbon|regular|latin','Boogaloo|regular|latin','Bowlby One|regular|latin','Bowlby One SC|regular|latin,latin-ext','Brawler|regular|latin','Bree Serif|regular|latin,latin-ext','Bubblegum Sans|regular|latin,latin-ext','Bubbler One|regular|latin,latin-ext','Buda|300|latin','Buenard|regular,700|latin,latin-ext','Butcherman|regular|latin,latin-ext','Butterfly Kids|regular|latin,latin-ext','Cabin|regular,500,600,700|latin','Cabin Condensed|regular,500,600,700|latin','Cabin Sketch|regular,700|latin','Caesar Dressing|regular|latin','Cagliostro|regular|latin','Calligraffitti|regular|latin','Cambo|regular|latin','Candal|regular|latin','Cantarell|regular,700|latin','Cantata One|regular|latin,latin-ext','Cantora One|regular|latin,latin-ext','Capriola|regular|latin,latin-ext','Cardo|regular,700|latin,greek,latin-ext,greek-ext','Carme|regular|latin','Carrois Gothic|regular|latin','Carrois Gothic SC|regular|latin','Carter One|regular|latin','Caudex|regular,700|latin,greek,latin-ext,greek-ext','Cedarville Cursive|regular|latin','Ceviche One|regular|latin','Changa One|regular|latin','Chango|regular|latin,latin-ext','Chau Philomene One|regular|latin,latin-ext','Chela One|regular|latin,latin-ext','Chelsea Market|regular|latin,latin-ext','Chenla|regular|khmer','Cherry Cream Soda|regular|latin','Cherry Swash|regular,700|latin,latin-ext','Chewy|regular|latin','Chicle|regular|latin,latin-ext','Chivo|regular,900|latin','Cinzel|regular,700,900|latin','Cinzel Decorative|regular,700,900|latin','Clicker Script|regular|latin,latin-ext','Coda|regular,800|latin','Coda Caption|800|latin','Codystar|300,regular|latin,latin-ext','Combo|regular|latin,latin-ext','Comfortaa|300,regular,700|latin,greek,latin-ext,cyrillic,cyrillic-ext','Coming Soon|regular|latin','Concert One|regular|latin,latin-ext','Condiment|regular|latin,latin-ext','Content|regular,700|khmer','Contrail One|regular|latin','Convergence|regular|latin','Cookie|regular|latin','Copse|regular|latin','Corben|regular,700|latin','Courgette|regular|latin,latin-ext','Cousine|regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Coustard|regular,900|latin','Covered By Your Grace|regular|latin','Crafty Girls|regular|latin','Creepster|regular|latin','Crete Round|regular|latin,latin-ext','Crimson Text|regular,600,700|latin','Croissant One|regular|latin,latin-ext','Crushed|regular|latin','Cuprum|regular,700|latin,latin-ext,cyrillic','Cutive|regular|latin,latin-ext','Cutive Mono|regular|latin,latin-ext','Damion|regular|latin','Dancing Script|regular,700|latin','Dangrek|regular|khmer','Dawning of a New Day|regular|latin','Days One|regular|latin','Delius|regular|latin','Delius Swash Caps|regular|latin','Delius Unicase|regular,700|latin','Della Respira|regular|latin','Denk One|regular|latin,latin-ext','Devonshire|regular|latin,latin-ext','Didact Gothic|regular|latin,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Diplomata|regular|latin,latin-ext','Diplomata SC|regular|latin,latin-ext','Domine|regular,700|latin,latin-ext','Donegal One|regular|latin,latin-ext','Doppio One|regular|latin,latin-ext','Dorsa|regular|latin','Dosis|200,300,regular,500,600,700,800|latin,latin-ext','Dr Sugiyama|regular|latin,latin-ext','Droid Sans|regular,700|latin','Droid Sans Mono|regular|latin','Droid Serif|regular,700|latin','Duru Sans|regular|latin,latin-ext','Dynalight|regular|latin,latin-ext','EB Garamond|regular|latin,vietnamese,latin-ext,cyrillic,cyrillic-ext','Eagle Lake|regular|latin,latin-ext','Eater|regular|latin,latin-ext','Economica|regular,700|latin,latin-ext','Ek Mukta|200,300,regular,500,600,700,800|latin,latin-ext,devanagari','Electrolize|regular|latin','Elsie|regular,900|latin,latin-ext','Elsie Swash Caps|regular,900|latin,latin-ext','Emblema One|regular|latin,latin-ext','Emilys Candy|regular|latin,latin-ext','Engagement|regular|latin','Englebert|regular|latin,latin-ext','Enriqueta|regular,700|latin,latin-ext','Erica One|regular|latin','Esteban|regular|latin,latin-ext','Euphoria Script|regular|latin,latin-ext','Ewert|regular|latin,latin-ext','Exo|100,200,300,regular,500,600,700,800,900|latin,latin-ext','Exo 2|100,200,300,regular,500,600,700,800,900|latin,latin-ext,cyrillic','Expletus Sans|regular,500,600,700|latin','Fanwood Text|regular|latin','Fascinate|regular|latin','Fascinate Inline|regular|latin','Faster One|regular|latin','Fasthand|regular|khmer','Fauna One|regular|latin,latin-ext','Federant|regular|latin','Federo|regular|latin','Felipa|regular|latin,latin-ext','Fenix|regular|latin,latin-ext','Finger Paint|regular|latin','Fira Mono|regular,700|latin,greek,latin-ext,cyrillic,cyrillic-ext','Fira Sans|300,regular,500,700|latin,greek,latin-ext,cyrillic,cyrillic-ext','Fjalla One|regular|latin,latin-ext','Fjord One|regular|latin','Flamenco|300,regular|latin','Flavors|regular|latin','Fondamento|regular|latin,latin-ext','Fontdiner Swanky|regular|latin','Forum|regular|latin,latin-ext,cyrillic,cyrillic-ext','Francois One|regular|latin,latin-ext','Freckle Face|regular|latin,latin-ext','Fredericka the Great|regular|latin','Fredoka One|regular|latin','Freehand|regular|khmer','Fresca|regular|latin,latin-ext','Frijole|regular|latin','Fruktur|regular|latin,latin-ext','Fugaz One|regular|latin','GFS Didot|regular|greek','GFS Neohellenic|regular,700|greek','Gabriela|regular|latin,latin-ext','Gafata|regular|latin,latin-ext','Galdeano|regular|latin','Galindo|regular|latin,latin-ext','Gentium Basic|regular,700|latin,latin-ext','Gentium Book Basic|regular,700|latin,latin-ext','Geo|regular|latin','Geostar|regular|latin','Geostar Fill|regular|latin','Germania One|regular|latin','Gilda Display|regular|latin,latin-ext','Give You Glory|regular|latin','Glass Antiqua|regular|latin,latin-ext','Glegoo|regular,700|latin,latin-ext,devanagari','Gloria Hallelujah|regular|latin','Goblin One|regular|latin','Gochi Hand|regular|latin','Gorditas|regular,700|latin','Goudy Bookletter 1911|regular|latin','Graduate|regular|latin','Grand Hotel|regular|latin,latin-ext','Gravitas One|regular|latin','Great Vibes|regular|latin,latin-ext','Griffy|regular|latin,latin-ext','Gruppo|regular|latin,latin-ext','Gudea|regular,700|latin,latin-ext','Habibi|regular|latin,latin-ext','Halant|300,regular,500,600,700|latin,latin-ext,devanagari','Hammersmith One|regular|latin,latin-ext','Hanalei|regular|latin,latin-ext','Hanalei Fill|regular|latin,latin-ext','Handlee|regular|latin','Hanuman|regular,700|khmer','Happy Monkey|regular|latin,latin-ext','Headland One|regular|latin,latin-ext','Henny Penny|regular|latin','Herr Von Muellerhoff|regular|latin,latin-ext','Hind|300,regular,500,600,700|latin,latin-ext,devanagari','Holtwood One SC|regular|latin','Homemade Apple|regular|latin','Homenaje|regular|latin,latin-ext','IM Fell DW Pica|regular|latin','IM Fell DW Pica SC|regular|latin','IM Fell Double Pica|regular|latin','IM Fell Double Pica SC|regular|latin','IM Fell English|regular|latin','IM Fell English SC|regular|latin','IM Fell French Canon|regular|latin','IM Fell French Canon SC|regular|latin','IM Fell Great Primer|regular|latin','IM Fell Great Primer SC|regular|latin','Iceberg|regular|latin','Iceland|regular|latin','Imprima|regular|latin,latin-ext','Inconsolata|regular,700|latin,latin-ext','Inder|regular|latin,latin-ext','Indie Flower|regular|latin','Inika|regular,700|latin,latin-ext','Irish Grover|regular|latin','Istok Web|regular,700|latin,latin-ext,cyrillic,cyrillic-ext','Italiana|regular|latin','Italianno|regular|latin,latin-ext','Jacques Francois|regular|latin','Jacques Francois Shadow|regular|latin','Jim Nightshade|regular|latin,latin-ext','Jockey One|regular|latin,latin-ext','Jolly Lodger|regular|latin,latin-ext','Josefin Sans|100,300,regular,600,700|latin,latin-ext','Josefin Slab|100,300,regular,600,700|latin','Joti One|regular|latin,latin-ext','Judson|regular,700|latin','Julee|regular|latin','Julius Sans One|regular|latin,latin-ext','Junge|regular|latin','Jura|300,regular,500,600|latin,greek,latin-ext,cyrillic,cyrillic-ext','Just Another Hand|regular|latin','Just Me Again Down Here|regular|latin,latin-ext','Kalam|300,regular,700|latin,latin-ext,devanagari','Kameron|regular,700|latin','Kantumruy|300,regular,700|khmer','Karla|regular,700|latin,latin-ext','Karma|300,regular,500,600,700|latin,latin-ext,devanagari','Kaushan Script|regular|latin,latin-ext','Kavoon|regular|latin,latin-ext','Kdam Thmor|regular|khmer','Keania One|regular|latin,latin-ext','Kelly Slab|regular|latin,latin-ext,cyrillic','Kenia|regular|latin','Khand|300,regular,500,600,700|latin,latin-ext,devanagari','Khmer|regular|khmer','Kite One|regular|latin','Knewave|regular|latin,latin-ext','Kotta One|regular|latin,latin-ext','Koulen|regular|khmer','Kranky|regular|latin','Kreon|300,regular,700|latin','Kristi|regular|latin','Krona One|regular|latin,latin-ext','La Belle Aurore|regular|latin','Laila|300,regular,500,600,700|latin,latin-ext,devanagari','Lancelot|regular|latin','Lato|100,300,regular,700,900|latin,latin-ext','League Script|regular|latin','Leckerli One|regular|latin','Ledger|regular|latin,latin-ext,cyrillic','Lekton|regular,700|latin,latin-ext','Lemon|regular|latin','Libre Baskerville|regular,700|latin,latin-ext','Life Savers|regular,700|latin,latin-ext','Lilita One|regular|latin,latin-ext','Lily Script One|regular|latin,latin-ext','Limelight|regular|latin,latin-ext','Linden Hill|regular|latin','Lobster|regular|latin,latin-ext,cyrillic','Lobster Two|regular,700|latin','Londrina Outline|regular|latin','Londrina Shadow|regular|latin','Londrina Sketch|regular|latin','Londrina Solid|regular|latin','Lora|regular,700|latin,latin-ext,cyrillic','Love Ya Like A Sister|regular|latin','Loved by the King|regular|latin','Lovers Quarrel|regular|latin,latin-ext','Luckiest Guy|regular|latin','Lusitana|regular,700|latin','Lustria|regular|latin','Macondo|regular|latin','Macondo Swash Caps|regular|latin','Magra|regular,700|latin,latin-ext','Maiden Orange|regular|latin','Mako|regular|latin','Marcellus|regular|latin,latin-ext','Marcellus SC|regular|latin,latin-ext','Marck Script|regular|latin,latin-ext,cyrillic','Margarine|regular|latin,latin-ext','Marko One|regular|latin','Marmelad|regular|latin,latin-ext,cyrillic','Marvel|regular,700|latin','Mate|regular|latin','Mate SC|regular|latin','Maven Pro|regular,500,700,900|latin','McLaren|regular|latin,latin-ext','Meddon|regular|latin','MedievalSharp|regular|latin,latin-ext','Medula One|regular|latin','Megrim|regular|latin','Meie Script|regular|latin,latin-ext','Merienda|regular,700|latin,latin-ext','Merienda One|regular|latin','Merriweather|300,regular,700,900|latin,latin-ext','Merriweather Sans|300,regular,700,800|latin,latin-ext','Metal|regular|khmer','Metal Mania|regular|latin,latin-ext','Metamorphous|regular|latin,latin-ext','Metrophobic|regular|latin','Michroma|regular|latin','Milonga|regular|latin,latin-ext','Miltonian|regular|latin','Miltonian Tattoo|regular|latin','Miniver|regular|latin','Miss Fajardose|regular|latin,latin-ext','Modern Antiqua|regular|latin,latin-ext','Molengo|regular|latin,latin-ext','Molle|italic|latin,latin-ext','Monda|regular,700|latin,latin-ext','Monofett|regular|latin','Monoton|regular|latin','Monsieur La Doulaise|regular|latin,latin-ext','Montaga|regular|latin','Montez|regular|latin','Montserrat|regular,700|latin','Montserrat Alternates|regular,700|latin','Montserrat Subrayada|regular,700|latin','Moul|regular|khmer','Moulpali|regular|khmer','Mountains of Christmas|regular,700|latin','Mouse Memoirs|regular|latin,latin-ext','Mr Bedfort|regular|latin,latin-ext','Mr Dafoe|regular|latin,latin-ext','Mr De Haviland|regular|latin,latin-ext','Mrs Saint Delafield|regular|latin,latin-ext','Mrs Sheppards|regular|latin,latin-ext','Muli|300,regular|latin','Mystery Quest|regular|latin,latin-ext','Neucha|regular|latin,cyrillic','Neuton|200,300,regular,700,800|latin,latin-ext','New Rocker|regular|latin,latin-ext','News Cycle|regular,700|latin,latin-ext','Niconne|regular|latin,latin-ext','Nixie One|regular|latin','Nobile|regular,700|latin','Nokora|regular,700|khmer','Norican|regular|latin,latin-ext','Nosifer|regular|latin,latin-ext','Nothing You Could Do|regular|latin','Noticia Text|regular,700|latin,vietnamese,latin-ext','Noto Sans|regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext,devanagari','Noto Serif|regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Nova Cut|regular|latin','Nova Flat|regular|latin','Nova Mono|regular|latin,greek','Nova Oval|regular|latin','Nova Round|regular|latin','Nova Script|regular|latin','Nova Slim|regular|latin','Nova Square|regular|latin','Numans|regular|latin','Nunito|300,regular,700|latin','Odor Mean Chey|regular|khmer','Offside|regular|latin','Old Standard TT|regular,700|latin','Oldenburg|regular|latin,latin-ext','Oleo Script|regular,700|latin,latin-ext','Oleo Script Swash Caps|regular,700|latin,latin-ext','Open Sans|300,regular,600,700,800|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext,devanagari','Open Sans Condensed|300,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Oranienbaum|regular|latin,latin-ext,cyrillic,cyrillic-ext','Orbitron|regular,500,700,900|latin','Oregano|regular|latin,latin-ext','Orienta|regular|latin,latin-ext','Original Surfer|regular|latin','Oswald|300,regular,700|latin,latin-ext','Over the Rainbow|regular|latin','Overlock|regular,700,900|latin,latin-ext','Overlock SC|regular|latin,latin-ext','Ovo|regular|latin','Oxygen|300,regular,700|latin,latin-ext','Oxygen Mono|regular|latin,latin-ext','PT Mono|regular|latin,latin-ext,cyrillic,cyrillic-ext','PT Sans|regular,700|latin,latin-ext,cyrillic,cyrillic-ext','PT Sans Caption|regular,700|latin,latin-ext,cyrillic,cyrillic-ext','PT Sans Narrow|regular,700|latin,latin-ext,cyrillic,cyrillic-ext','PT Serif|regular,700|latin,latin-ext,cyrillic,cyrillic-ext','PT Serif Caption|regular|latin,latin-ext,cyrillic,cyrillic-ext','Pacifico|regular|latin','Paprika|regular|latin','Parisienne|regular|latin,latin-ext','Passero One|regular|latin,latin-ext','Passion One|regular,700,900|latin,latin-ext','Pathway Gothic One|regular|latin,latin-ext','Patrick Hand|regular|latin,vietnamese,latin-ext','Patrick Hand SC|regular|latin,vietnamese,latin-ext','Patua One|regular|latin','Paytone One|regular|latin','Peralta|regular|latin,latin-ext','Permanent Marker|regular|latin','Petit Formal Script|regular|latin,latin-ext','Petrona|regular|latin','Philosopher|regular,700|latin,cyrillic','Piedra|regular|latin,latin-ext','Pinyon Script|regular|latin','Pirata One|regular|latin,latin-ext','Plaster|regular|latin,latin-ext','Play|regular,700|latin,greek,latin-ext,cyrillic,cyrillic-ext','Playball|regular|latin,latin-ext','Playfair Display|regular,700,900|latin,latin-ext,cyrillic','Playfair Display SC|regular,700,900|latin,latin-ext,cyrillic','Podkova|regular,700|latin','Poiret One|regular|latin,latin-ext,cyrillic','Poller One|regular|latin','Poly|regular|latin','Pompiere|regular|latin','Pontano Sans|regular|latin,latin-ext','Port Lligat Sans|regular|latin','Port Lligat Slab|regular|latin','Prata|regular|latin','Preahvihear|regular|khmer','Press Start 2P|regular|latin,greek,latin-ext,cyrillic','Princess Sofia|regular|latin,latin-ext','Prociono|regular|latin','Prosto One|regular|latin,latin-ext,cyrillic','Puritan|regular,700|latin','Purple Purse|regular|latin,latin-ext','Quando|regular|latin,latin-ext','Quantico|regular,700|latin','Quattrocento|regular,700|latin,latin-ext','Quattrocento Sans|regular,700|latin,latin-ext','Questrial|regular|latin','Quicksand|300,regular,700|latin','Quintessential|regular|latin,latin-ext','Qwigley|regular|latin,latin-ext','Racing Sans One|regular|latin,latin-ext','Radley|regular|latin,latin-ext','Rajdhani|300,regular,500,600,700|latin,latin-ext,devanagari','Raleway|100,200,300,regular,500,600,700,800,900|latin','Raleway Dots|regular|latin,latin-ext','Rambla|regular,700|latin,latin-ext','Rammetto One|regular|latin,latin-ext','Ranchers|regular|latin,latin-ext','Rancho|regular|latin','Rationale|regular|latin','Redressed|regular|latin','Reenie Beanie|regular|latin','Revalia|regular|latin,latin-ext','Ribeye|regular|latin,latin-ext','Ribeye Marrow|regular|latin,latin-ext','Righteous|regular|latin,latin-ext','Risque|regular|latin,latin-ext','Roboto|100,300,regular,500,700,900|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Roboto Condensed|300,regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Roboto Slab|100,300,regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Rochester|regular|latin','Rock Salt|regular|latin','Rokkitt|regular,700|latin','Romanesco|regular|latin,latin-ext','Ropa Sans|regular|latin,latin-ext','Rosario|regular,700|latin','Rosarivo|regular|latin,latin-ext','Rouge Script|regular|latin','Rozha One|regular|latin,latin-ext,devanagari','Rubik Mono One|regular|latin,latin-ext','Rubik One|regular|latin,latin-ext','Ruda|regular,700,900|latin,latin-ext','Rufina|regular,700|latin,latin-ext','Ruge Boogie|regular|latin,latin-ext','Ruluko|regular|latin,latin-ext','Rum Raisin|regular|latin,latin-ext','Ruslan Display|regular|latin,latin-ext,cyrillic','Russo One|regular|latin,latin-ext,cyrillic','Ruthie|regular|latin,latin-ext','Rye|regular|latin,latin-ext','Sacramento|regular|latin,latin-ext','Sail|regular|latin','Salsa|regular|latin','Sanchez|regular|latin,latin-ext','Sancreek|regular|latin,latin-ext','Sansita One|regular|latin','Sarina|regular|latin,latin-ext','Sarpanch|regular,500,600,700,800,900|latin,latin-ext,devanagari','Satisfy|regular|latin','Scada|regular,700|latin,latin-ext,cyrillic','Schoolbell|regular|latin','Seaweed Script|regular|latin,latin-ext','Sevillana|regular|latin,latin-ext','Seymour One|regular|latin,latin-ext,cyrillic','Shadows Into Light|regular|latin','Shadows Into Light Two|regular|latin,latin-ext','Shanti|regular|latin','Share|regular,700|latin,latin-ext','Share Tech|regular|latin','Share Tech Mono|regular|latin','Shojumaru|regular|latin,latin-ext','Short Stack|regular|latin','Siemreap|regular|khmer','Sigmar One|regular|latin','Signika|300,regular,600,700|latin,latin-ext','Signika Negative|300,regular,600,700|latin,latin-ext','Simonetta|regular,900|latin,latin-ext','Sintony|regular,700|latin,latin-ext','Sirin Stencil|regular|latin','Six Caps|regular|latin','Skranji|regular,700|latin,latin-ext','Slabo 13px|regular|latin,latin-ext','Slabo 27px|regular|latin,latin-ext','Slackey|regular|latin','Smokum|regular|latin','Smythe|regular|latin','Sniglet|regular,800|latin,latin-ext','Snippet|regular|latin','Snowburst One|regular|latin,latin-ext','Sofadi One|regular|latin','Sofia|regular|latin','Sonsie One|regular|latin,latin-ext','Sorts Mill Goudy|regular|latin,latin-ext','Source Code Pro|200,300,regular,500,600,700,900|latin,latin-ext','Source Sans Pro|200,300,regular,600,700,900|latin,vietnamese,latin-ext','Source Serif Pro|regular,600,700|latin,latin-ext','Special Elite|regular|latin','Spicy Rice|regular|latin','Spinnaker|regular|latin,latin-ext','Spirax|regular|latin','Squada One|regular|latin','Stalemate|regular|latin,latin-ext','Stalinist One|regular|latin,latin-ext,cyrillic','Stardos Stencil|regular,700|latin','Stint Ultra Condensed|regular|latin,latin-ext','Stint Ultra Expanded|regular|latin,latin-ext','Stoke|300,regular|latin,latin-ext','Strait|regular|latin','Sue Ellen Francisco|regular|latin','Sunshiney|regular|latin','Supermercado One|regular|latin','Suwannaphum|regular|khmer','Swanky and Moo Moo|regular|latin','Syncopate|regular,700|latin','Tangerine|regular,700|latin','Taprom|regular|khmer','Tauri|regular|latin,latin-ext','Teko|300,regular,500,600,700|latin,latin-ext,devanagari','Telex|regular|latin','Tenor Sans|regular|latin,latin-ext,cyrillic','Text Me One|regular|latin,latin-ext','The Girl Next Door|regular|latin','Tienne|regular,700,900|latin','Tinos|regular,700|latin,vietnamese,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Titan One|regular|latin,latin-ext','Titillium Web|200,300,regular,600,700,900|latin,latin-ext','Trade Winds|regular|latin','Trocchi|regular|latin,latin-ext','Trochut|regular,700|latin','Trykker|regular|latin,latin-ext','Tulpen One|regular|latin','Ubuntu|300,regular,500,700|latin,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Ubuntu Condensed|regular|latin,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Ubuntu Mono|regular,700|latin,greek,latin-ext,cyrillic,greek-ext,cyrillic-ext','Ultra|regular|latin','Uncial Antiqua|regular|latin','Underdog|regular|latin,latin-ext,cyrillic','Unica One|regular|latin,latin-ext','UnifrakturCook|700|latin','UnifrakturMaguntia|regular|latin','Unkempt|regular,700|latin','Unlock|regular|latin','Unna|regular|latin','VT323|regular|latin','Vampiro One|regular|latin,latin-ext','Varela|regular|latin,latin-ext','Varela Round|regular|latin','Vast Shadow|regular|latin','Vesper Libre|regular,500,700,900|latin,latin-ext,devanagari','Vibur|regular|latin','Vidaloka|regular|latin','Viga|regular|latin,latin-ext','Voces|regular|latin,latin-ext','Volkhov|regular,700|latin','Vollkorn|regular,700|latin','Voltaire|regular|latin','Waiting for the Sunrise|regular|latin','Wallpoet|regular|latin','Walter Turncoat|regular|latin','Warnes|regular|latin,latin-ext','Wellfleet|regular|latin,latin-ext','Wendy One|regular|latin,latin-ext','Wire One|regular|latin','Yanone Kaffeesatz|200,300,regular,700|latin,latin-ext','Yellowtail|regular|latin','Yeseva One|regular|latin,latin-ext,cyrillic','Yesteryear|regular|latin','Zeyada|regular|latin');
}

}

add_action('init', 'tosca_load_theme_options');