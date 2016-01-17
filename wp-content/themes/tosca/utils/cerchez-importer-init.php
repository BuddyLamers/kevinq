<?php

/* Provide 1-click import functionality with theme sample data */

class Theme_Demo_Data_Importer extends Cerchez_Theme_Importer {

	public $widget_import_results;

	public function __construct() {
		$this->demo_files_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'demos' . DIRECTORY_SEPARATOR . 'creative' . DIRECTORY_SEPARATOR;
		parent::__construct();
	}

	public function import_other_theme_data() {

		// set main and logo menu locations (no translation needed)
		$main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
		$logo_menu = get_term_by('name', 'Logo Menu', 'nav_menu');
		if ($main_menu && $logo_menu) {
			set_theme_mod('nav_menu_locations', array(
				'main_menu' => $main_menu->term_id,
				'logo_menu' => $logo_menu->term_id,
			));
		}

		// set homepage as a static page
		$pages = get_pages();
		foreach ($pages as $page) {
			if ($page->post_title == 'Home') { // no translation needed
				update_option('show_on_front', 'page');
				update_option('page_on_front', $page->ID);
				break;
			}
		}

	}
}

new Theme_Demo_Data_Importer;