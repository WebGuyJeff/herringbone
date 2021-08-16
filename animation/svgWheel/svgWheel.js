gsap.registerPlugin(ScrollTrigger, CSSRulePlugin);

window.onload = ()=>{

// declare start position var
let offScreen = $(".svgWheel").parent().width();

    // function wrapper for timeline 1 - Set the stage 0s
    function wheelInit() {

        // set initial states
        let tl = gsap.set(".svgWheel", { x:0-(offScreen), visibility:"visible", rotation:0});

        return tl;
    }

    // function wrapper for timeline 2 - Intro 2.5s
    function wheelIn() {

        // Wheel intro timeline
        let tl = gsap.timeline({defaults:{ease:"elastic.out(1,0.8)", duration: 2.5}})

        // define tween actions
        .fromTo(".svgWheel", {x:0-(offScreen)}, {x:0}, 0)
        .fromTo(".svgWheel", {rotation:-720}, {rotation:0}, 0)
        .fromTo(".svgWheel_rectRim", {rotation:720}, {rotation:0, transformOrigin:"50% 50%"}, 0)
        .fromTo(".svgWheel_lightingShading", {rotation:720}, {rotation:0, transformOrigin:"50% 50%"}, 0);

        return tl;
    }

    // function wrapper for timeline 3 - Outro 2s
    function wheelOut() {

        // Wheel outro timeline
        let tl = gsap.timeline({defaults:{ease:"power3.in"}})

        // accellerate to right
        .to(".svgWheel", {x:offScreen, duration: 2}, 0)
        .to(".svgWheel", {rotation:2880, duration: 2}, 0)
        .to(".svgWheel_rectRim", {rotation:-2880, transformOrigin:"50% 50%", duration: 2}, 0)
        .to(".svgWheel_lightingShading", {rotation:-2880, transformOrigin:"50% 50%", duration: 2}, 0);

        return tl;
    }

    // Wheel master timeline - 4.5s
    let wheelMaster = gsap.timeline({repeat:99, defaults:{force3D:true},
        scrollTrigger:{ // scrollTrigger on element animation_wrap-wheel top = viewport centre
            trigger:'.animation_wrap-wheel',
            toggleActions: "play none none pause", // onEnter onLeave onEnterBack onLeaveBack
            start:'top center'                       // OPTIONS -  play pause resume reset restart complete reverse none
        }})

        // Add all the wheel timelines to the master
        .add(wheelInit())
        .add(wheelIn())
        .add(wheelOut(),"-=1"); // Overlap previous timeline by 1 second

}
