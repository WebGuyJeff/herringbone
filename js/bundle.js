/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};

;// CONCATENATED MODULE: ./src/js/dropdown-menu.js
/**
 * Herringbone Dropdown Menu Javascript
 *
 * Hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


const dropdownMenu = () => {

    /* Private Functions */

    /**
     * Attach event listener to buttons in the loaded doc.
     */
    function initDropdownButtons() {

        let buttons = document.getElementsByClassName( 'dropdown_toggle' );

        [ ...buttons ].forEach( button => {
            button.addEventListener( 'click', buttonClicked = function(){
                hb_dropdownToggle.toggle( this.id );
            });
        });

    }

    /**
     * Call init function on document ready.
     */
    let docLoaded = setInterval( function() {

        if( document.readyState === 'complete' ) {
            clearInterval( docLoaded );
            /* Start the reactor */
            initDropdownButtons();
        }
    }, 100);


    /**
     * Check if passed elem is in left half of viewport.
     */
    function isInLeftHalf( button ) {

        const dims = button.getBoundingClientRect();
        viewportWidth = window.innerWidth;

        return (
            dims.left <= viewportWidth / 2
        );
    }


    /**
     * Check if passed elem is overflowing viewport bottom.
     */
    function isOverflowingViewportBottom( menu ) {

        const dims = menu.getBoundingClientRect();
        viewportHeight = window.innerHeight;

        return shouldScroll = {
            bool: dims.bottom > viewportHeight,
            distance: dims.bottom - viewportHeight
        };
    }


    return {

        /* Public functions */

        /**
         * Toggle the dropdown menu.
         */
        toggle: function( id ) {

            let button = document.getElementById( id );

            /*  Get current state of button */
            let aria_exp = button.getAttribute( "aria-expanded" );

            /*  If inactive, make it active */
            if ( aria_exp == "false" ) {

                //set dropdown popop vertical position
                let height = window.getComputedStyle( button ).height;
                let menu = document.querySelector('#' + id + ' + ' + '.dropdown_contents');
                menu.style.transform = 'translateY(' + height + ')';

                //set dropdown swing direction
                container = button.parentElement;
                let shouldDropRight = isInLeftHalf( container );
                if ( shouldDropRight ) {
                    menu.style.right = '';
                    menu.style.left = '0';
                } else {
                    menu.style.left = '';
                    menu.style.right = '0';
                }

                //set attributes
                button.classList.add( "dropdown_toggle-active" );
                button.setAttribute( "aria-expanded", true );
                button.setAttribute( "aria-pressed", true );

                //now browser has calc'd layout, see if y-scroll req'd
                let shouldScroll = isOverflowingViewportBottom( menu )
                if ( shouldScroll.bool ) {
                    window.scrollBy( 0, shouldScroll.distance ); // x,y
                }

                /* listen for page clicks */
                document.addEventListener( 'click', hb_dropdownToggle.pageClick( id ) );

            /*  Else, make it inactive */
            } else {
                hb_dropdownToggle.close( button );
            }
        },

        /**
         * Close the menu.
         */
        close: function( button ) {

            button.classList.remove( "dropdown_toggle-active" );
            button.setAttribute( "aria-expanded", false );
            button.setAttribute( "aria-pressed", false );
        },

        /**
         * Check if the click event was outside of the menu element.
         * 
         * Preserves the variable values for event listeners. If vars are
         * not passed with the returned function, the event listenersdropdownMenu
         */
        pageClick: function( id ) {
            /* Var values not passed to event listener */

            return function scopePreserver() {
                /* Var values passed to event listener */

                let button = document.getElementById( id );
                let menu = button.parentElement;

                /* If click was not on menu element */
                if ( menu !== !event.target && !menu.contains( event.target ) ) {

                    hb_dropdownToggle.close( button );
                    document.removeEventListener( 'click', scopePreserver );
                }
            };
        }


    };/* public functions */
    
};



;// CONCATENATED MODULE: ./src/js/hideheader.js
/**
 * Herringbone Hide-Header
 *
 * Handle header hide and reveal animation on button click and scroll events.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


const hideHeader = () => {

	let body        = document.querySelector( 'body' );
	let header      = document.querySelector( '.header' );
	let button      = document.querySelector( '.menuToggle' );
	let isAnimating = false;

	const docLoaded = setInterval( () => {
		if ( document.readyState === 'complete' ) {
			clearInterval( docLoaded );
			button.addEventListener( 'click', toggleState );
		}
	}, 100);

	const toggleState = () => {
		if ( !isAnimating ) {
			isAnimating = true;
			( body.classList.contains( "menu_active" ) ) ? hide() : show();
		}
	};

	const show = async () => {
		header.setAttribute( 'hidden', false );
		body.classList.add( "menu_active" );
		await transitionToPromise( header, 'transform', 'translate( 0, 0 )' );
		window.addEventListener( 'scroll', hide, { once: true } );
		isAnimating = false;
	};

	const hide = async () => {
		header.setAttribute( 'hidden', true );
		body.classList.remove( "menu_active" );
		await transitionToPromise( header, 'transform', 'translate( 0, -100% )' );
		isAnimating = false;
    };

	const transitionToPromise = ( element, property, value ) => {
        new Promise( resolve => {
            try {
                element.style[ property ] = value;
                const transitionEnded = ( event ) => {
                    if ( event.target !== element ) return;
                    header.removeEventListener( 'transitionend', transitionEnded );
                    resolve( 'Transition complete.' );
                }
                header.addEventListener( 'transitionend', transitionEnded );
            } catch ( error ) {
                console.error( error.name + ': ' + error.message );
                reject( error );
            }
        } );
	};

};



;// CONCATENATED MODULE: ./src/js/mobile-popup-menu.js

/* jQuery wtf??? */


const mobilePopupMenu = () => {

	let timerElapsed = true;
	let thumbNavDisplayed = true;
	let prevScrollpos = window.pageYOffset;
	let currentScrollPos;
		
	window.onscroll = function(){
		currentScrollPos = window.pageYOffset;
		
		if (timerElapsed) {
			timerElapsed = false;

			setTimeout(function(){
				if (prevScrollpos > currentScrollPos && thumbNavDisplayed == false) {
					$('.thumbNav-jshide').css({"transform":"translateY(0rem)"});
					thumbNavDisplayed = true;
				} else if (prevScrollpos < currentScrollPos && thumbNavDisplayed == true) {
					$('.thumbNav-jshide').css({"transform":"translateY(5rem)"});
					$('.thumbNav_checkbox').prop('checked', false);
					thumbNavDisplayed = false;
				}

				prevScrollpos = currentScrollPos;
				timerElapsed = true;

			}, 500);
		}
	};

};



;// CONCATENATED MODULE: ./src/js/css-animator.js
/**
 * CSS Animation Module.
 *
 * Animate CSS properties using preset eases.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

/**
 * True when modal is displayed.
 */
let active;


/**
 * Iterate through the IN animation passed by sequence()
 */
function doAnimation( element, property, ease, startValue, endValue, duration ) {

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


/**
 * Future expansion: Call the animations in sequence.
 * 
 * Handle passed arrays to perform multiple animations.
 */
 async function sequence() {
	if ( ! active ) {
		active = true;
	} else {
		active = false;
		fadeOut(overlay);
	}
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
function set( element, property, value ) {
	switch ( property ) {

		case 'scale':
			element.style.transform = 'scale(' + ( value ) + ')';
			element.style.opacity = ( value );
			return;

		case 'left':
			element.style.left = value + 'px';
			return;
	}
}


const animate = async (element, property, ease, startValue, endValue, duration) => {
	await doAnimation(element, property, ease, startValue, endValue, duration);
}
;// CONCATENATED MODULE: ./src/js/modal.js
/**
 * Herringbone Modal Javascript
 *
 * Handle modal animation and mechanics.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */



const modal = () => {

    function modal_init() {
        document.querySelectorAll( '.modal_control-open' ).forEach( button_open => {
            button_open.addEventListener( 'click', launch_modal );
        } );
    };

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
				await animate( dialog, 'left', 'easeInOutCirc', -768, 0, 800);
				animating = false;

			} else {
				dialog.style.left = '0';
				dialog.style.transform = 'scale(0)';
				dialog.style.opacity = '0';
				overlay.style.display = 'flex';
				overlay.style.opacity = '0';
				fadeIn( overlay );
				await animate( dialog, 'scale', 'easeInOutCirc', 0, 1, 800);
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
				await animate( dialog, 'left', 'easeInOutCirc', 0, -768, 800);
				animating = false;

			} else {
				dialog.style.left = '0';
				dialog.style.transform = 'scale(1)';
				dialog.style.opacity = '1';
				overlay.style.display = 'flex';
				overlay.style.opacity = '1';
				fadeOut(overlay);
				await animate( dialog, 'scale', 'easeInOutCirc', 1, 0, 800);
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

};



;// CONCATENATED MODULE: ./src/js/screenclass.js
/**
 * Herringbone Dynamic Classes Javascript
 *
 * Applies classes to the body element to indicate screen size and orientation.
 * These can be accessed using CSS as a global alternative to media queries.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


 const screenClass = () => {

	let winPxWidth,
		winPxHeight;

	let oldOrient,
		newOrient;

	let oldDevice,
		newDevice;

	let element = document.querySelector('body');

	function getScreen() {
		// Get the browser dims
		winPxWidth = window.innerWidth;
		winPxHeight = window.innerHeight;

		// Compare width and height, then update orientation var
		if (winPxWidth >= winPxHeight) {
			newOrient = 'landscape';
		} else {
			newOrient = 'portrait';
		}

		// If new orientation is different to old, update the classes
		if (newOrient !== oldOrient) {
			element.classList.remove(oldOrient);
			element.classList.add(newOrient);
			oldOrient = newOrient;
		}

		// Check screen width and update device var
		if (winPxWidth <= '768') {
			newDevice = 'mobile';
		} else if (winPxWidth <= '1120') {
			newDevice = 'tablet';
		} else if (winPxWidth <= '1440') {
			newDevice = 'laptop';
		} else if (winPxWidth <= '1920') {
			newDevice = 'desktop';
		} else {
			newDevice = 'xl';
		}

		// If new device is different to old, update the classes
		if (newDevice !== oldDevice) {
			element.classList.remove(oldDevice);
			element.classList.add(newDevice);
			oldDevice = newDevice;
		}
	}

	// Set a CSS custom property with the window scrollbar width.
	function set_scrollbar_css_custom_property() {
		const withScrollBar  = window.innerWidth;
		const noScrollBar    = document.querySelector("html").getBoundingClientRect().width;
		const scrollbarWidth = parseInt( ( withScrollBar - noScrollBar ), 10 ) + 'px';
		let root = document.documentElement;
		root.style.setProperty( '--scrollbar', scrollbarWidth );
	}

	// Detect body resize changes and update the scrollbar width property.
	const resizeObserver = new ResizeObserver( entries => 
		set_scrollbar_css_custom_property()
	);
	resizeObserver.observe( document.body );

	let docLoaded = setInterval( function() {
		if( document.readyState === 'complete' ) {
			clearInterval( docLoaded );
			getScreen();
		}
	}, 10);


	// Poll for resize settle to throttle updates
	var resizeTimeout;
	window.onresize = function() {
		if ( resizeTimeout ) {
			clearTimeout( resizeTimeout );
		}
		resizeTimeout = setTimeout( function() {
			getScreen();
			set_scrollbar_css_custom_property();
		}, 10);
	};


};


;// CONCATENATED MODULE: ./src/js/usp-section.js
/**
 * Herringbone USP Javascript
 *
 * USP section auto scroll and checkbox clearing.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


const uspSection = () => {

	const toggles = document.querySelectorAll( '.usp_state' );
	const labels  = document.querySelectorAll( '.usp_graphicWrap' );

	const initToggles = () => {
		[ ...labels ].forEach( label => {
			label.addEventListener( 'click', function() {

				for( let i = 0; i < toggles.length; i++ ){
					toggles[i].checked = false;
				}
		
				toggles[0].parentElement.scrollIntoView();
			} );
		} );
	}

	let docLoaded = setInterval( () => {
		if ( document.readyState === 'complete' ) {
			clearInterval( docLoaded );
			initToggles();
		}
	}, 100);

}



;// CONCATENATED MODULE: ./src/index.js
/**
 * Index file for all js modules.
 * 
 * This file is used to import all JS modules providing an entry point for Webpack bundling.
 * 
 * @link https://metabox.io/modernizing-javascript-code-in-wordpress/
 */













dropdownMenu();
hideHeader();
mobilePopupMenu();
modal();
screenClass();
uspSection();

/******/ })()
;