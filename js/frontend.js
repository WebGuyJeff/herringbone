/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};

;// CONCATENATED MODULE: ./src/js/frontend/dropdown-control.js
/**
 * Herringbone Dropdown Menu Javascript
 *
 * Hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

// Get the an array of unique menu elements which contain dropdowns.
const dropdowns = document.querySelectorAll( '.dropdown-hover' )
const dropdownParents = []
dropdowns.forEach( ( dropdown ) => {
	dropdownParents.push( dropdown.parentElement )
} )
const menuContainers = [ ...new Set( dropdownParents ) ]

// True when mousedown on element, false after mouseup.
let mouseDown = false

const dropdownControl = {
	/**
	 * Initialise the dropdowns.
	 *
	 * Fired on doc ready to attach event listeners to all dropdowns in the DOM.
	 */
	initDropdowns: function () {
		// Attach 'click' event handler to page.
		document.addEventListener( 'click', dropdownControl.pageClickHandler )

		// Attach 'mouseenter' and 'mouseleave' event handlers to dropdown(s).
		let hoverDropdowns = document.querySelectorAll( '.dropdown-hover' );
		[ ...hoverDropdowns ].forEach( ( dropdown ) => {
			dropdownControl.registerHover( dropdown )
		} )

		// Attach 'click' event handler to the menu container(s).
		menuContainers.forEach( ( menu ) => {
			menu.addEventListener( 'click', dropdownControl.menuClickHandler )
			menu.addEventListener( 'mousedown', () => {
				mouseDown = true
			} )
			menu.addEventListener( 'mouseup', () => {
				mouseDown = false
			} )
		} )
	},

	/**
	 * Call init function on document ready.
	 *
	 * Polls for document ready state.
	 */
	initialise: () => {
		let docLoaded = setInterval( function () {
			if ( document.readyState === 'complete' ) {
				clearInterval( docLoaded )
				dropdownControl.initDropdowns()
			}
		}, 100 )
	},

	/**
	 * Check if passed elem is in left half of viewport.
	 *
	 * @param {HTMLElement} element - Element to check.
	 */
	isInLeftHalf: function ( element ) {
		const dims = element.getBoundingClientRect()
		const viewportWidth = window.innerWidth

		return dims.left <= viewportWidth / 2
	},

	/**
	 * Check if passed elem is overflowing viewport bottom and scroll window if needed.
	 *
	 * @param {HTMLElement} menu - The dropdown contents (menu) element.
	 */
	scrollIntoView: function ( menu ) {
		const menuStyles = menu.getBoundingClientRect()
		const bodyStyles = document.body.getBoundingClientRect()
		const viewportHeight = window.innerHeight

		if ( menuStyles.bottom > viewportHeight ) {
			const scrollDistance = menuStyles.bottom - viewportHeight
			window.scrollBy( 0, scrollDistance ) // x,y

			if ( menuStyles.bottom > bodyStyles.bottom ) {
				document.body.style.height =
					document.documentElement.scrollHeight +
					scrollDistance +
					'px'
			}
		} else {
			return false
		}
	},

	/**
	 * Page Click Handler.
	 *
	 * A callback to be passed with event listeners.
	 *
	 * @param {Event} event - The event object.
	 */
	pageClickHandler: function ( event ) {
		// Bail if the click is on a menu.
		let isAMenu = false
		menuContainers.forEach( ( menu ) => {
			if ( !!menu.contains( event.target ) === true ) {
				isAMenu = true
			}
		} )
		if ( isAMenu ) return

		// Get all active top-level dropdowns.
		const activeDropdowns = []
		document.querySelectorAll( '.dropdown-hover' ).forEach( ( dropdown ) => {
			if (
				dropdown.contains(
					dropdown.querySelector( '.dropdown_toggle-active' )
				)
			) {
				activeDropdowns.push( dropdown )
			}
		} );

		// Close all active top-level dropdowns.
		[ ...activeDropdowns ].forEach( ( dropdown ) => {
			if ( !!dropdown.closest( '[data-hover-lock="true"]' ) === true ) {
				dropdown
					.closest( '.dropdown-hover' )
					.setAttribute( 'data-hover-lock', 'false' )
			}
			dropdownControl.close( dropdown.querySelector( '.dropdown_toggle' ) )
		} )
	},

	/**
	 * Hover Event Handler.
	 *
	 * A callback to be passed with event listeners.
	 *
	 * @param {Event} event - The event object.
	 */
	hoverHandler: function ( event ) {
		const button = event.target.closest( '.dropdown-hover' ).getElementsByClassName( 'dropdown_toggle' )[ 0 ]

		if ( event.type === 'mouseenter' ) {
			// Open it.
			dropdownControl.open( button )
		} else if ( event.type === 'mouseleave' ) {
			// In case a mousedown event is dragged off the element, this resets the var to false.
			mouseDown = false

			// If this menu branch isn't hover-locked.
			if (
				!! button.closest( '[data-hover-lock="true"]' ) === false &&
				button.classList.contains( 'dropdown_toggle-active' )
			) {
				/**
				 * Chrome Bug Patch:
				 *
				 * When the dropdown menu class is updated on click -> open(), the dropdown
				 * appears to be removed from the viewport for a split second causing a
				 * mouseleave event to fire. This means, when you click on a sub-dropdown menu
				 * after hovering over the parent, it closes the menu.
				 *
				 * More weirdly, this only happens if the browser itself doesn't have OS window
				 * focus before performing the hover > click. If you click anywhere on the
				 * browser UI, including on the viewport area, this bug will not occur. Super
				 * edge-case bug!
				 *
				 * Tested in KDE Debian, and only occurs in Chrome. Firefox/Opera tested OK.
				 *
				 * To patch this issue, a timeout delay is added to the mouseleave event, so
				 * that before the close() is fired, a sanity check can be performed to ensure
				 * the mouse is still not over the dropdown. If the mouse is still hovering the
				 * dropdown, the close() is not fired and this bug is avoided.
				 */
				let hoverTarget
				const mouseOverElem = ( event ) => {
					hoverTarget = event.target
				}
				document.addEventListener( 'mouseover', mouseOverElem, false )
				setTimeout( () => {
					if ( !button.parentElement.contains( hoverTarget ) ) {
						dropdownControl.close( button )
					}
					document.removeEventListener(
						'mouseover',
						mouseOverElem,
						false
					)
				}, 10 )
				// Bug Patch End.
			}
		}
	},

	/**
	 * Focus Event Handler.
	 *
	 * A callback to be passed with event listeners.
	 *
	 * @param {Event} event - The event object.
	 */
	focusHandler: function ( event ) {
		// Bail if a click is being triggered to avoid duplicate calls to open().
		if ( mouseDown ) return

		const button = event.target
			.closest( '.dropdown' )
			.getElementsByClassName( 'dropdown_toggle' )[ 0 ]

		if ( event.type === 'focusin' ) {
			// Open it.
			dropdownControl.open( button )
		} else if ( event.type === 'focusout' ) {
			// If this menu branch isn't hover-locked.
			if (
				!!button.closest( '[data-hover-lock="true"]' ) === false &&
				button.classList.contains( 'dropdown_toggle-active' )
			) {
				// If focus has moved outside the dropdown branch, close the whole thing.
				if (
					!!event.target
						.closest( '.dropdown-hover' )
						.contains( event.relatedTarget ) ===
					false
				) {
					// Close dropdown branch.
					dropdownControl.close(
						event.target
							.closest( '.dropdown-hover' )
							.querySelector( '.dropdown_toggle' )
					)
				} else {
					// Close dropdown.
					dropdownControl.close( button )
				}
			}
		}
	},

	/**
	 * Register hover and focus event listeners.
	 *
	 * Attach hover and focus listeners to a dropdown element. This can be used to register new
	 * dropdowns by external scripts. In the Toecaps theme, this function is used by
	 * menu-more.js to register the auto-generated 'more' dropdown.
	 *
	 * @param {HTMLElement} dropdown - The dropdown element to attach event listeners to.
	 */
	registerHover: function ( dropdown ) {
		// Only attach hover listeners to non-mobile menu.
		if ( !! dropdown.closest( '.fullscreenMenu' ) === false ) {
			dropdown.addEventListener(
				'mouseenter',
				dropdownControl.hoverHandler
			)
			dropdown.addEventListener(
				'mouseleave',
				dropdownControl.hoverHandler
			)
			dropdown.setAttribute( 'data-hover-listener', 'true' )
		}
		// Attach focus listeners to all menus.
		dropdown.addEventListener( 'focusin', dropdownControl.focusHandler )
		dropdown.addEventListener( 'focusout', dropdownControl.focusHandler )
	},

	/**
	 * Deregister hover event listeners.
	 *
	 * Useful for when the hover functionality is no longer desireable. This is also used by
	 * more.js to disable hover functionality when items are moved into the 'more' dropdown.
	 *
	 * @param {HTMLElement} dropdown The dropdown element to deregister hover listeners from.
	 */
	deregisterHover: function ( dropdown ) {
		dropdown.removeEventListener(
			'mouseenter',
			dropdownControl.hoverHandler
		)
		dropdown.removeEventListener(
			'mouseleave',
			dropdownControl.hoverHandler
		)
		dropdown.setAttribute( 'data-hover-listener', 'false' )
	},

	/**
	 * Menu Click Event Handler.
	 *
	 * Menu branches are locked open as soon as they are clicked anywhere inside. This means
	 * they won't close when the user accidentally hovers-off the menu, but they will close as
	 * soon as a click is detected outside of the menu branch.
	 *
	 * @param {Event} event The click event.
	 */
	menuClickHandler: function ( event ) {
		// If click is on a dropdown toggle button or dropdown primary element.
		if (
			!! event.target.closest( '.dropdown_toggle' ) === true ||
			!! event.target.closest( '.dropdown_primary' ) === true
		) {
			// Find the toggle button inside the parent dropdown element.
			const button = event.target
				.closest( '.dropdown' )
				.querySelector( '.dropdown_toggle' )

			// If active and unlocked.
			if (
				button.classList.contains( 'dropdown_toggle-active' ) &&
				!! button.closest( '[data-hover-lock="true"]' ) === false
			) {
				// Lock it.
				button
					.closest( '.dropdown-hover' )
					.setAttribute( 'data-hover-lock', 'true' )

				// If active and locked.
			} else if (
				button.classList.contains( 'dropdown_toggle-active' ) &&
				!! button.closest( '[data-hover-lock="true"]' ) === true
			) {
				// If it's the top level dropdown, unlock it.
				if ( button.parentElement.classList.contains( 'dropdown-hover' ) ) {
					button
						.closest( '.dropdown-hover' )
						.setAttribute( 'data-hover-lock', 'false' )
				}
				// Close it.
				dropdownControl.close( button )

				// Else, is not active.
			} else {
				// Lock it.
				button
					.closest( '.dropdown-hover' )
					.setAttribute( 'data-hover-lock', 'true' )

				// Open it.
				dropdownControl.open( button )
			}

			// Click is NOT on a dropdown button, but IS in an UNLOCKED dropdown branch.
		} else if (
			!!event.target.closest( '[data-hover-lock="true"]' ) === false &&
			!!event.target.closest( '.dropdown-hover' ) === true
		) {
			// Lock this menu branch.
			event.target
				.closest( '.dropdown-hover' )
				.setAttribute( 'data-hover-lock', 'true' )
		}
	},

	/**
	 * Open the menu.
	 *
	 * Takes a dropdown button element and opens the menu branch. It should not need to be aware
	 * of the caller or trigger, only requiring the passing of the button toggle element.
	 *
	 * It performs these tasks:
	 *  - Closes other open branches in the same dropdown.
	 *  - Close other top level dropdowns no longer in focus.
	 *  - Open inactive ancestor dropdowns when a child is focused directly by reverse tabbing.
	 *
	 * @param {HTMLElement} button The dropdown button toggle element.
	 */
	open: function ( button ) {

		const dropdown = button.parentElement

		// Set dropdown swing direction on smaller screens.
		if ( dropdown.classList.contains( 'dropdown-hover' ) ) {
			if ( dropdownControl.isInLeftHalf( dropdown ) ) {
				dropdown.classList.add( 'dropdown-swingRight' )
				dropdown.classList.remove( 'dropdown-swingLeft' )
			} else {
				dropdown.classList.add( 'dropdown-swingLeft' )
				dropdown.classList.remove( 'dropdown-swingRight' )
			}
		}

		// Close other open branches in the ancestor dropdown.
		const activeButtons = document.querySelectorAll(
			'.dropdown_toggle-active'
		);
		[ ...activeButtons ].forEach( ( activeButton ) => {
			// Check this isn't an ancestor of the newly opened dropdown.
			if ( !activeButton.parentElement.contains( button ) ) {
				// Close.
				dropdownControl.close( activeButton )
			}
		} )

		// Get and close all top-level dropdowns that do not contain this dropdown.
		const activeTopLevelDropdowns = []
		const allTopLevelDropdowns = document.querySelectorAll(
			'.dropdown-hover:not( .fullscreenMenu .dropdown )'
		);
		[ ...allTopLevelDropdowns ].forEach( ( topLevelDropdown ) => {
			if (
				topLevelDropdown.contains(
					topLevelDropdown.querySelector( '.dropdown_toggle-active' )
				)
			) {
				activeTopLevelDropdowns.push( topLevelDropdown )
			}
		} );
		[ ...activeTopLevelDropdowns ].forEach( ( activeDropdown ) => {
			// If dropdown isn't the target, but is active, close it.
			if ( !activeDropdown.contains( dropdown ) ) {
				// Remove lock and close.
				activeDropdown.setAttribute( 'data-hover-lock', 'false' )
				dropdownControl.close(
					activeDropdown.querySelector( '.dropdown_toggle' )
				)
			}
		} )

		// Open the ancestors when reverse-tabbing focuses on a last-child dropdown item first.
		if (
			!!button.parentElement.classList.contains( 'dropdown-hover' ) ===
				false &&
			!!button.classList.contains( 'dropdown_toggle-active' ) === false
		) {
			// This is a child dropdown with no active ancestor.

			const inactiveAncestorDropdowns = []
			const allBranchDropowns = [
				...dropdown
					.closest( '.dropdown-hover' )
					.querySelectorAll( '.dropdown' ),
			]
			// Push the top level dropdown to beginning of array.
			allBranchDropowns.unshift( dropdown.closest( '.dropdown-hover' ) )
			// Remove the target dropdown as this will be handled by outer scope.
			allBranchDropowns.pop()

			allBranchDropowns.forEach( ( branchDropdown ) => {
				if ( branchDropdown.contains( dropdown ) ) {
					inactiveAncestorDropdowns.push( branchDropdown )
					// Set attributes.
					const inactiveButton =
						branchDropdown.querySelector( '.dropdown_toggle' )
					inactiveButton.classList.add( 'dropdown_toggle-active' )
					inactiveButton.setAttribute( 'aria-expanded', true )
					inactiveButton.setAttribute( 'aria-pressed', true )
				}
			} )
		}

		// Set attributes.
		button.classList.add( 'dropdown_toggle-active' )
		button.setAttribute( 'aria-expanded', true )
		button.setAttribute( 'aria-pressed', true )

		// Now browser has calculcated layout, adjust y-scroll if required,
		let menu = dropdown.lastElementChild
		dropdownControl.scrollIntoView( menu )
	},

	/**
	 * Close the menu.
	 *
	 * Takes a dropdown button element and closes the menu branch. It should not need to be
	 * aware of the caller or trigger, only requiring the passing of the button toggle element.
	 *
	 * @param {HTMLElement} button The dropdown button toggle element.
	 */
	close: function ( button ) {
		// If the button's dropdown also has active children.
		let activeBranch = button.parentElement.querySelectorAll(
			'.dropdown_toggle-active'
		)
		if ( activeBranch.length > 1 ) {
			// Iterate through innermost to outer closing all open in branch.
			for ( let i = activeBranch.length - 1; i >= 0; i-- ) {
				activeBranch[ i ].classList.remove( 'dropdown_toggle-active' )
				activeBranch[ i ].setAttribute( 'aria-expanded', false )
				activeBranch[ i ].setAttribute( 'aria-pressed', false )
			}
		} else {
			button.classList.remove( 'dropdown_toggle-active' )
			button.setAttribute( 'aria-expanded', false )
			button.setAttribute( 'aria-pressed', false )
		}
	},
}



;// CONCATENATED MODULE: ./src/js/frontend/hideheader.js
/**
 * Herringbone Hide-Header
 *
 * Handle header hide and reveal animation on button click and scroll events.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */


const hideHeader = () => {

	let body        = document.querySelector( 'body' )
	let header      = document.querySelector( '.header' )
	let button      = document.querySelector( '.menuToggle' )
	let isAnimating = false

	if ( button === null ) return

	const docLoaded = setInterval( () => {
		if ( document.readyState === 'complete' ) {
			clearInterval( docLoaded )
			button.addEventListener( 'click', toggleState )
		}
	}, 100 )

	const toggleState = () => {
		if ( !isAnimating ) {
			isAnimating = true;
			( body.classList.contains( "menu_active" ) ) ? hide() : show()
		}
	}

	const show = async () => {
		header.setAttribute( 'hidden', false )
		body.classList.add( "menu_active" )
		await transitionToPromise( header, 'transform', 'translate( 0, 0 )' )
		window.addEventListener( 'scroll', hide, { once: true } )
		isAnimating = false
	}

	const hide = async () => {
		header.setAttribute( 'hidden', true )
		body.classList.remove( "menu_active" )
		await transitionToPromise( header, 'transform', 'translate( 0, -100% )' )
		isAnimating = false
    }

	const transitionToPromise = ( element, property, value ) => {
        new Promise( resolve => {
            try {
                element.style[ property ] = value
                const transitionEnded = ( event ) => {
                    if ( event.target !== element ) return
                    header.removeEventListener( 'transitionend', transitionEnded )
                    resolve( 'Transition complete.' )
                }
                header.addEventListener( 'transitionend', transitionEnded )
            } catch ( error ) {
                console.error( error.name + ': ' + error.message )
                reject( error )
            }
        } )
	}

}



;// CONCATENATED MODULE: ./src/js/frontend/mobile-popup-menu.js
const mobilePopupMenu = () => {
	if ( ! document.querySelector( '.thumbNav' ) ) return

	let timerElapsed = true
	let thumbNavDisplayed = true
	let prevScrollpos = window.pageYOffset
	let currentScrollPos
		
	window.onscroll = function(){
		currentScrollPos = window.pageYOffset
		if ( timerElapsed ) {
			timerElapsed = false
			setTimeout( function(){
				if ( prevScrollpos > currentScrollPos && thumbNavDisplayed === false ) {
					document.querySelector( '.thumbNav-jshide' ).style.transform = 'translateY(0rem)'
					thumbNavDisplayed = true
				} else if ( prevScrollpos < currentScrollPos && thumbNavDisplayed === true ) {
					document.querySelector( '.thumbNav-jshide' ).style.transform = 'translateY(5rem)'
					document.querySelector( '.thumbNav_checkbox' ).checked = false
					thumbNavDisplayed = false
				}
				prevScrollpos = currentScrollPos
				timerElapsed = true
			}, 500 )
		}
	}
}



;// CONCATENATED MODULE: ./src/js/frontend/css-animator.js
/**
 * CSS Animation Module.
 *
 * Animate CSS properties using preset eases.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

/**
 * True when modal is displayed.
 */
let active


/**
 * Iterate through the IN animation passed by sequence()
 */
function doAnimation( element, property, ease, startValue, endValue, duration ) {

	let fps		      = 60
	let iterations	  = fps * ( duration / 1000 )
	let range		  = endValue - startValue
	let timeIncrement = ( duration ) / iterations
	let currentValue  = 0
	let time		  = 0
	let isIncreasing  = endValue >= startValue // boolen to test for positive increment

	return new Promise( resolve => {
		let timer = setInterval( function() {
			time += timeIncrement
			currentValue = nextValue( ease, startValue, time, range, duration ).toFixed( 2 )
			if ( isIncreasing && currentValue >= endValue || !isIncreasing && currentValue <= endValue ) {
				clearInterval( timer )
				set( element, property, endValue )
				return resolve( property + ' done' )
			}
			set( element, property, currentValue )
		}, 1000/fps )
	} )
}


/**
 * Future expansion: Call the animations in sequence.
 * 
 * Handle passed arrays to perform multiple animations.
 */
 async function sequence() {
	if ( ! active ) {
		active = true
	} else {
		active = false
		fadeOut( overlay )
	}
}


/*
 * Animation ease.
 *
 * Eases are adapted from git repo bameyrick/js-easing-functions.
 *
 */
function nextValue( ease, startValue, time, range, duration ) {

	let t = time		// Time elapsed
	let s = startValue // Initial property value before animation
	let r = range // The difference between start and end values
	let d = duration	// Total duration of animation

	// The following eases are from git repo bameyrick/js-easing-functions
	switch ( ease ) {
		case 'linear': return r * ( t / d ) + s

		case 'easeInQuad':
			return r * ( t /= d ) * t + s

		case 'easeOutQuad':
			return -r * ( t /= d ) * ( t - 2 ) + s

		case 'easeInOutQuad':
			if ( ( t /= d / 2 ) < 1 ) {
				return r / 2 * t * t + s
			}
			return -r / 2 * ( --t * ( t - 2 ) - 1 ) + s

		case 'easeInCubic':
			return r * ( t /= d ) * t * t + s

		case 'easeOutCubic':
			return r * ( ( t = t / d - 1 ) * t * t + 1 ) + s

		case 'easeInOutCubic':
			if ( ( t /= d / 2 ) < 1 ) {
				return r / 2 * t * t * t + s
			}
			return r / 2 * ( ( t -= 2 ) * t * t + 2 ) + s

		case 'easeInQuart':
			return r * ( t /= d ) * t * t * t + s

		case 'easeOutQuart':
			return -r * ( ( t = t / d - 1 ) * t * t * t - 1 ) + s

		case 'easeInOutQuart':
			if ( ( t /= d / 2 ) < 1 ) {
				return r / 2 * t * t * t * t + s
			}
			return -r / 2 * ( ( t -= 2 ) * t * t * t - 2 ) + s

		case 'easeInQuint':
			return r * ( t /= d ) * t * t * t * t + s

		case 'easeOutQuint':
			return r * ( ( t = t / d - 1 ) * t * t * t * t + 1 ) + s

		case 'easeInOutQuint':
			if ( ( t /= d / 2 ) < 1 ) {
				return r / 2 * t * t * t * t * t + s
			}
			return r / 2 * ( ( t -= 2 ) * t * t * t * t + 2 ) + s

		case 'easeInSine':
			return -r * Math.cos( t / d * ( Math.PI / 2 ) ) + r + s

		case 'easeOutSine':
			return r * Math.sin( t / d * ( Math.PI / 2 ) ) + s

		case 'easeInOutSine':
			return -r / 2 * ( Math.cos( Math.PI * t / d ) - 1 ) + s

		case 'easeInExpo':
			return t === 0 ? s : r * Math.pow( 2, 10 * ( t / d - 1 ) ) + s

		case 'easeOutExpo':
			return t === d
				? s + r
				: r * ( -Math.pow( 2, -10 * t / d ) + 1 ) + s

		case 'easeInOutExpo':
			if ( t === 0 ) {
				return s
			}
			if ( t === d ) {
				return s + r
			}
			if ( ( t /= d / 2 ) < 1 ) {
				return r / 2 * Math.pow( 2, 10 * ( t - 1 ) ) + s
			}
			return r / 2 * ( -Math.pow( 2, -10 * --t ) + 2 ) + s

		case 'easeInCirc':
			return -r * ( Math.sqrt( 1 - ( t /= d ) * t ) - 1 ) + s

		case 'easeOutCirc':
			return r * Math.sqrt( 1 - ( t = t / d - 1 ) * t ) + s

		case 'easeInOutCirc':
			if ( ( t /= d / 2 ) < 1 ) {
				return -r / 2 * ( Math.sqrt( 1 - t * t ) - 1 ) + s
			}
			return r / 2 * ( Math.sqrt( 1 - ( t -= 2 ) * t ) + 1 ) + s

		case 'easeInBack':
			s = 1.70158
			return r * ( t /= d ) * t * ( ( s + 1 ) * t - s ) + s

		case 'easeOutBack':
			s = 1.70158
			return r * ( ( t = t / d - 1 ) * t * ( ( s + 1 ) * t + s ) + 1 ) + s

		case 'easeInOutBack':
			s = 1.70158
			if ( ( t /= d / 2 ) < 1 ) {
				return r / 2 * ( t * t * ( ( ( s *= 1.525 ) + 1 ) * t - s ) ) + s
			}
			return r / 2 * ( ( t -= 2 ) * t * ( ( ( s *= 1.525 ) + 1 ) * t + s ) + 2 ) + s

/* fixable*/ case 'easeInBounce':
			return r - easeOutBounce( d - t, 0, r, d ) + s

		case 'easeOutBounce':
			if ( ( t /= d ) < 1 / 2.75 ) {
				return r * ( 7.5625 * t * t ) + s
			} else if ( t < 2 / 2.75 ) {
				return r * ( 7.5625 * ( t -= 1.5 / 2.75 ) * t + 0.75 ) + s
			} else if ( t < 2.5 / 2.75 ) {
				return r * ( 7.5625 * ( t -= 2.25 / 2.75 ) * t + 0.9375 ) + s
			} else {
				return r * ( 7.5625 * ( t -= 2.625 / 2.75 ) * t + 0.984375 ) + s
			}

/* fixable*/ case 'easeInOutBounce':
			if ( t < d / 2 ) {
				return easeInBounce( t * 2, 0, r, d ) * 0.5 + s
			}
			return easeOutBounce( t * 2 - d, 0, r, d ) * 0.5 + r * 0.5 + s
	}
}


/*
 * Update the CSS property passed by animate()
 */
function set( element, property, value ) {
	switch ( property ) {

		case 'scale':
			element.style.transform = 'scale(' + ( value ) + ')'
			element.style.opacity = ( value )
			return

		case 'left':
			element.style.left = value + 'px'
			return
	}
}


const animate = async ( element, property, ease, startValue, endValue, duration ) => {
	await doAnimation( element, property, ease, startValue, endValue, duration )
}

;// CONCATENATED MODULE: ./src/js/frontend/modal.js
/**
 * Herringbone Modal Javascript
 *
 * Handle modal animation and mechanics.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */



const modal = () => {

    function modal_init() {
        document.querySelectorAll( '.modal_control-open' ).forEach( button_open => {
            button_open.addEventListener( 'click', launch_modal )
        } )
    }

	let animating = false 	// true when animation is in progress.
	let active = false		// true when modal is displayed.
	let mobile = true	 	// true when screen width is less than 768px (48em).

	// Plugin-wide vars.
	let overlay
	let dialog
	let button_close

	/**
	 * Open the model popup.
	 * 
	 */
	async function launch_modal( event ) {

		// Get the modal elements
		const modal_class = event.currentTarget.id
		overlay = document.querySelector( '.' + modal_class )

		dialog = overlay.querySelector( '.modal_dialog' )
		button_close = overlay.querySelector( '.modal_control-close' )

		button_close.onclick = () => {
			closeModal()
		}

		// If a click event is not on dialog
		window.onclick = function( event ) {
			if ( dialog !== !event.target && !dialog.contains( event.target ) ) {
				closeModal()
			}
		}

		await Promise.all( [
			set_modal_device_size(),
			get_scrollbar_width()
		] )
		openModal()
	}


	async function set_modal_device_size() {

		let pageWidth = parseInt( document.querySelector( "html" ).getBoundingClientRect().width, 10 )

		if ( pageWidth <= 768 ) {
			mobile = true
		} else {
			mobile = false
		}

		if ( mobile && active && !animating ) {
			dialog.style.left = '0'
			dialog.style.transform = 'scale(1)'
			dialog.style.opacity = '1'
			overlay.style.display = 'contents'
			overlay.style.opacity = '1'

		} else if ( mobile && !active && !animating ) {
			dialog.style.left = '-768px'
			dialog.style.transform = 'scale(1)'
			dialog.style.opacity = '1'
			overlay.style.display = 'contents'
			overlay.style.opacity = '1'

		} else if ( !mobile && active && !animating ) {
			dialog.style.left = '0'
			dialog.style.transform = 'scale(1)'
			dialog.style.opacity = '1'
			overlay.style.display = 'flex'
			overlay.style.opacity = '1'

		} else if ( !mobile && !active && !animating ) {
			dialog.style.left = '0'
			dialog.style.transform = 'scale(0)'
			dialog.style.opacity = '0'
			overlay.style.display = 'none'
			overlay.style.opacity = '0'

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
        let resizeTimer
        let resize_listener = ( event ) => {
            if ( resizeTimer !== null ) window.clearTimeout( resizeTimer )
            resizeTimer = window.setTimeout( function() {
                if ( !active ) {
                    window.removeEventListener( 'resize', resize_listener )
                    return
                }
                set_modal_device_size()
            }, 20 )
        }
        window.addEventListener( 'resize', resize_listener )
    }


	// Open the modal
	async function openModal() {
		if ( !active && !animating ) {
			active = true
			animating = true
			disableScroll()
            set_browser_resize_listener()

			if ( mobile ) {
				dialog.style.left = '-768px'
				dialog.style.transform = 'scale(1)'
				dialog.style.opacity = '1'
				overlay.style.display = 'contents'
				overlay.style.opacity = '1'
				await animate( dialog, 'left', 'easeInOutCirc', -768, 0, 800 )
				animating = false

			} else {
				dialog.style.left = '0'
				dialog.style.transform = 'scale(0)'
				dialog.style.opacity = '0'
				overlay.style.display = 'flex'
				overlay.style.opacity = '0'
				fadeIn( overlay )
				await animate( dialog, 'scale', 'easeInOutCirc', 0, 1, 800 )
				animating = false
			}
		}
	}


	// Close the modal
	async function closeModal() {
		if ( active && !animating ) {
			active = false
			animating = true
			enableScroll()

			if ( mobile ) {
				dialog.style.left = '0'
				dialog.style.transform = 'scale(1)'
				dialog.style.opacity = '1'
				overlay.style.display = 'contents'
				overlay.style.opacity = '1'
				await animate( dialog, 'left', 'easeInOutCirc', 0, -768, 800 )
				animating = false

			} else {
				dialog.style.left = '0'
				dialog.style.transform = 'scale(1)'
				dialog.style.opacity = '1'
				overlay.style.display = 'flex'
				overlay.style.opacity = '1'
				fadeOut( overlay )
				await animate( dialog, 'scale', 'easeInOutCirc', 1, 0, 800 )
				overlay.style.display = 'none'
				animating = false
			}
		}
	}


	// Moody overlay - fadeout
	function fadeOut( overlay ) {
		let p = 100 // 0.5 x 100 to escape floating point problem
		let animateFilterOut = setInterval( function() {
			if ( p <= 0 ){
				clearInterval( animateFilterOut )
			}
			overlay.style.opacity = p / 100
			p -= 2 // 1 represents 0.01 in css output
		}, 16 ) // 10ms x 25 for 0.25sec animation
	}


	// Moody overlay - fadein
	function fadeIn( overlay ) {
		let p = 4 // 0.01 x 100 to escape floating point problem
		let animateFilterIn = setInterval( function() {
			if ( p >= 100 ){ // 100 (/100) represents 0.5 in css output
				clearInterval( animateFilterIn )
			}
			overlay.style.opacity = p / 100
			p += 2 // 1 represents 0.01 in css output
		}, 16 ) // 10ms x 25 for 0.25sec animation
	}


	let scrollbarWidth
	async function get_scrollbar_width() {
		// Get window width inc scrollbar
		const widthWithScrollBar = window.innerWidth
		// Get window width exc scrollbar
		const widthWithoutScrollBar = document.querySelector( "html" ).getBoundingClientRect().width
		// Calc the scrollbar width
		scrollbarWidth = parseInt( ( widthWithScrollBar - widthWithoutScrollBar ), 10 ) + 'px'
		return scrollbarWidth
	}


	function disableScroll() {
		// Cover the missing scrollbar gap with a black div
		let elemExists = document.getElementById( "js_psuedoScrollBar" )

		if ( elemExists !== null ) {
			document.getElementById( "js_psuedoScrollBar" ).style.display = 'block'
		} else {
			let psuedoScrollBar = document.createElement( "div" )
			psuedoScrollBar.setAttribute( "id", "js_psuedoScrollBar" )
			psuedoScrollBar.style.position = 'fixed'
			psuedoScrollBar.style.right = '0'
			psuedoScrollBar.style.top = '0'
			psuedoScrollBar.style.width = scrollbarWidth
			psuedoScrollBar.style.height = '100vh'
			psuedoScrollBar.style.background = '#333'
			psuedoScrollBar.style.zIndex = '9'
			document.body.appendChild( psuedoScrollBar )
		}
		document.querySelector( "body" ).style.overflow = 'hidden'
		document.querySelector( "html" ).style.paddingRight = scrollbarWidth
	}


	function enableScroll() {
		let elemExists = document.getElementById( "js_psuedoScrollBar" )
		if ( elemExists !== null ) {
			document.getElementById( "js_psuedoScrollBar" ).style.display = 'none'
			document.querySelector( "body" ).style.overflow = 'visible'
			document.querySelector( "html" ).style.paddingRight = '0'
		}
	}


	// Poll for doc ready state
	let docLoaded = setInterval( function() {
		if( document.readyState === 'complete' ) {
			clearInterval( docLoaded )
			modal_init()
		}
	}, 100 )

}



;// CONCATENATED MODULE: ./src/js/frontend/screenclass.js
/**
 * Herringbone Dynamic Classes Javascript
 *
 * Applies classes to the body element to indicate screen size and orientation.
 * These can be accessed using CSS as a global alternative to media queries.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */


 const screenClass = () => {

	let winPxWidth,
		winPxHeight

	let oldOrient,
		newOrient

	let oldDevice,
		newDevice

	let element = document.querySelector( 'body' )

	function getScreen() {
		// Get the browser dims
		winPxWidth = window.innerWidth
		winPxHeight = window.innerHeight

		// Compare width and height, then update orientation var
		if ( winPxWidth >= winPxHeight ) {
			newOrient = 'landscape'
		} else {
			newOrient = 'portrait'
		}

		// If new orientation is different to old, update the classes
		if ( newOrient !== oldOrient ) {
			element.classList.remove( oldOrient )
			element.classList.add( newOrient )
			oldOrient = newOrient
		}

		// Check screen width and update device var
		if ( winPxWidth <= '768' ) {
			newDevice = 'mobile'
		} else if ( winPxWidth <= '1120' ) {
			newDevice = 'tablet'
		} else if ( winPxWidth <= '1440' ) {
			newDevice = 'laptop'
		} else if ( winPxWidth <= '1920' ) {
			newDevice = 'desktop'
		} else {
			newDevice = 'xl'
		}

		// If new device is different to old, update the classes
		if ( newDevice !== oldDevice ) {
			element.classList.remove( oldDevice )
			element.classList.add( newDevice )
			oldDevice = newDevice
		}
	}

	// Set a CSS custom property with the window scrollbar width.
	function set_scrollbar_css_custom_property() {
		const withScrollBar  = window.innerWidth
		const noScrollBar    = document.querySelector( "html" ).getBoundingClientRect().width
		const scrollbarWidth = parseInt( ( withScrollBar - noScrollBar ), 10 ) + 'px'
		let root = document.documentElement
		root.style.setProperty( '--scrollbar', scrollbarWidth )
	}

	// Detect body resize changes and update the scrollbar width property.
	const resizeObserver = new ResizeObserver( entries => 
		set_scrollbar_css_custom_property()
	)
	resizeObserver.observe( document.body )

	let docLoaded = setInterval( function() {
		if( document.readyState === 'complete' ) {
			clearInterval( docLoaded )
			getScreen()
		}
	}, 10 )


	// Poll for resize settle to throttle updates
	var resizeTimeout
	window.onresize = function() {
		if ( resizeTimeout ) {
			clearTimeout( resizeTimeout )
		}
		resizeTimeout = setTimeout( function() {
			getScreen()
			set_scrollbar_css_custom_property()
		}, 10 )
	}


}



;// CONCATENATED MODULE: ./src/js/frontend/usp-section.js
/**
 * Herringbone USP Javascript
 *
 * USP section auto scroll and checkbox clearing.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */


const uspSection = () => {

	const toggles = document.querySelectorAll( '.usp_state' )
	const labels  = document.querySelectorAll( '.usp_graphicWrap' )

	const initToggles = () => {
		[ ...labels ].forEach( label => {
			label.addEventListener( 'click', function() {

				for( let i = 0; i < toggles.length; i++ ){
					toggles[ i ].checked = false
				}
		
				toggles[ 0 ].parentElement.scrollIntoView()
			} )
		} )
	}

	let docLoaded = setInterval( () => {
		if ( document.readyState === 'complete' ) {
			clearInterval( docLoaded )
			initToggles()
		}
	}, 100 )

}



;// CONCATENATED MODULE: ./src/js/frontend/animate-rollby.js
/**
 * Herringbone RollBy Animation Javascript
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

const animateRollBy = () => {

	gsap.registerPlugin( ScrollTrigger )
	gsap.ticker.fps( 30 )
	
	window.onload = () => {
	
		const target    = document.querySelector( '#svg_tumbleweed' )
		const cards     = document.querySelectorAll( '.lilCards_card' )
		const container = target.parentElement
	
		// Setup hover effect with GSAP to avoid CSS conflict.
		const hoverIn = ( e ) => gsap.to( e.target, { scale: 1.05, duration: 0.15 } )
		const hoverOut = ( e ) => gsap.to( e.target, { scale: 1, duration: 0.15 } )
		const addListeners = () => {
			cards.forEach( ( card ) => {
				card.addEventListener( 'mouseover', hoverIn )
				card.addEventListener( 'mouseleave', hoverOut )
			} )
		}
		const removeListeners = () => {
			cards.forEach( ( card ) => {
				card.removeEventListener( 'mouseover', hoverIn )
				card.removeEventListener( 'mouseleave', hoverOut )
			} )
		}
		addListeners()
	
		const getRollTime = () => {
			const w = window.innerWidth
			if ( w < 768 ) return 1
			if ( w >= 768 && w < 1920 ) return 1.5
			if ( w >= 1920 ) return 2.2
		}
		
		const getRollWeedTween = () => {
			const circumference = ( target.clientWidth / 2 ) * 2 * Math.PI
			const distance      = () => target.clientWidth + container.clientWidth
			const rotation      = () => distance() / circumference * 360
			const tl = gsap.timeline( { defaults: { ease: "none", duration: getRollTime() } } )
				tl.fromTo( target, { x: 0 }, { x: distance() }, 0 )
				  .fromTo( target, { rotation: -rotation() }, { rotation: 0 }, 0 )
			return tl
		}
	
		const getSpinCardsTween = () => {
			const getSpin = ( card ) => {
				const tl = gsap.timeline( { repeat: 1 } )
				tl.fromTo( card, { rotateY: 0 }, { rotateY: 360, duration: 0.8, ease: "none" } )
				  .fromTo( card, { background: '#fff', rotateX: 0 }, { background: '#e9e9e9', rotateX: 6, duration: 0.2 }, 0 )
					  .to( card, { background: '#fff', rotateX: 10,duration: 0.2 }, 0.2 )
					  .to( card, { background: '#e9e9e9', rotateX: 6,duration: 0.2 }, 0.4 )
					  .to( card, { background: '#fff', rotateX: 0, duration: 0.2, clearProps: 'transform' }, 0.6 )
				return tl
			}
			const getAllSpins = () => {
				const tl    = gsap.timeline()
				cards.forEach( ( card ) => {
					tl.add( getSpin( card ), Math.random() / 2 ) // Random delay between 0 - 0.5.
				} )
				return tl
			}
			const spinCards = () => {
				const tl = gsap.timeline()
					.to( getAllSpins(), { duration: 1.5, progress: 1, ease: "circ" } )
				return tl
			}
			return spinCards
		}
	
		const newMaster = () => {
			const master = gsap.timeline( {
				defaults: { force3D:true },
				scrollTrigger: {
					trigger: container,
					/*
					 * toggleActions*: [onEnter] [onLeave] [onEnterBack] [onLeaveBack].
					 * *OPTIONS: play | pause | resume | reset | restart | complete | reverse | none.
					 */
					toggleActions: "play reset reset reset",
					// start: [trigger element position] [viewport position].
					start: 'top center'
				} } )
				.call( removeListeners, null, 0 )
				.add( getRollWeedTween() )
				.add( getSpinCardsTween(), getRollTime() * .33 )
				.call( addListeners, null, '+=0.5' )
			return master
		}
		let master = newMaster()
	
		window.addEventListener( 'resize', () => {
			master.kill()
			master = newMaster()
		} )
	}

}



;// CONCATENATED MODULE: ./src/js/frontend.js
/**
 * Webpack entry point.
 * 
 * @link https://metabox.io/modernizing-javascript-code-in-wordpress/
 */









dropdownControl.initialise()
hideHeader()
mobilePopupMenu()
modal()
screenClass()
uspSection()
animateRollBy()

/******/ })()
;
//# sourceMappingURL=frontend.js.map