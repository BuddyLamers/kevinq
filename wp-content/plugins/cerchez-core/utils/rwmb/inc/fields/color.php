<?php
defined('ABSPATH') || exit;

if ( ! class_exists('RWMB_Color_Field') ) {

	class RWMB_Color_Field extends RWMB_Field {

		static function admin_enqueue_scripts() {
			wp_enqueue_style('wp-color-picker');
			//wp_enqueue_style('rwmb-color', RWMB_CSS_URL . 'color.css', array('wp-color-picker'), RWMB_VER );
			wp_enqueue_script('rwmb-color', RWMB_JS_URL . 'color.js', array('wp-color-picker'), RWMB_VER, true );
		}

		static function html( $meta, $field ) {
			return sprintf(
				'<input class="rwmb-color" type="text" name="%s" id="%s" value="%s" size="%s" />
				<div class="rwmb-color-picker"></div>',
				$field['field_name'],
				empty( $field['clone'] ) ? $field['id'] : '',
				$meta,
				$field['size']
			);
		}

		static function value( $new, $old, $post_id, $field ) {
			return '#' === $new ? '' : $new;
		}

		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'size' => 7,
			) );

			return $field;
		}
	}
}
