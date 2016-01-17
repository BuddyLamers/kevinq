<?php
defined('ABSPATH') || exit;

if ( ! class_exists('RW_Meta_Box') ) {

	class RW_Meta_Box {

		public $meta_box;
		public $fields;
		public $types;
		public $validation;
		public $saved = false;

		function __construct( $meta_box ) {
			if ( ! is_admin() ) return;

			$this->meta_box   = self::normalize( $meta_box );
			$this->fields     = &$this->meta_box['fields'];
			$this->validation = &$this->meta_box['validation'];

			$show = true;
			$show = apply_filters('rwmb_show', $show, $this->meta_box );
			$show = apply_filters( "rwmb_show_{$this->meta_box['id']}", $show, $this->meta_box );

			if ( !$show ) return;

			add_action('admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts') );

			$fields = self::get_fields( $this->fields );
			foreach ( $fields as $field ) {
				call_user_func( array( self::get_class_name( $field ), 'add_actions') );
			}

			add_action('add_meta_boxes', array( $this, 'add_meta_boxes') );
			add_filter('default_hidden_meta_boxes', array( $this, 'hide'), 10, 2 );
			add_action('save_post', array( $this, 'save_post') );
			add_action('edit_attachment', array( $this, 'save_post') );
			add_action('add_attachment', array( $this, 'save_post') );
		}

		function admin_enqueue_scripts() {
			$screen = get_current_screen();

			if ('post' != $screen->base || ! in_array( $screen->post_type, $this->meta_box['pages'] ) )
				return;

			wp_enqueue_style('cerchez-core', RWMB_CSS_URL . 'style.css', array(), RWMB_VER );

			$has_clone = false;
			$fields = self::get_fields( $this->fields );

			foreach ( $fields as $field ) {
				if ( $field['clone'] ) $has_clone = true;
				call_user_func( array( self::get_class_name( $field ), 'admin_enqueue_scripts') );
			}

			if ( $has_clone ) wp_enqueue_script('rwmb-clone', RWMB_JS_URL . 'clone.js', array('jquery'), RWMB_VER, true );

			if ( $this->validation ) {
				wp_enqueue_script('jquery-validate', RWMB_JS_URL . 'jquery.validate.min.js', array('jquery'), RWMB_VER, true );
				wp_enqueue_script('rwmb-validate', RWMB_JS_URL . 'validate.js', array('jquery-validate'), RWMB_VER, true );
			}

			if ( $this->meta_box['autosave'] ) wp_enqueue_script('rwmb-autosave', RWMB_JS_URL . 'autosave.js', array('jquery'), RWMB_VER, true );
		}

		static function get_fields( $fields ) {
			$all_fields = array();
			foreach ( $fields as $field )
			{
				$all_fields[] = $field;
				if ( isset( $field['fields'] ) )
					$all_fields = array_merge( $all_fields, self::get_fields( $field['fields'] ) );
			}

			return $all_fields;
		}

		function add_meta_boxes() {
			foreach ( $this->meta_box['pages'] as $page )
			{
				add_meta_box(
					$this->meta_box['id'],
					$this->meta_box['title'],
					array( $this, 'show'),
					$page,
					$this->meta_box['context'],
					$this->meta_box['priority']
				);
			}
		}

		function hide( $hidden, $screen ) {
			if (
				'post' === $screen->base
				&& in_array( $screen->post_type, $this->meta_box['pages'] )
				&& $this->meta_box['default_hidden']
			) {
				$hidden[] = $this->meta_box['id'];
			}
			return $hidden;
		}

		function show() {
			global $post;

			$saved = self::has_been_saved( $post->ID, $this->fields );

			printf(
				'<div class="rwmb-meta-box" data-autosave="%s">',
				$this->meta_box['autosave']  ? 'true' : 'false'
			);

			wp_nonce_field( "rwmb-save-{$this->meta_box['id']}", "nonce_{$this->meta_box['id']}" );

			do_action('rwmb_before');
			do_action( "rwmb_before_{$this->meta_box['id']}" );

			foreach ( $this->fields as $field ) {
				call_user_func( array( self::get_class_name( $field ), 'show'), $field, $saved );
			}

			if ( isset( $this->validation ) && $this->validation ) {
				echo '<script>
					if ( typeof rwmb == "undefined" ) {
						var rwmb = {
							validationOptions : jQuery.parseJSON( \'' . json_encode( $this->validation ) . '\'),
							summaryMessage : "' . __('Please correct the errors highlighted below and try again.', 'cerchez-core') . '"
						};
					} else {
						var tempOptions = jQuery.parseJSON( \'' . json_encode( $this->validation ) . '\');
						jQuery.extend( true, rwmb.validationOptions, tempOptions );
					};
					</script>';
			}

			do_action('rwmb_after');
			do_action( "rwmb_after_{$this->meta_box['id']}" );

			echo '</div>';
		}

		function save_post( $post_id ) {
			if ( $this->saved === true ) return;
			$this->saved = true;

			$id = $this->meta_box['id'];
			if ( empty( $_POST["nonce_{$id}"] ) || ! wp_verify_nonce( $_POST["nonce_{$id}"], "rwmb-save-{$id}" ) )
				return;

			if ( defined('DOING_AUTOSAVE') && ! $this->meta_box['autosave'] )
				return;

			if ( $the_post = wp_is_post_revision( $post_id ) ) $post_id = $the_post;

			do_action('rwmb_before_save_post', $post_id );
			do_action( "rwmb_{$this->meta_box['id']}_before_save_post", $post_id );

			foreach ( $this->fields as $field ) {
				$name = $field['id'];
				$old  = get_post_meta( $post_id, $name, !$field['multiple'] );
				$new  = isset( $_POST[$name] ) ? $_POST[$name] : ( $field['multiple'] ? array() : '');

				$new = call_user_func( array( self::get_class_name( $field ), 'value'), $new, $old, $post_id, $field );

				$new = apply_filters( "rwmb_{$field['type']}_value", $new, $field, $old );
				$new = apply_filters( "rwmb_{$name}_value", $new, $field, $old );

				call_user_func( array( self::get_class_name( $field ), 'save'), $new, $old, $post_id, $field );
			}

			do_action('rwmb_after_save_post', $post_id );
			do_action( "rwmb_{$this->meta_box['id']}_after_save_post", $post_id );

			$called = false;
		}

		static function normalize( $meta_box ) {
			$meta_box = wp_parse_args( $meta_box, array(
				'id'             => sanitize_title( $meta_box['title'] ),
				'context'        => 'normal',
				'priority'       => 'high',
				'pages'          => array('post'),
				'autosave'       => false,
				'default_hidden' => false,
			) );
			$meta_box['fields'] = self::normalize_fields( $meta_box['fields'] );
			return $meta_box;
		}

		static function normalize_fields( $fields ) {
			foreach ( $fields as &$field ) {
				$field = wp_parse_args( $field, array(
					'multiple'      => false,
					'clone'         => false,
					'std'           => '',
					'desc'          => '',
					'format'        => '',
					'before'        => '',
					'after'         => '',
					'field_name'    => isset( $field['id'] ) ? $field['id'] : '',
					'required'      => false,
					'placeholder'   => ''
				) );

				$field = call_user_func( array( self::get_class_name( $field ), 'normalize_field'), $field );

				if ( isset( $field['fields'] ) )
					$field['fields'] = self::normalize_fields( $field['fields'] );
			}

			return $fields;
		}

		static function get_class_name( $field ) {
			$type = str_replace('_', ' ', $field['type'] );
			$class = 'RWMB_' . ucwords( $type ) . '_Field';
			$class = str_replace(' ', '_', $class );
			return class_exists( $class ) ? $class : false;
		}

		static function has_been_saved( $post_id, $fields ) {
			foreach ( $fields as $field ) {
				$value = get_post_meta( $post_id, $field['id'], !$field['multiple'] );
				if ( ( !$field['multiple'] && '' !== $value ) || ( $field['multiple'] && array() !== $value ) ) {
					return true;
				}
			}
			return false;
		}
	}
}
