<?php
/**
 * Template part for displaying a single post and used by single.php.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

namespace Jefferson\Herringbone;

?>

<article class="sauce">
	<div class="blog-post ">

		<h1 id="title" >
		Content-single.php
		</h1>

		<!-- If the post has a featured image, display it -->
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail();
		}
		?>

		<h2 class="blog-post-title">
			<?php the_title(); ?>
		</h2>

		<p class="blog-post-meta">
			<?php the_date(); ?> by <a href="#"><?php the_author(); ?></a>
		</p>

		<?php the_content(); ?>

	</div><!-- /.blog-post -->
</article>

<!--<script> console.log( 'wp-template: content-single.php' );</script>-->
