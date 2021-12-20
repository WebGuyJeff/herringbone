<?php
/**
 * Herringbone Theme Template - Page.php
 * 
 * This template is used for static pages and should be able to handle the following:
 * 
 * - Display page title and page content.
 * - Display comment list and comment form (unless comments are off).
 * - Include wp_link_pages() to support navigation links within a page.
 * - Metadata such as tags, categories, date and author should not be displayed.
 * - Display an "Edit" link for logged-in users with edit permissions.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */


header("HTTP/1.0 404 Not Found");

get_header(); ?>

<main class="main">
	<div class="base">

		<section class="sauce">
			<div >
				<a id="page_not_found">
					<h1 class="title">Clang! 🤕</h1>
				</a>
				<span class="subtitle">Error 404</span>
				<p >homepage</a> or try the links below.</p>
			</div>
		</section>


	</div>

	<div class="sides-narrow">
		<?php get_sidebar( 'left' ); ?>
		<?php get_sidebar( 'right' ); ?>
	</div>

</main>


<?php get_footer(); ?>
<script> console.log( 'wp-template: 404.php' );</script>