/**
 * Herrinbone USP Javascript
 *
 * Handles the USP section auto scroll and checkbox clearing.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.com>
 * @copyright Copyright (c) 2021, Jefferson Real
 */


function toggleCheckboxes(chkBx) {
	// toggle all checkboxes to false
	let cbArray = document.getElementsByClassName(chkBx);
	for(var i = 0; i < cbArray.length; i++){
		cbArray[i].checked = false;
	}

	cbArray[0].parentElement.scrollIntoView();
}
