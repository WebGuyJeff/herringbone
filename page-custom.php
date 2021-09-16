<?php
//namespace Herringbone;

get_header();
?>


<main class="base"> <?php //MAIN CONTENT COLUMN ?>
	<section class="sauce">


		<h1 id="title" class="cheese_h1 cheese_title">
		  Page-custom.php
		</h1>


		<?php
			$args =  array(
				'post_type' => 'my-custom-post',
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);
			$custom_query = new WP_Query( $args );
			while ($custom_query->have_posts()) : $custom_query->the_post(); ?>

			<div class="blog-post">

				<h1 class="blog-post-title">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h1>

				<?php the_excerpt(); ?>

			</div>
		<?php endwhile; ?>
	</section>
</main> <?php //MAIN CONTENT COLUMN END ?>


<div class="sides-narrow">
	<?php get_sidebar( 'left' ); ?>
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
<!-- template: page-custom.php -->