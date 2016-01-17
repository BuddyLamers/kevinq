<?php

/**

*	Template Name: Blog Template - Minimal Post List

*

*	The template for displaying blog posts, archive elements and search results

*/



get_header();



$sidebar_position = 'right';

$hide_heading_title = false;

$page_title = '';

if (is_page()) { // check if this is a static blog page (not homepage latest posts)

	the_post();

	$page_title = get_the_title();

	if ( function_exists ('rwmb_meta') ) {

		$hide_heading_title = rwmb_meta("hide_post_title");

		$hide_heading_title = ($hide_heading_title == 1);

		$sidebar_position = rwmb_meta('sidebar_position');

		if (empty($sidebar_position)) $sidebar_position = 'right';

	}

	$page_no = (get_query_var('paged')) ? get_query_var('paged') : ((get_query_var('page')) ? get_query_var('page') : 1);

	$args = array(

		'post_type' => 'post',

		'post_status' => 'publish',

		'paged' => $page_no

	);



	/* filter results by the selected base category */

	if ( function_exists('rwmb_meta') ) {

		$journal_category = rwmb_meta('base_category');

		if ( isset($journal_category) && ! empty($journal_category) && $journal_category != 0 ) {

			$args['cat'] = $journal_category;

		}

	}

	query_posts($args);

} else {

	$hide_heading_title = false;

	$allowed_html_array = array('em' => array());

	if (is_category()) {

		$page_title = sprintf( wp_kses(__('Category: <em>%s</em>', 'tosca'), $allowed_html_array), single_cat_title('', FALSE ) );

	} elseif ( is_search() ) {

		$page_title = sprintf( wp_kses(__('Search results for: <em>%s</em>', 'tosca'), $allowed_html_array), get_search_query());

	} elseif ( is_tag() ) {

		$page_title = sprintf( wp_kses(__('Posts tagged: <em>%s</em>', 'tosca'), $allowed_html_array), single_tag_title('', FALSE ) );

	} elseif ( is_day() ) {

		$page_title = sprintf( wp_kses(__('Archive: <em>%s</em>', 'tosca'), $allowed_html_array), get_the_time('F jS, Y') );

	} elseif ( is_month() ) {

		$page_title = sprintf( wp_kses(__('Archive: <em>%s</em>', 'tosca'), $allowed_html_array), get_the_time('F, Y') );

	} elseif ( is_year() ) {

		$page_title = sprintf( wp_kses(__('Archive: <em>%s</em>', 'tosca'), $allowed_html_array), get_the_time('Y') );

	} elseif ( is_author() ) {

		$page_title = sprintf( wp_kses(__('Author Archive: %s</em>', 'tosca'), $allowed_html_array), get_the_author() );

	}

}

?>



<section id="content">

	<div class="container">

		<?php if ( is_active_sidebar('default-sidebar') && ! empty($sidebar_position) && $sidebar_position == 'left' ) get_sidebar('left'); ?>

		<div id="post-list" class="col <?php if ( is_active_sidebar('default-sidebar') && ! empty($sidebar_position) && $sidebar_position != 'none') { echo 'grid9'; if ($sidebar_position == 'left') echo ' omega'; } else echo 'grid12'; ?>">

			<?php if ( ! $hide_heading_title && $page_title) : ?>

			<h2 class="page-title" itemprop="name"><?php echo $page_title; ?></h2>

			<?php endif; ?>

			<?php

				if (have_posts()) {

					while(have_posts()) {

						the_post();

						get_template_part('content', get_post_format());

					}

					tosca_pagination_links();

					wp_reset_query();

				} else {

					get_template_part('content', 'none');

				}

			?>

		</div>

		<?php if ( is_active_sidebar('default-sidebar') && ! empty($sidebar_position) && $sidebar_position == 'right' ) get_sidebar(); ?>

		<div class="clear"></div>

	</div>

</section>



<?php get_footer(); ?>