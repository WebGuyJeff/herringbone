<?php
/**
 * Herringbone Theme Functions.php config file.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */


/**
 * Load the PHP autoloader from it's own file
 */
require_once(get_template_directory() . '/functions/autoload.php');


/**
 * WordPress hooks for this theme.
 */
use Jefferson\Herringbone\Hooks;
$hooks = new Hooks;


/**
 * Enqueue scripts and styles
 */
function enqueue_scripts_and_styles() {
	wp_enqueue_style( 'style_css', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), 'all');
	wp_enqueue_style( 'hb_css', get_template_directory_uri() . '/css/hb.css', array( 'style_css' ), filemtime(get_template_directory() . '/css/hb.css'), 'all');
	// If not in admin area
	if (!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php') {
		wp_register_style( 'hb_landing_css', get_template_directory_uri() . '/css/landing.css', array( 'hb_css' ), filemtime(get_template_directory() . '/css/landing.css'), 'all');
		wp_register_style( 'hb_landingdev_css', get_template_directory_uri() . '/css/landing-dev.css', array( 'hb_landing_css' ), filemtime(get_template_directory() . '/css/landing-dev.css'), 'all');
		wp_enqueue_script( 'hb_screenclass_js', get_template_directory_uri() . '/js/hb_screenclass.js', array (), '0.1', true );
		// De-register wp jquery and use CDN
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array (), '3.6.0', true );
		wp_enqueue_script('jquery');
		// Other front end resources
		wp_enqueue_script( 'hb_mobile-popup-menu', get_template_directory_uri() . '/js/hb_mobile-popup-menu.js', array ( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'hb_dropdownToggle', get_template_directory_uri() . '/js/hb_dropdown-menu.js', array (), '1.0', true );
		wp_enqueue_script( 'gsap', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js', array ( 'jquery' ), '3.6.1', true );
		wp_enqueue_script( 'gsap_cssrule', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/CSSRulePlugin.min.js', array ( 'gsap' ), '3.6.1', true );
		wp_enqueue_script( 'gsap_scrolltrigger', '//cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/ScrollTrigger.min.js', array ( 'gsap' ), '3.6.1', true );
		wp_register_script( 'svgWheel_js', get_template_directory_uri() . '/animation/svgWheel/svgWheel.js', array ( 'gsap_cssrule' ), '1.0', true );
		wp_register_script( 'hb_modal_js', get_template_directory_uri() . '/js/hb_modal.js', array (), '0.1', true );
		wp_register_script( 'hb_hideheader_js', get_template_directory_uri() . '/js/hb_hideheader.js', array ( 'gsap_cssrule' ), '0.1', true );
		wp_register_script( 'hb_usp_js', get_template_directory_uri() . '/js/hb_usp.js', array (), '0.1', true );

		//wp_enqueue_style( 'jetbrains', 'https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap', array(), time() , 'all');
	}
}
add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );


// ======================================================= Basic WordPress setup


/**
 * Disable plugin auto updates
 */
add_filter( 'auto_update_plugin', '__return_false' );

/**
 * Disable theme auto updates
 */
add_filter( 'auto_update_theme', '__return_false' );

/**
 * Register widget area.
 */
function herringbone_widgets_init() {
	register_sidebar(
		array(
			'name'		    => esc_html__( 'Left Sidebar', 'herringbone' ),
			'id'			=> 'sidebar-left',
			'description'   => esc_html__( 'Used for article contents and includes right sidebar content at mid-width.', 'herringbone' ),
			'before_widget' => '<section id="%1$s" class="sauce widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'		    => esc_html__( 'Right Sidebar', 'herringbone' ),
			'id'			=> 'sidebar-right',
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
		 * Wordpress will dynamically populate the title tag using the page H1.
		 */
		// Handled by HB SEO functionality
		//add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Enable custom image sizes and set the sizes required for the theme
		 */
		//add_theme_support( 'pop-up-banner' );
		//add_image_size( 'service-tile', 960, 960, TRUE );
		//add_image_size( 'review-avatar', 150, 150, TRUE );
		//add_image_size( 'full-width-banner', 1920, 480, TRUE );
		//add_image_size( 'page-featured', 615, 615, TRUE );


		/*
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
		 * 
		 */


		register_nav_menus(
			array(
				'mobile-popup-menu' 			=> esc_html__( 'Mobile Popup Menu', 'herringbone' ),
				'global-primary-menu' 			=> esc_html__( 'Global Header Menu', 'herringbone' ),
				'global-secondary-menu' 		=> esc_html__( 'Global Footer Menu', 'herringbone' ),
				'global-legal-links' 			=> esc_html__( 'Global Legal Links', 'herringbone' ),
				'landing-page-primary-menu' 	=> esc_html__( 'Landing Page Header Menu', 'herringbone' ),
				'landing-page-secondary-menu'	=> esc_html__( 'Landing Page Footer Menu', 'herringbone' ),
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
				'height'	  => 1000,
				'width'		  => 1000,
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
add_filter('get_the_archive_title', function ($title) {
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
});


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
add_filter( 'wp_sitemaps_add_provider', function ($provider, $name) {
  return ( $name == 'users' ) ? false : $provider;
}, 10, 2);

// ================================================== Herringbone admin settings


/**
 * Add Herringbone admin menu option to sidebar
 */
function herringbone_settings_add_menu() {

	$icon = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMzIgMTMyIj48cGF0aCBmaWxsPSIjMDAwIiBkPSJNMCAwdjEzYzAgNSAwIDEwIDggMTNsNTggMjcgNTgtMjdjOC0zIDgtOCA4LTEzVjBMNzQgMjZjLTggNC04IDktOCAxNCAwLTUgMC0xMC04LTE0em0wIDQwdjEzYzAgNCAwIDEwIDggMTNsNTggMjcgNTgtMjdjOC0zIDgtOSA4LTEzVjQwTDc0IDY2Yy04IDQtOCA5LTggMTMgMC00IDAtOS04LTEzem0wIDM5djE0YzAgNCAwIDkgOCAxM2w1OCAyNiA1OC0yNmM4LTQgOC05IDgtMTNWNzlsLTU4IDI3Yy04IDMtOCA5LTggMTMgMC00IDAtMTAtOC0xM3oiPjwvcGF0aD48L3N2Zz4=';

  	add_menu_page(
		'Herringbone Theme Settings',//page_title
	  	'Herringbone',		 		 //menu_title
		'manage_options',			 //capability
		'herringbone-settings',		 //menu_slug
		'', 						 //function
		$icon,						 //icon_url
		4							 //position
	);

	add_submenu_page(
		'herringbone-settings',		 //parent_slug
	  	'Herringbone Theme Settings',//page_title
		'Theme Settings',	 	 	 //menu_title
		'manage_options',		 	 //capability
		'herringbone-settings', 	 //menu_slug
		'herringbone_settings_page', //function
		1							 //position
	);

}
add_action( 'admin_menu', 'herringbone_settings_add_menu' );


/**
 * Create Herringbone Global Settings Page
 */
function herringbone_settings_page() { ?>
  	<div class="wrap">
			<h1>Herringbone Settings</h1>
			<form method="post" action="options.php">
					<?php
							settings_fields( 'section' );
							do_settings_sections( 'theme-options' );
							submit_button();
					?>
			</form>
  	</div>
<?php }

/*
 * Add options fields to the admin page
 *
// Codepen
function setting_codepen() { ?>
  	<input type="text" name="codepen" id="codepen" value="<?php echo get_option( 'codepen' ); ?>" />
<?php }
// Instagram
function setting_instagram() { ?>
	<input type="text" name="instagram" id="instagram" value="<?php echo get_option('instagram'); ?>" />
<?php }
// Facebook
function setting_facebook() { ?>
	<input type="text" name="facebook" id="facebook" value="<?php echo get_option('facebook'); ?>" />
<?php }
*/


/*
 * Tell WordPress to build the admin page
 *
function herringbone_settings_page_setup() {
  	add_settings_section( 'section', 'Social Links', null, 'theme-options' );
  	add_settings_field( 'codepen', 'Codepen URL', 'setting_codepen', 'theme-options', 'section' );
	add_settings_field( 'instagram', 'Instagram URL', 'setting_instagram', 'theme-options', 'section' );
	add_settings_field( 'facebook', 'Facebook URL', 'setting_facebook', 'theme-options', 'section' );

  	register_setting( 'section', 'codepen' );
	register_setting( 'section', 'instagram' );
	register_setting( 'section', 'facebook' );
}
add_action( 'admin_init', 'herringbone_settings_page_setup' );
*/

// =========================================================== Custom Post Types


/* Custom Post Type
function create_my_custom_post() {
	register_post_type( 'my-custom-post',
		array(
			'labels' => array(
				'name' => __( 'My Custom Post' ),
				'singular_name' => __( 'My Custom Post' ),
			),
			'public' => true,
			'has_archive' => true,
			'supports' => array(		 // Define post elements
				'title',				 // the_title()
				'editor',				// the_content()
				'thumbnail',			 // the_post_thumbnail()
				'custom-fields'
			),
			'taxonomies' => array(	   // Add ways to group posts
				'post_tag',			  // Tags
				'category',			  // Categories
			)
		)
	);
	register_taxonomy_for_object_type( 'category', 'my-custom-post' );
	register_taxonomy_for_object_type( 'post_tag', 'my-custom-post' );
}
add_action( 'init', 'create_my_custom_post' );
*/
