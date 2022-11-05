/**
 * CSS Animation Module.
 *
 * Animate CSS properties using preset eases.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2022, Jefferson Real
 */

/**
 * True when modal is displayed.
 */
let active;


/**
 * Iterate through the IN animation passed by sequence()
 */
function doAnimation( element, property, ease, startValue, endValue, duration ) {

	let fps		      = 60;
	let iterations	  = fps * ( duration / 1000 );
	let range		  = endValue - startValue;
	let timeIncrement = ( duration ) / iterations;
	let currentValue  = 0;
	let time		  = 0;
	let isIncreasing  = endValue >= startValue; //boolen to test for positive increment

	return new Promise( resolve => {
		let timer = setInterval( function() {
			time += timeIncrement;
			currentValue = nextValue(ease, startValue, time, range, duration).toFixed(2);
			if ( isIncreasing && currentValue >= endValue || !isIncreasing && currentValue <= endValue ) {
				clearInterval( timer );
				set( element, property, endValue );
				return resolve( property + ' done' );
			}
			set( element, property, currentValue );
		}, 1000/fps );
	} );
}


/**
 * Future expansion: Call the animations in sequence.
 * 
 * Handle passed arrays to perform multiple animations.
 */
 async function sequence() {
	if ( ! active ) {
		active = true;
	} else {
		active = false;
		fadeOut(overlay);
	}
}


/*
 * Animation ease.
 *
 * Eases are adapted from git repo bameyrick/js-easing-functions.
 *
 */
function nextValue(ease, startValue, time, range, duration) {

	let t = time		// Time elapsed
	let s = startValue  // Initial property value before animation
	let r = range	    // The difference between start and end values
	let d = duration	// Total duration of animation

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
}


/*
 * Update the CSS property passed by animate()
 */
function set( element, property, value ) {
	switch ( property ) {

		case 'scale':
			element.style.transform = 'scale(' + ( value ) + ')';
			element.style.opacity = ( value );
			return;

		case 'left':
			element.style.left = value + 'px';
			return;
	}
}


export const animate = async (element, property, ease, startValue, endValue, duration) => {
	await doAnimation(element, property, ease, startValue, endValue, duration);
}