<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Theme Template - Footer Variant for Landing Pages.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */
?>

<footer class="footer">
	<div class="footer_inner">

		<div class="footerNav">

			<?php wp_nav_menu(
				array(
					'theme_location'	=> 'landing_footer_nav',
					'items_wrap'		=> '%3$s',
					'menu_class'		=> 'nav',
					'container'	   		=> 'div', //Only one nav elem per page for good accessibililty
					'container_class' 	=> 'nav',
					'walker'         	=> new Menu_Walker,
					'fallback_cb'		=> Menu_Walker::fallback_callback( $args ),
					'echo'           	=> TRUE,
				)
			); ?>

		</div>

		<div class="footer_copyright">

			<?php wp_nav_menu(
				array(
					'theme_location'	=> 'legal_link',
					'items_wrap'	  	=> '%3$s',
					'menu_class'	  	=> 'footer_label',
					'container'	   		=> false, //Only one nav elem per page for good accessibililty
					'walker'         	=> new Menu_Walker,
					'fallback_cb'		=> Menu_Walker::fallback_callback( $args ),
					'echo'           	=> TRUE,
				)
			); ?>

			<?php echo "<p class=\"footer_label\">&copy; " . date("Y") . " Hello, my name is Jeff</p>";?>
		</div>

	</div>
</footer>

<?php get_template_part( 'template-parts/nav', 'mobile' );?>

<?php wp_footer(); ?>

</body>
</html>
<script> console.log( 'wp-template: footer-landing.php' );</script>