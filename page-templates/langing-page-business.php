<?php

/**
 * Template Name: Landing Page - Business Web Development
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

    <section class="problem">
        <?php get_template_part( 'template-parts/landing/dev/problem'); ?>
    </section>
    <section class="solution">
        <?php get_template_part( 'template-parts/landing/dev/solution'); ?>
    </section>
    <section class="target-market">
        <?php get_template_part( 'template-parts/landing/dev/target-market'); ?>
    </section>
    <section class="competition">
        <?php get_template_part( 'template-parts/landing/dev/competition'); ?>
    </section>
    <section class="working-with-me">
        <?php get_template_part( 'template-parts/landing/dev/working-with-me'); ?>
    </section>
    <section class="cost">
        <?php get_template_part( 'template-parts/landing/dev/cost'); ?>
    </section>
    <section class="process">
        <?php get_template_part( 'template-parts/landing/dev/process'); ?>
    </section>

</main>

<?php get_template_part( 'template-parts/modal', 'contact' ); ?>
<?php get_footer( 'landing' ); ?>

<script> console.log( 'wp-template: landing-page.php' );</script>
