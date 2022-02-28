<?php
namespace Jefferson\Herringbone;

/**
 * Template part for the mobile navigation menu
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

$theme_root = get_template_directory_uri();


wp_nav_menu(
			$args = array(
				'theme_location'	=> 'mobile-popup-menu',
				'items_wrap'		=> '%3$s',
				'menu_class'		=> 'nav',
				'container'	   		=> 'nav',
				'container_class' 	=> 'mobileNav',
				'echo'           	=> true,
				'walker'         	=> new Menu_Walker,
				'fallback_cb'		=> [ new Menu_Walker(), 'fallback' ],
			)
		);
?>

<nav class="thumbNav thumbNav-jshide">
   <input class="thumbNav_checkbox" type="checkbox" id="thumbNav_checkbox" data-com.bitwarden.browser.user-edited="yes">
   <label class="thumbNav_toggle thumbNav_button thumbNav_button-hover" for="thumbNav_checkbox">
   <a class="thumbNav_label" title="Main Menu" aria-label="Main Menu">
	  <img class="thumbNav_icon" src="<?php echo $theme_root; ?>/imagery/icons_nav/menu.svg" alt="Menu Icon">
   </a>
   </label>
   <div class="thumbNav_child">
	  <a href="/contact" title="Navigate to Contact Page" aria-label="Contact Page" class="thumbNav_button thumbNav_button-hover">
		 <img class="thumbNav_icon" src="<?php echo $theme_root; ?>/imagery/icons_nav/contact.svg" alt="Contact Menu Icon">
	  </a>
   </div>
   <div class="thumbNav_child">
	  <a href="/about" title="Navigate to About Page" aria-label="About Page" class="thumbNav_button thumbNav_button-hover">
		 <img class="thumbNav_icon" src="<?php echo $theme_root; ?>/imagery/icons_nav/about.svg" alt="About Menu Icon">
	  </a>
   </div>
   <div class="thumbNav_child">
	  <a href="/" title="Navigate to Home Page" aria-label="Home Page" class="thumbNav_button thumbNav_button-hover">
		 <img class="thumbNav_icon" src="<?php echo $theme_root; ?>/imagery/icons_nav/home.svg" alt="Home Menu Icon">
	  </a>
   </div>
</nav>
