<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      0.1.5
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    sidebar_menu_items
 * @subpackage sidebar_menu_items/public
 * @author     Your Name <email@example.com>
 */
class Sidebar_Menu_Items_Public
{
    /**
     * The ID of this plugin.
     *
     * @since    0.1.2
     * @access   private
     * @var      string    $sidebar_menu_items    The ID of this plugin.
     */
    private $sidebar_menu_items;

    /**
     * The version of this plugin.
     *
     * @since    0.1.2
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    0.1.2
     * @param      string    $sidebar_menu_items       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($sidebar_menu_items, $version)
    {
        $this->sidebar_menu_items = $sidebar_menu_items;
        $this->version = $version;
    }

    /**
     * Unwraps the anchor menu item and replaces with
     * a new HTML container.
     *
     * @since    0.1.5
     * @param      string    $item_output   Menu item HTML
     * @param      string    $item          Menu item object
     * @param      string    $depth
     * @param      string    $args
     */
    public function replace_anchor($item_output, $item, $depth, $args)
    {
        if($this->is_sidebar_menu_object($item)) {
            $class = "{$this->sidebar_menu_items}-{$item->post_name}";
            $charset = defined(DB_CHARSET) ? DB_CHARSET : 'utf-8';
            $item_output = mb_convert_encoding($item_output, 'HTML-ENTITIES', $charset);
            $doc = new DOMDocument;
            @$doc->loadHTML("<html><body>$item_output</body>");
            $sidebar = $doc->createElement('div');
            $sidebar->setAttribute('class', $class);
            $container = $doc->getElementsByTagName('a')->item(0);
            while($container->childNodes->length > 0)
                $sidebar->appendChild($container->childNodes->item(0));
            $item_output = $doc->saveHTML($sidebar);
        }
        return $item_output;
    }

    public function add_sidebar($title, $item, $args, $depth)
    {
        if($this->is_sidebar_menu_object($item)) {
            ob_start();
            dynamic_sidebar($this->get_sidebar_id($item));
            $title = ob_get_clean();
        }

        return $title;
    }

    private function is_sidebar_menu_object($item)
    {
        return $this->sidebar_menu_items === $item->type;
    }

    private function get_sidebar_id( $item )
    {   
        return $item->object;
    }
}
