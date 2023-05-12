<?php


/**
 * Herringbone Theme Template Part - Dev Landing Page USP Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

$theme = get_option( 'hb_dev_landing_settings' );

$cacti_complete = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_complete.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_complete.svg' ) )
	: '<h3>Complete Solution</h3>';

$cacti_personal = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_personal.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_personal.svg' ) )
	: '<h3>Personal Service</h3>';

$cacti_flexibility = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_flexibility.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_flexibility.svg' ) )
	: '<h3>Flexibility</h3>';

$cacti_experience = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_experience.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_experience.svg' ) )
	: '<h3>Experience</h3>';

$cacti_value = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_value.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_value.svg' ) )
	: '<h3>Value for Money</h3>';

$cacti_aftercare = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_aftercare.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_aftercare.svg' ) )
	: '<h3>Aftercare</h3>';

$cacti_shadow = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/cacti_shadow.svg' ) )
	: '';

$cacti_wall = ( file_exists( get_theme_file_path( 'imagery/usp_cacti/wall.svg' ) ) )
	? file_get_contents( get_theme_file_path( 'imagery/usp_cacti/wall.svg' ) )
	: '';

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
			<div class="usp_cactiBox" title="Complete Start to Finish Website Solution">
				<span class="screen-reader-text">
					Complete Start to Finish Website Solution
				</span>
				<?php echo $cacti_complete; ?>
			</div>
			<?php echo $cacti_shadow; ?>
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
			<div class="usp_cactiBox" title="Personal Service from a Dedicated Professional">
				<span class="screen-reader-text">
					Personal Service from a Dedicated Professional
				</span>
				<?php echo $cacti_personal; ?>
			</div>
			<?php echo $cacti_shadow; ?>
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
			<div class="usp_cactiBox" title="Flexible to Fit Your Working Style">
				<span class="screen-reader-text">
					Flexible to Fit Your Working Style
				</span>
				<?php echo $cacti_flexibility; ?>
			</div>
			<?php echo $cacti_shadow; ?>
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
			<div class="usp_cactiBox" title="Diverse Experience">
				<span class="screen-reader-text">
					Diverse Experience
				</span>
				<?php echo $cacti_experience; ?>
			</div>
			<?php echo $cacti_shadow; ?>
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
			<div class="usp_cactiBox" title="Value for Money">
				<span class="screen-reader-text">
					Value for Money
				</span>
				<?php echo $cacti_value; ?>
			</div>
			<?php echo $cacti_shadow; ?>
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
			<div class="usp_cactiBox" title="Aftercare and Support">
				<span class="screen-reader-text">
					Aftercare and Support
				</span>
				<?php echo $cacti_aftercare; ?>
			</div>
			<?php echo $cacti_shadow; ?>
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
	<?php echo $cacti_wall; ?>
</div>
