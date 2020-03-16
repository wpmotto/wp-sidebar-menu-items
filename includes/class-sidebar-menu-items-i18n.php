<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      0.1.2
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.2
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/includes
 * @author     Your Name <email@example.com>
 */
class Sidebar_Menu_Items_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.2
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sidebar-menu-items',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
