/**
 * Herrinbone Modal Javascript
 *
 * A function to handle modal animation and mechanics.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */

function hb_modalPlugin() {

    function hb_modal() {

        // Get the modal elements
        let overlay = document.getElementById("modal_contactform-overlay");
        let dialog = document.getElementById("modal_contactform-dialog");
        let btno = document.getElementById("modal_contactform-open");
        let btnx = document.getElementById("modal_contactform-close");

        let animating = false; // true when animation is in progress
        let active = false;    // true when modal is displayed
        let mobile = true;     // true when screen width is less than 768px (48em)



        function screenSizeCheck() {

            //console.log('Mobile:' + mobile + '  Active:' + active + '  Animating:' + animating);

            let pageWidth = parseInt(document.querySelector("html").getBoundingClientRect().width, 10);

            if (pageWidth <= 768) {
                mobile = true;
            } else {
                mobile = false;
            }

            if (mobile && active && !animating) {
                dialog.style.left = '0';
                dialog.style.transform = 'scale(1)';
                dialog.style.opacity = '1';
                overlay.style.display = 'contents';
                overlay.style.opacity = '1';

            } else if (mobile && !active && !animating) {
                dialog.style.left = '-768px';
                dialog.style.transform = 'scale(1)';
                dialog.style.opacity = '1';
                overlay.style.display = 'contents';
                overlay.style.opacity = '1';

            } else if (!mobile && active && !animating) {
                dialog.style.left = '0';
                dialog.style.transform = 'scale(1)';
                dialog.style.opacity = '1';
                overlay.style.display = 'flex';
                overlay.style.opacity = '1';

            } else if (!mobile && !active && !animating) {
                dialog.style.left = '0';
                dialog.style.transform = 'scale(0)';
                dialog.style.opacity = '0';
                overlay.style.display = 'none';
                overlay.style.opacity = '0';

            }
        }
        screenSizeCheck();


        let resizeTimer;

        window.addEventListener('resize', function(event) {
            if(resizeTimer !== null) window.clearTimeout(resizeTimer);
            resizeTimer = window.setTimeout(function() {
                screenSizeCheck();
            }, 20);
        });


        // Chalkboard message button
        btno.onclick = function() {
            openModal();
        }


        // Dialog close button
        btnx.onclick = function() {
            closeModal();
        }


        // If a click event is not on dialog
        window.onclick = function(event) {
            if ( dialog !== !event.target && !dialog.contains(event.target) ) {
                closeModal();
            }
        }


        // Open the modal
        async function openModal() {
            if ( !active && !animating ) {
                active = true;
                animating = true;
                disableScroll();

                if (mobile) {
                    dialog.style.left = '-768px';
                    dialog.style.transform = 'scale(1)';
                    dialog.style.opacity = '1';
                    overlay.style.display = 'contents';
                    overlay.style.opacity = '1';

                    let result = await hb_animationPlugin.animate( dialog, 'left', 'easeInOutCirc', -768, 0, 800);

                    animating = false;

                } else {
                    dialog.style.left = '0';
                    dialog.style.transform = 'scale(0)';
                    dialog.style.opacity = '0';
                    overlay.style.display = 'flex';
                    overlay.style.opacity = '0';

                    fadeIn(overlay);
                    let result = await hb_animationPlugin.animate( dialog, 'scale', 'easeInOutCirc', 0, 1, 800);

                    animating = false;
                }
            }
        }


        // Close the modal
        async function closeModal() {
            if ( active && !animating ) {
                active = false;
                animating = true;
                enableScroll();

                if (mobile) {
                    dialog.style.left = '0';
                    dialog.style.transform = 'scale(1)';
                    dialog.style.opacity = '1';
                    overlay.style.display = 'contents';
                    overlay.style.opacity = '1';

                    let result = await hb_animationPlugin.animate( dialog, 'left', 'easeInOutCirc', 0, -768, 800);

                    animating = false;


                } else {
                    dialog.style.left = '0';
                    dialog.style.transform = 'scale(1)';
                    dialog.style.opacity = '1';
                    overlay.style.display = 'flex';
                    overlay.style.opacity = '1';

                    fadeOut(overlay);
                    let result = await hb_animationPlugin.animate( dialog, 'scale', 'easeInOutCirc', 1, 0, 800);

                    overlay.style.display = 'none';
                    animating = false;
                }
            }
        }


        // Moody overlay - fadeout
        function fadeOut(overlay) {
            let p = 100;  // 0.5 x 100 to escape floating point problem
            let animateFilterOut = setInterval(function() {
                if (p <= 0){
                    clearInterval(animateFilterOut);
                }

                overlay.style.opacity = p / 100;

                p -= 2; // 1 represents 0.01 in css output
            }, 16); // 10ms x 25 for 0.25sec animation
        }


        // Moody overlay - fadein
        function fadeIn(overlay) {
            let p = 4;  // 0.01 x 100 to escape floating point problem

            let animateFilterIn = setInterval(function() {
                if (p >= 100){ // 100 (/100) represents 0.5 in css output
                    clearInterval(animateFilterIn);
                }

                overlay.style.opacity = p / 100;

                p += 2; // 1 represents 0.01 in css output
            }, 16); // 10ms x 25 for 0.25sec animation
        }


        // Store the scrollbar width
        let scrollbarWidth;

        function getScrollbarWidth() {

            // Get window width inc scrollbar
            const widthWithScrollBar = window.outerWidth;
            // Get window width exc scrollbar
            const widthWithoutScrollBar = document.querySelector("html").getBoundingClientRect().width;
            // Calc the scrollbar width
            scrollbarWidth = parseInt((widthWithScrollBar - widthWithoutScrollBar), 10) + 'px';

        }
        getScrollbarWidth();


        function disableScroll() {

            // Cover the missing scrollbar gap with a black div
            let elemExists = document.getElementById("js_psuedoScrollBar");

            if ( elemExists !== null ) {
                document.getElementById("js_psuedoScrollBar").style.display = 'block';
            } else {
                let psuedoScrollBar = document.createElement("div");
                psuedoScrollBar.setAttribute("id", "js_psuedoScrollBar");
                psuedoScrollBar.style.position = 'fixed';
                psuedoScrollBar.style.right = '0';
                psuedoScrollBar.style.top = '0';
                psuedoScrollBar.style.width = scrollbarWidth;
                psuedoScrollBar.style.height = '100vh';
                psuedoScrollBar.style.background = '#333';
                psuedoScrollBar.style.zIndex = '9';
                document.body.appendChild(psuedoScrollBar);
            }

            document.querySelector("body").style.overflow = 'hidden';
            document.querySelector("html").style.paddingRight = scrollbarWidth;
        }

        function enableScroll() {

            let elemExists = document.getElementById("js_psuedoScrollBar");

            if ( elemExists !== null ) {
                document.getElementById("js_psuedoScrollBar").style.display = 'none';
                document.querySelector("body").style.overflow = 'visible';
                document.querySelector("html").style.paddingRight = '0';
            }
        }

    }//hb_modal()


    // Poll for doc ready state
    let docLoaded = setInterval(function() {
        if(document.readyState === 'complete') {
            clearInterval(docLoaded);

            /* Start the reactor */
            hb_modal();
        }
    }, 100);


}//hb_modalPlugin();
hb_modalPlugin();





/*
 * Herringbone Animation Plugin
 *
 * A plugin to handle the animation of css properties using preset eases.
 *
 */
var hb_animationPlugin = (function() {

    /*
     * Globally accessible functions (hb_animationPlugin.function();)
     */
    return {
        // Global animate function just passing the baton for now
        animate: async function(element, property, ease, startValue, endValue, duration) {
            const result = await animate(element, property, ease, startValue, endValue, duration);
            return result;
        },

        sequence: function() {
            // This will handle passed arrays to perform multiple animations
        }
    };//return global functions


    /*
     * Call the animations in sequence
     */

    // Boolean true when modal is displayed
    let active;

    async function sequence() {

        if (active != true) {
            active = true;

            //set the scene
            //element.style.transform = 'scale(0)';
            //element.style.opacity = '0';

                            // property, ease, startVal, endVal, duration
            //const result1 = await animate('scale', 'easeInOutQuad', 0, 1, 500);

        } else {
            active = false;

            fadeOut(overlay);

                            // property, ease, startVal, endVal, duration
            //const result1 = await animate('scale', 'easeInOutQuad', 1, 0, 500);

        }
    }//sequence();

    /*
     * Iterate through the IN animation passed by sequence()
     */
    function animate(element, property, ease, startValue, endValue, duration) {

        let fps           = 60;
        let iterations	  = fps * (duration / 1000);
        let range         = endValue - startValue;
        let timeIncrement = (duration) / iterations;
        let currentValue  = 0;
        let time          = 0;
        let isIncreasing  = endValue >= startValue; //boolen to test for positive increment

        return new Promise(resolve => {

                let timer = setInterval(function() {

                    time += timeIncrement;
                    currentValue = nextValue(ease, startValue, time, range, duration).toFixed(2);

                    if ( isIncreasing && currentValue >= endValue || !isIncreasing && currentValue <= endValue ) {
                        clearInterval(timer);
                        set(element, property, endValue);
                        return resolve(property + ' done');
                    }
                    set(element, property, currentValue);
                }, 1000/fps);
        });
    }//animate();


    /*
     * Animation ease
     */
    function nextValue(ease, startValue, time, range, duration) {

        let t = time        // Time elapsed
        let s = startValue  // Initial property value before animation
        let r = range       // The difference between start and end values
        let d = duration    // Total duration of animation


        // The following eases are from git repo bameyrick/js-easing-functions

        switch (ease) {
            case 'linear': return r * (t / d) + s;

            case 'easeInQuad':
            	return r * (t /= d) * t + s;

            case 'easeOutQuad':
            	return -r * (t /= d) * (t - 2) + s;

            case 'easeInOutQuad':
            	if ((t /= d / 2) < 1) {
            		return r / 2 * t * t + s;
            	}
            	return -r / 2 * (--t * (t - 2) - 1) + s;

            case 'easeInCubic':
            	return r * (t /= d) * t * t + s;

            case 'easeOutCubic':
            	return r * ((t = t / d - 1) * t * t + 1) + s;

            case 'easeInOutCubic':
            	if ((t /= d / 2) < 1) {
            		return r / 2 * t * t * t + s;
            	}
            	return r / 2 * ((t -= 2) * t * t + 2) + s;

            case 'easeInQuart':
            	return r * (t /= d) * t * t * t + s;

            case 'easeOutQuart':
            	return -r * ((t = t / d - 1) * t * t * t - 1) + s;

            case 'easeInOutQuart':
            	if ((t /= d / 2) < 1) {
            		return r / 2 * t * t * t * t + s;
            	}
            	return -r / 2 * ((t -= 2) * t * t * t - 2) + s;

            case 'easeInQuint':
            	return r * (t /= d) * t * t * t * t + s;

            case 'easeOutQuint':
            	return r * ((t = t / d - 1) * t * t * t * t + 1) + s;

            case 'easeInOutQuint':
            	if ((t /= d / 2) < 1) {
            		return r / 2 * t * t * t * t * t + s;
            	}
            	return r / 2 * ((t -= 2) * t * t * t * t + 2) + s;

            case 'easeInSine':
            	return -r * Math.cos(t / d * (Math.PI / 2)) + r + s;

            case 'easeOutSine':
            	return r * Math.sin(t / d * (Math.PI / 2)) + s;

            case 'easeInOutSine':
            	return -r / 2 * (Math.cos(Math.PI * t / d) - 1) + s;

            case 'easeInExpo':
            	return t === 0 ? s : r * Math.pow(2, 10 * (t / d - 1)) + s;

            case 'easeOutExpo':
            	return t === d
            		? s + r
            		: r * (-Math.pow(2, -10 * t / d) + 1) + s;

            case 'easeInOutExpo':
            	if (t === 0) {
            		return s;
            	}
            	if (t === d) {
            		return s + r;
            	}
            	if ((t /= d / 2) < 1) {
            		return r / 2 * Math.pow(2, 10 * (t - 1)) + s;
            	}
            	return r / 2 * (-Math.pow(2, -10 * --t) + 2) + s;

            case 'easeInCirc':
            	return -r * (Math.sqrt(1 - (t /= d) * t) - 1) + s;

            case 'easeOutCirc':
            	return r * Math.sqrt(1 - (t = t / d - 1) * t) + s;

            case 'easeInOutCirc':
            	if ((t /= d / 2) < 1) {
            		return -r / 2 * (Math.sqrt(1 - t * t) - 1) + s;
            	}
            	return r / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + s;

            case 'easeInBack':
                s = 1.70158
            	return r * (t /= d) * t * ((s + 1) * t - s) + s;

            case 'easeOutBack':
                s = 1.70158
            	return r * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + s;

            case 'easeInOutBack':
            	s = 1.70158
            	if ((t /= d / 2) < 1) {
            		return r / 2 * (t * t * (((s *= 1.525) + 1) * t - s)) + s;
            	}
            	return r / 2 * ((t -= 2) * t * (((s *= 1.525) + 1) * t + s) + 2) + s;

/*fixable*/ case 'easeInBounce':
            	return r - easeOutBounce(d - t, 0, r, d) + s;

            case 'easeOutBounce':
            	if ((t /= d) < 1 / 2.75) {
            		return r * (7.5625 * t * t) + s;
            	} else if (t < 2 / 2.75) {
            		return r * (7.5625 * (t -= 1.5 / 2.75) * t + 0.75) + s;
            	} else if (t < 2.5 / 2.75) {
            		return r * (7.5625 * (t -= 2.25 / 2.75) * t + 0.9375) + s;
            	} else {
            		return r * (7.5625 * (t -= 2.625 / 2.75) * t + 0.984375) + s;
            	}

/*fixable*/ case 'easeInOutBounce':
            	if (t < d / 2) {
            		return easeInBounce(t * 2, 0, r, d) * 0.5 + s;
            	}
            	return easeOutBounce(t * 2 - d, 0, r, d) * 0.5 + r * 0.5 + s;

        }
    }//nextValue();


    /*
     * Update the CSS property passed by animate()
     */
    function set(element, property, value) {
        switch (property) {

            case 'scale':
                element.style.transform = 'scale(' + (value) + ')';
                element.style.opacity = (value);

                return;

                case 'left':
                    element.style.left = value + 'px';

                    return;

            case 'radius':

                /* Disabled border radius scale as non-performant
                if (typeof borderRadAll !== 'undefined') {
                    bAll = (borderRadAll + ((range / 100) * (100 - p))).toFixed(0);
                    element.style.borderRadius = "" + (bAll / 100) + 'px';

                    return;

                } else {
                    /* //Disabled radius scale as non-performant
                    tl = (borderRadTL + ((rangeTL / 100) * (100 - p))).toFixed(0);
                    tr = (borderRadTR + ((rangeTR / 100) * (100 - p))).toFixed(0);
                    bl = (borderRadBL + ((rangeBL / 100) * (100 - p))).toFixed(0);
                    br = (borderRadBR + ((rangeBR / 100) * (100 - p))).toFixed(0);

                    element.style.borderTopLeftRadius = "" + (tl / 100) + 'px';
                    element.style.borderTopRightRadius = "" + (tr / 100) + 'px';
                    element.style.borderBottomLeftRadius = "" + (bl / 100) + 'px';
                    element.style.borderBottomRightRadius = "" + (br / 100) + 'px';
                    return;

                }*/

                return;
        }//switch
    }//set();

    /*
    function initZoom(element) {

        // Corner radius values
        let borderRadTL;
        let borderRadTR;
        let borderRadBL;
        let borderRadBR;
        let borderRadAll;

        // Used to calc the animated range
        let width;
        let height;
        let max;

        // Store the range for each radius property
        let rangeTL;
        let rangeTR;
        let rangeBL;
        let rangeBR;
        let range;

        // Holds the animated values
        let tl;
        let tr;
        let bl;
        let br;
        let bAll;

        // Stylesheet CSS properties
        let storedCSS = {};

        // Computed CSS properties
        let computedStyles;
        let computedCSS = {};

        //Get the computed styles
        computedStyles = window.getComputedStyle(element);
        computedCSS["borderTopLeftRadius"] = computedStyles.getPropertyValue('border-top-left-radius');
        computedCSS["borderTopRightRadius"] = computedStyles.getPropertyValue('border-top-right-radius');
        computedCSS["borderBottomLeftRadius"] = computedStyles.getPropertyValue('border-bottom-left-radius');
        computedCSS["borderBottomRightRadius"] = computedStyles.getPropertyValue('border-bottom-right-radius');
        computedCSS["borderRadius"] = computedStyles.getPropertyValue('border-radius');


        //Store the stylesheet styles to restore after animation
        storedCSS["transform"] = computedStyles.getPropertyValue('transform');
        storedCSS["overflow"] = computedStyles.getPropertyValue('overflow');
        storedCSS["borderTopLeftRadius"] = computedStyles.getPropertyValue('border-top-left-radius');
        storedCSS["borderTopRightRadius"] = computedStyles.getPropertyValue('border-top-right-radius');
        storedCSS["borderBottomLeftRadius"] = computedStyles.getPropertyValue('border-bottom-left-radius');
        storedCSS["borderBottomRightRadius"] = computedStyles.getPropertyValue('border-bottom-right-radius');
        storedCSS["borderRadius"] = computedStyles.getPropertyValue('border-radius');

        // checkForNullProperty(storedCSS); Giving crappy results

        // get the computed radius values to animate, without the px units
        borderRadTL = (computedCSS.borderTopLeftRadius.replace(/[^0-9.]/g,"") * 100);
        borderRadTR = (computedCSS.borderTopRightRadius.replace(/[^0-9.]/g,"") * 100);
        borderRadBL = (computedCSS.borderBottomLeftRadius.replace(/[^0-9.]/g,"") * 100);
        borderRadBR = (computedCSS.borderBottomRightRadius.replace(/[^0-9.]/g,"") * 100);

        // get the computed size dims
        width = (computedStyles.getPropertyValue('width').replace(/[^0-9.]/g,"") * 100);
        height = (computedStyles.getPropertyValue('height').replace(/[^0-9.]/g,"") * 100);

        // find the greater dim
        if (width >= height) {
            max = (width / 2);
        } else {
            max = (height / 2);
        }

        //if all rads are equal...
        if (   borderRadTL == borderRadTR
            && borderRadTL == borderRadBL
            && borderRadTL == borderRadBR ) {
                // set the singular variable
                borderRadAll = borderRadTL;
            }

        if (typeof borderRadAll !== 'undefined') {
            range = (max - borderRadAll);
            element.style.borderRadius = (max / 100) + 'px';
        } else {
            // Use max - radius to calculate the range for each corner.
            rangeTL = (max - borderRadTL);
            rangeTR = (max - borderRadTR);
            rangeBL = (max - borderRadBL);
            rangeBR = (max - borderRadBR);
        }
        // set the scene
        element.style.transform = 'scale(0)';
        element.style.overflow = 'hidden';

    }//initZoom()

    // Init the zoom vars ready for use
    if (typeof computedStyles == 'undefined') {
        initZoom(element);
    }
    */


    /*
     * Restore the original css values
     *
     * Currently unable to reliably return properties to original value.
     * Omitting for another day.
     */
    function cleanup() {
        for (const [key, value] of Object.entries(storedCSS)) {
            element.style[key] = value;
        }
    }//cleanup()


    /*
     * Check the stored CSS properties for null.
     *
     * When a null value is found, set the value as revert
     *
     */
    function checkForNullProperty(propertyArray) {
        for (let [key, value] of Object.entries(propertyArray)) {
            if (value == '' || value == 'none' || value == 'undefined') {
                value = 'revert';
            }
        }
    }//checkForNullProperty()


})();//hb_animationPlugin();
