<?php
defined('ABSPATH') || exit;

require_once RWMB_FIELDS_DIR . 'text.php';

if ( ! class_exists('RWMB_URL_Field') ) {
	class RWMB_URL_Field extends RWMB_Text_Field {
		static function html( $meta, $field ) {
			return sprintf(
				'<input type="url" class="rwmb-url" name="%s" id="%s" value="%s" size="%s" placeholder="%s"/>',
				$field['field_name'],
				$field['id'],
				$meta,
				$field['size'],
				$field['placeholder']
			);
		}

		static function value( $new, $old, $post_id, $field) {
			return is_array( $new ) ? array_map('esc_url', $new ) : esc_url( $new );
		}
	}
}
