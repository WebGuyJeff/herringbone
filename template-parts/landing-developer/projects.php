<?php
/**
 * Herringbone Theme Template Part - Dev Landing Page Project Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

?>

<div class="landing_content" style="--row: 1 / -1; --col: full-l / full-r;">

	<div class="copy">
		<h2 class="title">
			Projects
		</h2>
		<p>
			Here are some of my projects.
		</p>
	</div>

	<div class="masonFlop">

		<?php
		$args = array(
			'post_type'      => 'project',
			'posts_per_page' => -1,
			'order'          => 'ASC',
		);

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
				$custom_fields = get_post_custom();
				$post_tags     = get_the_tags();

				?>

				<article id="<?php echo esc_attr( sanitize_title_with_dashes( the_title( '', '', false ) ) ); ?>" class="masonFlop_card">
					<div class="masonFlop_content-left">
						<figure>
							<?php
							if ( get_the_post_thumbnail() ) :
								the_post_thumbnail();
							endif;
							?>
						</figure>
					</div>
					<div class="masonFlop_content-right">
						<div class="copy">

							<h3 class="masonFlop_heading">
								<?php the_title(); ?>
							</h3>
							<span class="masonFlop_moustache">
								<?php echo esc_html( wp_strip_all_tags( get_the_category_list( ', ' ) ) ); ?>
							</span>
							<p>
								<?php the_excerpt(); ?>
							</p>

							<?php if ( $post_tags ) : ?>
								<ul class="tagCloud">
								<?php foreach ( $post_tags as $post_tag ) : ?>
									<li><?php echo $post_tag->name; ?></li>
								<?php endforeach ?>
								</ul>
							<?php endif ?>

							<?php if ( $custom_fields['_hbpr__project_url'] ) : ?>
							<a href="<?php echo esc_url( $custom_fields['_hbpr__project_url'][0] ); ?>" class="button button-border">
								<span>
									View Project
								</span>
							</a>
							<?php endif ?>

							<?php if ( $custom_fields['_hbpr__repository_url'] ) : ?>
							<a href="<?php echo esc_url( $custom_fields['_hbpr__repository_url'][0] ); ?>" class="button button-border">
								<span>
									Visit Repository
								</span>
							</a>
							<?php endif ?>

						</div>
					</div>
				</article>

				<?php

			endwhile;
			wp_reset_postdata();
		endif;
		?>

	</div>
</div>

<div class="landing_backdrop"></div>
