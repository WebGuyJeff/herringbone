<?php


get_header();
?>


<main class="base"> <?php //MAIN CONTENT COLUMN ?>

<section class="sauce">
	<div class="cheese">

		<h1 id="title" class="cheese_h1 cheese_title">
		  Index.php
		</h1>

	</div>
</section>

<section class="sauce">
	<div class="cheese">

		<?php
			if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
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

</main> <?php //MAIN CONTENT COLUMN END ?>

<div class="sides-narrow">
	<?php get_sidebar( 'left' ); ?>
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
<!-- template: index.php -->