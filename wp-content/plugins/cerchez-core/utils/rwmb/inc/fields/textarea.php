<?php
defined('ABSPATH') || exit;

if ( ! class_exists('RWMB_Textarea_Field') ) {

	class RWMB_Textarea_Field extends RWMB_Field {

		static function html( $meta, $field ) {
			return sprintf(
				'<textarea class="rwmb-textarea large-text" name="%s" id="%s" cols="%s" rows="%s" placeholder="%s">%s</textarea>',
				$field['field_name'],
				$field['id'],
				$field['cols'],
				$field['rows'],
				$field['placeholder'],
				$meta
			);
		}

		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'cols' => 60,
				'rows' => 3,
			) );
			return $field;
		}
	}
}