
/* jQuery wtf??? */


const mobilePopupMenu = () => {

	let timerElapsed = true;
	let thumbNavDisplayed = true;
	let prevScrollpos = window.pageYOffset;
	let currentScrollPos;
		
	window.onscroll = function(){
		currentScrollPos = window.pageYOffset;
		
		if (timerElapsed) {
			timerElapsed = false;

			setTimeout(function(){
				if (prevScrollpos > currentScrollPos && thumbNavDisplayed == false) {
					$('.thumbNav-jshide').css({"transform":"translateY(0rem)"});
					thumbNavDisplayed = true;
				} else if (prevScrollpos < currentScrollPos && thumbNavDisplayed == true) {
					$('.thumbNav-jshide').css({"transform":"translateY(5rem)"});
					$('.thumbNav_checkbox').prop('checked', false);
					thumbNavDisplayed = false;
				}

				prevScrollpos = currentScrollPos;
				timerElapsed = true;

			}, 500);
		}
	};

};

export { mobilePopupMenu };
