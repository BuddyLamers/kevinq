<form class="searchform" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_html_e('Type and hit Enter&hellip;', 'tosca'); ?>">

	<input type="submit" value="&#xe602;">

</form>