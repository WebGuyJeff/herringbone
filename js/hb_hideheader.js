/**
 * Herrinbone Hide-Header Javascript
 *
 * A function to hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

gsap.registerPlugin( CSSRulePlugin );

var hb_header = (function() {

	//Get the elements being animated
	let header = document.querySelector( '.header' );
	let backdrop = document.querySelector( 'body > main > section:first-child > .landing_backdrop' );

	//This function calculates the new position values for the animation
	function getHeaderHeight() {

		// Get the header height
		let headerFontSize = window.getComputedStyle( header ).fontSize;
		let headerHeight = parseFloat( window.getComputedStyle( header ).height );

		// We use the element font size to convert the values to em units
		let headerHeightEm = ( parseFloat( headerHeight ) / parseFloat( headerFontSize )).toFixed(2);

		return headerHeightEm;
	}

	let isAnimating = false;
	let isToggled = false;
	let newHeaderMargTop;
	let btnOffset;
	let heightEm;

	return {
		toggle: function() {

			// Check if the header is already toggled and supply vars to invert the state
			// We update variables every toggle as layout may have changed
			if ( !isAnimating ) {
				isAnimating = true;
				if ( isToggled ) {
					isToggled = false;
					bodyClassToggle();
					heightEm		  = getHeaderHeight();
					newHeaderMargTop  = -Math.abs(heightEm) + 'em';
					newSectionMargTop = '0em';
					btnOffset		  = '0em';
					animate();
				} else {
					isToggled = true;
					bodyClassToggle();
					heightEm	      = getHeaderHeight();
					newHeaderMargTop  = '0em';
					newSectionMargTop = -Math.abs(heightEm) + 'em';
					btnOffset		  = -Math.abs( heightEm ) + 'em';
					animate();
				}
			}
		},
	};

	// Move the elements! - GSAP v3 CSSRule Plugin
	function animate() {
		let headerHide = gsap.timeline( {
			defaults: {
				duration:1,
				ease:"elastic.out( 1,0.8 )"
			},
			force3D:true,
			onComplete:isAnimatingToggleFalse,
		});
			headerHide.to( ".header", { marginTop:newHeaderMargTop }, 0 )
					  .to( ".headerToggle", { y:btnOffset }, 0 )
					  .to( backdrop, { marginTop:newSectionMargTop }, 0 )
	}

	// Do nothing if animation is already in progress
	function isAnimatingToggleFalse() {
		isAnimating = false;
	}

	// Add a classname to the body element when header is active
	function bodyClassToggle() {
		let body = document.querySelector( 'body' );
		if ( isToggled ) {
			body.classList.add( "header_active" );
		} else {
			body.classList.remove( "header_active" );
		}
	}

})();
