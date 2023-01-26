<?php
/**
 * Herringbone Custom Menu_Walker Class.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

namespace Jefferson\Herringbone;

// WordPress Dependencies.
use Walker_Nav_Menu;
use function is_search;
use function esc_attr;
use function has_nav_menu;
use function wp_nav_menu;

/**
 * Class Menu_Walker.
 *
 * This class builds a custom nav menu html structure and CSS classes as an
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
 */
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
	 * when calling output_theme_location_menu from within template files, because
	 * it just makes sense to be able to set your desired indentation at this
	 * point.
	 *
	 * @var int: number between 0-9
	 */
	private $t_offset;

	/**
	 * Menu Class.
	 *
	 * This string is passed from output_theme_location_menu and holds the single classname that
	 * forms the 'Block' of the BEM class structure. This is the only classname that will be set
	 * on the top container <nav> or <div> element.
	 *
	 * @var string: CSS class(es) string
	 */
	private $menu_class;

	/**
	 * Top-level Item Class.
	 *
	 * [WARNING] This is currently a problem when used in conjunction with menu-more.js which moves
	 * menu items into a 'more' dropdown when they overflow-x. The js has no knowledge of these
	 * classes and therefore items may end up in that dropdown still bearing any top-level classes.
	 *
	 * This string is passed from output_theme_location_menu to provide the ability to set unique
	 * classes on the top level menu items only. This is useful for styling the top level menu items
	 * as a bar or buttons for example.
	 *
	 * @var string: CSS class(es) string
	 */
	private $top_level_classes;

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
	 * Dropdown Toggle Icon.
	 *
	 * This is an SVG icon string which will be used on dropdown toggle buttons.
	 *
	 * @var string: An SVG icon.
	 */
	public static $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224 416c-8.188 0-16.38-3.125-22.62-9.375l-192-192c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L224 338.8l169.4-169.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-192 192C240.4 412.9 232.2 416 224 416z"/></svg>';

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
	 * @param {int} $adjust Number of additional indents to return.
	 * @var   {string} $indent The indent string.
	 */
	private function i( $adjust = 0 ) {
		$indent = str_repeat( $this->t, $this->t_offset + $this->t_nest_step + $adjust );
		return $indent;
	}

	/**
	 * __construct
	 *
	 * Init the class variables.
	 */
	public function __construct() {
		// Globalise the args.
		$this->is_search  = is_search();
		$this->t          = "\t";
		$this->n          = "\n";
		$this->first_call = true;
	}

	/**
	 * Display_element.
	 *
	 * This method controls when and if the element output methods are fired. This is where
	 * logic is set to determine the order and association of parent > child html
	 * menu branches. It is the 'composer' to the Walker_Nav_Menu 'orchestra'.
	 *
	 * default wp display_element uses this order: start_el, start_lvl, end_lvl, end_el.
	 *
	 * @param {object} $item The menu item object.
	 * @param {array}  $children_elements The child elements array (passed by reference).
	 * @param {object} $max_depth The max depth of the menu.
	 * @param {int}    $depth The depth of the menu item.
	 * @param {array}  $args The menu arguments array.
	 * @param {object} $output The menu output object (passed by reference).
	 */
	public function display_element( $item, &$children_elements, $max_depth, $depth, $args, &$output ) {

		// Store the item object class-wide.
		$this->item = $item;

		// Grab 'html_tab_indents' passed by output_theme_location_menu.
		if ( $this->first_call ) {
			$this->first_call = false;

			if ( isset( $args[0]->html_tab_indents ) ) {
				$this->t_offset = $args[0]->html_tab_indents;
			} else {
				$this->t_offset = 1;
			}

			if ( isset( $args[0]->top_level_classes ) && '' !== $args[0]->top_level_classes ) {
				$this->top_level_classes = $args[0]->top_level_classes;
			} else {
				$this->top_level_classes = '';
			}

			if ( isset( $args[0]->menu_class ) && '' !== $args[0]->menu_class ) {
				$this->menu_class = $args[0]->menu_class;
			} else {
				$this->menu_class = '';
			}
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

		if ( $item->current && ! $this->is_search ) {
			// Element is active and not on a search page.
			$item->hb__is_active = true;
		} else {
			// Explicit boolean.
			$item->hb__is_active = false;
		}

		//
		// Fire the html output methods.
		//

		// If item has children and args allow further depth.
		if ( ( 0 === $max_depth || $max_depth > $depth + 1 ) && $item->hb__is_parent ) {

			// Open a new menu dropdown component.
			$this->start_lvl( $output, $depth, $args );

			// Output this parent item adjacent to dropdown toggle button.
			$this->t_nest_step = $this->t_nest_step + 1;
			$this->start_el( $output, $item, $depth, ...array_values( $args ) );

			// Output dropdown contents element with toggle button.
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

			// Output the menu item.
			$this->start_el( $output, $item, $depth, ...array_values( $args ) );
		}
	}


	/**
	 * Method start_el.
	 *
	 * Build an anchor element using $item vars and append to output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		$is_parent = $item->hb__is_parent;
		$is_active = $item->hb__is_active;

		// Get CSS Classes.
		if ( $is_parent ) {
			$item_classes = 'dropdown_primary';
			// Add top level item class(es) if provided.
			if ( 0 === $depth && ! empty( $this->top_level_classes ) ) {
				$item_classes .= ' ' . $this->top_level_classes;
			}
		} else {
			$item_classes = $this->build_class_string( $item, $depth, $args );
		}

		// Wrap CSS classes.
		$class_string = 'class="' . trim( $item_classes ) . '"';

		// Aria attributes.
		$aria_attributes = ' aria-label="' . $item->title . '"';
		$aria_attributes = ( $is_active ) ? $aria_attributes . ' aria-current="page"' : $aria_attributes;

		// Anchor attributes.
		$anchor_attributes  = ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
		$anchor_attributes .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
		$anchor_attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
		$anchor_attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';

		// Build markup.
		$item_output  = "{$this->n}{$this->i(0)}<a {$class_string} {$anchor_attributes} {$aria_attributes}>";
		$item_output .= "{$this->n}{$this->i(1)}<span>";
		$item_output .= "{$this->n}{$this->i(2)}{$item->title}";
		$item_output .= "{$this->n}{$this->i(1)}</span>";
		$item_output .= "{$this->n}{$this->i(0)}</a>";

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}


	/**
	 * Method start_lvl.
	 *
	 * Start building a new dropdown for a menu branch.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {

		// Get the $item.
		$item = $this->item;

		// Get CSS classes.
		$dropdown_classes = $this->build_class_string( $item, $depth, $args );

		// Append dropdown classes.
		if ( 0 === $depth ) {
			$dropdown_classes = 'dropdown dropdown-hover ' . $dropdown_classes;
		} else {
			$dropdown_classes = 'dropdown dropdown-inMenu ' . $dropdown_classes;
		}

		$output .= "{$this->n}{$this->i(0)}<div class=\"{$dropdown_classes}\">";
	}


	/**
	 * Method end_el.
	 *
	 * Open a new dropdown_contents div ready for child menu items.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {

		$item  = $this->item;
		$icon  = self::$icon;
		$title = $item->title;

		// Button aria attributes.
		$aria_attributes = 'aria-label="Open menu" aria-pressed="false" aria-expanded="false" aria-haspopup="menu"';

		$toggle_classes = 'dropdown-toggle';
		// Add top level item class(es) if provided.
		if ( 0 === $depth && ! empty( $this->top_level_classes ) ) {
			$toggle_classes .= ' ' . $this->top_level_classes;
		}

		$output .= "{$this->n}{$this->i(0)}<button class=\"{$toggle_classes}\" {$aria_attributes}>";
		$output .= "{$this->n}{$this->i(1)}<span class=\"dropdown_toggleIcon\">{$icon}</span>";
		$output .= "{$this->n}{$this->i(1)}<span class=\"screen-reader-text\">{$title}</span>";
		$output .= "{$this->n}{$this->i(0)}</button>";
		$output .= "{$this->n}{$this->i(0)}<div class=\"dropdown_contents\">";
	}


	/**
	 * Method end_lvl.
	 *
	 * Close a dropdown component and menu branch.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {

		$output .= "{$this->n}{$this->i(1)}</div>"; // Dropdown contents.
		$output .= "{$this->n}{$this->i(0)}</div>"; // Dropdown.
	}


	/**
	 * Fallback.
	 *
	 * This method can be set as a callback in wp_nav_menu to display a fallback menu
	 * before the user sets a menu in that location.
	 *
	 * @param {array} $args An object of wp_nav_menu() arguments.
	 */
	public static function fallback( array $args ) {

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$link = '<li class="button"><a href="' . admin_url( 'customize.php' ) . '">Edit Menus</a></li>';

		// Populate vars with any passed args.
		$wrap       = ! empty( $args['container'] ) ? esc_attr( $args['container'] ) : 'nav';
		$menu_class = ! empty( $args['menu_class'] ) ? 'class="' . esc_attr( $args['menu_class'] ) . '"' : 'class="menu"';
		$menu_id    = ! empty( $args['menu_id'] ) ? 'id="' . esc_attr( $args['menu_id'] ) . '"' : '';
		$aria       = 'aria-label="Fallback Menu"';

		// Build fallback markup.
		$output = sprintf( $link );
		$aria   = ( 'nav' === $wrap ) ? $aria : '';
		$output = "<$wrap $menu_class $menu_id $aria>$output</$wrap>";

		if ( $args['echo'] ) {
			echo $output;
		} else {
			return $output;
		}
	}


	/**
	 * Output Theme Location Menu.
	 *
	 * A wrapper for wp_nav_menu to simplify args template-side and
	 * force use of limited arg options. The html structure is BEM so the
	 * menu_class is passed to wp_nav_menu as both menu and container class
	 * so the component has a consistent 'Block' class prefix.
	 *
	 * Example call:
	 *
	 * Menu_Walker::output_theme_location_menu( array(
	 *     'theme_location'    => 'landing-page-secondary-menu',
	 *     'menu_class'        => 'footerNav',
	 *     'nav_or_div'        => 'div',
	 *     'nav_aria_label'    => '',
	 * ) );
	 *
	 * @param array $menu_args An object of wp_nav_menu() arguments.
	 */
	public static function output_theme_location_menu( array $menu_args ) {

		// Test if args are valid.
		$pass      = true;
		$test_args = array( 'nav_or_div', 'menu_class', 'nav_aria_label', 'theme_location', 'html_tab_indents', 'top_level_classes' );

		if ( $pass && count( $menu_args ) > 6 ) {
			$pass = false;
		} else {

			foreach ( $menu_args as $key => $value ) {

				if ( in_array( $key, $test_args, true ) ) {
					$passed_args[ $key ] = $value;

				} else {
					$pass = false;
				}
			}
		}

		if ( $pass && ! isset( $menu_args['theme_location'] ) || '' === $menu_args['theme_location'] ) {
			$pass = false;

			echo '<pre style="text-align: left;">';
			echo "\n# Menu_Walker ERROR 🤕";
			echo "\n# 'theme_location' is required. Example:";
			echo "\n#";
			echo "\n# Menu_Walker::output_theme_location_menu( array(";
			echo "\n#     'theme_location'   => 'main-menu',";
			echo "\n# ) );";
			echo "\n#";
			echo "\n# Please correct the method call at this point in your template file";
			echo '</pre>';

			return;
		}

		// Check theme_location exists.
		$locations = get_registered_nav_menus();

		if ( $pass && ! array_key_exists( $menu_args['theme_location'], $locations ) ) {

			$pass = false;

			echo '<pre style="text-align: left;">';
			echo "\n# Menu_Walker ERROR 🤕";
			echo "\n# theme_location '{$menu_args['theme_location']}' not found in registered menu locations.";
			echo "\n#";
			echo "\n# These are the current registered menu locations:";
			foreach ( $locations as $key => $value ) {
				echo "\n# '{$key}'";
			}
			echo "\n#";
			echo "\n# Please correct the method call at this point in your template file";
			echo '</pre>';

			return;
		}

		if ( $pass
			&& isset( $menu_args['nav_or_div'] )
			&& 'nav' !== $menu_args['nav_or_div']
			&& 'div' !== $menu_args['nav_or_div'] ) {

			$pass = false;

			echo '<pre style="text-align: left;">';
			echo "\n# Menu_Walker ERROR 🤕";
			echo "\n# 'nav_or_div' must be value either 'nav' or 'div'";
			echo "\n#";
			echo "\n# Please correct the method call at this point in your template file";
			echo '</pre>';

			return;
		}

		if ( $pass && isset( $passed_args['html_tab_indents'] ) ) {

			if ( ! is_int( $passed_args['html_tab_indents'] )
				|| strlen( $passed_args['html_tab_indents'] ) > 1
				|| strlen( $passed_args['html_tab_indents'] ) === 0
				|| $passed_args['html_tab_indents'] > 9
				|| $passed_args['html_tab_indents'] < 0
			) {

				$pass = false;

				echo '<pre style="text-align: left;">';
				echo "\n# Menu_Walker ERROR 🤕";
				echo "\n# 'html_tab_indents' must be an integer from 0-9";
				echo "\n#";
				echo "\n# Please correct the method call at this point in your template file";
				echo '</pre>';

				return;
			}
		}

		if ( ! $pass ) {

			echo '<pre style="text-align: left;">';
			echo "\n# Menu_Walker ERROR 🤕";
			echo "\n# output_theme_location_menu accepts up to 6 arguments with 'theme_location'";
			echo "\n# being the only required parameter. Example:";
			echo "\n#";
			echo "\n# Menu_Walker::output_theme_location_menu( array(";
			echo "\n#     'theme_location'     => 'main-menu',";
			echo "\n#     'menu_class'         => 'mainMenu',";
			echo "\n#     'nav_or_div'         => 'nav',";
			echo "\n#     'nav_aria_label'     => 'Menu',";
			echo "\n#     'html_tab_indents'   => 3,";
			echo "\n#     'top_level_classes'  => 'button',";
			echo "\n# ) );";
			echo "\n#";
			echo "\n# Please correct the method call at this point in your template file";
			echo '</pre>';

			return;
		}

		$defaults = array(
			'theme_location'       => '',
			'menu_class'           => 'menu',
			'container'            => 'nav',
			'container_class'      => '',
			'container_aria_label' => 'Menu',
			'items_wrap'           => '%3$s',
			'echo'                 => true,
			'depth'                => 0,
			'fallback_cb'          => array( new Menu_Walker(), 'fallback' ),
			'walker'               => new Menu_Walker(),
			'html_tab_indents'     => 3,
			'nav_or_div'           => 'nav',
			'nav_aria_label'       => 'Menu',
			'top_level_classes'    => '', // Applied to only top-level menu items.
		);

		// Merge passed args with defaults array.
		$args = array_merge( $defaults, $passed_args );

		// We only want one menu class.
		$menu_class_string  = self::sanitise_classes( $args['menu_class'] );
		$args['menu_class'] = explode( ' ', $menu_class_string )[0];

		// WordPress-ify the args in case used outside this class.
		$args['container_class']      = $args['menu_class'];
		$args['container']            = $args['nav_or_div'];
		$args['container_aria_label'] = $args['nav_aria_label'];

		// Clean the class strings.
		$args['menu_class']        = self::sanitise_classes( $args['menu_class'] );
		$args['container_class']   = self::sanitise_classes( $args['container_class'] );
		$args['top_level_classes'] = self::sanitise_classes( $args['top_level_classes'] );

		// If menu is registered at location, pass to wp_nav_menu.
		if ( has_nav_menu( $args['theme_location'] ) ) {

			wp_nav_menu( $args );

			// Insert the 'more items' template element (for cloning by js).
			$icon = self::$icon;
			echo <<<TEMPLATE
<template class="autoMoreTemplate">
	<div class="mainMenu_item autoMore dropdown dropdown-hover">
		<span class="dropdown_primary" role="button" tabindex="0">
			More
		</span>
		<button class="dropdown_toggle" aria-label="More" aria-pressed="false" aria-expanded="false" aria-haspopup="menu">
			<span class="dropdown_toggleIcon">
				{$icon}
			</span>
		</button>
		<div class="dropdown_contents">
			<!-- MORE ITEMS ARE INSERTED HERE -->
		</div>
	</div>
</template>
TEMPLATE;

			// Otherwise, use fallback method.
		} else {

			self::fallback( $args );
		}
	}


	/**
	 * Clean a string for CSS class use or similar.
	 *
	 * Removes excess whitespace and invalid characters.
	 *
	 * @param {string} $string A string to be cleaned.
	 * @return {string} A cleaned string.
	 */
	public static function sanitise_classes( $string ) {

		$trimmed_string = trim( $string );
		$safe_string    = preg_replace( '/[^A-Za-z0-9 \-_]/', '', $trimmed_string );

		return $safe_string;
	}


	/**
	 * Build Class String
	 *
	 * Builds and returns a string of classes for the passed menu item.
	 *
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function build_class_string( $item, $depth, $args ) {

		// Passed from display_element.
		$is_parent  = $item->hb__is_parent;
		$is_active  = $item->hb__is_active;
		$has_active = $item->hb__has_active;

		// BEM Structure.
		$css_element  = '_item';
		$css_modifier = array(
			'parent'     => '-parent',
			'active'     => '-active',
			'has_active' => '-parent-hasActive',
		);

		// Classes.
		$class_array       = array();
		$menu_class        = $this->menu_class;

		array_push( $class_array, $menu_class );

		// Adds a dropdown class to dropdown children.
		if ( 0 < $depth ) {
			array_push( $class_array, 'dropdown_item' );
		}

		$class_string = '';

		/**
		 * For each class in the array, create relevant modifier classes for the menu item. This
		 * allows the caller to use as many dynamic classes as desired.
		 */
		foreach ( $class_array as $css_block ) {

			// Only append BEM '_item' for menu_class. For all other classes, just use modifier.
			$css_element = ( $css_block === $menu_class ) ? $css_element : '';

			// Start with ' ' to ensure classes are separated from last loop - trim excess later.
			$class_string = $class_string . ' ' . $css_block . $css_element;
			$class_string = ( $is_parent ) ? $class_string . ' ' . $css_block . $css_element . $css_modifier['parent'] : $class_string;
			$class_string = ( $is_active ) ? $class_string . ' ' . $css_block . $css_element . $css_modifier['active'] : $class_string;
			$class_string = ( $has_active ) ? $class_string . ' ' . $css_block . $css_element . $css_modifier['has_active'] : $class_string;
		}

		// Adds top level item class(es) if provided.
		if ( 0 === $depth && ! empty( $this->top_level_classes ) && ! $is_parent ) {
			$class_string .= ' ' . $this->top_level_classes;
		}

		return trim( $class_string );

	}
}//end class
