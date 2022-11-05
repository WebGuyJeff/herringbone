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

export { hideHeader };
