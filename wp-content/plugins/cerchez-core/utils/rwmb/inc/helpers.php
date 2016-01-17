<?php
defined('ABSPATH') || exit;

if ( ! class_exists('RWMB_Helper') ) {

	class RWMB_Helper {

		static function on_load() {
			add_shortcode('rwmb_meta', array( __CLASS__, 'shortcode') );
		}

		static function shortcode( $atts ) {
			$atts = wp_parse_args( $atts, array(
				'type'    => 'text',
				'post_id' => get_the_ID(),
			) );
			if ( empty( $atts['meta_key'] ) ) return '';

			$meta = self::meta( $atts['meta_key'], $atts, $atts['post_id'] );

			if ( in_array( $atts['type'], array('file', 'file_advanced') ) ) {
				$content = '<ul>';
				foreach ( $meta as $file ) {
					$content .= sprintf(
						'<li><a href="%s" title="%s">%s</a></li>',
						$file['url'],
						$file['title'],
						$file['name']
					);
				}
				$content .= '</ul>';
			} elseif ( in_array( $atts['type'], array('image', 'image_advanced') ) ) {
				$content = '<ul>';
				foreach ( $meta as $image ) {
					if ( isset( $atts['link'] ) && $atts['link'] ) {
						$content .= sprintf(
							'<li><a href="%s" title="%s"><img src="%s" alt="%s" title="%s" /></a></li>',
							$image['full_url'],
							$image['title'],
							$image['url'],
							$image['alt'],
							$image['title']
						);
					} else {
						$content .= sprintf(
							'<li><img src="%s" alt="%s" title="%s" /></li>',
							$image['url'],
							$image['alt'],
							$image['title']
						);
					}
				}
				$content .= '</ul>';
			} elseif ( is_array( $meta ) ) {
				$content = '<ul><li>' . implode('</li><li>', $meta ) . '</li></ul>';
			} else {
				$content = $meta;
			}

			return apply_filters( __FUNCTION__, $content );
		}

		static function meta( $key, $args = array(), $post_id = null ) {
			if (empty( $post_id )) {
				global $post;
				if( ! is_object($post) ) return;
				$post_id = get_the_ID();
			}

			$args = wp_parse_args( $args, array(
				'type' => 'text',
			) );

			if ( !isset( $args['multiple'] ) ) $args['multiple'] = in_array( $args['type'], array('file', 'image', 'image_advanced') );

			$meta = get_post_meta( $post_id, $key, !$args['multiple'] );

			if ( in_array( $args['type'], array('file', 'file_advanced') ) ) {
				if ( is_array( $meta ) && !empty( $meta ) ) {
					$files = array();
					foreach ( $meta as $id ) {
						$files[$id] = self::file_info( $id );
					}
					$meta = $files;
				}
			} elseif ( in_array( $args['type'], array('image', 'image_advanced') ) ) {
				global $wpdb;

				$meta = $wpdb->get_col( $wpdb->prepare( "
					SELECT meta_value FROM $wpdb->postmeta
					WHERE post_id = %d AND meta_key = '%s'
					ORDER BY meta_id ASC
				", $post_id, $key ) );

				if ( is_array( $meta ) && !empty( $meta ) ) {
					$images = array();
					foreach ( $meta as $id )
					{
						$images[$id] = self::image_info( $id, $args );
					}
					$meta = $images;
				}
			}

			return apply_filters( __FUNCTION__, $meta, $key, $args, $post_id );
		}

		static function file_info( $id ) {
			$path = get_attached_file( $id );
			return array(
				'ID'    => $id,
				'name'  => basename( $path ),
				'path'  => $path,
				'url'   => wp_get_attachment_url( $id ),
				'title' => get_the_title( $id ),
			);
		}

		static function image_info( $id, $args = array() ) {
			$args = wp_parse_args( $args, array(
				'size' => 'thumbnail',
			) );

			$img_src = wp_get_attachment_image_src( $id, $args['size'] );
			if ( empty( $img_src ) ) return false;

			$attachment = get_post( $id );
			$path = get_attached_file( $id );
			return array(
				'ID'          => $id,
				'name'        => basename( $path ),
				'path'        => $path,
				'url'         => $img_src[0],
				'width'       => $img_src[1],
				'height'      => $img_src[2],
				'full_url'    => wp_get_attachment_url( $id ),
				'title'       => $attachment->post_title,
				'caption'     => $attachment->post_excerpt,
				'description' => $attachment->post_content,
				'alt'         => get_post_meta( $id, '_wp_attachment_image_alt', true ),
			);
		}
	}

	RWMB_Helper::on_load();
}

if ( ! function_exists('rwmb_meta')) {
	function rwmb_meta( $key, $args = array(), $post_id = null ) {
		return RWMB_Helper::meta( $key, $args, $post_id );
	}
}