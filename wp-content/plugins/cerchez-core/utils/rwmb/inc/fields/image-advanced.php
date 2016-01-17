<?php
defined('ABSPATH') || exit;

require_once RWMB_FIELDS_DIR . 'image.php';

if ( ! class_exists('RWMB_Image_Advanced_Field') ) {
	class RWMB_Image_Advanced_Field extends RWMB_Image_Field {

		static function admin_enqueue_scripts() {
			parent::admin_enqueue_scripts();
			wp_enqueue_media();
			wp_enqueue_script('rwmb-image-advanced', RWMB_JS_URL . 'image-advanced.js', array('jquery', 'underscore'), RWMB_VER, true );
			wp_localize_script('rwmb-image-advanced', 'rwmbImageAdvanced', array(
				'frameTitle' => __('Select Images', 'cerchez-core'),
			) );
		}

		static function add_actions() {
			parent::add_actions();
			add_action('wp_ajax_rwmb_attach_media', array( __CLASS__, 'wp_ajax_attach_media') );
			add_action('print_media_templates', array( __CLASS__, 'print_templates') );
		}

		static function wp_ajax_attach_media() {
			$post_id = is_numeric( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : 0;
			$field_id = isset( $_POST['field_id'] ) ? $_POST['field_id'] : 0;
			$attachment_ids = isset( $_POST['attachment_ids'] ) ? $_POST['attachment_ids'] : array();

			check_ajax_referer( "rwmb-attach-media_{$field_id}" );
			foreach ( $attachment_ids as $attachment_id ) {
				add_post_meta( $post_id, $field_id, $attachment_id, false );
			}
			wp_send_json_success();
		}

		static function html( $meta, $field ) {
			$i18n_title = apply_filters('rwmb_image_advanced_select_string', _x('Select or Upload Images', 'image upload', 'cerchez-core'), $field );
			$attach_nonce = wp_create_nonce( "rwmb-attach-media_{$field['id']}" );
			$html = self::get_uploaded_images( $meta, $field );
			$classes = array('button', 'rwmb-image-advanced-upload', 'hide-if-no-js', 'new-files');

			if ( ! empty( $field['max_file_uploads'] ) && count( $meta ) >= (int) $field['max_file_uploads'] )
				$classes[] = 'hidden';

			$classes = implode(' ', $classes );
			$html .= "<a href='#' class='{$classes}' data-attach_media_nonce={$attach_nonce}>{$i18n_title}</a>";

			return $html;
		}

		static function value( $new, $old, $post_id, $field ) {
			$new = (array) $new;
			return array_unique( array_merge( $old, $new ) );
		}

		static function print_templates() {
			$i18n_delete = apply_filters('rwmb_image_delete_string', _x('Delete', 'image upload', 'cerchez-core') );
			$i18n_edit   = apply_filters('rwmb_image_edit_string', _x('Edit', 'image upload', 'cerchez-core') );
			?>
				<script id="tmpl-rwmb-image-advanced" type="text/html">
				<# _.each( attachments, function( attachment ) { #>
				<li id="item_{{{ attachment.id }}}">
					<# if ( attachment.sizes.hasOwnProperty('thumbnail') ) { #>
						<img src="{{{ attachment.sizes.thumbnail.url }}}">
					<# } else { #>
						<img src="{{{ attachment.sizes.full.url }}}">
					<# } #>
					<a title="<?php echo $i18n_edit; ?>" class="rwmb-edit-file" href="{{{ attachment.editLink }}}" target="_blank"><?php echo $i18n_edit; ?></a>
					<a title="<?php echo $i18n_delete; ?>" class="rwmb-delete-file" href="#" data-attachment_id="{{{ attachment.id }}}">×</a>
				</li>
				<# } ); #>
			</script><?php
		}

	}
}
