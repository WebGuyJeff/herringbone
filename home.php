<?php

/**
 * Herringbone Theme Template - Home.php
 * 
 * This template is the default home page (unless set to a static page) and
 * forms the blog posts home page. When a static page is used as the site home
 * page, this template would normally be used, for example, as /blog.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

get_header();
?>

<main class="main">

	<div class="base"> <?php //MAIN CONTENT COLUMN ?>

		<section class="sauce">
			<div >

				<h1 id="title" >
				Home.php
				</h1>

			</div>
		</section>

		<section class="sauce">
			<div >
				<?php
					if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'template-parts/content', get_post_format() );
					endwhile;
				?>
				<nav>
					<ul class="pager">
						<li><?php next_posts_link( 'Previous' ); ?></li>
						<li><?php previous_posts_link( 'Next' ); ?></li>
					</ul>
				</nav>
				<?php
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
<!--<script> console.log( 'wp-template: home.php' );</script>-->