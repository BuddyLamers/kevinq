<?php

/**

 * The template for displaying 404 pages (not found)

 */



get_header(); ?>



<section id="content">

	<div class="container textcenter">

		<h1 class="error"><?php esc_html_e('404', 'tosca'); ?></h1>

		<p class="margin-top"><?php esc_html_e('Apologies, but no results were found for the requested page.', 'tosca'); ?></p>

		<p><?php esc_html_e('Perhaps searching will help find a related item.', 'tosca'); ?></p>

		<?php get_search_form(); ?>

		<br>

	</div>

</section>



<?php get_footer(); ?>