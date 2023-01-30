<?php


/**
 * Herringbone Theme Template Part - Dev Landing Page - Welcome Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */
?>

<div class="landing_content" style="--row: 1 / -1; --col: narrow-l / narrow-r;">
	<div class="chalkboard ">

		<div class="chalkboard_pinChalkboardTop">
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/grabhand-left.svg' ) ); ?>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/grabhand-right.svg' ) ); ?>
		</div>

		<div class="copy">

			<h1 class="chalkboard_title title">
				Hi I’m Jeff, a
				<span class="title-hype">
					Web Developer
				</span>
			</h1>

			<p>
				I help businesses, individuals and start-ups by providing website
				development and website design services. I'm a complete one-man web
				design company delivering more punch per pound and a higher
				attention to detail. With my own planet-friendly web hosting
				service, I also look after you on the road ahead with one-to-one web
				support.
			</p>

			<h2 class="chalkboard_cta">
				Need Website Help?
			</h2>

			<p>
				I’m available to discuss, plan and quote for your project and
				my advice is always free! I’m based in Hampshire (South UK) but only
				one Zoom call away from being anywhere in the world.
			</p>

			<div class="textAlignCenter">
				<button
					aria-label="Send Me a Message"
					title="Send Me a Message"
					type="button"
					id="modal_contactForm"
					class="button aligncenter modal_control-open"
				>
					<span>
						Message Me
					</span>
				</button>
			</div>
		</div>
	</div>
	<div class="chalkboard_pinChalkboardRight">
		<div class="svg_dimensionsBox">
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/me.svg' ) ); ?>
		</div>
	</div>
</div>
<div class="landing_backdrop">
	<?php
		echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-fills.svg' ) );
		echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/sun.svg' ) );
		echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/clouds.svg' ) );
	?>
	<div class="desert_terrain">
		<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-sand.svg' ) ); ?>
		<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-furniture.svg' ) ); ?>
	</div>
</div>
