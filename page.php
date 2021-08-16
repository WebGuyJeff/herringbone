<?php get_header(); ?>


<main class="base"> <?php //MAIN CONTENT COLUMN ?>
	<section class="sauce">

        <h1 id="title" class="cheese_h1 cheese_title">
          Page.php
        </h1>

  		<nav class="blog-nav">
    			<a class="blog-nav-item active" href="<?php echo home_url();?>">Home</a>
    			<?php wp_list_pages( '&title_li=' ); ?>
  		</nav>
	</div>

    <div class="sauce">
        <?php
            if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                    get_template_part( 'content', get_post_format() );
                endwhile;
            endif;
        ?>
    </section>
</main> <?php //MAIN CONTENT COLUMN END ?>

<div class="sides-narrow">
    <?php get_sidebar( 'left' ); ?>
    <?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
