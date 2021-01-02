<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://motto.ca
 * @since             0.1.3
 * @package           sidebar_menu_items
 *
 * @wordpress-plugin
 * Plugin Name:       Sidebar Menu Items
 * Plugin URI:        http://github.com/mottodesignstudio/wp-sidebar-menu-items
 * Description:       Use sidebar areas within your menus.
 * Version:           0.1.3
 * Author:            Motto
 * Author URI:        https://motto.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sidebar-menu-items
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.1.2 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIDEBAR_MENU_ITEMS_VERSION', '0.1.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sidebar-menu-items-activator.php
 */
function activate_sidebar_menu_items() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sidebar-menu-items-activator.php';
	Sidebar_Menu_Items_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sidebar-menu-items-deactivator.php
 */
function deactivate_sidebar_menu_items() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sidebar-menu-items-deactivator.php';
	Sidebar_Menu_Items_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sidebar_menu_items' );
register_deactivation_hook( __FILE__, 'deactivate_sidebar_menu_items' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sidebar-menu-items.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.2
 */
function run_sidebar_menu_items() {

	$plugin = new Sidebar_Menu_Items();
	$plugin->run();

}
run_sidebar_menu_items();
