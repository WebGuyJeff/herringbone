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

export { mobilePopupMenu }
