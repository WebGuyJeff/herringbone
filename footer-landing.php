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
		Menu_Walker::output_theme_location( array(
			'theme_location'	=> 'landing-page-secondary-menu',
			'menu_class'		=> 'menu',
			'nav_or_div'		=> 'div',
			'nav_aria_label'	=> '',
			'html_tab_indents'  => 3,
		) );
		?>

		<div class="footer_copyright">

			<?php
			Menu_Walker::output_theme_location( array(
				'theme_location'	=> 'global-legal-links',
				'menu_class'		=> 'menu',
				'nav_or_div'		=> false,
				'nav_aria_label'	=> '',
				'html_tab_indents'  => 3,
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