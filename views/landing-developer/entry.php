<?php

/**
 * landing-developer entry.php
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

// wp_enqueue WARNING: only seems to work at this level?!

wp_enqueue_style( 'hb_landing_css' );
wp_enqueue_style( 'hb_landingdev_css' );

// Landing page animated header
wp_enqueue_script( 'hb_hideheader_js' );

?>

<main class="main-landing">

	<section class="welcome">
		<?php get_template_part( 'views/landing-developer/parts/welcome' ); ?>
	</section>

	<section class="services" id="section-services">
		<?php get_template_part( 'views/landing-developer/parts/services'); ?>
	</section>

	<section class="usp" id="working-with-me">
		<?php get_template_part( 'views/landing-developer/parts/usp'); ?>
	</section>

	<section class="contact" id="section-contact">
		<?php get_template_part( 'views/landing-developer/parts/contact'); ?>
	</section>

</main>

<?php get_template_part( 'template-parts/modal', 'contact' ); ?>