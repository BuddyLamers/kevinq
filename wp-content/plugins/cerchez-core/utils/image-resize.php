<?php



/**

* Resizes an image and returns the resized URL. Uses native WordPress functionality.

*

* The function supports GD Library and ImageMagick. WordPress will pick whichever is most appropriate.

* If none of the supported libraries are available, the function will return the original image url.

*

* Images are saved to the WordPress uploads directory, just like images uploaded through the Media Library.

* 

* Supports WordPress 3.5 and above.

*

*/



add_action('delete_attachment', 'cerchez_delete_resized_images');



function cerchez_image_resize($url, $width=null, $height=null, $crop=true, $align='c', $retina=false) {



	global $wpdb;

	$args = func_get_args();

	$common = cerchez_common_info($args);

	if (is_array($common)) {

		extract($common);

	} else {

		return $common;

	}



	if (!file_exists($dest_file_name)) {

		// We only want to resize Media Library images, so we can be sure they get deleted correctly when appropriate

		$query = $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE guid='%s'", $url);

		$get_attachment = $wpdb->get_results($query);

		$editor = wp_get_image_editor($file_path);

		if (is_wp_error($editor)) {

			if (is_user_logged_in()) print_r($editor);

			return null;

		}



		if ($crop) {

			$src_x = $src_y = 0;

			$src_w = $orig_width;

			$src_h = $orig_height;

			$cmp_x = $orig_width / $dest_width;

			$cmp_y = $orig_height / $dest_height;

			if ($cmp_x > $cmp_y) {

				$src_w = round ($orig_width / $cmp_x * $cmp_y);

				$src_x = round (($orig_width - ($orig_width / $cmp_x * $cmp_y)) / 2);

			} else if ($cmp_y > $cmp_x) {

				$src_h = round ($orig_height / $cmp_y * $cmp_x);

				$src_y = round (($orig_height - ($orig_height / $cmp_y * $cmp_x)) / 2);

			}

			if ($align && $align != 'c') {

				if (strpos ($align, 't') !== false) {

					$src_y = 0;

				}

				if (strpos ($align, 'b') !== false) {

					$src_y = $orig_height - $src_h;

				}

				if (strpos ($align, 'l') !== false) {

					$src_x = 0;

				}

				if (strpos ($align, 'r') !== false) {

					$src_x = $orig_width - $src_w;

				}

			}

			$editor->crop($src_x, $src_y, $src_w, $src_h, $dest_width, $dest_height);

		} else {

			$editor->resize($dest_width, $dest_height);

		}



		$saved = $editor->save($dest_file_name);



		if (is_wp_error($saved)) {

			if (is_user_logged_in()) {

				print_r($saved);

				unlink($dest_file_name);

			}

			return null;

		}



		// Add the resized dimensions and alignment to original image metadata, so the images can be deleted when the original image is delete from the Media Library

		if ($get_attachment) {

			$metadata = wp_get_attachment_metadata($get_attachment[0]->ID);

			if (isset($metadata['image_meta'])) {

				$md = $saved['width'] . 'x' . $saved['height'];

				if ($crop) $md .= ($align) ? "_${align}" : "_c";

				$metadata['image_meta']['resized_images'][] = $md;

				wp_update_attachment_metadata($get_attachment[0]->ID, $metadata);

			}

		}

		$resized_url = str_replace(basename($url), basename($saved['path']), $url);

	} else {

		$resized_url = str_replace(basename($url), basename($dest_file_name), $url);

	}

	return $resized_url;

}



// Returns common information shared by processing functions

function cerchez_common_info($args) {

	list($url, $width, $height, $crop, $align, $retina) = $args;

	if (empty($url)) {

		return is_user_logged_in() ? "image_not_specified" : null;

	}



	// Return if nocrop is set on query string

	if (preg_match('/(\?|&)nocrop/', $url)) {

		return $url;

	}



	// Get the image file path

	$urlinfo = parse_url($url);

	$wp_upload_dir = wp_upload_dir();



	if (preg_match('/\/[0-9]{4}\/[0-9]{2}\/.+$/', $urlinfo['path'], $matches)) {

		$file_path = $wp_upload_dir['basedir'] . $matches[0];

	} else {

		$pathinfo = parse_url( $url );

		$uploads_dir = is_multisite() ? '/files/' : '/wp-content/';

		$file_path = ABSPATH . str_replace(dirname($_SERVER['SCRIPT_NAME']) . '/', '', strstr($pathinfo['path'], $uploads_dir));

		$file_path = preg_replace('/(\/\/)/', '/', $file_path);

	}



	if (!file_exists($file_path)) {

		return null;

	}



	$size = is_user_logged_in() ? getimagesize($file_path) : @getimagesize($file_path);

	if (!$size) {

		return is_user_logged_in() ? "getimagesize_error_common" : null;

	}



	list($orig_width, $orig_height, $orig_type) = $size;

	if ($width && !$height) {

		$height = floor ($orig_height * ($width / $orig_width));

	} else if ($height && !$width) {

		$width = floor ($orig_width * ($height / $orig_height));

	} else if (!$width && !$height) {

		return $url;

	}

	$retina = $retina ? ($retina === true ? 2 : $retina) : 1;

	$dest_width = $width * $retina;

	$dest_height = $height * $retina;

	$info = pathinfo($file_path);

	$dir = $info['dirname'];

	$ext = $info['extension'];

	$name = wp_basename($file_path, ".$ext");

	$suffix = "${dest_width}x${dest_height}";

	if ($crop) {

		$suffix .= ($align) ? "_${align}" : "_c";

	}

	$dest_file_name = "${dir}/${name}-${suffix}.${ext}";



	return array(

		'dir' => $dir,

		'name' => $name,

		'ext' => $ext,

		'suffix' => $suffix,

		'orig_width' => $orig_width,

		'orig_height' => $orig_height,

		'orig_type' => $orig_type,

		'dest_width' => $dest_width,

		'dest_height' => $dest_height,

		'file_path' => $file_path,

		'dest_file_name' => $dest_file_name,

	);

}



// Deletes the resized images when the original image is deleted from the WordPress Media Library

function cerchez_delete_resized_images($post_id) {

	$metadata = wp_get_attachment_metadata($post_id);

	if (!$metadata) return;

	if (!isset($metadata['file']) || !isset($metadata['image_meta']['resized_images'])) return;

	$wp_upload_dir = wp_upload_dir();

	$pathinfo = pathinfo($metadata['file']);

	$resized_images = $metadata['image_meta']['resized_images'];

	foreach ($resized_images as $dims) {

		$file = $wp_upload_dir['basedir'] . '/' . $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-' . $dims . '.' . $pathinfo['extension'];

		is_user_logged_in() ? unlink($file) : @unlink($file);

	}

}