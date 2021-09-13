<div class="blog-post">

	<h1 id="title" class="cheese_h1 cheese_title">
	  Content.php
	</h1>

  	<h2 class="blog-post-title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>

  	<p class="blog-post-meta">

		<?php the_date(); ?>
			by
		<a href="#">
			<?php the_author(); ?>
		</a>
		<a href="<?php comments_link(); ?>">
		  	<?php printf( _nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'textdomain' ), number_format_i18n( get_comments_number() ) ); ?>
		</a>

	</p>

	<!-- Display the featured image if present -->
	<?php if ( has_post_thumbnail() ) {?>
		<div class="row">
			<div class="col-md-4">
				<a href="<?php the_permalink(); ?>">
					<?php	the_post_thumbnail('thumbnail'); ?>
				</a>
			</div>
			<div class="col-md-6">
				<?php the_excerpt(); ?>
			</div>
		</div>
	<?php } else { ?>
		<?php the_excerpt(); ?>
	<?php } ?>

</div><!-- /.blog-post -->
<!-- template: content.php -->