<?php

/**
 * Herringbone Theme Template - Single.php
 * 
 * This template is used for single post types and should be able to handle the following:
 * 
 * - Include wp_link_pages() to support navigation links within a post.
 * - Display post title and post content.
 *     ~ The title should be plain text instead of a link pointing to itself.
 * - Display the post date.
 *     ~ Respect the date and time format settings unless it's important to the design.
 *       (User settings for date and time format are in Administration Panels > Settings > General).
 *     ~ For output based on the user setting, use the_time( get_option( 'date_format' ) ).
 * - Display the author name (if appropriate).
 * - Display post categories and post tags.
 * - Display an "Edit" link for logged-in users with edit permissions.
 * - Display comment list and comment form (if turned on).
 * - Show navigation links to next and previous post using previous_post_link() and next_post_link().
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

get_header();
?>

<main class="main">

	<div class="base"> <?php //MAIN CONTENT COLUMN ?>
		
		<section class="sauce">
			<div >


				<h1 id="title" >
				Single.php
				</h1>



				<?php
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content-single', get_post_format() );
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						endwhile;
					endif;
				?>
			</div>
		</section>
	</div> <?php //MAIN CONTENT COLUMN END ?>

	<div class="sides-narrow">
		<?php get_sidebar( 'left' ); ?>
		<?php get_sidebar( 'right' ); ?>
	</div>

</main>

<?php get_footer(); ?>
<script> console.log( 'wp-template: single.php' );</script>