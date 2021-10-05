<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Custom Menu_Walker Class.
 * 
 * This class build a custom nav menu html structure and CSS classes as an
 * extension of the built-in WordPress Walker_Nav_Menu class bearing these
 * methods:
 * 
 * Walker::display_element - Fires the methods below based on menu tree array.
 * 
 * Walker_Nav_Menu::start_lvl - Open tags for a new dropdown component for a menu branch.
 * Walker_Nav_Menu::start_el - Build a complete anchor elem using $item vars.
 * Walker_Nav_Menu::end_el - Open tags for a new dropdown_contents div for child menu items.
 * Walker_Nav_Menu::end_lvl - Close tags for a dropdown component and menu branch.
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

//WordPress Dependencies
use Walker_Nav_Menu;
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
     * __construct
     *
     * Init the class variables.
     */
    public function __construct() {
        $this->is_search = is_search();
        $this->t_offset  = 2;
        $this->t         = "\t";
        $this->n         = "\n";
    }


    /**
     * display_element
     * 
     * This method controls when and if the element output methods are fired. This is where
     * logic is set to determine the order and association of parent > child html
     * menu branches. It is the 'composer' to the Walker_Nav_Menu 'orchestra'.
     * 
     * default wp display_element uses this order: start_el, start_lvl, end_lvl, end_el.
     * 
     * @var bool: $item->hb__is_parent
     * @var bool: $item->hb__has_active
     * @var bool: $item->hb__is_active
     */
    public function display_element( $item, &$children_elements, $max_depth, $depth, $args, &$output ) {

        $id = $item->ID;

        // If the element ID is a parent key in the array of children...
        if ( array_key_exists( $id, $children_elements ) ) {
            // ...it's a parent.
            $item->hb__is_parent = true;
            // Keep (unreliable) WP var correct because we're nice.
            $this->has_children = $item->hb__is_parent;

            // For all the children of this element...
            foreach ( $children_elements[ $id ] as $child ) {
                // ...if one is current...
                if ( $child->current ) {
                    // ...this parent has an active child.
                    $item->hb__has_active = true;
                }
            }
        }

        if ($item->current && !$this->is_search) {
            // this element is active and not on a search page
            $item->hb__is_active = true;
        } else {
            // explicit boolean
            $item->hb__is_active = false;
        }

        //
        // Now fire the html output methods.
        //

        // If the args allow for further depth...
        if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) 
            //...and the menu item has children...
            && $item->hb__is_parent ) {
            
            //...set newlevel true.
            if ( ! isset( $newlevel ) ) {
                $newlevel = true;
                // ...start building a menu dropdown.
                $this->start_lvl( $output, $depth, $args, $item );
            }

            // Output this parent menu item <a>
            $this->start_el( $output, $item, $depth, ...array_values( $args ) );

            // Output the dropdown toggle and open the contents element
            $this->end_el( $output, $item, $depth, ...array_values( $args ) );


            // For each child of this element...
            foreach ( $children_elements[ $id ] as $child ) {

                // Call this method again (self-calling) for the child item element.
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );

            }

            // The dropdown for this branch is populated, so remove the element from children_elements.
            unset( $children_elements[ $id ] );


            // If newlevel is true...
            if ( isset( $newlevel ) && $newlevel ) {
                // ...close the current dropdown element.
                $this->end_lvl( $output, $depth, ...array_values( $args ) );
            }
        } else {
            // Output the parent menu item <a>
            $this->start_el( $output, $item, $depth, ...array_values( $args ) );
        }
    }


    /**
     * start_lvl
     * 
     * Start building a new dropdown for a menu branch.
     * 
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = null, $item ) {

        $t            = $this->t;
        $n            = $this->n;
        $indent       = str_repeat( $t, $this->t_offset + $depth );
        $indent_plus1 = $indent . $t;
        $indent_plus2 = $indent . $indent . $t;
        $icon         = file_get_contents( get_theme_file_path( "imagery/icons_nav/button-dropdown.svg" ) );

        // Passed from display_element:
        $is_parent  = $item->hb__is_parent;

        // Item aria attributes
        $aria_attributes = ( $is_parent ) ? 'aria-pressed="false" aria-expanded="false" aria-haspopup="menu"' : '';

        $output .= "{$n}{$indent}<div class=\"dropdown\">";
        $output .= "{$n}{$indent_plus1}<button class=\"dropdown_toggle\" {$aria_attributes}>";
        $output .= "{$n}{$indent_plus2}Open";
        $output .= "{$n}{$indent_plus2}{$icon}";
        $output .= "{$n}{$indent_plus1}</button>";
    }


    /**
     * start_el
     * 
     * Build an anchor element using $item vars and append to output.
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
        $indent         = str_repeat( $t, $this->t_offset + $depth );
        $indent_plus1   = $indent . $t;
        $indent_plus2   = $indent . $indent . $t;
        $css_block      = $args->menu_class;
        $css_element    = '_item';
        $css_modifier   = array(
            'parent'        => '-parent',
            'active'        => '-active',
            'has_active'    => '-parent-hasActive',
        );

        // Passed from display_element:
        $is_parent  = $item->hb__is_parent;
        $is_active  = $item->hb__is_active;
        $has_active = $item->hb__has_active;

        // Classes
        $class_string = $css_block . $css_element;
        $class_string = ( $is_parent )  ? $class_string . ' ' . $css_block . $css_element . $css_modifier[ 'parent' ]      : $class_string;
        $class_string = ( $is_active )  ? $class_string . ' ' . $css_block . $css_element . $css_modifier[ 'active' ]      : $class_string;
        $class_string = ( $has_active ) ? $class_string . ' ' . $css_block . $css_element . $css_modifier[ 'has_active' ]  : $class_string;
        $class_string = 'class="' . $class_string . '"';

        // Aria attributes
        $aria_attributes = ' aria-label="' . $item->title . '"';

        // Anchor attributes
        $anchor_attributes  = !empty( $item->url )        ? ' href="' . esc_attr( $item->url ) . '"'          : '';
        $anchor_attributes .= !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"'  : '';
        $anchor_attributes .= !empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"'     : '';
        $anchor_attributes .= !empty( $item->xfn )        ? ' rel="' . esc_attr( $item->xfn ) . '"'           : '';

        // Build markup
        $item_output  = "{$n}{$indent_plus1}<a {$class_string} {$anchor_attributes} {$aria_attributes}>";
        $item_output .= "{$n}{$indent_plus2}{$item->title}";
        $item_output .= "{$n}{$indent_plus1}</a>";

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }


    /**
     * end_el
     * 
     * Open a new dropdown_contents div ready for child menu items.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Page data object. Not used.
     * @param int      $depth  Depth of page. Not Used.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) { 
        $t            = $this->t;
        $n            = $this->n;
        $indent       = str_repeat( $t, $this->t_offset + $depth );
        $indent_plus1 = $indent . $t;
        $indent_plus2 = $indent . $indent . $t;

        $output .= "{$n}{$indent_plus1}<div class=\"dropdown_contents\">";
    }


    /**
     * end_lvl
     * 
     * Close a dropdown component and menu branch.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {

        $t            = $this->t;
        $n            = $this->n;
        $indent       = str_repeat( $t, $this->t_offset + $depth );
        $indent_plus1 = $indent . $t;
        $indent_plus2 = $indent . $indent . $t;

        $output .= "{$n}{$indent_plus1}</div>"; //dropdown contents
        $output .= "{$n}{$indent}</div>";          //dropdown
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
