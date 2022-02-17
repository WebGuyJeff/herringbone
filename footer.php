<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Theme Template - Footer.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2022, Jefferson Real
 */
?>

<footer class="footer">
	<div class="footer_inner sauce">

		<?php
			Menu_Walker::output_theme_location_menu( array(
				'theme_location'	=> 'global-secondary-menu',
				'menu_class'		=> 'footer_nav',
				'nav_or_div'		=> 'div',
				'nav_aria_label'	=> '',
				'html_tab_indents'  => 3,
				'button_class'		=> 'button button-noback',
			) );
		?>


		<div class="footer_legalLinks">
			<?php
				Menu_Walker::output_theme_location_menu( array(
					'theme_location'	=> 'global-legal-links',
					'nav_or_div'		=> false,
					'nav_aria_label'	=> '',
					'html_tab_indents'  => 3,
					'button_class'		=> 'button button-noback',
				) );

			echo "<p class=\"footer_label\">&copy; " . date("Y") . " Hello, my name is Jeff</p>";
			?>
		</div>

	</div>
</footer>

<?php get_template_part( 'template-parts/nav', 'mobile' );?>
<?php echo do_shortcode('[wallomatic]'); ?>

<?php wp_footer(); ?>

</body>
</html>
<!--<script> console.log( 'wp-template: footer.php' );</script>-->