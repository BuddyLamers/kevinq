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

			<h3>

				<a href="<?php echo esc_url($post_link); ?>" class="title"<?php if ($post_link_custom) echo ' target="_blank"'; ?>><?php

					if ( ! post_password_required() && has_post_thumbnail() ) {

						the_post_thumbnail('thumbnail');

					} else if ( post_password_required()) {

						echo '<em class="thumb"></em>';

					}

				?><span><?php the_title(); ?></span>

				</a>

				<span class="meta">

					<?php if ( ! post_password_required() && comments_open() && ! $post_link_custom ) : ?>

					<a class="comment-no"><em class="icon-comments"></em> <?php comments_number(); ?></a>

					<?php endif; ?>

					<a><em class="icon-clock"></em> <?php echo esc_html(get_the_time(get_option('date_format'))); ?></a>

				</span>

			</h3>

		</article>