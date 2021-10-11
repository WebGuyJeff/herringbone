<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Custom Menu_Walker Class.
 * 
 * This class build a custom nav menu html structure and CSS classes as an
 * extension of the built-in WordPress Walker_Nav_Menu class. 
 * 
 * The methods in this walker are used somewhat differently to the built-in WP
 * walker as summarised below:
 * 
 * Walker::display_element - Fires the methods below to generate the menu tree html.
 * 
 * Walker_Nav_Menu::start_lvl - Open tags for a dropdown component and new menu branch.
 * Walker_Nav_Menu::start_el - Build a complete anchor menu item using $item vars.
 * Walker_Nav_Menu::end_el - Open tags for a new dropdown_contents div for child menu items.
 * Walker_Nav_Menu::end_lvl - Close tags for a dropdown component and menu branch.
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

//WordPress Dependencies
use Walker_Nav_Menu;
use function is_search;
use function esc_attr;
use function has_nav_menu;
use function wp_nav_menu;


class Menu_Walker extends Walker_Nav_Menu {


    /**
     * Used to pass item between methods without modifying args.
     * 
     * @var object: The menu item object
     */
    private $item;


    /**
     * Holds the markup indentation offset integer.
     * 
     * Think of this as a global indenting value which indents the entire html
     * output by this many \t indents. It is set as parameter 'html_tab_indents'
     * when calling output_theme_location from within template files, because
     * it just makes sense to be able to set your desired indentation at this
     * point.
     * 
     * @var int: number between 0-9
     */
    private $t_offset;


    /**
     * Keeps track of markup nesting.
     * 
     * This is nesting at a per-function level which indents by one more \t each
     * time a parent <elem> is opened ready to add children, and removes one indent
     * before closing it for properly indented markup.
     * 
     * @var int: Holds a value by which to offset the markup indentation.
     */
    private $t_nest_step = 0;


    /**
     * Update the markup indent size variable.
     * 
     * Allows for inline adjustment of indent size. It is called from within string
     * concatenation for easy config/readability. This indent control is used to set
     * indentation changes on a per-line basis. It allows easy building of hmtl when
     * there are multiple elements in a function with various indent requirements.
     * 
     * Example indent(with 1 extra indent): $output .= "{$this->i(1)}<p>stuff"
     * 
     * @param string: $indent Holds indent output string.
     * @param int:    $adjust The integer by which to adjust.
     */
    private function i( $adjust = 0 ) {
        $indent = str_repeat( $this->t, $this->t_offset + $this->t_nest_step + $adjust );
        return $indent;
    }


    /**
     * __construct
     *
     * Init the class variables.
     * 
     * @param bool:   $is_search     is page a search page?
     * @param int:    $t_offset      contstant offset to account for indent level in surrounding markup.
     * @param int:    $t_nest_step   variable offset which accounts for nesting elements up and down.
     * @param string: $t             indent string.
     * @param string: $n             newline string.
     * 
     */
    public function __construct() {
        $this->is_search   = is_search();
        $this->t           = "\t";
        $this->n           = "\n";
        $this->first_call  = true;
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
     * @param bool: $item->hb__is_parent
     * @param bool: $item->hb__has_active
     * @param bool: $item->hb__is_active
     */
    public function display_element( $item, &$children_elements, $max_depth, $depth, $args, &$output ) {

        // Grab 'html_tab_indents' passed by output_theme_location
        if ( $this->first_call ) {
            $this->first_call = false;
            $this->t_offset  = $args[0]->html_tab_indents;
        }

        //
        // Prepare some per-element constants to help identify parent <=> child.
        //

        $id = $item->ID;

        // If element ID is a parent key in array of children...
        if ( array_key_exists( $id, $children_elements ) ) {
            // ...it's a parent.
            $item->hb__is_parent = true;
            // Keep (unreliable) WP var correct because we're nice.
            $this->has_children = $item->hb__is_parent;

            // For all children of element...
            foreach ( $children_elements[ $id ] as $child ) {
                // ...if one is current...
                if ( $child->current ) {
                    // ...this parent has an active child.
                    $item->hb__has_active = true;
                }
            }
        }

        if ($item->current && !$this->is_search) {
            // element is active and not on a search page
            $item->hb__is_active = true;
        } else {
            // explicit boolean
            $item->hb__is_active = false;
        }

        //
        // Fire the html output methods.
        //

        // If item has children and args allow further depth.
        if ( ( 0 == $max_depth || $max_depth > $depth + 1 ) && $item->hb__is_parent ) {

            // Open a new menu dropdown component.
            $this->start_lvl( $output, $depth, $args );

            // Output this parent item adjacent to dropdown toggle button.
            $this->t_nest_step = $this->t_nest_step + 1;
            $this->start_el( $output, $item, $depth, ...array_values( $args ) );

            // Output dropdown contents element with toggle button.
            $this->item = $item; //store item vars class-wide
            $this->end_el( $output, $item, $depth, ...array_values( $args ) );

            // For each child of this item.
            $this->t_nest_step = $this->t_nest_step + 1;
            foreach ( $children_elements[ $id ] as $child ) {

                // Call this method again to process it's output before continuing.
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );

                // Remove processed element from children_elements.
                unset( $children_elements[ $id ] );
            }

            // Close populated dropdown component.
            $this->t_nest_step = $this->t_nest_step - 2;
            $this->end_lvl( $output, $depth, ...array_values( $args ) );

        // Otherwise, item has no children.
        } else {

            // Output the menu item <a>
            $this->start_el( $output, $item, $depth, ...array_values( $args ) );
        }
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
        $class_string = ( $depth === 0 ) ? 'button button-border' : $class_string;
        $class_string = 'class="' . $class_string . '"';

        // Aria attributes
        $aria_attributes = ' aria-label="' . $item->title . '"';

        // Anchor attributes
        $anchor_attributes  = !empty( $item->url )        ? ' href="' . esc_attr( $item->url ) . '"'          : '';
        $anchor_attributes .= !empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"'  : '';
        $anchor_attributes .= !empty( $item->target )     ? ' target="' . esc_attr( $item->target ) . '"'     : '';
        $anchor_attributes .= !empty( $item->xfn )        ? ' rel="' . esc_attr( $item->xfn ) . '"'           : '';

        // Build markup
        $item_output  = "{$this->n}{$this->i(0)}<a {$class_string} {$anchor_attributes} {$aria_attributes}>";
        $item_output .= "{$this->n}{$this->i(1)}<span>";
        $item_output .= "{$this->n}{$this->i(2)}{$item->title}";
        $item_output .= "{$this->n}{$this->i(1)}</span>";
        $item_output .= "{$this->n}{$this->i(0)}</a>";

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
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
    public function start_lvl( &$output, $depth = 0, $args = null ) {

        // Dropdown Class
        if ( $depth === 0 ) {
            $dropdown_class = 'dropdown';
        } else {
            $dropdown_class = 'dropdown dropdown-inMenu';
        }

        $output .= "{$this->n}{$this->i(0)}<div class=\"{$dropdown_class}\">";
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

        $item         = $this->item;
        $icon         = file_get_contents( get_theme_file_path( "imagery/icons_nav/button-dropdown.svg" ) );

        // Passed from display_element:
        $is_parent  = $item->hb__is_parent;
        $title      = $item->title;
        $id         = $item->ID;
        $location   = $args->theme_location;

        // Button Classes
        $button_classes = ( $depth === 0 ) ? 'dropdown_toggle button button-border' : 'dropdown_toggle';
        $button_classes = 'class="' . $button_classes . '"';

        // Button aria attributes
        $aria_attributes = ( $is_parent ) ? 'aria-pressed="false" aria-expanded="false" aria-haspopup="menu"' : '';

        $output .= "{$this->n}{$this->i(0)}<button {$button_classes} id=\"{$location}{$id}\" {$aria_attributes}>";
        $output .= "{$this->n}{$this->i(1)}<span class=\"dropdown_toggleIcon\">{$icon}</span>";
        $output .= "{$this->n}{$this->i(1)}<span class=\"screenReaderText\">{$title}</span>";
        $output .= "{$this->n}{$this->i(0)}</button>";
        $output .= "{$this->n}{$this->i(0)}<div class=\"dropdown_contents\">";
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

        $output .= "{$this->n}{$this->i(1)}</div>"; //dropdown contents
        $output .= "{$this->n}{$this->i(0)}</div>"; //dropdown
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

        // Populate vars with any passed args
        $wrap       = !empty( $container )               ? esc_attr( $container )                                    : '';
        $wrap_class = !empty( $container_class )         ? 'class="' . esc_attr( $container_class ) . '"'            : '';
        $wrap_id    = !empty( $container_id )            ? 'id="' . esc_attr( $container_id ) . '"'                  : '';
        $aria       = !empty( $container_aria_label )    ? 'aria-label="' . esc_attr( $container_aria_label ) . '"'  : '';
        $menu_class = !empty( $menu_class )              ? 'class="' . esc_attr( $menu_class ) . '"'                 : '';
        $menu_id    = !empty( $menu_id )                 ? 'id="' . esc_attr( $menu_id ) . '"'                       : '';
        
        // Build fallback markup
        $output = sprintf( $link );
        if ( ! empty ( $wrap ) ) {
            $aria = ( $wrap == 'nav' ) ? $aria : '';
            $output  = "<$wrap $wrap_class $wrap_id $aria><div $menu_class $menu_id>$output</div></$wrap>";
        } else {
            $output  = "<div $menu_class $menu_id>$output</div>";
        }

        if ( $echo ) {
            echo $output;
        } else {
            return $output;
        }
    }


    /**
     * output_theme_location
     * 
     * A wrapper for wp_nav_menu to simplify args template-side and
     * force use of limited arg options. The html structure is BEM so the
     * menu_class is passed to wp_nav_menu as both menu and container class
     * so the component has a consistent 'Block' class prefix.
     * 
     * Example call:
     * 
     * Menu_Walker::output_theme_location( array(
     *     'theme_location'	=> 'landing-page-secondary-menu',
     *     'menu_class'		=> 'footerNav',
     *     'nav_or_div'		=> 'div',
     *     'nav_aria_label'    => '',
     * ) );
     * 
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public static function output_theme_location( array $hb__args ) {

        //Test if args are valid
        $pass = true;
        $test_args = [ 'nav_or_div', 'menu_class', 'nav_aria_label', 'theme_location', 'html_tab_indents' ];

        if ( !isset( $hb__args[ 'theme_location' ] ) ) {
            $pass = false;
        }

        if ( $pass && count ( $hb__args ) > 5 ) {
            $pass = false;
        } else {

            foreach ( $hb__args as $key => $value ) {

                if ( in_array( $key, $test_args ) ) {
                    $passed_args[ $key ] = $value;

                } else {
                    $pass = false;
                }
            }
        }

        if ( $pass && isset( $passed_args[ 'html_tab_indents' ] ) ) {

            if ( !is_int( $passed_args[ 'html_tab_indents' ] )
                || strlen( $passed_args[ 'html_tab_indents' ] ) > 1 
                || strlen( $passed_args[ 'html_tab_indents' ] ) == 0
                || $passed_args[ 'html_tab_indents' ] > 9
                || $passed_args[ 'html_tab_indents' ] < 0 ) {
            
                echo "<pre>";
                echo "\n# Menu_Walker ERROR 🤕";
                echo "\n# 'html_tab_indents' must be an integer from 0-9";
                echo "\n#";
                echo "\n# Please correct the method call at this point in your template file";
                echo "</pre>";

                return;
            }
        }

        if ( !$pass ) {

            echo "<pre>";
            echo "\n# Menu_Walker ERROR 🤕";
            echo "\n# output_theme_location accepts up to 5 arguments with 'theme_location'";
            echo "\n# being the only required parameter. Example:";
            echo "\n#";
            echo "\n# Menu_Walker::output_theme_location( array(";
            echo "\n#     'theme_location'   => 'main-menu',";
            echo "\n#     'menu_class'       => 'mainMenu',";
            echo "\n#     'nav_or_div'       => 'nav',";
            echo "\n#     'nav_aria_label'   => 'Menu',";
            echo "\n#     'html_tab_indents' => 3,";
            echo "\n# ) );";
            echo "\n#";
            echo "\n# Please correct the method call at this point in your template file";
            echo "</pre>";

            return;
        }

        $defaults = array(
            'theme_location'       => '',
            'menu_class'           => 'menu',
            'container'            => 'div',
            'container_class'      => '',
            'container_aria_label' => 'Menu',
            'items_wrap'           => '%3$s',
            'echo'                 => true,
            'depth'                => 0,
            'fallback_cb'          => [ new Menu_Walker(), 'fallback' ],
            'walker'               => new Menu_Walker(),
            'html_tab_indents'     => 3,
            'nav_or_div'           => 'div',
            'nav_aria_label'       => 'Menu',
        );

        // Merge passed args with defaults array
        $args = array_merge( $defaults, $passed_args );

        // WordPress-ify the args
        $args[ 'container_class' ]      = $args[ 'menu_class' ];
        $args[ 'container' ]            = $args[ 'nav_or_div' ];
        $args[ 'container_aria_label' ] = $args[ 'nav_aria_label' ];

        // If menu is registered at location, pass to wp_nav_menu.
        if ( has_nav_menu( $args[ 'theme_location' ] ) ) {
            wp_nav_menu( $args );

        // Otherwise, use fallback method.
        } else {
            Menu_Walker::fallback( $args );
        }
    }


}//class end
