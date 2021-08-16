<!--
The template for displaying all single posts
https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
-->

<?php get_header(); ?>


<main class="base"> <?php //MAIN CONTENT COLUMN ?>
    
    <section class="sauce">
        <div class="cheese">


            <h1 id="title" class="cheese_h1 cheese_title">
              Single.php
            </h1>



            <?php
                if ( have_posts() ) :
                    while ( have_posts() ) : the_post();
                    get_template_part( 'content-single', get_post_format() );
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    endwhile;
                endif;
            ?>
        </div>
    </section>
</main> <?php //MAIN CONTENT COLUMN END ?>


<div class="sides-narrow">
    <?php get_sidebar( 'left' ); ?>
    <?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
