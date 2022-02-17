/**
 * Herringbone Dynamic Classes Javascript
 *
 * Applies classes to the body element to indicate screen size and orientation.
 * These can be accessed using CSS as a global alternative to media queries.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


(function() {

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
	function set_scrollbar_custom_property() {
		const withScrollBar = window.innerWidth;
		const noScrollBar = document.querySelector("html").getBoundingClientRect().width;
		scrollbarWidth = parseInt((withScrollBar - noScrollBar), 10) + 'px';
		let root = document.documentElement;
		root.style.setProperty('--scrollbar', scrollbarWidth);
	}

	// Observe body height changes and update the scrollbar width.
	// create an Observer instance
	const resizeObserver = new ResizeObserver( entries => 
		set_scrollbar_custom_property()
	);
	// start observing doc node
	resizeObserver.observe( document.body );

	// Poll for doc ready state
	let docLoaded = setInterval(function() {
		if(document.readyState === 'complete') {
			clearInterval(docLoaded);
			/* Start the reactor */
			getScreen();
		}
	}, 10);


	// Poll for resize settle to throttle updates
	var resizeTimeout;
	window.onresize = function() {
		if (resizeTimeout) {
			clearTimeout(resizeTimeout);
		}
		resizeTimeout = setTimeout(function() {
			/* Start the reactor */
			getScreen();
			set_scrollbar_custom_property();
		}, 10);  //Lessen this value for faster response at performance cost
	};


})();
