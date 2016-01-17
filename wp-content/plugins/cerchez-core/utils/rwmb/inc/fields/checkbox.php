<?php
defined('ABSPATH') || exit;

if ( ! class_exists('RWMB_Checkbox_Field') ) {
	class RWMB_Checkbox_Field extends RWMB_Field {

		static function html( $meta, $field ) {
			return sprintf(
				'<input type="checkbox" class="rwmb-checkbox" name="%s" id="%s" value="1" %s />',
				$field['field_name'],
				$field['id'],
				checked( !empty( $meta ), 1, false )
			);
		}

		static function value( $new, $old, $post_id, $field ) {
			return empty( $new ) ? 0 : 1;
		}
	}
}