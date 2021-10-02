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
     * Is current post a custom post type?
     *
     * @var bool
     */
    protected $is_custom_post;

    /**
     * Archive page for current URL.
     *
     * @var string
     */
    protected $archive;



    /**
     * __construct
     *
     * Init the class variables.
     */
    public function __construct() {
        $custom_post_type       = get_post_type();
        $this->is_custom_post   = in_array( $custom_post_type, get_post_types( array( '_builtin' => false ) ) );
        $this->archive_url      = get_post_type_archive_link( $custom_post_type );
        $this->is_search        = is_search();

        // Define menu item names
        $this->item_css_class_suffixes = array(
            'list' => '_list',
            'item' => '_item',
            'link' => '_link',
            'parent_item' => '_item-parent',
            'active_item' => '_item-current',
            'parent_of_active_item' => '_item-parent-current',
            'ancestor_of_active_item' => '_item-ancestor-current',
            'sub_menu' => '_dropdown',
            'sub_menu_toggle' => 'dropdown_toggle',
        );
    }



    /**
     * display_element
     * 
     * Check if menu elements are sub-items or match the active url and apply classes accordingly.
     * Then pass all args back up to parent class.
     */
    public function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {

        $element->is_subitem = ( ( !empty($children_elements[$element->ID] )
                                    && ( ( $depth + 1 ) < $max_depth
                                    || ( $max_depth === 0 ) ) ) );

        if ( $element->is_subitem ) {
            foreach ( $children_elements[$element->ID] as $child ) {
                if ( $child->current_item_parent || $this->compare_base_url( $this->archive_url, $child->url ) ) {
                    $element->classes[] = 'active';
                }
            }
        }

        $element->is_active = ( !empty( $element->url ) && strpos( $this->archive_url, $element->url ) );

        if ($element->is_active && !$this->is_search) {
            $element->classes[] = 'active';
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }



    /**
     * start_lvl
     * 
     * Start building the menu options parent element.
     * 
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {

        $t      = "\t";
        $n      = "\n";
        $depth  = $depth + 1;
        $indent = str_repeat( $t, $depth );
        $prefix = $args->menu_class;
        $suffix = $this->item_css_class_suffixes;
        $class  = $prefix . $suffix[ 'sub_menu' ];
        $icon   = file_get_contents( get_theme_file_path( "imagery/icons_nav/button-dropdown.svg" ) );

        $output  = $n . $indent . '<div class="dropdown">';
        $output .= $n . $indent . '<button class="dropdown_toggle">Open' . $icon . '</button>';
        $output .= $n . $indent . '<div class="dropdown_contents">' . $n;
    }



    /**
     * start_el
     * 
     * Start processing and building the menu option elements.
     * Add main/sub classes to li's and links.
     * 
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

        $GLOBALS[ 'wp_the_query' ];

        $indent = ( $depth > 0 ? str_repeat("    ", $depth ) : '' ); // code indent
        $prefix = $args->menu_class;
        $suffix = $this->item_css_class_suffixes;

        if( !empty( $item->classes )
            && is_array( $item->classes )
            && in_array( 'menu-item-has-children', $item->classes ) ){

            // This guy has children
            $args->has_children = true;
        } else {
            $args->has_children = false;
        }

        // Item classes
        $item_classes = array(
            'item_class' => $depth == 0 ? $prefix . $suffix[ 'item' ] : '',
            'parent_class' => $args->has_children ? $parent_class = $prefix . $suffix[ 'parent_item' ] : '',
            'active_page_class' => in_array("current-menu-item", $item->classes) ? $prefix . $suffix[ 'active_item' ] : '',
            'active_parent_class' => in_array("current-menu-parent", $item->classes) ? $prefix . $suffix[ 'parent_of_active_item' ] : '',
            'active_ancestor_class' => in_array("current-menu-ancestor", $item->classes) ? $prefix . $suffix['ancestor_of_active_item'] : '',
            'depth_class' => $depth >= 1 ? $prefix . $suffix[ 'sub_menu_item' ] . ' ' . $prefix . $suffix[ 'sub_menu_item' ] . '-' . $depth : '',
            'user_class' => $item->classes[0] !== '' ? $prefix . '_item--' . $item->classes[0] : ''
        );

        // convert array to string excluding any empty values
        $class_string = implode("  ", array_filter($item_classes));

        // Item aria attributes
        $aria_attributes = 'aria-label="' . apply_filters('the_title', $item->title, $item->ID) . '"';

        if ( $args->has_children ) {
            $aria_attributes .= ' aria-pressed="false" aria-expanded="false" aria-haspopup="menu"';
        }

        // Add the classes to the wrapping <li>
        $output .= $indent . '<li class="' . $class_string . '" ' . $aria_attributes . '>';

        // Link classes
        $link_classes = array(
            'item_link' => $depth == 0 ? $prefix . $suffix['link'] : '',
            'depth_class' => $depth >= 1 ? $prefix . $suffix['sub_link'] . '  ' . $prefix . $suffix['sub_link'] . '--' . $depth : '',
        );

        $link_class_string = implode("  ", array_filter($link_classes));
        $link_class_output = 'class="' . $link_class_string . '"';

        // link attributes
        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        // Create link markup
        $item_output = '<a' . $attributes . ' ' . $link_class_output . '>';
        $item_output .= apply_filters('the_title', $item->title, $item->ID);
        $item_output .= '</a>';

        // Filter <li>

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }



    /**
     * Ends the menu option element output, if needed.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Page data object. Not used.
     * @param int      $depth  Depth of page. Not Used.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        
        $n       = "\n";

        $output .= "</li>{$n}";
    }



    /**
     * Ends the list of after the elements are added.
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {

        $t       = "\t";
        $n       = "\n";
        $indent  = str_repeat( $t, $depth );

        $output .= "$indent</div></div>{$n}";
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

        $element    = !empty( $container )               ? esc_attr( $container )                                    : '';
        $wrap_class = !empty( $container_class )         ? 'class="' . esc_attr( $container_class ) . '"'            : '';
        $wrap_id    = !empty( $container_id )            ? 'id="' . esc_attr( $container_id ) . '"'                  : '';
        $aria       = !empty( $container_aria_label )    ? 'aria-label="' . esc_attr( $container_aria_label ) . '"'  : '';
        $menu_class = !empty( $menu_class )              ? 'class="' . esc_attr( $menu_class ) . '"'                 : '';
        $menu_id    = !empty( $menu_id )                 ? 'id="' . esc_attr( $menu_id ) . '"'                       : '';
        
        $output = sprintf( $link );
        if ( ! empty ( $element ) ) {
            $output  = "<$element $wrap_class $wrap_id $aria><ul $menu_class $menu_id>$output</ul></$element>";
        }

        if ( $echo ) {
            echo $output;
        } else {
            return $output;
        }
    }



    /**
     * compare_base_url
     * 
     * This method tests 2 urls to see if they match and returns a boolean result.
     */
    public function compare_base_url($base_url, $input_url, $strict_scheme = true) {
        $base_url = trailingslashit($base_url);
        $input_url = trailingslashit($input_url);
    
        if ($base_url === $input_url) {
            return true;
        }
    
        $input_url = parse_url($input_url);
    
        if (!isset($input_url['host'])) {
            return true;
        }
    
        $base_url = parse_url($base_url);
    
        if (!isset($base_url['host'])) {
            return false;
        }
    
        if (!$strict_scheme || !isset($input_url['scheme']) || !isset($base_url['scheme'])) {
            $input_url['scheme'] = $base_url['scheme'] = 'https';
        }
    
        if (($base_url['scheme'] !== $input_url['scheme'])) {
            return false;
        }
    
        if ($base_url['host'] !== $input_url['host']) {
            return false;
        }
    
        if ((isset($base_url['port']) || isset($input_url['port']))) {
            return isset($base_url['port'], $input_url['port']) && $base_url['port'] === $input_url['port'];
        }
    
        return true;
    }



}//class end




    /**
     * cssClasses
     * 
     * Cleanup the core classes.
     *//*
    public function cssClasses( $classes, $item ) {
        $slug = sanitize_title( $item->title );

        // Fix core 'active' behavior for custom post types
        if ( $this->is_custom_post ) {
            $classes = str_replace('current_page_parent', '', $classes);

            if ( $this->archive_url && !$this->is_search ) {
                if ( $this->compare_base_url( $this->archive_url, $item->url ) ) {
                    $classes[] = 'active';
                }
            }
        }

        // Replace 'current-xxx' with 'active'
        $classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );

        // Remove menu/page prefixes
        $classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );

        // Add 'menu_item' class
        $classes[] = 'menu_item';

        // Add 'menu_dropdown' if the item has sub-items
        if ($item->is_subitem) {
            $classes[] = 'menu_dropdown';
        }

        $classes = array_unique( $classes );
        $classes = array_map( 'trim', $classes );

        return array_filter( $classes );
    }
*/


    /**
     * walk
     * 
     * The walk method builds the html output.
     *//*
    public function walk($elements, $max_depth, ...$args) {
        // Add filters
        add_filter('nav_menu_css_class', array($this, 'cssClasses'), 10, 2);
        add_filter('nav_menu_item_id', '__return_null');

        // Perform usual walk
        $output = call_user_func_array(['parent', 'walk'], func_get_args());

        // Unregister filters
        remove_filter('nav_menu_css_class', [$this, 'cssClasses']);
        remove_filter('nav_menu_item_id', '__return_null');

        // Return result
        return $output;
    }
*/