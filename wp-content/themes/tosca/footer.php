<?php

/**

 * The template for displaying the footer

 *

 */



global $theme_options;



if ( ! empty($theme_options['footer_text']) && ! is_page_template('template-under-construction.php')) : ?>

<footer id="footer">

	<div class="container">

		<?php do_action('tosca_footer_widgets'); ?>

		<?php

			if ( function_exists('icl_translate') ) {

				$theme_options['footer_text'] = icl_translate('Theme Mod', 'footer_text', get_theme_mod('footer_text'));

			}

			echo wp_kses_post(do_shortcode($theme_options['footer_text']));

		?>

	</div>

</footer>

<?php endif; ?>



<?php if ( ! empty($theme_options['scroll_to_top']) ) : ?>

<a href="#header" id="go-to-top-link" title="<?php esc_html_e('Scroll to the top', 'tosca'); ?>"><em class="icon-arrow-up"></em></a>

<?php endif; ?>



<?php if (isset($theme_options['page_border']) && ! empty($theme_options['page_border'])) : ?>

<div class="borders" id="border-top"></div><div class="borders" id="border-right"></div><div class="borders" id="border-bottom"></div><div class="borders" id="border-left"></div>

<?php endif; ?>



<?php wp_footer(); ?>

</body>

</html>