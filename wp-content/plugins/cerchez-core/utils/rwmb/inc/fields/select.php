<?php
defined('ABSPATH') || exit;

if ( !class_exists('RWMB_Select_Field') ) {

	class RWMB_Select_Field extends RWMB_Field {

		static function admin_enqueue_scripts() {
			wp_enqueue_style('rwmb-select', RWMB_CSS_URL . 'select.css', array(), RWMB_VER );
		}

		static function html( $meta, $field ) {
			$html = sprintf(
				'<select class="rwmb-select %s" name="%s" id="%s" size="%s"%s>',
				$field['class'],
				$field['field_name'],
				$field['id'],
				$field['size'],
				$field['multiple'] ? ' multiple="multiple"' : ''
			);

			$html .= self::options_html( $field, $meta );

			$html .= '</select>';

			return $html;
		}

		static function meta( $post_id, $saved, $field ) {
			$single = $field['clone'] || !$field['multiple'];
			$meta = get_post_meta( $post_id, $field['id'], $single );
			$meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;

			$meta = array_map('esc_attr', (array) $meta );

			return $meta;
		}

		static function save( $new, $old, $post_id, $field ) {
			if ( !$field['clone'] ) {
				parent::save( $new, $old, $post_id, $field );
				return;
			}

			if ( empty( $new ) )
				delete_post_meta( $post_id, $field['id'] );
			else
				update_post_meta( $post_id, $field['id'], $new );
		}

		static function normalize_field( $field ) {
			$field = wp_parse_args( $field, array(
				'class'        => '',
				'desc'        => '',
				'name'        => $field['id'],
				'size'        => $field['multiple'] ? 5 : 0,
				'placeholder' => '',
			) );
			if ( !$field['clone'] && $field['multiple'] )
				$field['field_name'] .= '[]';
			return $field;
		}

		static function options_html( $field, $meta ) {
			$html = '';
			if ( $field['placeholder'] )
				$html = 'select' == $field['type'] ? "<option value=''>{$field['placeholder']}</option>" : '<option></option>';

			$option = '<option value="%s"%s>%s</option>';

			foreach ( $field['options'] as $value => $label ) {
				$html .= sprintf(
					$option,
					$value,
					selected( in_array( $value, (array)$meta ), true, false ),
					$label
				);
			}

			return $html;
		}
	}
}
