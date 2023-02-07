/**
 * Herringbone RollBy Animation Javascript
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

const animateRollBy = () => {

	gsap.registerPlugin( ScrollTrigger )
	gsap.ticker.fps( 30 )
	
	window.onload = () => {
	
		const target    = document.querySelector( '#svg_tumbleweed' )
		const cards     = document.querySelectorAll( '.lilCards_card' )
		const container = target.parentElement
	
		// Setup hover effect with GSAP to avoid CSS conflict.
		const hoverIn = ( e ) => gsap.to( e.target.closest( '.lilCards_card' ), { scale: 1.05, duration: 0.15 } )
		const hoverOut = ( e ) => gsap.to( e.target.closest( '.lilCards_card' ), { scale: 1, duration: 0.15 } )
		const addListeners = () => {
			cards.forEach( ( card ) => {
				card.addEventListener( 'mouseover', hoverIn )
				card.addEventListener( 'mouseleave', hoverOut )
			} )
		}
		const removeListeners = () => {
			cards.forEach( ( card ) => {
				card.removeEventListener( 'mouseover', hoverIn )
				card.removeEventListener( 'mouseleave', hoverOut )
			} )
		}
		addListeners()
	
		const getRollTime = () => {
			const w = window.innerWidth
			if ( w < 768 ) return 1
			if ( w >= 768 && w < 1920 ) return 1.5
			if ( w >= 1920 ) return 2.2
		}
		
		const getRollWeedTween = () => {
			const circumference = ( target.clientWidth / 2 ) * 2 * Math.PI
			const distance      = () => target.clientWidth + container.clientWidth
			const rotation      = () => distance() / circumference * 360
			const tl = gsap.timeline( { defaults: { ease: "none", duration: getRollTime() } } )
				tl.fromTo( target, { x: 0 }, { x: distance() }, 0 )
				  .fromTo( target, { rotation: -rotation() }, { rotation: 0 }, 0 )
			return tl
		}
	
		const getSpinCardsTween = () => {
			const getSpin = ( card ) => {
				const tl = gsap.timeline( { repeat: 1 } )
				tl.fromTo( card, { rotateY: 0 }, { rotateY: 360, duration: 0.8, ease: "none" } )
				  .fromTo( card, { background: '#fff', rotateX: 0 }, { background: '#e9e9e9', rotateX: 6, duration: 0.2 }, 0 )
					  .to( card, { background: '#fff', rotateX: 10,duration: 0.2 }, 0.2 )
					  .to( card, { background: '#e9e9e9', rotateX: 6,duration: 0.2 }, 0.4 )
					  .to( card, { background: '#fff', rotateX: 0, duration: 0.2, clearProps: 'transform' }, 0.6 )
				return tl
			}
			const getAllSpins = () => {
				const tl    = gsap.timeline()
				cards.forEach( ( card ) => {
					tl.add( getSpin( card ), Math.random() / 2 ) // Random delay between 0 - 0.5.
				} )
				return tl
			}
			const spinCards = () => {
				const tl = gsap.timeline()
					.to( getAllSpins(), { duration: 1.5, progress: 1, ease: "circ" } )
				return tl
			}
			return spinCards
		}
	
		const newMaster = () => {
			const master = gsap.timeline( {
				defaults: { force3D:true },
				scrollTrigger: {
					trigger: container,
					/*
					 * toggleActions*: [onEnter] [onLeave] [onEnterBack] [onLeaveBack].
					 * *OPTIONS: play | pause | resume | reset | restart | complete | reverse | none.
					 */
					toggleActions: "play reset reset reset",
					// start: [trigger element position] [viewport position].
					start: 'top center'
				} } )
				.call( removeListeners, null, 0 )
				.add( getRollWeedTween() )
				.add( getSpinCardsTween(), getRollTime() * .33 )
				.call( addListeners, null, '+=0.5' )
			return master
		}
		let master = newMaster()
	
		window.addEventListener( 'resize', () => {
			master.kill()
			master = newMaster()
		} )
	}

}

export { animateRollBy }
