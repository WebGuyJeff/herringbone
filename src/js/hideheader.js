/**
 * Herringbone Hide-Header Javascript
 *
 * A function to hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


const hideHeader = () => {

	let header = document.querySelector( '.header' );
	let isAnimating = false;
	let isToggled = false;
	let propertyValue;

	// Transition element and return a promise of transition end.
	const transitionToPromise = ( element, property, value ) =>
        new Promise( resolve => {
            try {
                element.style[property] = value;
                const transitionEnded = event => {
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


	// Add a classname to the body element when header is active
	function bodyClassToggle() {
		let body = document.querySelector( 'body' );
		if ( isToggled ) {
			body.classList.add( "menu_active" );
		} else {
			body.classList.remove( "menu_active" );
		}
	}

    // Close the header if the user starts scrolling
    const autoclose = event => {
        console.log('scrolled!');
        hb_header.toggle();
    }

    // Public functions
	return {

		toggle: async function() {
			if ( !isAnimating ) {
				isAnimating = true;
				if ( isToggled ) {
					isToggled = false;
                    header.setAttribute('hidden', true);
					bodyClassToggle();
					propertyValue = `translate( 0, -100% )`;
				} else {
					isToggled = true;
                    header.setAttribute('hidden', false);
					bodyClassToggle();
                    window.addEventListener( 'scroll', autoclose, { once: true });
					propertyValue = `translate( 0, 0 )`;
				}
                await transitionToPromise( header, 'transform', propertyValue);
                isAnimating = false;
			}
		},

	};

};

export { hideHeader };
