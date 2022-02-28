<?php

/**
 * Template Name: Landing Page
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

 
// wp_enqueue WARNING: does not work at this template level!


get_header( 'landing' );
get_template_part( 'views/landing-developer/entry' );
get_footer( 'landing' );

?>

<!--<script> console.log( 'wp-template: landing-page.php' );</script>-->
