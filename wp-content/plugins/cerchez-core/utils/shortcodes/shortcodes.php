<?php



/* allow shortcodes in widgets */

add_filter('widget_text', 'do_shortcode');



require_once( 'shortcode-list.php' );

require_once( 'shortcode-generator.php' );