<?php

/**

 * The template for displaying Comments.

 */



if ( post_password_required() || ! comments_open() ) {

	return;

}

?>



		<div id="comments" class="comments-container">

			<div class="sep"></div>

<?php if ( have_comments() ) : ?>

			<h3><?php printf( esc_html__('Comments (%s)', 'tosca'), number_format_i18n( get_comments_number() ) ); ?></h3>

			<ol class="commentlist">

				<?php

					wp_list_comments( array(

						'callback' => 'tosca_comments',

						'style' => 'ol',

						'short_ping' => true,

					) );

				?>

			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option('page_comments') ) : // are there comments to navigate through ?>

			<div class="comments-pagination">

				<p><?php previous_comments_link( esc_html__('&larr; Older Comments', 'tosca') ); echo " "; next_comments_link( esc_html__('Newer Comments &rarr;', 'tosca') ); ?></p>

			</div>

<?php endif; // check for comment navigation ?>

<?php if ( ! comments_open() && get_comments_number() ) : ?>

			<p class="nocomments"><?php esc_html_e('Comments are closed.' , 'tosca'); ?></p>

<?php endif; ?>

<?php endif; // have_comments() ?>

<?php

	$commenter = wp_get_current_commenter();

	$req = get_option('require_name_email');

	$aria_req = ( $req ? " aria-required='true'" : '' );

	$args = array(

		'logged_in_as' => '

				<p class="logged-in-as">' . esc_html__('Logged in as', 'tosca') . ' <a href="' . esc_url( get_option('siteurl') ) . '/wp-admin/profile.php">' . $user_identity . '</a>. <a href="' . esc_url( wp_logout_url(apply_filters('the_permalink', get_permalink())) ) . '" title="' . esc_html__('Log out of this account', 'tosca') . '">' . esc_html__('Log out', 'tosca') . '</a></p>',

		'comment_notes_after' => '',

		'title_reply' => esc_html__('Leave a comment', 'tosca'),

		'title_reply_to' => esc_html__('Leave a reply to %s', 'tosca'),

		'comment_field' => '<label for="comment">' . esc_html__('Message', 'tosca') . ':</label><textarea name="comment" id="comment" rows="7" tabindex="4" class="full-width" aria-required="true"></textarea>',

		'fields' => apply_filters( 'comment_form_default_fields', array(

			'author' => '<div class="comment-form-author">' . '<label for="author">' . esc_html__('Name', 'tosca') . ( $req ? '<span class="required">*</span>' : '' ) . ':</label><input id="author" name="author" type="text" class="full-width" value="' . esc_attr( $commenter['comment_author'] ) . '"' . $aria_req . ' tabindex="1" /></div>',

			'email' => '<div class="comment-form-email"><label for="email">' . esc_html__('Email', 'tosca') . ( $req ? '<span class="required">*</span>' : '' ) . ':</label><input id="email" name="email" type="text" class="full-width" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . ' tabindex="2" /></div>',

			'url' => '<div class="comment-form-url"><label for="url">' . esc_html__('Website', 'tosca') . ':</label>' . '<input id="url" name="url" type="text" class="full-width" value="' . esc_attr( $commenter['comment_author_url'] ) . '" tabindex="3" /></div><div class="clear"></div>'

		) )

	);

	comment_form( $args );

?>

		</div>