<?php
/**
 * Herringbone Theme Template File - Front Page.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

get_header();
//enqueue styles and scripts
wp_enqueue_style( 'hb_landdev_css' );
wp_enqueue_script( 'hb_modal_js' );
wp_enqueue_script( 'hb_hideheader_js' );
?>

<main class="main mex">
    <section class="welcome">
        <?php get_template_part( 'template-parts/landing/dev/welcome' ); ?>
    </section>
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


    <section class="product">
        <?php get_template_part( 'template-parts/landing/dev/product'); ?>
    </section>
    <section class="tickle">
        <?php get_template_part( 'template-parts/landing/dev/tickle'); ?>
    </section>
    <section class="usp">
        <?php get_template_part( 'template-parts/landing/dev/usp'); ?>
    </section>

</main>


<?php
/* Contact form modal */
get_template_part( 'template-parts/modal', 'contact' );
get_footer();
