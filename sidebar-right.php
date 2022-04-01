<?php


/**
 * Herringbone Theme Template File - Right Sidebar.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */
?>

<aside class="sides">

	<?php if ( is_active_sidebar( 'sidebar-right' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-right' ); ?>
	<?php else : ?>
		<!-- Time to add some widgets! -->
	<?php endif; ?>

</aside>
