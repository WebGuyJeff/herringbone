<?php


/**
 * Herringbone Theme Template File - Left Sidebar.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */
?>

<aside class="dip">

	<?php if ( is_active_sidebar( 'sidebar-left' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-left' ); ?>
	<?php else : ?>
		<!-- Time to add some widgets! -->
	<?php endif; ?>
	
</aside>
