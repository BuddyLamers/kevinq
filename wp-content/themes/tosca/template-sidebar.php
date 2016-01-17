<?php

/**

 *	Template Name: Sidebar Template

 *

 *	The template for displaying generic pages with a sidebar

 */



get_header();

the_post();



$hide_heading_title = false;

$sidebar_position = 'right';

if ( function_exists ('rwmb_meta') ) {

	$hide_heading_title = rwmb_meta('hide_post_title');

	$hide_heading_title = ($hide_heading_title == 1);

	$sidebar_position = rwmb_meta('sidebar_position');

	if (empty($sidebar_position)) $sidebar_position = 'right';

}

?>



<section id="content">

	<div class="container">

		<?php

			if ( is_active_sidebar('default-sidebar') && ! empty($sidebar_position) && $sidebar_position == 'left' ) {

				get_sidebar('left');

			}

		?>



		<div class="col <?php if ( is_active_sidebar('default-sidebar') && ! empty($sidebar_position) && $sidebar_position != 'none') { echo 'grid9'; if ($sidebar_position == 'left') echo ' omega'; } else echo 'grid12'; ?>">



			<?php if ( ! $hide_heading_title && get_the_title()) : ?>

			<h2 class="page-title no-bottom" itemprop="name"><?php the_title(); ?></h2>

			<hr class="special">

			<?php endif; ?>



			<div class="entry-content" itemprop="mainContentOfPage">

				<?php

					the_content();

					wp_link_pages();

				?>

			</div>



			<?php if ( ! post_password_required() ) : ?>

					<?php comments_template(); ?>

			<?php endif; ?>



		</div>



		<?php

			if ( is_active_sidebar('default-sidebar') && ! empty($sidebar_position) && $sidebar_position == 'right' ) {

				get_sidebar();

			}

		?>



		<div class="clear"></div>

	</div>

</section>



<?php get_footer(); ?>