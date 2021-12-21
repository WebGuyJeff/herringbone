<?php


/**
 * Herringbone Theme Template Part - Dev Landing Page - Welcome Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */
?>

<div class="landing_content" style="--row: 1 / -1; --col: oneone-l / oneone-r;">
	<div class="chalkboard ">

        <div class="chalkboard_pinChalkboardTop">
            <?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/grabhand-left.svg' ) ); ?>
			<?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/grabhand-right.svg' ) ); ?>
        </div>

		<div class="column textAlignCenter">

			<h1 class="chalkboard_title title">
				Hi I’m Jeff, a
				<span class="title-hype">
					Web Developer
				</span>
			</h1>

			<p class="weight400">
				I help businesses, individuals and start-ups by providing website
				development and website design services. I'm a complete one-man web
				design company delivering more punch per pound and a higher
				attention to detail. With my own planet-friendly web hosting
				service, I also look after you on the road ahead with one-to-one web
				support.
			</p>

			<ul class="chalkboard_list" style="list-style:none; margin:1em 0; padding:0;">
				<li>
				<?php echo file_get_contents( get_theme_file_path( 'imagery/icons_services/icon-design.svg' ) ); ?>
					Web Design
				</li>
				<li>
				<?php echo file_get_contents( get_theme_file_path( 'imagery/icons_services/icon-develop.svg' ) ); ?>
					Web Development
				</li>
				<li>
				<?php echo file_get_contents( get_theme_file_path( 'imagery/icons_services/icon-hosting.svg' ) ); ?>
					Web Hosting
				</li>
				<li>
				<?php echo file_get_contents( get_theme_file_path( 'imagery/icons_services/icon-support.svg' ) ); ?>
					Support Plans
				</li>
				<li>
				<?php echo file_get_contents( get_theme_file_path( 'imagery/icons_services/icon-wordpress.svg' ) ); ?>
					WordPress Expert
				</li>
				<li>
				<?php echo file_get_contents( get_theme_file_path( 'imagery/icons_services/icon-cloud.svg' ) ); ?>
					Cloud Solutions
				</li>
			</ul>

			<h2 class="chalkboard_cta">
				Need Website Help?
			</h2>

			<p class="weight400">
				I’m available to discuss, plan and quote for your project and
				my advice is always free! I’m based in Hampshire (South UK) but only
				one Zoom call away from being anywhere in the world.
			</p>

			<button
				aria-label="Send Me a Message"
				title="Send Me a Message"
				type="button"
				id="modal_contactForm"
				class="button button-cta spinny aligncenter modal_control-open"
			>
				<span>
					Message Me
				</span>
			</button>

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
		echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/sun.svg' ) );
		echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/clouds.svg' ) );
	?>
	<div class="welcome_desert">
        <?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-scape.svg' ) ); ?>
        <?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-cactus.svg' ) ); ?>
        <?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-shrub.svg' ) ); ?>
        <svg class="desert_cactus" viewBox="0 0 244 404" fill="currentColor"><use href="#desert_cactus" /></svg>
        <svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <svg class="desert_cactus" viewBox="0 0 244 404" fill="currentColor"><use href="#desert_cactus" /></svg>
		<svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-pricklyPear.svg' ) ); ?>
		<svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
		<svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
        <svg class="desert_shrub" viewBox="0 0 124 154" fill="currentColor"><use href="#desert_shrub" /></svg>
	</div>

    <?php echo file_get_contents( get_theme_file_path( 'imagery/landing/dev/desert-fills.svg' ) ); ?>
</div>