<?php

/**
 * Herringbone Theme Template File - Modal Contact Form.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

wp_enqueue_script( 'hb_modal_js' );

?>

<aside class="modal modal_contactForm">
	<div 
		role="dialog" 
		aria-labelledby="aria_form-title" 
		aria-describedby="aria_form-desc" 
		class="modal_dialog sauce "
	>
		<div class="modal_controls">
			<button 
				aria-label="Close Contact Form"
				title="Close Contact Form"
				type="button"
				class="modal_control-close"
			>
				Close
			</button>
		</div>
		<div class="modal_contents">
			<?php echo do_shortcode('[bigup_contact_form title="Let&apos;s Get Your Project Started" message="Complete the form below and I&apos;ll get back to you shortly - Jeff"]'); ?>

		</div>
	</div>
</aside>
