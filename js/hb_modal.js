/**
 * Herrinbone Modal Javascript
 *
 * A function to handle modal animation and mechanics.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */


 const hb_modalPlugin = (function() {


	/**
     * Setup the modal.
	 * 
	 * Attach button click listener to all modal buttons. The button
	 * ID will contain the class name of the modal type to open. This
	 * allows the launch_modal function to remain generic while having
	 * multiple modals in the same document. It also means you can
	 * have multiple buttons pointing to the same modal, or many modals
	 * and many buttons all initialised with this same function.
     * 
     */
    function modal_init() {
        document.querySelectorAll( '.modal_control-open' ).forEach( button_open => {
            button_open.addEventListener( 'click', launch_modal );
        } );
    };


	// Declare state flags.
	let animating = false; 	// true when animation is in progress.
	let active = false;		// true when modal is displayed.
	let mobile = true;	 	// true when screen width is less than 768px (48em).


	// Plugin-wide vars.
	let overlay;
	let dialog;
	let button_close;


	/**
	 * Open the model popup.
	 * 
	 */
	async function launch_modal( event ) {

		// Get the modal elements
		const modal_class = event.currentTarget.id;
		overlay = document.querySelector( '.' + modal_class );

		dialog = overlay.querySelector( '.modal_dialog' );
		button_close = overlay.querySelector( '.modal_control-close' );

		button_close.onclick = () => {
			closeModal();
		}

		// If a click event is not on dialog
		window.onclick = function( event ) {
			if ( dialog !== !event.target && !dialog.contains(event.target) ) {
				closeModal();
			}
		}

		await Promise.all( [
			set_modal_device_size(),
			get_scrollbar_width()
		] );
		openModal();
	}


	async function set_modal_device_size() {

		let pageWidth = parseInt( document.querySelector("html").getBoundingClientRect().width, 10 );

		if ( pageWidth <= 768 ) {
			mobile = true;
		} else {
			mobile = false;
		}

		if ( mobile && active && !animating ) {
			dialog.style.left = '0';
			dialog.style.transform = 'scale(1)';
			dialog.style.opacity = '1';
			overlay.style.display = 'contents';
			overlay.style.opacity = '1';

		} else if ( mobile && !active && !animating ) {
			dialog.style.left = '-768px';
			dialog.style.transform = 'scale(1)';
			dialog.style.opacity = '1';
			overlay.style.display = 'contents';
			overlay.style.opacity = '1';

		} else if ( !mobile && active && !animating ) {
			dialog.style.left = '0';
			dialog.style.transform = 'scale(1)';
			dialog.style.opacity = '1';
			overlay.style.display = 'flex';
			overlay.style.opacity = '1';

		} else if ( !mobile && !active && !animating ) {
			dialog.style.left = '0';
			dialog.style.transform = 'scale(0)';
			dialog.style.opacity = '0';
			overlay.style.display = 'none';
			overlay.style.opacity = '0';

		}
	}


	/**
	 * Restyle the modal on window resize.
	 * 
	 * This prepares the modal by switching between different device
	 * layouts as required. Without this check, there is an inconsistancy in
	 * transitions if for example, the modal is launched as 'desktop' then
	 * closed as 'mobile'.
	 * 
	 */
    function set_browser_resize_listener() {
        let resizeTimer;
        let resize_listener = ( event ) => {
            if ( resizeTimer !== null ) window.clearTimeout( resizeTimer );
            resizeTimer = window.setTimeout( function() {
                if ( !active ) {
                    window.removeEventListener( 'resize', resize_listener );
                    return;
                }
                set_modal_device_size();
            }, 20 );
        };
        window.addEventListener( 'resize', resize_listener );
    }


	// Open the modal
	async function openModal() {
		if ( !active && !animating ) {
			active = true;
			animating = true;
			disableScroll();
            set_browser_resize_listener();

			if ( mobile ) {
				dialog.style.left = '-768px';
				dialog.style.transform = 'scale(1)';
				dialog.style.opacity = '1';
				overlay.style.display = 'contents';
				overlay.style.opacity = '1';
				await hb_animationPlugin.animate( dialog, 'left', 'easeInOutCirc', -768, 0, 800);
				animating = false;

			} else {
				dialog.style.left = '0';
				dialog.style.transform = 'scale(0)';
				dialog.style.opacity = '0';
				overlay.style.display = 'flex';
				overlay.style.opacity = '0';
				fadeIn( overlay );
				await hb_animationPlugin.animate( dialog, 'scale', 'easeInOutCirc', 0, 1, 800);
				animating = false;
			}
		}
	}


	// Close the modal
	async function closeModal() {
		if ( active && !animating ) {
			active = false;
			animating = true;
			enableScroll();

			if ( mobile ) {
				dialog.style.left = '0';
				dialog.style.transform = 'scale(1)';
				dialog.style.opacity = '1';
				overlay.style.display = 'contents';
				overlay.style.opacity = '1';
				await hb_animationPlugin.animate( dialog, 'left', 'easeInOutCirc', 0, -768, 800);
				animating = false;

			} else {
				dialog.style.left = '0';
				dialog.style.transform = 'scale(1)';
				dialog.style.opacity = '1';
				overlay.style.display = 'flex';
				overlay.style.opacity = '1';
				fadeOut(overlay);
				await hb_animationPlugin.animate( dialog, 'scale', 'easeInOutCirc', 1, 0, 800);
				overlay.style.display = 'none';
				animating = false;
			}
		}
	}


	// Moody overlay - fadeout
	function fadeOut( overlay ) {
		let p = 100;  // 0.5 x 100 to escape floating point problem
		let animateFilterOut = setInterval( function() {
			if ( p <= 0 ){
				clearInterval( animateFilterOut );
			}
			overlay.style.opacity = p / 100;
			p -= 2; // 1 represents 0.01 in css output
		}, 16 ); // 10ms x 25 for 0.25sec animation
	}


	// Moody overlay - fadein
	function fadeIn( overlay ) {
		let p = 4;  // 0.01 x 100 to escape floating point problem
		let animateFilterIn = setInterval( function() {
			if ( p >= 100 ){ // 100 (/100) represents 0.5 in css output
				clearInterval( animateFilterIn );
			}
			overlay.style.opacity = p / 100;
			p += 2; // 1 represents 0.01 in css output
		}, 16 ); // 10ms x 25 for 0.25sec animation
	}


	let scrollbarWidth;
	async function get_scrollbar_width() {
		// Get window width inc scrollbar
		const widthWithScrollBar = window.innerWidth;
		// Get window width exc scrollbar
		const widthWithoutScrollBar = document.querySelector( "html" ).getBoundingClientRect().width;
		// Calc the scrollbar width
		scrollbarWidth = parseInt( (widthWithScrollBar - widthWithoutScrollBar), 10 ) + 'px';
		return scrollbarWidth;
	}


	function disableScroll() {
		// Cover the missing scrollbar gap with a black div
		let elemExists = document.getElementById( "js_psuedoScrollBar" );

		if ( elemExists !== null ) {
			document.getElementById( "js_psuedoScrollBar" ).style.display = 'block';
		} else {
			let psuedoScrollBar = document.createElement( "div" );
			psuedoScrollBar.setAttribute( "id", "js_psuedoScrollBar" );
			psuedoScrollBar.style.position = 'fixed';
			psuedoScrollBar.style.right = '0';
			psuedoScrollBar.style.top = '0';
			psuedoScrollBar.style.width = scrollbarWidth;
			psuedoScrollBar.style.height = '100vh';
			psuedoScrollBar.style.background = '#333';
			psuedoScrollBar.style.zIndex = '9';
			document.body.appendChild( psuedoScrollBar );
		}
		document.querySelector( "body" ).style.overflow = 'hidden';
		document.querySelector( "html" ).style.paddingRight = scrollbarWidth;
	}


	function enableScroll() {
		let elemExists = document.getElementById("js_psuedoScrollBar");
		if ( elemExists !== null ) {
			document.getElementById("js_psuedoScrollBar").style.display = 'none';
			document.querySelector("body").style.overflow = 'visible';
			document.querySelector("html").style.paddingRight = '0';
		}
	}


	// Poll for doc ready state
	let docLoaded = setInterval( function() {
		if( document.readyState === 'complete' ) {
			clearInterval( docLoaded );
			modal_init();
		}
	}, 100);

})();//modal plugin end.




/**
 * Herringbone Animation Plugin.
 *
 * A plugin to handle the animation of css properties using preset eases.
 *
 */
const hb_animationPlugin = (function() {


	/**
	 * True when modal is displayed.
	 */
	let active;


	/**
	 * Globally accessible functions.
	 * 
	 * Syntax: hb_animationPlugin.function();
	 * 
	 */
	return {
		// Global animate function just passing the baton for now
		animate: async function(element, property, ease, startValue, endValue, duration) {
			const result = await animate(element, property, ease, startValue, endValue, duration);
			return result;
		},
		sequence: function() {
			// This will handle passed arrays to perform multiple animations
		}
	};

	/**
	 * Call the animations in sequence.
	 */
	async function sequence() {
		if ( ! active ) {
			active = true;
		} else {
			active = false;
			fadeOut(overlay);
		}
	}

	/**
	 * Iterate through the IN animation passed by sequence()
	 */
	function animate( element, property, ease, startValue, endValue, duration ) {

		let fps		      = 60;
		let iterations	  = fps * ( duration / 1000 );
		let range		  = endValue - startValue;
		let timeIncrement = ( duration ) / iterations;
		let currentValue  = 0;
		let time		  = 0;
		let isIncreasing  = endValue >= startValue; //boolen to test for positive increment

		return new Promise( resolve => {
			let timer = setInterval( function() {
				time += timeIncrement;
				currentValue = nextValue(ease, startValue, time, range, duration).toFixed(2);
				if ( isIncreasing && currentValue >= endValue || !isIncreasing && currentValue <= endValue ) {
					clearInterval( timer );
					set( element, property, endValue );
					return resolve( property + ' done' );
				}
				set( element, property, currentValue );
			}, 1000/fps );
		} );
	}


	/*
	 * Animation ease.
	 *
	 * Eases are adapted from git repo bameyrick/js-easing-functions.
	 *
	 */
	function nextValue(ease, startValue, time, range, duration) {

		let t = time		// Time elapsed
		let s = startValue  // Initial property value before animation
		let r = range	    // The difference between start and end values
		let d = duration	// Total duration of animation

		// The following eases are from git repo bameyrick/js-easing-functions
		switch (ease) {
			case 'linear': return r * (t / d) + s;

			case 'easeInQuad':
				return r * (t /= d) * t + s;

			case 'easeOutQuad':
				return -r * (t /= d) * (t - 2) + s;

			case 'easeInOutQuad':
				if ((t /= d / 2) < 1) {
					return r / 2 * t * t + s;
				}
				return -r / 2 * (--t * (t - 2) - 1) + s;

			case 'easeInCubic':
				return r * (t /= d) * t * t + s;

			case 'easeOutCubic':
				return r * ((t = t / d - 1) * t * t + 1) + s;

			case 'easeInOutCubic':
				if ((t /= d / 2) < 1) {
					return r / 2 * t * t * t + s;
				}
				return r / 2 * ((t -= 2) * t * t + 2) + s;

			case 'easeInQuart':
				return r * (t /= d) * t * t * t + s;

			case 'easeOutQuart':
				return -r * ((t = t / d - 1) * t * t * t - 1) + s;

			case 'easeInOutQuart':
				if ((t /= d / 2) < 1) {
					return r / 2 * t * t * t * t + s;
				}
				return -r / 2 * ((t -= 2) * t * t * t - 2) + s;

			case 'easeInQuint':
				return r * (t /= d) * t * t * t * t + s;

			case 'easeOutQuint':
				return r * ((t = t / d - 1) * t * t * t * t + 1) + s;

			case 'easeInOutQuint':
				if ((t /= d / 2) < 1) {
					return r / 2 * t * t * t * t * t + s;
				}
				return r / 2 * ((t -= 2) * t * t * t * t + 2) + s;

			case 'easeInSine':
				return -r * Math.cos(t / d * (Math.PI / 2)) + r + s;

			case 'easeOutSine':
				return r * Math.sin(t / d * (Math.PI / 2)) + s;

			case 'easeInOutSine':
				return -r / 2 * (Math.cos(Math.PI * t / d) - 1) + s;

			case 'easeInExpo':
				return t === 0 ? s : r * Math.pow(2, 10 * (t / d - 1)) + s;

			case 'easeOutExpo':
				return t === d
					? s + r
					: r * (-Math.pow(2, -10 * t / d) + 1) + s;

			case 'easeInOutExpo':
				if (t === 0) {
					return s;
				}
				if (t === d) {
					return s + r;
				}
				if ((t /= d / 2) < 1) {
					return r / 2 * Math.pow(2, 10 * (t - 1)) + s;
				}
				return r / 2 * (-Math.pow(2, -10 * --t) + 2) + s;

			case 'easeInCirc':
				return -r * (Math.sqrt(1 - (t /= d) * t) - 1) + s;

			case 'easeOutCirc':
				return r * Math.sqrt(1 - (t = t / d - 1) * t) + s;

			case 'easeInOutCirc':
				if ((t /= d / 2) < 1) {
					return -r / 2 * (Math.sqrt(1 - t * t) - 1) + s;
				}
				return r / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + s;

			case 'easeInBack':
				s = 1.70158
				return r * (t /= d) * t * ((s + 1) * t - s) + s;

			case 'easeOutBack':
				s = 1.70158
				return r * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + s;

			case 'easeInOutBack':
				s = 1.70158
				if ((t /= d / 2) < 1) {
					return r / 2 * (t * t * (((s *= 1.525) + 1) * t - s)) + s;
				}
				return r / 2 * ((t -= 2) * t * (((s *= 1.525) + 1) * t + s) + 2) + s;

/*fixable*/ case 'easeInBounce':
				return r - easeOutBounce(d - t, 0, r, d) + s;

			case 'easeOutBounce':
				if ((t /= d) < 1 / 2.75) {
					return r * (7.5625 * t * t) + s;
				} else if (t < 2 / 2.75) {
					return r * (7.5625 * (t -= 1.5 / 2.75) * t + 0.75) + s;
				} else if (t < 2.5 / 2.75) {
					return r * (7.5625 * (t -= 2.25 / 2.75) * t + 0.9375) + s;
				} else {
					return r * (7.5625 * (t -= 2.625 / 2.75) * t + 0.984375) + s;
				}

/*fixable*/ case 'easeInOutBounce':
				if (t < d / 2) {
					return easeInBounce(t * 2, 0, r, d) * 0.5 + s;
				}
				return easeOutBounce(t * 2 - d, 0, r, d) * 0.5 + r * 0.5 + s;
		}
	}


	/*
	 * Update the CSS property passed by animate()
	 */
	function set(element, property, value) {
		switch (property) {

			case 'scale':
				element.style.transform = 'scale(' + (value) + ')';
				element.style.opacity = (value);
				return;

			case 'left':
				element.style.left = value + 'px';
				return;
		}
	}


})();//animation plugin end.
