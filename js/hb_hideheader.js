/**
 * Herrinbone Hide-Header Javascript
 *
 * A function to hide the header and reveal by button click. Mainly for use on
 * landing pages where the main header isn't required.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

gsap.registerPlugin(CSSRulePlugin);

var hb_header = (function() {
    let debug = true; //Output in console
    let dims = {};

    //Get the elements being animated
    let header = document.querySelector('.header');
    let welc = document.querySelector('.welcome');

    //This function calculates the new position values for the animation
    function getDims(toggle) {

        // Get the header dims
        let headerFontSize = window.getComputedStyle(header).fontSize;
        let headerHeight = window.getComputedStyle(header).height;
        let headerMargTop = window.getComputedStyle(header).marginTop;
        let headerMargBot = window.getComputedStyle(header).marginBottom;

        //Combine the height and margins for the absolute height
        let headerAbsHeight = parseFloat(headerHeight)
                            + parseFloat(headerMargTop)
                            + parseFloat(headerMargBot);

        // Get welcome section margin top
        let welcFontSize = window.getComputedStyle(welc).fontSize;
        let welcMarg = window.getComputedStyle(welc).marginTop;

        // We use the element font size to get the current value of 1em in px
        // to account for fluid CSS units where 1em may not equal 16px.
        headerAbsHeight = (parseFloat(headerAbsHeight) / parseFloat(headerFontSize)).toFixed(2);
        welcMarg = (parseFloat(welcMarg) / parseFloat(welcFontSize)).toFixed(2);

        return {
            y: headerAbsHeight,
            marg: welcMarg,
        }
    }

    let idle = true;
    let toggle = false;
    let move;
    let offset;
    let marg;

    return {
        toggle: function() {

            // Check if the header is already toggled and supply vars to invert the state
            // We update variables every toggle as layout may have changed
            if (idle) {
                idle = false;
                if (toggle) {
                    toggle = false;
                    bodyClassToggle();
                    dims = getDims(toggle);
                    move = -Math.abs(dims.y) + 'em';
                    offset = dims.y + 'em';
                    marg = (parseFloat(dims.marg) - parseFloat(dims.y)).toFixed(2) + 'em';
                    animate();
                } else {
                    toggle = true;
                    bodyClassToggle();
                    dims = getDims(toggle);
                    move = dims.y + 'em';
                    offset = -Math.abs(dims.y) + 'em';
                    marg = (parseFloat(dims.marg) + parseFloat(dims.y)).toFixed(2) + 'em';
                    animate();
                }
            }
        },

    };

    // Move the elements! - GSAP v3 CSSRule Plugin
    function animate() {
        let headerHide = gsap.timeline( {
            defaults: {
                duration:1,
                ease:"elastic.out(1,0.8)"
            },
            force3D:true,
            onComplete:active,
        });
            headerHide.to(".header", { y:move }, 0)
                      .to(".headerToggle", { y:offset }, 0)
                      .to(".welcome", { marginTop:marg }, 0)
    }

    // Do nothing if animation is already in progress
    function active() {
        idle = true;
    }

    // Add a classname to the body element when header is active
    function bodyClassToggle() {
        let body = document.querySelector('body');
        if (toggle) {
            body.classList.add("header_active");
        } else {
            body.classList.remove("header_active");
        }
    }

})();
