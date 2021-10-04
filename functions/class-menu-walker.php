<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Custom Menu_Walker Class.
 * 
 * This class build a custom nav menu html structure and CSS classes as an
 * extension of the built-in WordPress Walker_Nav_Menu class bearing these
 * methods:
 * 
 * start_lvl — Starts the list before the elements are added.
 * start_el — Starts the element output.
 * end_el — Ends the element output, if needed.
 * end_lvl — Ends the list after the elements are added.
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

 //WordPress Dependencies
use Walker_Nav_Menu;
use Walker; 
use function get_post_type;
use function get_post_types;
use function get_post_type_archive_link;
use function is_search;
use function sanitize_title;
use function add_filter;
use function remove_filter;
use function esc_attr;


class Menu_Walker extends Walker_Nav_Menu {



    /**
     * Database fields to use.
     *
     * @var array
     *
     * @see Walker::$db_fields
     */
    public $db_fields = array(
        'parent' => 'menu_item_parent',
        'id'     => 'db_id',
    );



    /**
     * __construct
     *
     * Init the class variables.
     */
    public function __construct() {
        $this->is_search        = is_search();

        $this->t = "\t";
        $this->n = "\n";

        $this->css_item_element_classes = array(
            'item' => '_item',
            'parent' => '_parent',
        );

        // Dropdown css classes.
        $this->css_dropdown_block_element_classes = array(
            'dropdown' => 'dropdown',
            'toggle' => '_toggle',
            'list' => '_content',
        );

        $this->css_modifier_classes = array(
            'active' => '-active',
            'has_active' => '-hasActiveChild',
        );

    }



    /**
     * display_element
     * 
     * Check if menu elements are parents, have active children or are active themselves and
     * attach the results to the element object.
     * 
     * @var bool: $element->hb__is_parent
     * @var bool: $element->hb__has_active_child
     * @var bool: $element->hb__active
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

        $id = $element->ID;


        // If the element ID is a parent key in the array of children...
        if ( array_key_exists( $id, $children_elements ) ) {

            // ...it's a parent.
            $element->hb__is_parent = true;
            //Keep WP var correct in case accessed elsewhere
            $this->has_children = $element->hb__is_parent;

            // For all the children of this element...
            foreach ( $children_elements[ $id ] as $child ) {

                // ...if one is current...
                if ( $child->current ) {

                    // ...this parent has an active child.
                    $element->hb__has_active_child = true;
                }
            }
        }

        if ($element->current && !$this->is_search) {
            // this element is active and not on a search page
            $element->hb__active = true;
        } else {
            $element->hb__active = false;
        }

// WP default method wraps the child list in the parent <li> calling class methods
// in this order: start_el, start_lvl, end_lvl, end_el.


    $this->start_el( $output, $element, $depth, ...array_values( $args ) );

        // Descend only when the depth is right and there are children for this element.
        if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) && $element->hb__is_parent ) {
    
            foreach ( $children_elements[ $id ] as $child ) {
    
                if ( ! isset( $newlevel ) ) {
                    $newlevel = true;
                    // Start the child delimiter.
                    $this->start_lvl( $output, $depth, ...array_values( $args ) );
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }
 
        if ( isset( $newlevel ) && $newlevel ) {
            // End the child delimiter.
            $this->end_lvl( $output, $depth, ...array_values( $args ) );
        }

        // End this element.
        $this->end_el( $output, $element, $depth, ...array_values( $args ) );

    }



    /**
     * start_lvl
     * 
     * Start building a new menu branch.
     * 
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {

        $t          = $this->t;
        $n          = $this->n;
        $indent     = str_repeat( $t, $depth );
        $icon       = file_get_contents( get_theme_file_path( "imagery/icons_nav/button-dropdown.svg" ) );

        $output .= "{$n}{$indent}<div class=\"dropdown\">";
        $output .= "{$n}{$indent}<button class=\"dropdown_toggle\">Open{$icon}</button>";
        $output .= "{$n}{$indent}<div class=\"dropdown_contents\">";

    }



    /**
     * start_el
     * 
     * Start processing and building the menu option elements.
     * 
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $t              = $this->t;
        $n              = $this->n;
        $indent         = str_repeat( $t, $depth ); // code indent
        $css_block      = $args->menu_class;
        $css_element    = $this->css_item_element_classes;
        $css_modifier   = $this->css_modifier_classes;

        // Passed from display_element:
        $is_parent  = $item->hb__is_parent;
        $has_active = $item->hb__has_active_child;
        $is_active  = $item->hb__active;

        // Item Classes
        $class_string  = 'class="';
        $class_string .= $css_block . $css_element[ 'item' ];
        $class_string .= ( $is_active )  ? ' ' . $css_block . $css_element[ 'item' ] . $css_modifier[ 'active' ]        : '';
        $class_string .= ( $is_parent )  ? ' ' . $css_block . $css_element[ 'parent' ]                                  : '';
        $class_string .= ( $has_active ) ? ' ' . $css_block . $css_element[ 'parent' ] . $css_modifier[ 'has_active' ]  : '';
        $class_string .= '"';

        // Item aria attributes
        $aria_attributes = ' aria-label="' . $item->title . '"';
        $aria_attributes .= ( $is_parent ) ? ' aria-pressed="false" aria-expanded="false" aria-haspopup="menu"' : '';

        // Item anchor attributes
        $anchor_attributes  = !empty( $item->url )        ? ' href="' . esc_attr( $item->url ) . '"'          : '';
        $anchor_attributes .= !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"'  : '';
        $anchor_attributes .= !empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"'     : '';
        $anchor_attributes .= !empty( $item->xfn )        ? ' rel="' . esc_attr( $item->xfn ) . '"'           : '';

        // Build item markup
        $item_output = "{$n}{$indent}<a {$class_string} {$anchor_attributes} {$aria_attributes}>{$item->title}";

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }



    /**
     * End the menu option element.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Page data object. Not used.
     * @param int      $depth  Depth of page. Not Used.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {

        $t = $this->t;
        $n = $this->n;
        $indent  = str_repeat( $t, $depth );

        $output .= "{$n}</a>";
    }



    /**
     * Ends the menu branch.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {

        $t = $this->t;
        $n = $this->n;
        $indent  = str_repeat( $t, $depth );

        $output .= "{$n}{$indent}</div>"; //dropdown contents
        $output .= "{$n}</div>";        //dropdown
    }



    /**
     * fallback
     * 
     * This method can be set as a callback in wp_nav_menu to display a fallback menu
     * before the user sets a menu in that location.
     * 
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public static function fallback( array $args ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        if ( isset( $args ) ) {
            extract( $args );
        } 

        $link = '<li class="button"><a href="' .admin_url( 'customize.php', 'https' ) . '">Edit Menus</a></li>';

        $wrap       = !empty( $container )               ? esc_attr( $container )                                    : '';
        $wrap_class = !empty( $container_class )         ? 'class="' . esc_attr( $container_class ) . '"'            : '';
        $wrap_id    = !empty( $container_id )            ? 'id="' . esc_attr( $container_id ) . '"'                  : '';
        $aria       = !empty( $container_aria_label )    ? 'aria-label="' . esc_attr( $container_aria_label ) . '"'  : '';
        $menu_class = !empty( $menu_class )              ? 'class="' . esc_attr( $menu_class ) . '"'                 : '';
        $menu_id    = !empty( $menu_id )                 ? 'id="' . esc_attr( $menu_id ) . '"'                       : '';
        
        $output = sprintf( $link );
        if ( ! empty ( $wrap ) ) {
            $aria = ( $wrap == 'nav' ) ? $aria : '';
            $output  = "<$wrap $wrap_class $wrap_id $aria><ul $menu_class $menu_id>$output</ul></$wrap>";
        } else {
            $output  = "<ul $menu_class $menu_id>$output</ul>";
        }

        if ( $echo ) {
            echo $output;
        } else {
            return $output;
        }
    }

    

}//class end
