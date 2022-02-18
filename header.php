<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Theme Template - Header
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" prefix="og: https://ogp.me/ns/website#">

<head>
	<?php
	$seo = new Seo_Meta;
	echo $seo->head_meta;
	wp_head();
	?>
</head>

<body <?php body_class(); ?>>

	<header class="header">
		<div class="header_inner sauce">

			<div class="header_content header_content-left header_content-third">

				<a class="siteTitle" href="<?php echo get_bloginfo( 'wpurl' );?>" aria-label="Home">
					<?php
					if ( has_custom_logo() ) {

						$logo_id = get_theme_mod( 'custom_logo' );
						$logo_src = wp_get_attachment_image_src( $logo_id , 'full' );
						echo '<img class="siteTitle_logo" src="' . esc_url( $logo_src[0] ) . '">';
					} 
					?>
					<div class="siteTitle_text">
						<p class="siteTitle_sitename">
							<?php echo get_bloginfo( 'name' ); ?>
						</p>
						<span class="siteTitle_tagline">
							<?php echo get_bloginfo( 'description' ); ?>
						</span>
					</div>
				</a>

			</div>

			<div class="header_content header_content-middle">

				<?php
					Menu_Walker::output_theme_location_menu( array(
						'theme_location'	=> 'global-primary-menu',
						'menu_class'		=> 'mainMenu',
						'nav_or_div'		=> 'nav',
						'nav_aria_label'	=> 'Main Menu',
						'html_tab_indents'  => 3,
						'button_class'		=> 'button button-noback',
					) );
				?>

			</div>

			<div class="header_content header_content-right header_content-third">
			</div>

		</div>
	</header>
<!--<script> console.log( 'wp-template: header.php' );</script>-->