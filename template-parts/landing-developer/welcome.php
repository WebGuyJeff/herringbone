<?php


/**
 * Herringbone Theme Template Part - Dev Landing Page - Welcome Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

$theme = get_option( 'hb_dev_landing_settings' );
?>

<div class="landing_content" style="--row: 1 / -1; --col: narrow-l / narrow-r;">
	<div class="chalkboard ">

		<div class="chalkboard_pinChalkboardTop">
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/grabhand-left.svg' ) ); ?>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/grabhand-right.svg' ) ); ?>
		</div>

		<div class="copy">

			<h1 class="chalkboard_title title">
				<?php echo esc_html( ( $theme['welcome_title'] ) ? $theme['welcome_title'] : get_bloginfo( 'name' ) ); ?>
			</h1>

			<?php if ( $theme['welcome_intro'] ) : ?>
			<p>
				<?php echo esc_html( $theme['welcome_intro'] ); ?>
			</p>
			<?php endif ?>

			<?php if ( $theme['welcome_cta_title'] ) : ?>
			<h2 class="chalkboard_cta">
				<?php echo esc_html( $theme['welcome_cta_title'] ); ?>
			</h2>
			<?php endif ?>

			<?php if ( $theme['welcome_cta_text'] ) : ?>
			<p>
				<?php echo esc_html( $theme['welcome_cta_text'] ); ?>
			</p>
			<?php endif ?>

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
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/meToon_idle.svg' ) ); ?>
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
