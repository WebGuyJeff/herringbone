<?php
namespace Jefferson\Herringbone;

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package herringbone
 */
class Hooks {

	
	//init the class on each new instance
	function __construct() {

		add_filter( 'body_class', array( $this, 'add_body_classes' ) );
		add_action( 'wp_head', array( $this, 'add_pingback_header' ) );

	}//__construct


	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function add_body_classes( $classes ) {

		// Home
		if ( is_front_page() ) { //Homepage
			$classes[] = 'hb__home';
		}

		// Page type
		if ( is_home() ) { //Posts Page
			$classes[] = 'hb__pag-posts';
		} elseif ( is_category() ) {
			$classes[] = 'hb__pag-category';
		} elseif ( is_archive() ) { //Auto-gen 'cats'
			$classes[] = 'hb__pag-archive';
		} elseif ( is_singular() ) {
			$classes[] = 'hb__pag-singular';
		} else {
			$classes[] = 'hb__pag-typeunknown';
		}

		// Template
		if ( is_page_template( 'column-sidebar' ) ) {
			$classes[] = 'hb__tmp-sidesright';
		} elseif ( is_page_template( 'sidebar-column' ) ) {
			$classes[] = 'hb__tmp-sidesleft';
		} elseif ( is_page_template( 'sidebar-column-sidebar' ) ) {
			$classes[] = 'hb__tmp-sidesboth';
		} elseif ( is_page_template( 'landing-page' ) ) {
			$classes[] = 'hb__tmp-landingpage';
		} elseif ( is_page_template( 'full-width-page' ) ) {
			$classes[] = 'hb__tmp-fullwidthpage';
		}

		return $classes;
	}


	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	public function add_pingback_header() {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}


}//class