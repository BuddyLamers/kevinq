<?php 



// set default link values

$post_link = get_permalink();

$post_link_custom = false;



$post_format = get_post_format();

if ($post_format == 'link') {

	$content = get_the_content();

	if (preg_match("/<a\s[^>]*href=([\"\']??)([^\\1 >]*?)\\1[^>]*>(.*)<\/a>/siU", $content, $matches)) {

		if (isset($matches[2])) {

			$post_link = $matches[2];

			$post_link_custom = true;

		}

	}

}

?>



		<article id="post-<?php the_ID(); ?>" <?php post_class('post animate-in-view'); ?>>

<?php if ( ! post_password_required() ) : ?>

			<div class="post-image thumb fade">

				<div class="photo">

					<a href="<?php echo esc_url($post_link); ?>"<?php if ($post_link_custom) echo ' target="_blank"'; ?>><?php the_post_thumbnail('large'); ?><span class="info"><span class="icon-link"></span></span></a>

				</div>

			</div>

<?php endif; ?>

			<div class="post-text">

				<div class="inner">

					<h3><a href="<?php echo esc_url($post_link); ?>" class="title"<?php if ($post_link_custom) echo ' target="_blank"'; ?>><?php the_title(); ?></a></h3>

					<div class="post-info">

						<span class="time"><?php esc_html_e('Posted in ', 'tosca'); echo esc_html(get_the_time(get_option('date_format'))); ?></span><?php $post_categories = get_the_category_list(esc_html__(', ', 'tosca')); if ($post_categories) : ?> <span class="categories"><?php esc_html_e('in ', 'tosca'); ?> <?php echo $post_categories; ?></span><?php endif; ?> <span class="author"><?php esc_html_e('by', 'tosca'); ?> <?php the_author_posts_link(); ?></span><?php if ( ! post_password_required() && comments_open() && ! $post_link_custom ) : ?> <span class="comments">&#8226; <a href="<?php echo esc_url($post_link); ?>#comments"><?php comments_number(); ?></a></span><?php endif; ?>

					</div>

					<?php if ( ! $post_link_custom ) : ?>

					<div class="post-excerpt"><?php the_excerpt(10); ?></div>

					<?php endif; ?>

				</div>

			</div>

			<div class="clear"></div>

		</article>