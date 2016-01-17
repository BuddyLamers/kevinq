<?php
// Prevent loading this file directly
defined('ABSPATH') || exit;

if ( !class_exists('RWMB_Wysiwyg_Field') ) {
	class RWMB_Wysiwyg_Field extends RWMB_Field {
		static function admin_enqueue_scripts() {
			wp_enqueue_style('rwmb-meta-box-wysiwyg', RWMB_CSS_URL . 'wysiwyg.css', array(), RWMB_VER );
		}

		static function value( $new, $old, $post_id, $field ) {
			return ( $field['raw'] ? $new : wpautop( $new ) );
		}

		static function html( $meta, $field ) {
			ob_start();
			$field['options']['textarea_name'] = $field['field_name'];
			wp_editor( $meta, $field['id'], $field['options'] );
			return ob_get_clean();
		}

		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'raw'     => false,
				'options' => array(),
			) );

			$field['options'] = wp_parse_args( $field['options'], array(
				'editor_class' => 'rwmb-wysiwyg',
				'dfw'          => true,
			) );

			$field['options'] = apply_filters('rwmb_wysiwyg_settings', $field['options'] );

			return $field;
		}
	}
}