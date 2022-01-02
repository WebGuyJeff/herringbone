<?php

/**
 * Template Name: Landing Page
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

get_header( 'landing' );

//enqueue styles and scripts
wp_enqueue_style( 'hb_landing_css' );
wp_enqueue_style( 'hb_landingdev_css' );
wp_enqueue_script( 'gsap' );
wp_enqueue_script( 'gsap_cssrule' );
wp_enqueue_script( 'hb_hideheader_js' );
?>

<main class="main-landing">

	<section class="welcome">
		<?php get_template_part( 'template-parts/landing/dev/welcome' ); ?>
	</section>

	<section class="services">
		<?php get_template_part( 'template-parts/landing/dev/services'); ?>
	</section>

	<section class="usp">
		<?php get_template_part( 'template-parts/landing/dev/usp'); ?>
	</section>

	<section class="contact">
		<?php get_template_part( 'template-parts/landing/dev/contact'); ?>
	</section>

</main>

<?php get_template_part( 'template-parts/modal', 'contact' ); ?>
<?php get_footer( 'landing' ); ?>

<script> console.log( 'wp-template: landing-page.php' );</script>
