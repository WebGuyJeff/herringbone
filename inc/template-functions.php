<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package herringbone
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function herringbone_body_classes( $classes ) {
	// Add a class to id non-singular vs singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'singular-false';
	} else {
        $classes[] = 'singular-true';
    }

	// Add a class when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-left' ) ) {
		$classes[] = 'side_left-false';
	} elseif ( ! is_active_sidebar( 'sidebar-right' ) ) {
        $classes[] = 'side_right-false';
    }

    // Add a class when the page is a landing page
    if ( is_page( 'web-developer' ) || is_page( 'wordpress-developer' ) || is_front_page() ) {
		$classes[] = 'landing_page';
    }

	return $classes;
}
add_filter( 'body_class', 'herringbone_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function herringbone_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'herringbone_pingback_header' );
