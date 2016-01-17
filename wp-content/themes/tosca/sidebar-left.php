		<aside id="sidebar" class="col grid3 left-side" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

			<?php

				$active_sidebar = 'default-sidebar';

				if ( class_exists('WooCommerce') && is_woocommerce() ) {

					$active_sidebar = 'woo-sidebar';

				}

				if ( is_active_sidebar($active_sidebar) ) {

					dynamic_sidebar($active_sidebar);

				}

			?>



		</aside>