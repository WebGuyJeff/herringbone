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
	
		const tumbleweedID = '#svg_tumbleweed'
		const cardClass    = '.lilCards_card'
		const flipClass    = '.lilCards_flip'
		const iconClass    = '.lilCards_tapIcon'
		
		const target    = document.querySelector( tumbleweedID )
		const cards     = document.querySelectorAll( cardClass )
		const flipCards = document.querySelectorAll( flipClass )
		const container = target.parentElement
	
		// Setup card interactivity.
		
		const pulseAnimation = ( elem ) => {
			const tl = gsap.timeline()
				tl.set( elem.closest( cardClass ), { zIndex: 10 } )
				tl.set( elem, { scale: 0.75, boxShadow: '0 0 0 0 #3335', opacity: 1 } )
				   .to( elem, { scale: 1, boxShadow: '0 0 0 25px #0000', duration: 1 } )
				tl.set( elem.closest( cardClass ), { zIndex: 0 } )
			return tl
		}
		
		const hoverIn  = ( e ) => pulseAnimation( e.target.closest( cardClass ).querySelector( iconClass ) ).play()
		
		const hoverOut = ( e ) => {
			gsap.set( e.target.closest( cardClass ), { zIndex: 0 } )
			gsap.to( e.target.closest( cardClass ).querySelector( iconClass ), { opacity: 0.5, duration: 0.15 } )
		}
		
		const click    = ( e ) => {
			const elem = e.target.closest( flipClass )
			const deg  = elem.style.transform.includes( 'rotateY(180deg)' ) ? 0 : 180
			gsap.to( elem, { rotationY: deg, duration: 0.15 } )
		}
		
		const addListeners = () => {
			flipCards.forEach( ( card ) => {
				card.addEventListener( 'mouseenter', hoverIn )
				card.addEventListener( 'mouseleave', hoverOut )
				card.addEventListener( 'click', click )
			} )
		}
		addListeners()
		
		const removeListeners = () => {
			flipCards.forEach( ( card ) => {
				card.removeEventListener( 'mouseover', hoverIn )
				card.removeEventListener( 'mouseleave', hoverOut )
				card.removeEventListener( 'click', click )
			} )
		}
		
		flipCards.forEach( ( card ) => {
			const icon = card.querySelector( iconClass )
			gsap.timeline( {
				defaults: { force3D:true },
				scrollTrigger: {
					trigger: card,
					/*
					 * toggleActions*: [onEnter] [onLeave] [onEnterBack] [onLeaveBack].
					 * *OPTIONS: play | pause | resume | reset | restart | complete | reverse | none.
					 */
					toggleActions: "play reset play reset",
					// start: [trigger element position] [viewport position].
					start: 'bottom bottom'
				} } )
				.add( pulseAnimation( icon ) )
				.to( icon, { opacity: 0.5, duration: 0.15 } )
		} )
		
		// Setup tumbleweed animation.
	
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
					  .to( card, { background: '#fff', rotateX: 10, duration: 0.2 }, 0.2 )
					  .to( card, { background: '#e9e9e9', rotateX: 6, duration: 0.2 }, 0.4 )
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
