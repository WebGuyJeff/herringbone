<?php

/**
 * landing-business entry.php
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

?>

<main class="main-landing">

    <section class="problem">
        <?php get_template_part( 'views/landing-business/parts/problem'); ?>
    </section>
    <section class="solution">
        <?php get_template_part( 'views/landing-business/parts/solution'); ?>
    </section>
    <section class="target-market">
        <?php get_template_part( 'views/landing-business/parts/target-market'); ?>
    </section>
    <section class="competition">
        <?php get_template_part( 'views/landing-business/parts/competition'); ?>
    </section>
    <section class="working-with-me">
        <?php get_template_part( 'views/landing-business/parts/working-with-me'); ?>
    </section>
    <section class="cost">
        <?php get_template_part( 'views/landing-business/parts/cost'); ?>
    </section>
    <section class="process">
        <?php get_template_part( 'views/landing-business/parts/process'); ?>
    </section>

</main>

<?php get_template_part( 'template-parts/modal', 'contact' ); ?>