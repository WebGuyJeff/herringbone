<?php
/**
 * Herringbone Theme Template File - Front Page.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */
 ?>

<aside id="modal_contactform-overlay" class="modal">
    <div id="modal_contactform-dialog" role="dialog" aria-labelledby="aria_form-title" aria-describedby="aria_form-desc" class="modal_dialog sauce cheese">
        <button aria-label="Close Contact Form" title="Close Contact Form" type="button" id="modal_contactform-close" class="modal_close">
            Close
        </button>
        <?php echo do_shortcode('[xocontactform title="Let&apos;s Get Your Project Started" message="Complete the form below and I&apos;ll get back to you shortly - Jeff"]'); ?>
    </div>
</aside>
