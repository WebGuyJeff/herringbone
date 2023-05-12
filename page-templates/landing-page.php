<?php
/**
 * Template Name: Landing Page
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

wp_enqueue_script( 'hb_hideheader_js' );

get_header( 'landing' );
?>

<main class="main-landing">

	<section class="welcome">
		<?php get_template_part( 'template-parts/landing-developer/welcome' ); ?>
	</section>

	<section class="services" id="section-services">
		<?php get_template_part( 'template-parts/landing-developer/services' ); ?>
	</section>

	<section class="projects" id="section-projects">
		<?php get_template_part( 'template-parts/landing-developer/projects' ); ?>
	</section>

	<section class="usp" id="working-with-me">
		<?php get_template_part( 'template-parts/landing-developer/usp' ); ?>
	</section>

	<section class="contact" id="section-contact">
		<?php get_template_part( 'template-parts/landing-developer/contact' ); ?>
	</section>

</main>

<?php
	get_footer( 'landing' );
	get_template_part( 'template-parts/modal', 'contact' );
?>

<!--<script> console.log( 'wp-template: landing-page.php' );</script>--> 
