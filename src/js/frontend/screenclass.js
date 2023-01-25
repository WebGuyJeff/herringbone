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

export { screenClass }
