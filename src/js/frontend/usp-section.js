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

export { uspSection }
