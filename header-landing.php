<?php
/**
 * Herringbone Theme Template - Header Variant for Landing Pages.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" prefix="og: https://ogp.me/ns/website#">
<head>
<?php get_template_part( 'template-parts/hb-head', 'none' );?>
<?php wp_head();?>
</head>
<body <?php body_class(); ?>>

<div class="table">  <?php //PAGE LAYOUT GRID ?>

<header class="header sauce">

	<div class="header_content header_content-left header_content-third">

	  <a class="siteTitle" href="<?php echo get_bloginfo( 'wpurl' );?>" aria-label="Home">
		<!-- logo class baked into svg -->
		  <?php echo file_get_contents( get_theme_file_path( "imagery/logo/avatar_square-transparent.svg" ));?>
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
	<div class="header_content header_content-hidden">

		<div class="headerNav">

			<?php wp_nav_menu(
				  array(
					  'theme_location'  => 'headernav',
					  'items_wrap'	  => '%3$s',
					  'menu_class'	  => 'nav',
					  'container'	   => 'nav',
					  'container_class' => 'nav',
				  )
			); ?>

		</div>

	</div>
	<div class="header_content header_content-right header_content-third">

		<button aria-label="Main Menu" title="Main Menu" type="button" class="headerToggle" onclick="hb_header.toggle();">
			<svg class="burger" version="1.1" preserveAspectRatio="xMidYMid meet" height="100" width="100" viewBox="0 0 100 100">
				<defs>
					<filter id="gooeyness">
						<feGaussianBlur in="SourceGraphic" stdDeviation="1.5" result="blur"></feGaussianBlur>
						<feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 10 -5" result="gooeyness"></feColorMatrix>
						<feComposite in="SourceGraphic" in2="gooeyness" operator="atop"></feComposite>
					</filter>
				</defs>
				<g class="headerToggle_lines">
					<path class="line line1" d="M 50,25 H 10" />
					<path class="line line2" d="M 50,25 H 90" />

					<path class="line line3" d="M 50,50 H 10" />
					<path class="line line4" d="M 50,50 H 90" />

					<path class="line line5" d="M 50,75 H 10" />
					<path class="line line6" d="M 50,75 H 90" />
				</g>
				<g class="headerToggle_x">
					<path class="line" d="M 25,25 L 75,75"></path>
					<path class="line" d="M 75,25 L 25,75"></path>
				</g>
			</svg>
		</button>

	</div>

</header>
<!-- template: header-landing.php -->