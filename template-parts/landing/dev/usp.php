<?php


/**
 * Herringbone Theme Template Part - Dev Landing Page USP Section.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

//enqueue script for the usp checkbox and autoscroll
wp_enqueue_script( 'hb_usp_js' );
?>


<div class="landing_content cheese" style="--row: 1 / -1; --col: full-l / full-r;">

	<input type="checkbox" checked class="usp_state" id="usp_default">
	<div class="usp_card">
		<div class="usp_blurb">
			<div class="column">
				<h2 class="usp_title">Working With Me</h2>
				<p>
					There are many benefits to working with me, not least becauase it's just easy.
					Whether you're an established team looking for support from a developer or a
					solo-entrepenear bewildered by the confusing website market, I'm here to help.
				</p>
				<span class="usp_instruction">Tap a cactus to learn more</span>
			</div>
		</div>
		<label for="usp_default" class="usp_button green">Learn More</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_complete" />
	<div class="usp_card" style="--grid_area: a;">
		<label for="usp_complete" onclick="toggleCheckboxes('usp_state');" style="--grid_area: a;" class="usp_graphicWrap">
			<div class="usp_playerSelect"></div>
			<div class="usp_perspective">
				<img
					class="usp_cacti"
					alt="Complete Start to Finish Website Solution"
					title="Complete Start to Finish Website Solution"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_complete.svg'; ?>"
				>
			</div>
			<div class="usp_cactiShadow"></div>
		</label>
		<div class="usp_blurb">
			<div class="column">
				<h3 class="usp_subtitle">Complete Solution</h3>
				<p>
					By adapting a development model I adopted in high street retail and eCommerce, I
					provide a resourceful and complete solution to web development. I drive projects
					from conception to completion, from research and design to development and
					deployment and even provide hosting and support.
				</p>
			</div>
		</div>
		<label for="usp_complete" class="usp_button red">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_personal" />
	<div class="usp_card" style="--grid_area: b;">
		<label for="usp_personal" onclick="toggleCheckboxes('usp_state');" class="usp_graphicWrap">
			<div class="usp_playerSelect"></div>
			<div class="usp_perspective">
				<img
					class="usp_cacti"
					alt="Personal Service from a Dedicated Professional"
					title="Personal Service from a Dedicated Professional"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_personal.svg'; ?>"
				>
			</div>
			<div class="usp_cactiShadow"></div>
		</label>
		<div class="usp_blurb">
			<div class="column">
				<h3 class="usp_subtitle">Personal Service</h3>
				<p>
					I'll always be your direct point of contact, and getting to know you means we
					collaborate in a style that works best. The wonderful thing about people is
					we're all different. I aim to accommodate all and love learning about individual
					requirements, so I approach every challenge with your perspective in mind. I
					don't believe one size fits all, so I build bespoke solutions from the ground up
					wherever it adds value to your brand.
				</p>
			</div>
		</div>
		<label for="usp_personal" class="usp_button red">Back</label>
	</div>





	<input type="checkbox" class="usp_state" id="usp_flexibility" />
	<div class="usp_card" style="--grid_area: c;">
		<label for="usp_flexibility" onclick="toggleCheckboxes('usp_state');" class="usp_graphicWrap">
			<div class="usp_playerSelect"></div>
			<div class="usp_perspective">
				<img
					class="usp_cacti"
					alt="Flexible to Fit Your Working Style"
					title="Flexible to Fit Your Working Style"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_flexibility.svg'; ?>"
				>
			</div>
			<div class="usp_cactiShadow"></div>
		</label>
		<div class="usp_blurb">
			<div class="column">
				<h3 class="usp_subtitle">Flexibility</h3>
				<p>
					As an experienced project manager, I foresee opportunities for improvement early
					on. Being an independent developer, I adapt quickly without the delay of
					meetings and sign-offs between teams. Your budget gets used efficiently, and I
					have the insight to provide solutions and keep milestones on target when running
					large projects.
				</p>
			</div>
		</div>
		<label for="usp_flexibility" class="usp_button red">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_experience" />
	<div class="usp_card" style="--grid_area: d;">
		<label for="usp_experience" onclick="toggleCheckboxes('usp_state');" class="usp_graphicWrap">
			<div class="usp_playerSelect"></div>
			<div class="usp_perspective">
				<img
					class="usp_cacti"
					alt="Diverse Experience"
					title="Diverse Experience"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_experience.svg'; ?>"
				>
			</div>
			<div class="usp_cactiShadow"></div>
		</label>
		<div class="usp_blurb">
			<div class="column">
				<h3 class="usp_subtitle">Experience</h3>
				<p>
					I've worked most roles in eCommerce, including being on the front line with
					customers, so I know first-hand the problems site owners and users face. Having
					a diverse development skillset means I know immediately what is possible and how
					best to apply your budget. My solutions are focused on the best outcome for all
					involved, keeping your customers happy and your business profitable.
				</p>
			</div>
		</div>
		<label for="usp_experience" class="usp_button red">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_value" />
	<div class="usp_card" style="--grid_area: e;">
		<label for="usp_value" onclick="toggleCheckboxes('usp_state');" class="usp_graphicWrap">
			<div class="usp_playerSelect"></div>
			<div class="usp_perspective">
				<img
					class="usp_cacti"
					alt="Value for Money"
					title="Value for Money"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_value.svg'; ?>"
				>
			</div>
			<div class="usp_cactiShadow"></div>
		</label>
		<div class="usp_blurb">
			<div class="column">
				<h3 class="usp_subtitle">Value For Money</h3>
				<p>
					I code everything as if it were my own, following strict standards to ensure
					longevity and adaptability as your needs grow. Your website is an investment in
					your brand, and your audience will judge your credibility on it. I make sure
					your budget works hard to set you aside from the crowd, and with less spent on
					web agency overheads, there's more to put to work.
				</p>
			</div>
		</div>
		<label for="usp_value" class="usp_button red">Back</label>
	</div>


	<input type="checkbox" class="usp_state" id="usp_aftercare" />
	<div class="usp_card" style="--grid_area: f;">
		<label for="usp_aftercare" onclick="toggleCheckboxes('usp_state');" class="usp_graphicWrap">
			<div class="usp_playerSelect"></div>
			<div class="usp_perspective">
				<img
					class="usp_cacti"
					alt="Aftercare and Support"
					title="Aftercare and Support"
					src="<?php echo get_template_directory_uri() . '/imagery/usp_cacti/cacti_aftercare.svg'; ?>"
				>
			</div>
			<div class="usp_cactiShadow"></div>
		</label>
		<div class="usp_blurb">
			<div class="column">
				<h3 class="usp_subtitle">Aftercare</h3>
				<p>
					I see my projects through for the long journey ahead, providing dedicated
					website hosting and technical support. I provide training and documentation
					where needed and perform ongoing maintenance to keep your website current. Part
					of that maintenance is keeping your website up to date with the latest
					technologies for optimum performance and security. It also means your website
					remains easily adaptable and compatible with add-on functionality, even if you
					decide to work with other developers.
				</p>
			</div>
		</div>
		<label for="usp_aftercare" class="usp_button red">Back</label>
	</div>
</div>


<div class="landing_backdrop">
	<img class="usp_wall" alt="SVG background image of rustic spanish bricks in a simple cartoon style" src="<?php echo get_bloginfo('template_url') ?>/imagery/usp_cacti/wall.svg"/>
</div>
