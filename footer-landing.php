<?php
namespace Jefferson\Herringbone;

/**
 * Herringbone Theme Template - Footer Variant for Landing Pages.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */
?>

<footer class="footer">
	<div class="footer_inner">

		<?php
		Menu_Walker::output_theme_location_menu(
			array(
				'theme_location'    => 'landing-page-secondary-menu',
				'menu_class'        => 'footer_nav',
				'nav_or_div'        => 'nav',
				'nav_aria_label'    => 'Footer menu',
				'html_tab_indents'  => 3,
				'top_level_classes' => 'button button-noback',
			)
		);
		?>

		<div class="footer_legalLinks">

			<?php
			Menu_Walker::output_theme_location_menu(
				array(
					'theme_location'    => 'global-legal-links',
					'menu_class'        => 'menu',
					'nav_or_div'        => 'nav',
					'nav_aria_label'    => 'Legal links',
					'html_tab_indents'  => 3,
					'top_level_classes' => 'button button-noback',
				)
			);
			?>

		</div>

	</div>
</footer>

<?php get_template_part( 'template-parts/nav', 'mobile' ); ?>

<?php wp_footer(); ?>

</body>
</html>
<!--<script> console.log( 'wp-template: footer-landing.php' );</script>-->
