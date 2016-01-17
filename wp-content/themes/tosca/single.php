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

		<h2 class="page-title no-bottom" itemprop="name headline"><?php the_title(); ?></h2>

		<hr class="special">

		<?php endif;

		if (is_attachment() && wp_attachment_is_image($post->id)) : ?>

		<div class="featured-image"><figure class="wp-caption"><?php echo wp_get_attachment_image($post->id, "full"); ?></figure></div>

		<?php else: ?>

		<div class="entry-content" itemprop="articleBody">

			<?php

				the_content();

				wp_link_pages();

			?>

		</div>

		<?php endif;

		if ( ! post_password_required() ) : ?>

		<div class="sep before-post-meta-info"></div>

		<p class="post-meta-info"><span><em class="icon-clock"></em> <?php esc_html_e('Posted on', 'tosca'); echo ' ' . get_the_time(get_option('date_format')); ?></span> <span><em class="icon-user"></em> <?php esc_html_e('By', 'tosca'); ?> <?php the_author_posts_link(); ?></span><?php $post_categories = get_the_category_list(esc_html__(', ', 'tosca')); if ( is_single() && $post_categories ) : ?> <br><span><em class="icon-category"></em> <?php esc_html_e('Categories: ', 'tosca'); ?> <?php echo $post_categories; ?></span><?php endif; ?><?php if ( is_single() && get_the_tags() ) : ?> <?php if ( ! $post_categories) echo '<br>'; ?><span><em class="icon-tag"></em> <?php the_tags(esc_html__('Tags: ', 'tosca'), esc_html__(', ', 'tosca')); ?></span><?php endif; ?></p>

		<?php comments_template(); ?>

		<?php endif; ?>



	</div>

</section>



<?php get_footer();