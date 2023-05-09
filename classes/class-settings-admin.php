<?php
namespace Jefferson\Herringbone;

/**
 * Settings Admin Page - Herringbone Theme.
 *
 * To retrieve values:
 *
 * // Get the serialized array of all options:
 * $hb_settings = get_option( 'hb_settings_array' ); // Serialized array of all Options
 *
 * // Then get a single option from that array:
 * $hb_email_address = $hb_settings['hb_email_address']; // Email Address
 *
 * @package herringbone
 */
class Settings_Admin {

	private const ICON = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMzIgMTMyIj48cGF0aCBmaWxsPSIjMDAwIiBkPSJNMCAwdjEzYzAgNSAwIDEwIDggMTNsNTggMjcgNTgtMjdjOC0zIDgtOCA4LTEzVjBMNzQgMjZjLTggNC04IDktOCAxNCAwLTUgMC0xMC04LTE0em0wIDQwdjEzYzAgNCAwIDEwIDggMTNsNTggMjcgNTgtMjdjOC0zIDgtOSA4LTEzVjQwTDc0IDY2Yy04IDQtOCA5LTggMTMgMC00IDAtOS04LTEzem0wIDM5djE0YzAgNCAwIDkgOCAxM2w1OCAyNiA1OC0yNmM4LTQgOC05IDgtMTNWNzlsLTU4IDI3Yy04IDMtOCA5LTggMTMgMC00IDAtMTAtOC0xM3oiPjwvcGF0aD48L3N2Zz4=';
	// private const SLUG = 'herringbone-settings';

	public const PARENTSLUG   = 'herringbone';
	private const SETTINGSLUG = 'herringbone-settings';


	/**
	 * Register the settings admin hooks.
	 *
	 * In order to set a custom post menu item as a sub item, the 'admin_menu' hook priority must be
	 * 9 or lower. See the following documentation:
	 *
	 * @link https://developer.wordpress.org/reference/functions/register_post_type/#show_in_menu
	 */
	public function __construct() {
		// Move the default posts menu item from 5 to 9
		add_action(
			'admin_menu',
			function() {
				global $menu;
				$new_position = 9;
				$cpt_title    = 'Posts';
				foreach ( $menu as $key => $value ) {
					if ( $cpt_title === $value[0] ) {
						$copy = $menu[ $key ];
						unset( $menu[ $key ] );
						$menu[ $new_position ] = $copy;
					}
				}
			}
		);
		add_action( 'admin_menu', array( $this, 'add_settings_menu' ), 9 );
		add_action( 'admin_init', array( new Settings_Tab_Theme(), 'init' ) );
		add_action( 'admin_init', array( new Settings_Tab_Dev_Landing(), 'init' ) );
		add_action( 'below_parent_settings_page_heading', array( &$this, 'echo_settings_link_callback' ) );
	}

	public function add_settings_menu() {

		add_menu_page(
			'Herringbone Theme',                  // Page title.
			'Herringbone',                        // Menu title.
			'manage_options',                     // Capability.
			self::PARENTSLUG,                     // Parent Menu Slug.
			array( $this, 'create_parent_page' ), // Callback.
			self::ICON,                           // Icon.
			5                                     // Position.
		);

		// This overrides WP from giving the first sub menu item the same text as the parent menu.
		add_submenu_page(
			self::PARENTSLUG,                       // Parent Slug.
			'Herringbone Theme Dashboard',          // Page Title.
			'Dashboard',                            // Menu Title.
			'manage_options',                       // Capability.
			self::PARENTSLUG                        // Sub Menu Slug.
		);

		add_submenu_page(
			self::PARENTSLUG,                       // Parent Slug.
			'Herringbone Theme Settings',           // Page Title.
			'Theme Settings',                       // Menu Title.
			'manage_options',                       // Capability.
			self::SETTINGSLUG,                      // Sub Menu Slug.
			array( $this, 'create_settings_page' ), // Callback.
			2,                                      // Position.
		);

		// Sub menu item for custom post type 'Projects'.
		add_submenu_page(
			self::PARENTSLUG,                  // Parent Slug.
			'Project Posts',                   // Page Title.
			'Project Posts',                   // Menu Title.
			'manage_options',                  // Capability.
			Register_Projects_CPT::PROJECTSLUG // Sub Menu (custom post) Slug.
		);
	}


	/**
	 * Do Action Hook
	 */
	public function below_parent_settings_page_heading() {
		do_action( 'below_parent_settings_page_heading' );
	}


	/**
	 * Create Parent Admin Page
	 */
	public function create_parent_page() {
		$theme_data = wp_get_theme();
		?>

		<div class="wrap">
			<h1>
				<span>
					<img
						style="max-height: 1em;margin-right: 0.5em;vertical-align: middle;"
						src="<?php echo self::ICON; ?>"
					/>
				</span>
				<?php echo esc_html( get_admin_page_title() ); ?>
			</h1>

			<section>
				<h2>
					Information
				</h2>

				<table>
					<tbody>
						<tr>
							<td>Name</td>
							<td><?php echo $theme_data->get( 'Name' ); ?></td>
						</tr>

						<tr>
							<td>Theme URI</td>
							<td><a href="<?php echo $theme_data->get( 'ThemeURI' ); ?>"><?php echo $theme_data->get( 'ThemeURI' ); ?></a></td>
						</tr>
						<tr>
							<td>Description</td>
							<td><?php echo $theme_data->get( 'Description' ); ?></td>
						</tr>
						<tr>
							<td>Author</td>
							<td><?php echo $theme_data->get( 'Author' ); ?></td>
						</tr>
						<tr>
							<td>Author URI</td>
							<td><a href="<?php echo $theme_data->get( 'AuthorURI' ); ?>"><?php echo $theme_data->get( 'AuthorURI' ); ?></a></td>
						</tr>
						<tr>
							<td>Version</td>
							<td><?php echo $theme_data->get( 'Version' ); ?></td>
						</tr>
					</tbody>
				<table>

			</section>

			<section>
				<h2>
					Management
				</h2>
				<div class="dashTiles">
					<?php $this->below_parent_settings_page_heading(); ?>
				</div>
			</section>
		</div>

		<?php
	}


	public function create_settings_page() {

		// Get the active tab from the $_GET URL param.
		$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : null;

		?>

		<div class="wrap">
			<h1>
				<span>
					<img
						style="max-height: 1em;margin-right: 0.5em;vertical-align: middle;"
						src="<?php echo self::ICON; ?>"
					/>
				</span>
				<?php echo esc_html( get_admin_page_title() ); ?>
			</h1>

			<p>These settings manage content that appears on the front end of the Herringbone theme.</p>

			<?php settings_errors(); // Display the form save notices here. ?>

			<nav class="nav-tab-wrapper">                                                                                                                              
				<a
					href="?page=<?php echo self::SETTINGSLUG; ?>"
					class="nav-tab 
					<?php
					if ( $tab === null ) {
						echo 'nav-tab-active';}
					?>
					"
				>
					Theme
				</a>
				<a
					href="?page=<?php echo self::SETTINGSLUG; ?>&tab=dev-landing-page"
					class="nav-tab 
					<?php
					if ( $tab === 'dev-landing-page' ) {
						echo 'nav-tab-active';}
					?>
					"
				>
					Dev Landing Page
				</a>
			</nav>

			<div class="tab-content">
				<form method="post" action="options.php">

					<?php

					switch ( $tab ) :
						case 'dev-landing-page':
								settings_fields( Settings_Tab_Dev_Landing::GROUP );
								do_settings_sections( Settings_Tab_Dev_Landing::PAGE );
							break;
						default:
								settings_fields( Settings_Tab_Theme::GROUP );
								do_settings_sections( Settings_Tab_Theme::PAGE );
							break;
					endswitch;

					submit_button();

					?>

				</form>
			</div>
		</div>

		<?php
	}


	/**
	 * Echo a link to this theme's dashboard page.
	 */
	public static function echo_dashboard_page_link( $link, $text ) {
		?>

		<a href="<?php echo $link; ?>">
			<?php echo $text; ?>
		</a>

		<?php
	}


	/**
	 * Echo settings link on the dashboard page callback.
	 */
	public function echo_settings_link_callback() {
		self::echo_dashboard_page_link(
			'/wp-admin/admin.php?page=' . self::SETTINGSLUG,
			'Theme settings'
		);
	}
}
