<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://motto.ca
 * @since      0.1.0
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/admin
 */
class Sidebar_Menu_Items_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sidebar_menu_items    The ID of this plugin.
	 */
	private $sidebar_menu_items;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $menu_title;
	private $menu_slug;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $sidebar_menu_items       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $sidebar_menu_items, $version ) {

		$this->sidebar_menu_items = $sidebar_menu_items;
		$this->version = $version;
		$this->menu_title = __('Sidebars', $this->sidebar_menu_items);
		$this->menu_slug = $this->sidebar_menu_items;
	}

	public function register_menu_metabox() {	
		add_meta_box( 
			$this->menu_slug, 
			$this->menu_title, 
			array($this, 'render_menu_metabox'), 
			'nav-menus', 'side', 'default' 
		);
	}

	/**
	 * TODO: Select all not working.
	 */
	public function render_menu_metabox( $object, $args ) {
		global $nav_menu_selected_id;
		$sidebars = $this->get_sidebars();
		$walker = new Walker_Nav_Menu_Checklist( $db_fields = false );
	
		$removed_args = array(
			'action',
			'customlink-tab',
			'edit-menu-item',
			'menu-item',
			'page-tab',
			'_wpnonce',
		); 
		?>
		<div id="<?php echo $this->menu_slug ?>-div">
			<div id="tabs-panel-<?php echo $this->menu_slug ?>-all" class="tabs-panel tabs-panel-active">
				<ul id="<?php echo $this->menu_slug ?>-checklist-pop" class="categorychecklist form-no-clear" >
					<?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item',  $sidebars ), 0, (object) array( 'walker' => $walker ) ); ?>
				</ul>

				<p class="button-controls">
					<span class="list-controls">
						<a href="<?php
							echo esc_url(add_query_arg(
								array(
									$this->menu_slug . '-all' => 'all',
									'selectall' => 1,
								),
								remove_query_arg( $removed_args )
							));
						?>#<?php echo $this->menu_slug ?>" class="select-all"><?php _e( 'Select All' ); ?></a>
					</span>
					<span class="add-to-menu">
						<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="add-<?php echo $this->menu_slug ?>-menu-item" id="submit-<?php echo $this->menu_slug ?>-div" />
						<span class="spinner"></span>
					</span>
				</p>
			</div>
		</div>
		<?php
	}	

	private function get_sidebars() {
		global $wp_registered_sidebars;
		$sidebars = array();
		$i = 1;
		foreach( $wp_registered_sidebars as $sidebar ) {						
			$sidebars[] = (object) array(
				'ID' => $i,
				'db_id' => 0,
				'menu_item_parent' => 0,
				'object_id' => 1,
				'post_parent' => 0,
				'type' => $this->menu_slug,
				'object' => $sidebar['id'],
				'type_label' => $this->menu_title,
				'title' => $sidebar['name'],
				'url' => $sidebar['id'],
				'target' => '',
				'attr_title' => '',
				'description' => $sidebar['description'],
				'classes' => array(),
				'xfn' => '',
			);
			$i++;
		}

		return $sidebars;
	}
}
