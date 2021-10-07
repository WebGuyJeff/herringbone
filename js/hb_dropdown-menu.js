/**
 * Herrinbone Dropdown Menu Javascript
 *
 * A function to hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 *
 * //Public call syntax
 * //hb_dropdownToggle.closeDropdownMenu();
 * 
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */


var hb_dropdownToggle = (function() {


    /**
     * Attach event listener to buttons in the loaded doc
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
     * Call init funtion on document ready
     */
    let docLoaded = setInterval( function() {
        if( document.readyState === 'complete' ) {
            clearInterval( docLoaded );
            /* Start the reactor */
            initDropdownButtons();
        }
    }, 100);


	/**
	 * Public functions
     * 
     * call syntax: hb_dropdownToggle.functionName();
	 */
    return {


        /**
         * Toggle the dropdown menu.
         */
        toggle: function( id ) {

            let button = document.getElementById( id );

            // Get current state of button
            let aria_exp = button.getAttribute( "aria-expanded" );

            // If inactive, make it active
            if ( aria_exp == "false" ) {
                button.classList.add( "dropdown_toggle-active" );
                button.setAttribute( "aria-expanded", true );
                button.setAttribute( "aria-pressed", true );

                // Scroll menu into view
                menu = button.parentElement;
                menu.scrollIntoView();

                /**
                 * Preserves the variable values for event listeners.
                 */
                function scopePreserver( id ) {
                    //Vars will be forgotten in this scope
                    return function pageClick() {
                        //Vars will be remembered in this scope
                        hb_dropdownToggle.clickOff( id, event );
                    };
                }

                document.addEventListener( 'click', scopePreserver( id ) );

                console.log('addEventListener ' + id);

            // Else, make it inactive
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
         */
        clickOff: function( id, event ) {

            console.log('clickOff ' + id);

            let button = document.getElementById( id );
            let menu = button.parentElement;

            if ( menu !== !event.target && !menu.contains( event.target ) ) {
                hb_dropdownToggle.close( button );

                document.removeEventListener( 'click', pageClick() );
            }
        }

    };//public functions
    
})();//plugin end