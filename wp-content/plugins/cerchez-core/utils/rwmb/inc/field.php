<?php

if ( !class_exists('RWMB_Field ') ) {

	class RWMB_Field {

		static function add_actions() {}
		static function admin_enqueue_scripts() {}

		static function show( $field, $saved ) {
			global $post;

			$field_class = RW_Meta_Box::get_class_name( $field );
			$meta = call_user_func( array( $field_class, 'meta'), $post->ID, $saved, $field );

			$group = '';
			$type = $field['type'];
			$id   = $field['id'];

			$begin = call_user_func( array( $field_class, 'begin_html'), $meta, $field );

			$begin = apply_filters('rwmb_begin_html', $begin, $field, $meta );
			$begin = apply_filters( "rwmb_{$type}_begin_html", $begin, $field, $meta );
			$begin = apply_filters( "rwmb_{$id}_begin_html", $begin, $field, $meta );

			// Cloneable fields
			if ( $field['clone'] ) {
				if ( isset( $field['clone-group'] ) ) $group = " clone-group='{$field['clone-group']}'";

				$meta = (array) $meta;

				$field_html = '';

				foreach ( $meta as $index => $sub_meta ) {
					$sub_field = $field;
					$sub_field['field_name'] = $field['field_name'] . "[{$index}]";
					if ( $field['multiple'] ) $sub_field['field_name'] .= '[]';

					$input_html = '<div class="rwmb-clone">';

					$input_html .= call_user_func( array( $field_class, 'html'), $sub_meta, $sub_field );

					$input_html = apply_filters( "rwmb_{$type}_html", $input_html, $field, $sub_meta );
					$input_html = apply_filters( "rwmb_{$id}_html", $input_html, $field, $sub_meta );

					$input_html .= self::clone_button();

					$input_html .= '</div>';

					$field_html .= $input_html;
				}
			} else {
				$field_html = call_user_func( array( $field_class, 'html'), $meta, $field );
				$field_html = apply_filters( "rwmb_{$type}_html", $field_html, $field, $meta );
				$field_html = apply_filters( "rwmb_{$id}_html", $field_html, $field, $meta );
			}

			$end = call_user_func( array( $field_class, 'end_html'), $meta, $field );

			$end = apply_filters('rwmb_end_html', $end, $field, $meta );
			$end = apply_filters( "rwmb_{$type}_end_html", $end, $field, $meta );
			$end = apply_filters( "rwmb_{$id}_end_html", $end, $field, $meta );

			$html = apply_filters( "rwmb_{$type}_wrapper_html", "{$begin}{$field_html}{$end}", $field, $meta );
			$html = apply_filters( "rwmb_{$id}_wrapper_html", $html, $field, $meta );

			$classes = array('rwmb-field', "rwmb-{$type}-wrapper" );
			if ('hidden' === $field['type'] ) $classes[] = 'hidden';
			if ( !empty( $field['required'] ) ) $classes[] = 'required';
			if ( !empty( $field['class'] ) ) $classes[] = $field['class'];

			printf(
				$field['before'] . '<div class="%s"%s>%s</div>' . $field['after'],
				implode(' ', $classes ),
				$group,
				$html
			);
		}

		static function html( $meta, $field ) {
			return '';
		}

		static function begin_html( $meta, $field ) {
			if ( empty( $field['name'] ) ) return '<div class="rwmb-input">';

			return sprintf(
				'<div class="rwmb-label">
					<label for="%s">%s</label>
				</div>
				<div class="rwmb-input">',
				$field['id'],
				$field['name']
			);
		}

		static function end_html( $meta, $field ) {
			$id = $field['id'];
			$button = '';
			if ( $field['clone'] ) $button = '<a href="#" class="rwmb-button button-primary add-clone">' . __('+', 'cerchez-core') . '</a>';
			$desc = !empty( $field['desc'] ) ? "<p id='{$id}_description' class='description'>{$field['desc']}</p>" : '';
			$html = "{$button}{$desc}</div>";
			return $html;
		}

		static function clone_button() {
			return '<a href="#" class="rwmb-button button remove-clone">' . __('&#8211;', 'cerchez-core') . '</a>';
		}

		static function meta( $post_id, $saved, $field ) {
			$meta = get_post_meta( $post_id, $field['id'], !$field['multiple'] );
			$meta = ( !$saved && '' === $meta || array() === $meta ) ? $field['std'] : $meta;
			if ('wysiwyg' !== $field['type'] ) $meta = is_array( $meta ) ? array_map('esc_attr', $meta ) : esc_attr( $meta );
			$meta = apply_filters( "rwmb_{$field['type']}_meta", $meta );
			$meta = apply_filters( "rwmb_{$field['id']}_meta", $meta );
			return $meta;
		}

		static function value( $new, $old, $post_id, $field ) {
			return $new;
		}

		static function save( $new, $old, $post_id, $field ) {
			$name = $field['id'];
			if ('' === $new || array() === $new ) {
				delete_post_meta( $post_id, $name );
				return;
			}

			if ( $field['multiple'] ) {
				foreach ( $new as $new_value ) {
					if ( !in_array( $new_value, $old ) ) add_post_meta( $post_id, $name, $new_value, false );
				}
				foreach ( $old as $old_value ) {
					if ( !in_array( $old_value, $new ) ) delete_post_meta( $post_id, $name, $old_value );
				}
			} else {
				if ( $field['clone'] ) {
					$new = (array) $new;
					foreach ( $new as $k => $v ) {
						if ('' === $v ) unset( $new[$k] );
					}
				}
				update_post_meta( $post_id, $name, $new );
			}
		}

		static function normalize_field( $field ) {
			return $field;
		}
	}
}