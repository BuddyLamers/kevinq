<?php
defined('ABSPATH') || exit;

if ( ! class_exists('RWMB_Image_Field') ) {

	class RWMB_Image_Field extends RWMB_File_Field {

		static function admin_enqueue_scripts() {
			parent::admin_enqueue_scripts();
			wp_enqueue_style('rwmb-image', RWMB_CSS_URL . 'image.css', array(), RWMB_VER );
			wp_enqueue_script('rwmb-image', RWMB_JS_URL . 'image.js', array('jquery-ui-sortable'), RWMB_VER, true );
		}

		static function add_actions() {
			parent::add_actions();
			add_action('wp_ajax_rwmb_reorder_images', array( __CLASS__, 'wp_ajax_reorder_images') );
		}

		static function wp_ajax_reorder_images() {
			$field_id = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$order    = isset( $_POST['order'] ) ? $_POST['order'] : 0;
			$post_id  = isset( $_POST['post_id'] ) ? (int) $_POST['post_id'] : 0;

			check_ajax_referer( "rwmb-reorder-images_{$field_id}" );

			parse_str( $order, $items );

			delete_post_meta( $post_id, $field_id );
			foreach ( $items['item'] as $item ) {
				add_post_meta( $post_id, $field_id, $item, false );
			}
			wp_send_json_success();
		}

		static function html( $meta, $field ) {
			$i18n_title = apply_filters('rwmb_image_upload_string', _x('Upload Images', 'image upload', 'cerchez-core'), $field );
			$i18n_more  = apply_filters('rwmb_image_add_string', _x('+ Add new image', 'image upload', 'cerchez-core'), $field );

			$html = self::get_uploaded_images( $meta, $field );

			$html .= sprintf(
				'<h4>%s</h4>
				<div class="new-files">
					<div class="file-input"><input type="file" name="%s[]" /></div>
					<a class="rwmb-add-file" href="#"><strong>%s</strong></a>
				</div>',
				$i18n_title,
				$field['id'],
				$i18n_more
			);

			return $html;
		}

		static function get_uploaded_images( $images, $field ) {
			$reorder_nonce = wp_create_nonce( "rwmb-reorder-images_{$field['id']}" );
			$delete_nonce = wp_create_nonce( "rwmb-delete-file_{$field['id']}" );
			$classes = array('rwmb-images', 'rwmb-uploaded');
			if ( count( $images ) <= 0  )
				$classes[] = 'hidden';
			$ul = '<ul class="%s" data-field_id="%s" data-delete_nonce="%s" data-reorder_nonce="%s" data-force_delete="%s" data-max_file_uploads="%s">';
			$html = sprintf(
				$ul,
				implode(' ', $classes ),
				$field['id'],
				$delete_nonce,
				$reorder_nonce,
				$field['force_delete'] ? 1 : 0,
				$field['max_file_uploads']
			);

			foreach ( $images as $image ) {
				$html .= self::img_html( $image );
			}

			$html .= '</ul>';

			return $html;
		}

		static function img_html( $image ) {
			$i18n_delete = apply_filters('rwmb_image_delete_string', _x('Delete', 'image upload', 'cerchez-core') );
			$i18n_edit   = apply_filters('rwmb_image_edit_string', _x('Edit', 'image upload', 'cerchez-core') );
			$li = '
				<li id="item_%s">
					<img src="%s" />
					<a title="%s" class="rwmb-edit-file" href="%s" target="_blank">%s</a>
					<a title="%s" class="rwmb-delete-file" href="#" data-attachment_id="%s">×</a>
				</li>';

			$src  = wp_get_attachment_image_src( $image, 'thumbnail');
			$src  = $src[0];
			$link = get_edit_post_link( $image );

			return sprintf(
				$li,
				$image,
				$src,
				$i18n_edit, $link, $i18n_edit,
				$i18n_delete, $image
			);
		}

		static function meta( $post_id, $saved, $field ) {
			global $wpdb;

			$meta = $wpdb->get_col( $wpdb->prepare( "
				SELECT meta_value FROM $wpdb->postmeta
				WHERE post_id = %d AND meta_key = '%s'
				ORDER BY meta_id ASC
			", $post_id, $field['id'] ) );

			return empty( $meta ) ? array() : $meta;
		}
	}
}
