<?php

/**
 * Template Name: Landing Page - Business Web Development
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

get_header( 'landing' );

?>

<main class="main-landing">

    <section class="problem">
        <?php get_template_part( 'template-parts/landing-business/problem'); ?>
    </section>
    <section class="solution">
        <?php get_template_part( 'template-parts/landing-business/solution'); ?>
    </section>
    <section class="target-market">
        <?php get_template_part( 'template-parts/landing-business/target-market'); ?>
    </section>
    <section class="competition">
        <?php get_template_part( 'template-parts/landing-business/competition'); ?>
    </section>
    <section class="working-with-me">
        <?php get_template_part( 'template-parts/landing-business/working-with-me'); ?>
    </section>
    <section class="cost">
        <?php get_template_part( 'template-parts/landing-business/cost'); ?>
    </section>
    <section class="process">
        <?php get_template_part( 'template-parts/landing-business/process'); ?>
    </section>

</main>

<?php
	get_footer( 'landing' );
	get_template_part( 'template-parts/modal', 'contact' );
?>

<!--<script> console.log( 'wp-template: landing-page-business.php' );</script>-->
