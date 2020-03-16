<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      0.1.2
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.2
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/includes
 * @author     Your Name <email@example.com>
 */
class Sidebar_Menu_Items {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.2
	 * @access   protected
	 * @var      sidebar_menu_items_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.2
	 * @access   protected
	 * @var      string    $sidebar_menu_items    The string used to uniquely identify this plugin.
	 */
	protected $sidebar_menu_items;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.2
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.2
	 */
	public function __construct() {
		if ( defined( 'SIDEBAR_MENU_ITEMS_VERSION' ) ) {
			$this->version = SIDEBAR_MENU_ITEMS_VERSION;
		} else {
			$this->version = '0.1.2';
		}
		$this->sidebar_menu_items = 'sidebar-menu-items';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - sidebar_menu_items_Loader. Orchestrates the hooks of the plugin.
	 * - sidebar_menu_items_i18n. Defines internationalization functionality.
	 * - sidebar_menu_items_Admin. Defines all hooks for the admin area.
	 * - sidebar_menu_items_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidebar-menu-items-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sidebar-menu-items-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sidebar-menu-items-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sidebar-menu-items-public.php';

		$this->loader = new Sidebar_Menu_Items_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the sidebar_menu_items_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sidebar_Menu_Items_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sidebar_Menu_Items_Admin( 	
			$this->get_sidebar_menu_items(), 
			$this->get_version() 
		);

		$this->loader->add_action( 
			'admin_head-nav-menus.php', $plugin_admin, 'register_menu_metabox'
		);


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Sidebar_Menu_Items_Public( 	
			$this->get_sidebar_menu_items(), 
			$this->get_version() 
		);

		$this->loader->add_filter( 
			'walker_nav_menu_start_el', $plugin_public, 'replace_anchor', 10, 4
		);
		$this->loader->add_filter( 
			'nav_menu_item_title', $plugin_public, 'add_sidebar', 20, 4
		);
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		// $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.2
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.2
	 * @return    string    The name of the plugin.
	 */
	public function get_sidebar_menu_items() {
		return $this->sidebar_menu_items;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.2
	 * @return    sidebar_menu_items_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.2
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
