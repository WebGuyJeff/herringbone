/**
 * Herringbone Dropdown Menu Javascript
 *
 * A function to hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2022, Jefferson Real
 */


var hb_dropdownToggle = (function() {

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
         * not passed with the returned function, the event listeners
         * access the function scope at time of event, capturing the wrong
         * values, or none at all.
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
    
})();/* plugin end */