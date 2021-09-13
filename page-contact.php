<?php get_header(); ?>



<main class="base"> <?php //MAIN CONTENT COLUMN ?>

    <section class="sauce">
       <div class="cheese">
          <a id="need_help">
            <h1 class="cheese_h1 cheese_title">Learn How to Develop Your Business Online</h1>
          </a>
          <a id="contact_form">
            <p class="cheese_p">Fill out the form below and I'll be in touch shortly.</p>
          </a>
       </div>
    </section>

    <section class="sauce">
        <?php echo do_shortcode('[xocontactform title="This is a test form" message="This is a test message"]'); ?>
    </section>

</main> <?php //MAIN CONTENT COLUMN END ?>

<div class="sides-narrow">
    <!-- LEFT SIDEBAR -->
    <?php get_sidebar( 'left' ); ?>
    <!-- RIGHT SIDEBAR -->
    <?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
<!-- template: page-contact.php -->