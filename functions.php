<?php
/**
 * Herringbone Theme Functions.php config file.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */


/**
 * Load the PHP autoloader from it's own file
 */
require_once get_template_directory() . '/classes/autoload.php';


/**
 * Setup theme settings and custom post types.
 */
use Jefferson\Herringbone\Settings_Admin;
use Jefferson\Herringbone\Register_Projects_CPT;
if ( is_admin() ) {
	new Settings_Admin();
}
add_action( 'init', [ new Register_Projects_CPT, 'create_cpt' ] );


/**
 * WordPress hooks for this theme.
 */
use Jefferson\Herringbone\Hooks;
$hooks = new Hooks();


/**
 * Turn off theme and plugin auto-updates.
 */
//add_filter( 'auto_update_plugin', '__return_false' );
//add_filter( 'auto_update_theme', '__return_false' );


/**
 * Enqueue scripts and styles.
 */
function enqueue_scripts_and_styles() {
	// Customizer preview.
	if ( is_customize_preview() ) {
		wp_enqueue_script( 'hb_customizer_js', get_template_directory_uri() . '/js/customizer.js', array(), filemtime( get_template_directory() . '/js/customizer.js' ), true );
	}
	// Front end.
	if ( ! is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php' ) {
		wp_enqueue_style( 'style_css', get_template_directory_uri() . '/style.css', array(), filemtime( get_template_directory() . '/style.css' ), 'all' );
		// De-register wp jquery and use CDN.
		wp_deregister_script( 'jquery' );
		wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0', true );
		// Other front end resources.
		wp_register_script( 'gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js', array( 'jquery' ), '3.9.1', true );
		// CSSRule this is part of core but there's a separate CDN?
		// wp_register_script( 'gsap_cssrule', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/CSSRulePlugin.min.js', array( 'gsap' ), '3.9.1', true );
		wp_register_script( 'gsap_scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js', array( 'gsap' ), '3.9.1', true );
		wp_register_script( 'svgWheel_js', get_template_directory_uri() . '/animation/svgWheel/svgWheel.js', array( 'gsap_cssrule' ), filemtime( get_template_directory() . '/animation/svgWheel/svgWheel.js' ), true );
		wp_enqueue_script( 'hb_frontend_js', get_template_directory_uri() . '/js/frontend.js', array( 'gsap', 'gsap_scrolltrigger' ), filemtime( get_template_directory() . '/js/frontend.js' ), true );
	}
	global $template;
	// Landing pages.
	if ( ! is_admin() && basename( $template ) === 'landing-page.php' ) {
		hb_remove_gutenburg_css();
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );


/**
 * Enqueue admin scripts and styles.
 */
function enqueue_admin_scripts_and_styles() {
	// Admin area.
	if ( is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php' ) {
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/style-admin.css', array(), filemtime( get_template_directory() . '/style-admin.css' ), 'all' );
	}
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_scripts_and_styles' );


/**
 * Remove gutenburg CSS.
 */
function hb_remove_gutenburg_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}


/**
 * Register widget areas.
 */
function herringbone_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Left Sidebar', 'herringbone' ),
			'id'            => 'sidebar-left',
			'description'   => esc_html__( 'Used for article contents and includes right sidebar content at mid-width.', 'herringbone' ),
			'before_widget' => '<section id="%1$s" class="sauce widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Right Sidebar', 'herringbone' ),
			'id'            => 'sidebar-right',
			'description'   => esc_html__( 'Used for related content and unimportant stuff.', 'herringbone' ),
			'before_widget' => '<section id="%1$s" class="sauce widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'herringbone_widgets_init' );


if ( ! function_exists( 'herringbone_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function herringbone_setup() {
		/*
		 * Make theme available for translation.
		 * Translations to be filed in the /languages/ directory.
		 */
		load_theme_textdomain( 'herringbone', get_template_directory() . '/languages' );

		/*
		 * Let WordPress manage the document title.
		 * WordPress will dynamically populate the title tag using the page H1.
		 */
		// Handled by HB SEO functionality
		// add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Enable custom image sizes and set the sizes required for the theme
		 */
		// add_theme_support( 'pop-up-banner' );
		// add_image_size( 'service-tile', 960, 960, TRUE );
		// add_image_size( 'review-avatar', 150, 150, TRUE );
		// add_image_size( 'full-width-banner', 1920, 480, TRUE );
		// add_image_size( 'page-featured', 615, 615, TRUE );

		/**
		 * Enable categories and tags for default post types.
		 */
		function enable_categories_and_tags_for_default_posts() {
			register_taxonomy_for_object_type( 'post_tag', 'page' );
			register_taxonomy_for_object_type( 'category', 'page' );
		}
		add_action( 'init', 'enable_categories_and_tags_for_default_posts' );

		/**
		 * Register WordPress wp_nav_menu() locations
		 *
		 * This option exists in the wp_nav_menu function:
		 *
		 * "'fallback_cb'
		 * (callable|false) If the menu doesn't exist, a callback function will fire.
		 * Default is 'wp_page_menu'. Set to false for no fallback."
		 *
		 * This means where the user hasn't set a menu in the theme settings, for instance,
		 * straight after theme install, WP will display a meaninglesss pages menu which
		 * makes the theme look broken. TODO: A FALLBACK MUST BE PUT IN PLACE
		 */

		register_nav_menus(
			array(
				'mobile-popup-menu'           => esc_html__( 'Mobile Popup Menu', 'herringbone' ),
				'global-primary-menu'         => esc_html__( 'Global Header Menu', 'herringbone' ),
				'global-secondary-menu'       => esc_html__( 'Global Footer Menu', 'herringbone' ),
				'global-legal-links'          => esc_html__( 'Global Legal Links', 'herringbone' ),
				'landing-page-primary-menu'   => esc_html__( 'Landing Page Header Menu', 'herringbone' ),
				'landing-page-secondary-menu' => esc_html__( 'Landing Page Footer Menu', 'herringbone' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		/**
		 * Add theme support for selective refresh for widgets.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 1000,
				'width'       => 1000,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'herringbone_setup' );


// ================================================================= SEO Cleanup


/**
 * Return a title without prefix for every type used in the get_the_archive_title().
 */
add_filter(
	'get_the_archive_title',
	function ( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_year() ) {
			$title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
		} elseif ( is_month() ) {
			$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
		} elseif ( is_day() ) {
			$title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = _x( 'Asides', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = _x( 'Galleries', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = _x( 'Images', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = _x( 'Videos', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = _x( 'Quotes', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = _x( 'Links', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = _x( 'Statuses', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = _x( 'Audio', 'post format archive title' );
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = _x( 'Chats', 'post format archive title' );
			}
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} elseif ( is_tax() ) {
			$title = single_term_title( '', false );
		} else {
			$title = __( 'Archives' );
		}
		return $title;
	}
);


/**
 * Clean default WP bloat from wp_head hook
 */
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'index_rel_link' );
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
// rss feeds
// remove_action( 'wp_head', 'feed_links', 2 );
// remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );


/**
 * Remove default title meta function
 */
remove_action( 'wp_head', '_wp_render_title_tag', 1 );


/**
 * Remove USERS from sitemap
 */
add_filter(
	'wp_sitemaps_add_provider',
	function ( $provider, $name ) {
		return ( $name == 'users' ) ? false : $provider;
	},
	10,
	2
);


/**
 * Enable WP custom fields even if ACF is installed.
 */
add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );
