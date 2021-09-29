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

		<?php
		wp_nav_menu( array(
				'theme_location'	=> 'landing-page-secondary-menu',
				'items_wrap'		=> '%3$s',
				'menu_class'		=> 'nav',
				'container'	   		=> 'div',
				'container_class' 	=> 'footerNav',
				'echo'           	=> true,
				'walker'         	=> new Menu_Walker,
				'fallback_cb'		=> [ new Menu_Walker(), 'fallback' ],
		) ); 
		?>

		<div class="footer_copyright">

			<?php 
			wp_nav_menu( array(
					'theme_location'	=> 'global-legal-links',
					'items_wrap'	  	=> '%3$s',
					'menu_class'	  	=> 'footer_label',
					'container'	   		=> false,
					'echo'           	=> true,
					'walker'         	=> new Menu_Walker,
					'fallback_cb'		=> [ new Menu_Walker(), 'fallback' ],
			) );
			?>

			<?php echo "<p class=\"footer_label\">&copy; " . date("Y") . " Hello, my name is Jeff</p>";?>

		</div>

	</div>
</footer>

<?php get_template_part( 'template-parts/nav', 'mobile' );?>

<?php wp_footer(); ?>

</body>
</html>
<script> console.log( 'wp-template: footer-landing.php' );</script>