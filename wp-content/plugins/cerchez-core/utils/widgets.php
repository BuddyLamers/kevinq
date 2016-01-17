<?php



add_action('widgets_init', 'cerchez_load_widgets');



class Cerchez_Flickr extends WP_Widget {



	public function __construct() {

		$widget_ops = array('description' => __( 'Display your latest Flickr photostream.', 'cerchez-core') );

		parent::__construct(false, __('Flickr Widget', 'cerchez-core'), $widget_ops);

	}



	/* Displays the widget contents. */

	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );



		echo $args['before_widget'];

		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];



		$photos = $this->get_photos( array(

			'userid' => $instance['userid'],

			'count' => $instance['count']

		) );



		if ( is_wp_error( $photos ) ) {

			echo $photos->get_error_message();

		} else {

			$items ='';

			foreach ( $photos as $photo ) {

				$src = str_replace("_m.","_s.", esc_url( $photo->media->m ));

				$title = esc_attr( $photo->title );

				$items .= sprintf( '<a href="%s" rel="external" class="tooltip" title="%s"><img src="%s" alt="%s" width="75" height="75" /></a>', esc_url( $photo->link ), $title, $src, $title );

			}

			echo $items . '<div class="clear"></div>';

		}

		echo $args['after_widget'];

	}



	/* Returns an array of photos on a WP_Error. */

	private function get_photos( $args = array() ) {

		$transient_key = md5( 'cerchez-core-flickr-cache-' . print_r( $args, true ) );

		$cached = get_transient( $transient_key );

		if ( $cached ) return $cached;



		$userid = isset( $args['userid'] ) ? $args['userid'] : '';

		$count = isset( $args['count'] ) ? absint( $args['count'] ) : 10;

		$query = array(

			'id' => $userid

		);



		$photos = $this->request_feed( 'photos_public', $query );



		if ( ! $photos ) return new WP_Error('error', __('Could not fetch photos.', 'cerchez-core'));



		$photos = array_slice( $photos, 0, $count );

		set_transient( $transient_key, $photos, apply_filters('cerchez-core_flickr_widget_cache_timeout', 3600 ) );

		return $photos;

	}



	/* Fetch items from the Flickr Feed API. */

	private function request_feed( $feed = 'photos_public', $args = array() ) {

		$args['format'] = 'json';

		$args['nojsoncallback'] = 1;

		$url = sprintf( 'http://api.flickr.com/services/feeds/%s.gne', $feed );

		$url = esc_url_raw( add_query_arg( $args, $url ) );



		$response = wp_remote_get( $url, array('timeout' => 10) );

		if ( is_wp_error($response) || ! isset($response['body']) )

			return false;

		

		$body = wp_remote_retrieve_body( $response );

		$body = preg_replace( "#\\\\'#", "\\\\\\'", $body );

 		$obj = json_decode( $body );



		return $obj ? $obj->items : false;



	}



	/* Validate and update widget options. */

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['userid'] = strip_tags( $new_instance['userid'] );

		$instance['count'] = absint( $new_instance['count'] );

		return $new_instance;

	}



	/* Render widget controls. */

	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Photos from Flickr', 'cerchez-core');

		$userid = isset( $instance['userid'] ) ? $instance['userid'] : '';

		$count = isset( $instance['count'] ) ? absint( $instance['count'] ) : 6;

		?>

		<p>

			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Title', 'cerchez-core' ); ?>:</label> 

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		</p>

		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>"><?php _e( 'Flickr ID ', 'cerchez-core' ); ?>(<a href="http://idgettr.com/" target="_blank">idgettr.com</a>):</label> 

			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'userid' ) ); ?>" type="text" value="<?php echo esc_attr( $userid ); ?>" />

		</p>

		<p>

			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php _e( 'Count', 'cerchez-core' ); ?>:</label><br />

			<input type="number" min="1" max="20" value="<?php echo esc_attr( $count ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" />

		</p>

<?php

	}

}



class Cerchez_Dribbble extends WP_Widget {



	public function __construct() {

		$widget_ops = array('description' => __( 'Display your latest Dribbble shots.', 'cerchez-core') );

		parent::__construct(false, __('Dribbble Widget', 'cerchez-core'),$widget_ops);

	}



	/* Displays the widget contents. */

	public function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );

		$player = esc_attr($instance['player']);

		$limit = esc_attr($instance['count']);

		$size = (isset($instance['size'])) ? esc_attr($instance['size']) : 3;



		echo $args['before_widget'];

		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];

		echo $this->get_dribbble_shots($player, $limit, $size);

		echo $args['after_widget'];

	}



	function get_dribbble_shots( $player, $limit, $size ) {

		$key = 'cerchezdribbble_' . $player;



		if ( $cache === $cache = get_transient($key) ) {

			$url = 'https://dribbble.com/' . $player . '/shots.rss';

			$rss = fetch_feed( $url );

			if( is_wp_error( $rss ) ) return __('Could not fetch dribbbles.', 'cerchez-core');



			add_filter('wp_feed_cache_transient_lifetime', create_function('$a', 'return 360;'));

			set_transient($key, $rss, 300);

		} else {

			$rss = $cache;

		}



		$maxitems = $rss->get_item_quantity($limit); 

		$rss_items = $rss->get_items(0, $maxitems);



		if ( ! empty($rss_items) ) {

			$i = 0;

			$output = '';

			foreach ( $rss_items as $item ) {

				if ( $i == $limit ) break;

				$description = $item->get_description();

				preg_match("/src=\"(http.*(jpg|jpeg|gif|png))/", $description, $image_url);

				$image = $image_url[1];

				switch ($size) {

					case 1:

						$image = preg_replace('/.(jpg|jpeg|gif|png)/', '_teaser.$1', $image);

						break;



					case 2:

						$image = preg_replace('/.(jpg|jpeg|gif|png)/', '_1x.$1', $image);

						break;

				}



				$output .= '<a href="' . esc_url($item->get_permalink()) . '" rel="external" class="tooltip" title="' . esc_attr($item->get_title()) . '">';

				$output .= '<img src="' . esc_url($image) . '" alt="' . esc_attr($item->get_title()) . '">';

				$output .= '</a>';

				$i++;

			}

			$output .= '<div class="clear"></div>';

		} else {

			$output = __('Error retrieving Dribbble shots', 'cerchez-core');

		}



		return $output;

	}



	/* Validate and update widget options. */

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['player'] = strip_tags( $new_instance['player'] );

		$instance['count'] = absint( $new_instance['count'] );

		$instance['size'] = absint( $new_instance['size'] );

		return $new_instance;

	}



	/* Render widget controls. */

	public function form( $instance ) {

		$defaults = array(

			'title' => __( 'Dribbble shots', 'cerchez-core'),

			'player' => 'liviucerchez',

			'count' => 1,

			'size' => 1,

		);

		$instance = wp_parse_args( (array) $instance, $defaults );



		$title = $instance['title'];

		$player = $instance['player'];

		$count = $instance['count'];

		$size = $instance['size'];



		?>

		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'cerchez-core' ); ?>:</label> 

			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

		</p>

		<p>

			<label for="<?php echo $this->get_field_id( 'player' ); ?>"><?php _e( 'Player', 'cerchez-core' ); ?>:</label> 

			<input class="widefat" id="<?php echo $this->get_field_id( 'player' ); ?>" name="<?php echo $this->get_field_name( 'player' ); ?>" type="text" value="<?php echo esc_attr( $player ); ?>" />

		</p>

		<p>

			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of shots to show', 'cerchez-core' ); ?>:</label>

			<input type="number" min="1" max="15" value="<?php echo esc_attr( $count ); ?>" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" />

		</p>

		<p>

			<label for="<?php echo $this->get_field_id( 'size' ); ?>"><?php _e( 'Image size', 'cerchez-core' ); ?>:</label>

			<select name="<?php echo $this->get_field_name('size'); ?>">

				<option value="1" <?php selected(1, $size); ?>><?php _e( 'Small', 'cerchez-core' ); ?></option>

				<option value="2" <?php selected(2, $size); ?>><?php _e( 'Normal', 'cerchez-core' ); ?></option>

				<option value="3" <?php selected(3, $size); ?>><?php _e( 'Big', 'cerchez-core' ); ?></option>

			</select>

		</p>

<?php

	}

}



function cerchez_load_widgets() {

	register_widget('Cerchez_Dribbble');

	register_widget('Cerchez_Flickr');

}

