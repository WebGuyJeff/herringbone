<?php


get_header();
wp_enqueue_script('svgWheel_js');
?>


<main class="base"> <?php //MAIN CONTENT COLUMN ?>

  <section class="sauce">
	<div class="cheese">
	  <a id="who_is_jeff">
		<h1 class="cheese_h1 cheese_title">Who is Jefferson Real?</h1>
	  </a>
	  <p class="cheese_p">Jefferson is a creator of the internet, a website designer, developer and systems engineer. He enjoys helping small and medium businesses grow using innovative website development.</p>
	</div>
  </section>

  <section class="sauce">
	<div class="cheese">

	  <a id="my_problem">
		<h2 class="cheese_h2">My Problem With Websites</h2>
	  </a>

	  <p class="cheese_p">
		Before web dev, I had worked almost every position imaginable in e-commerce and those I didn’t, I
		had a hand in at some point.
		Having run customer fulfilment from every angle, I'd seen the good, the bad and the downright
		ugly of websites and their (sometimes tense) relationship with humans.
	  </p>
	  <p class="cheese_p">
		Things weren't always rosy behind closed curtains either; If I had a pound for every time I had a
		queue of staff at my desk with new website related grumbles...
	  </p>
	  <p class="cheese_p">
		These problems aren't retail-specific though; Confusing user interfaces and poorly implemented features
		are common across the spectrum, business and non-profit.
	  </p>
	  <p class="cheese_p">
		In my time working closely with website users and their problems, I found myself asking <i>why has
		nobody fixed this?</i> far too often.
	  </p>
	  <p class="cheese_p">
		Take this example:
	  </p>
	  <p class="cheese_p">
		Winter was on the approach and I was lacking in the cold weather Dept.
		I head over to my trusted clothing shop and start clicking away.
		I've used this retailer a few times before; The products are good and I feel safe sending my money their way.
		Sifting through the menu I trawl through the categories <i>'Knitwear'</i>, <i>'Accessories'</i>,
		<i>'Cold Weather Wear'</i> finally I find hats on the last page of a category labelled <i>'Seasonal'</i>.
	  </p>

	  <q class="cheese_blockquote">
		Why has nobody fixed this?
	  </q>

	  <p class="cheese_p">
		Perhaps I'm being a little pedantic, but I know if the hats were available under a category called "Hats", they'd
		already have my money and I'd have been happily on my way.
		Who knows? Maybe I'd have even had the shopping stamina to have added a few more things to the cart.
		A few more clicks and I've got my order placed.
		A couple of days pass and I get an email from the retailer:
	  </p>

	  <blockquote class="cheese_blockquote">
	  <p class="cheese_blockquote_p">
		Unfortunately, the following item(s) that you ordered are now out-of-stock. Although we try our best
		to maintain 100% accuracy with inventory, there are rare occasions where we experience an inventory error.
	  </p>
	  <p class="cheese_blockquote_p">
	  <cite class="cheese_footnotes">
		@Big Retailer's Response Email
	  </cite>
	  </p>
	  </blockquote>

	  <p class="cheese_p">
		My experience browsing their website wasn't great, their response time was casual at best and while I
		received an instant refund, I'm still no better off than I was two days ago.
	  </p>
	  <p class="cheese_p">
		Now I'm not a big complainer but when it comes to shopping, I like things easy. My only takeaway from this
		transaction is a negative impression that will likely be enough to persuade me to try elsewhere next time.
		That was a few years ago and I've not used them since. Not out of spite, I just prefer easy!
	  </p>

	  <p class="cheese_p">
		My point here is whether the problem is stock system technicalities or simple menu labelling semantics,
		both are equal hurdles to a users transaction and more importantly, the chance of repeat engagement.
	  </p>

	</div>
  </section>

  <section class="sauce">
	<div class="cheese">

	  <a id="my_mission">
		 <h2 class="cheese_h2">My Mission</h2>
	  </a>

	  <p class="cheese_p">
		Having served my time on the 'front line' the natural next step was to put myself in a position to
		implement the ideals that I wanted to see.
	  </p>

	  <p class="cheese_p">
		 I'm now on a mission having turned passion into purpose, making the world a little better piece by piece.
		 I build innovative, real-world user experiences by focusing on the simple, compelling and the functional.
	  </p>

	  <p class="cheese_p">
		 I favour websites that allow me to reach my goal efficiently and pleasurably and I try to carry that idea
		 with me in everything I develop. It’s about creating an experience that transforms users into
		 followers and customers into ambassadors.
	  </p>

	  <p class="cheese_p">
		 I often find solving problems is achieved by making bold decisions and I take pleasure in helping people
		 through that online journey.
	  </p>

	  <p class="cheese_p">
		 Above everything else, I love developing the web.
	  </p>

	</div>
  </section>

	<div class="animation_wrap animation_wrap-wheel">
		<h2 class="cheese_h2 animation_title">I Make Things</h2>
		<?php echo file_get_contents( get_theme_file_path( "animation/svgWheel/svgWheel.svg" )) ;?>
	</div>

</main> <?php //MAIN CONTENT COLUMN END ?>

<div class="sides-narrow">
	<!-- LEFT SIDEBAR -->
	<?php get_sidebar( 'left' ); ?>
	<!-- RIGHT SIDEBAR -->
	<?php get_sidebar( 'right' ); ?>
</div>

<?php get_footer(); ?>
<script> console.log( 'wp-template: page-about.php' );</script>