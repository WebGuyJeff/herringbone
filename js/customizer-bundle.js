/**
 * Theme Name: Herringbone
 * Theme URI: https://github.com/wordpressjeff/herringbone#readme
 * Author: Jefferson Real
 * Author URI: https://jeffersonreal.uk
 * Description: A WordPress theme for my developer site and blog.
 * Tags: blog, sidebar, 2-column, 3-column, custom-logo, sidebar-widgets
 * Version: 0.6.2
 * Requires at least: 5.0
 * Tested up to: 6.1.1
 * Requires PHP: 8.0
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: herringbone
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/customizer/customizer.js":
/*!*****************************************!*\
  !*** ./src/js/customizer/customizer.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "customizer": () => (/* binding */ customizer)
/* harmony export */ });
/**
 * Customizer Module.
 *
 * Manage WP Customizer interface.
 *
 * @package herringbone
 * @author Jefferson Real <me@jeffersonreal.uk>
 * @copyright Copyright (c) 2023, Jefferson Real
 */

function customizer() {

console.log( 'This module will contain customizer JS' )

}




/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***************************!*\
  !*** ./src/customizer.js ***!
  \***************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _js_customizer_customizer_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./js/customizer/customizer.js */ "./src/js/customizer/customizer.js");
/**
 * Index file for js modules.
 * 
 * This file is used to import JS modules providing an entry point for Webpack bundling.
 * 
 * @link https://metabox.io/modernizing-javascript-code-in-wordpress/
 */



(0,_js_customizer_customizer_js__WEBPACK_IMPORTED_MODULE_0__.customizer)()

})();

/******/ })()
;
//# sourceMappingURL=customizer-bundle.js.map