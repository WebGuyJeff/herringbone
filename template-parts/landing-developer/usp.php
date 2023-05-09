<?php


/**
 * Herringbone Theme Template Part - Dev Landing Page USP Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

$theme = get_option( 'hb_dev_landing_settings' );
?>

<div class="landing_content " style="--row: 1 / -1; --col: full-l / full-r;">

	<input type="checkbox" checked class="usp_state" id="usp_default">
	<div class="usp_card">
		<div class="usp_blurb">
			<div class="copy">
				<h2 class="usp_title">
					<?php echo esc_html( ( $theme['usp_title'] ) ? $theme['usp_title'] : 'Working With Me' ); ?>
				</h2>

				<?php if ( $theme['usp_intro'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp_intro'] ); ?>
				</p>
				<?php endif ?>

				<span class="usp_instruction">Tap a cactus to learn more</span>
			</div>
		</div>
		<label for="usp_default" class="usp_button green" role="button">Learn More</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_complete" />
	<div class="usp_card" style="--grid_area: a;">
		<label for="usp_complete" style="--grid_area: a;" class="usp_graphicWrap" role="button">
			<?php get_template_part( 'views/landing-developer/parts/plumbob' ); ?>
			<div class="usp_cactiBox">
				<img
					class="usp_cacti"
					alt="Complete Start to Finish Website Solution"
					title="Complete Start to Finish Website Solution"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_complete.svg'; ?>"
				>
			</div>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ); ?>
		</label>
		<div class="usp_blurb">
			<div class="copy">
				<h3 class="usp_subtitle">Complete Solution</h3>

				<?php if ( $theme['usp1_text'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp1_text'] ); ?>
				</p>
				<?php endif ?>

			</div>
		</div>
		<label for="usp_complete" class="usp_button red" role="button">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_personal" />
	<div class="usp_card" style="--grid_area: b;">
		<label for="usp_personal" class="usp_graphicWrap" role="button">
			<?php get_template_part( 'views/landing-developer/parts/plumbob' ); ?>
			<div class="usp_cactiBox">
				<img
					class="usp_cacti"
					alt="Personal Service from a Dedicated Professional"
					title="Personal Service from a Dedicated Professional"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_personal.svg'; ?>"
				>
			</div>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ); ?>
		</label>
		<div class="usp_blurb">
			<div class="copy">
				<h3 class="usp_subtitle">Personal Service</h3>

				<?php if ( $theme['usp2_text'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp2_text'] ); ?>
				</p>
				<?php endif ?>

			</div>
		</div>
		<label for="usp_personal" class="usp_button red" role="button">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_flexibility" />
	<div class="usp_card" style="--grid_area: c;">
		<label for="usp_flexibility" class="usp_graphicWrap" role="button">
			<?php get_template_part( 'views/landing-developer/parts/plumbob' ); ?>
			<div class="usp_cactiBox">
				<img
					class="usp_cacti"
					alt="Flexible to Fit Your Working Style"
					title="Flexible to Fit Your Working Style"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_flexibility.svg'; ?>"
				>
			</div>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ); ?>
		</label>
		<div class="usp_blurb">
			<div class="copy">
				<h3 class="usp_subtitle">Flexibility</h3>

				<?php if ( $theme['usp3_text'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp3_text'] ); ?>
				</p>
				<?php endif ?>

			</div>
		</div>
		<label for="usp_flexibility" class="usp_button red" role="button">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_experience" />
	<div class="usp_card" style="--grid_area: d;">
		<label for="usp_experience" class="usp_graphicWrap" role="button">
			<?php get_template_part( 'views/landing-developer/parts/plumbob' ); ?>
			<div class="usp_cactiBox">
				<img
					class="usp_cacti"
					alt="Diverse Experience"
					title="Diverse Experience"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_experience.svg'; ?>"
				>
			</div>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ); ?>
		</label>
		<div class="usp_blurb">
			<div class="copy">
				<h3 class="usp_subtitle">Experience</h3>

				<?php if ( $theme['usp4_text'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp4_text'] ); ?>
				</p>
				<?php endif ?>

			</div>
		</div>
		<label for="usp_experience" class="usp_button red" role="button">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_value" />
	<div class="usp_card" style="--grid_area: e;">
		<label for="usp_value" class="usp_graphicWrap" role="button">
			<?php get_template_part( 'views/landing-developer/parts/plumbob' ); ?>
			<div class="usp_cactiBox">
				<img
					class="usp_cacti"
					alt="Value for Money"
					title="Value for Money"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_value.svg'; ?>"
				>
			</div>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ); ?>
		</label>
		<div class="usp_blurb">
			<div class="copy">
				<h3 class="usp_subtitle">Value For Money</h3>

				<?php if ( $theme['usp5_text'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp5_text'] ); ?>
				</p>
				<?php endif ?>

			</div>
		</div>
		<label for="usp_value" class="usp_button red" role="button">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_aftercare" />
	<div class="usp_card" style="--grid_area: f;">
		<label for="usp_aftercare" class="usp_graphicWrap" role="button">
			<?php get_template_part( 'views/landing-developer/parts/plumbob' ); ?>
			<div class="usp_cactiBox">
				<img
					class="usp_cacti"
					alt="Aftercare and Support"
					title="Aftercare and Support"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_aftercare.svg'; ?>"
				>
			</div>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ); ?>
		</label>
		<div class="usp_blurb">
			<div class="copy">
				<h3 class="usp_subtitle">Aftercare</h3>

				<?php if ( $theme['usp6_text'] ) : ?>
				<p>
					<?php echo esc_html( $theme['usp6_text'] ); ?>
				</p>
				<?php endif ?>

			</div>
		</div>
		<label for="usp_aftercare" class="usp_button red" role="button">Back</label>
	</div>
</div>


<div class="landing_backdrop">
	<img class="usp_wall" alt="SVG background image of rustic spanish bricks in a simple cartoon style" src="<?php echo get_bloginfo('template_url') ?>/imagery/usp_cacti/wall.svg"/>
</div>
