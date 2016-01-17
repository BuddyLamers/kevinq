<?php

get_header();

the_post();

$hide_heading_title = false;

if ( function_exists ('rwmb_meta') ) {

	$hide_heading_title = rwmb_meta("hide_post_title");

	$hide_heading_title = ($hide_heading_title == 1);

}

?>



<section id="content">

	<div class="container">

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

</section>



<?php get_footer(); ?>