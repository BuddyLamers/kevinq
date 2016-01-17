<?php
// Prevent loading this file directly
defined('ABSPATH') || exit;

if ( ! class_exists('RWMB_Number_Field') ) {

	class RWMB_Number_Field extends RWMB_Field {

		static function html( $meta, $field ) {
			return sprintf(
				'<input type="number" class="rwmb-number %s" name="%s" id="%s" value="%s" step="%s" min="%s" max="%s" placeholder="%s"/>',
				$field['class'],
				$field['field_name'],
				$field['id'],
				$meta,
				$field['step'],
				$field['min'],
				isset($field['max']) ? $field['max'] : '',
				$field['placeholder']
			);
		}

		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'step' => 1,
				'min'  => 0,
				'placeholder' => '',
				'class'       => '',
			) );

			return $field;
		}
	}
}
