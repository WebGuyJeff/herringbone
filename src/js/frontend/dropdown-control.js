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
		const button = event.target
			.closest( '.dropdown-hover' )
			.getElementsByClassName( 'dropdown_toggle' )[ 0 ]

		if ( event.type === 'mouseenter' ) {
			// Open it.
			dropdownControl.open( button )
		} else if ( event.type === 'mouseleave' ) {
			// In case a mousedown event is dragged off the element, this resets the var to false.
			mouseDown = false

			// If this menu branch isn't hover-locked.
			if (
				!!button.closest( '[data-hover-lock="true"]' ) === false &&
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
		if ( !!dropdown.closest( '.fullscreenMenu' ) === false ) {
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
			!!event.target.closest( '.dropdown_toggle' ) === true ||
			!!event.target.closest( '.dropdown_primary' ) === true
		) {
			// Find the toggle button inside the parent dropdown element.
			const button = event.target
				.closest( '.dropdown' )
				.querySelector( '.dropdown_toggle' )

			// If active and unlocked.
			if (
				button.classList.contains( 'dropdown_toggle-active' ) &&
				!!button.closest( '[data-hover-lock="true"]' ) === false
			) {
				// Lock it.
				button
					.closest( '.dropdown-hover' )
					.setAttribute( 'data-hover-lock', 'true' )

				// If active and locked.
			} else if (
				button.classList.contains( 'dropdown_toggle-active' ) &&
				!!button.closest( '[data-hover-lock="true"]' ) === true
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

export { dropdownControl }
