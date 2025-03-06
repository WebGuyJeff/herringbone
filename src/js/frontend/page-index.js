/**
 * Content index Module.
 *
 * Auto-generate a sticky index drawer.
 *
 * @package herringbone
 * @author Jefferson Real <jeff@webguyjeff.com>
 * @copyright Copyright (c) 2024, Jefferson Real
 */

const pageIndex = () => {

	const content       = document.querySelector( 'body > main' ),
		  index         = document.querySelector( '.pageIndex' ),
		  tab           = document.querySelector( '.pageIndex_tab' ),
		  nav           = document.querySelector( '.pageIndex_nav' ),
		  titleSelector = 'h2'

	let hasTouchedDoc   = false,
		hasTouchedLink  = false,
		hasTouchedOpen  = false,
		hasTouchedClose = false,
		hasSwipedLeft   = false,
		hasSwipedY      = false,
		isTouchingIndex = false,
		touchStartX     = 0,
		touchStartY     = 0

	if ( content === null ||
		 index   === null ||
		 tab     === null ||
		 nav     === null ) {
		throw new Error( 'pageIndex: Required element missing' );
	} else {
		index.style.display = 'flex'
	}

	const slugify = ( string ) =>
		string
			.toLowerCase()
			.trim()
			.replace(/[^\w\s-]/g, "")
			.replace(/[\s_-]+/g, "-")
			.replace(/^-+|-+$/g, "");

	const buildIndex = () => {
		content.querySelectorAll( 'section' ).forEach( ( section ) => {
			const title = section.querySelector( titleSelector ).textContent,
				  slug  = slugify( title ),
				  li    = document.createElement( 'li' ),
				  a     = document.createElement( 'a' )
			let   id    = ''
			if ( section.id.length > 0 ) {
				id = section.id
			} else {
				id = slug
				section.id = id
			}
			li.classList.add( 'pageIndex_navItem' )
			a.href      = '#' + id
			a.innerHTML = title
			li.insertAdjacentElement( 'afterbegin', a )
			nav.querySelector( 'ul' ).insertAdjacentElement( 'beforeend', li )
		} )
	}

	const makeIndexActive = () => index.classList.add( 'active' )

	const makeIndexInactive = () => index.classList.remove( 'active' )

	let endActiveTimeout
	const debouncedEndActive = ( wait = 800 ) => {
		if ( hasSwipedLeft || hasTouchedLink || hasTouchedClose ) {
			// Close immediately after user-initiated touch actions.
			hasSwipedLeft   = false
			hasTouchedLink  = false
			hasTouchedClose = false
			wait = 0
		} else if ( hasTouchedOpen ) {
			// Delay auto-close on touch devices (mouse users can hover to keep index open).
			hasTouchedOpen = false
			wait = 6000
		}
		clearTimeout( endActiveTimeout )
		endActiveTimeout = setTimeout( () => {
			const isHovered = nav?.matches( ':hover' )
			if ( ! isHovered || hasTouchedDoc ) {
				// Not hovered by mouse (touch hover ignored).
				makeIndexInactive()
			}
		}, wait )
	}

	let endScrollingTimeout
	const debouncedEndScrolling = ( wait = 800 ) => {
		clearTimeout( endScrollingTimeout )
		endScrollingTimeout = setTimeout( () => {
			index.classList.remove( 'scrolling' )
		}, wait )
	}

	let setActiveLinkTimeout
	const debouncedSetActiveLink = () => {
		clearTimeout( setActiveLinkTimeout )
		setActiveLinkTimeout = setTimeout( () => {
			for ( const child of content.children ) {
				const h2 = child.querySelector( 'h2' ).getBoundingClientRect()
				// Find first title from top visible in viewport.
				if ( h2.top > 0 ) {
					nav.querySelector( 'li.active' )?.classList.remove( 'active' )
					nav.querySelector( `a[href="#${child.id}"]` )?.closest( 'li' ).classList.add( 'active' )
					break
				}
			}
		}, 10 )
	}

	const mouseOverAction = () => ! hasTouchedDoc && makeIndexActive()

	const mouseLeaveAction = () => ! hasTouchedDoc && debouncedEndActive()

	const scrollAction = () => {
		index.classList.add( 'scrolling' )
		debouncedEndScrolling()
		debouncedSetActiveLink()
	}

	const documentTouchStartAction = () => {
		index.classList.add( 'isTouch' )
		hasTouchedDoc = true
	}

	const indexTouchStartAction = ( e ) => {
		isTouchingIndex = true
		touchStartX = e.targetTouches[0].screenX
		touchStartY = e.targetTouches[0].screenY
	}

	const touchMoveAction = ( e ) => {
		if ( ! isTouchingIndex ) return;
		const swipeDistanceY = Math.abs( touchStartY - e.targetTouches[0].screenY )
		const swipeDistanceX = touchStartX - e.targetTouches[0].screenX
		if ( swipeDistanceY > 32 ) {
			hasSwipedY = true
			return
		}
		if ( swipeDistanceX > 32 ) {
			hasSwipedLeft = true
			debouncedEndActive()
		}
	}

	const touchEndAction = ( e ) => {
		isTouchingIndex = false
		const touchedLink  = e.target.nodeName === 'A' && index.classList.contains( 'active' ),
			  touchedOpen  = tab.contains( e.target ) && ! index.classList.contains( 'active' ),
			  touchedClose = tab.contains( e.target ) && index.classList.contains( 'active' )
		if ( hasSwipedY ) {
			// Don't call debouncedEndActive as user may be scrolling the menu.
			hasSwipedY = false
			return
		} else if ( touchedLink ) {
			hasTouchedLink = true
			debouncedEndActive()
		} else if ( touchedOpen ) {
			hasTouchedOpen = true
			makeIndexActive()
			debouncedEndActive()
		} else if ( touchedClose ) {
			hasTouchedClose = true
			debouncedEndActive()
		}
	}

	const addListeners = () => {
		[ nav, tab ].forEach( ( element ) => element?.addEventListener( 'mouseover', () => mouseOverAction() ) );
		[ nav, tab ].forEach( ( element ) => element?.addEventListener( 'mouseleave', () => mouseLeaveAction() ) );
		document.addEventListener( 'scroll', () => scrollAction() );
		// Touch event listeners for mobile devices
		document.addEventListener( 'touchstart', ( e ) => documentTouchStartAction( e ), { once: true } )
		index.addEventListener( 'touchstart', ( e ) => indexTouchStartAction( e ) )
		index.addEventListener( 'touchmove', ( e ) => touchMoveAction( e ) )
		index.addEventListener( 'touchend', ( e ) => touchEndAction( e ) )
	}

	const docLoaded = setInterval( () => {
		if ( document.readyState === 'complete' ) {
			clearInterval( docLoaded )
			buildIndex()
			addListeners()
		}
	}, 100 )
}

export { pageIndex }
