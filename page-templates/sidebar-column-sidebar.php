<?php
/**
 * Template Name: Sidebar-Column-Sidebar
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

get_header(); ?>

<main class="base">


	<?php
	if ( have_posts() ) :

		if ( is_home() && ! is_front_page() ) :
			?>
			<header>
				<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
			</header>
			<?php
		endif;

		/* Start the Loop */
		while ( have_posts() ) :
			the_post();

			/*
			 * Include the Post-Type-specific template for the content.
			 * If you want to override this in a child theme, then include a file
			 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
			 */
			get_template_part( 'template-parts/content', get_post_type() );

		endwhile;

		the_posts_navigation();

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>


</main>

<div class="sides-narrow">
	<?php get_sidebar( 'left' ); ?>
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
<!-- template: sidebar-column-sidebar.php -->
