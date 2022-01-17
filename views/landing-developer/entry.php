<?php

/**
 * landing-developer entry.php
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

wp_enqueue_style( 'hb_landingdev_css' );

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