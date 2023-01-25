/**
 * Index file for js modules.
 * 
 * This file is used to import JS modules providing an entry point for Webpack bundling.
 * 
 * @link https://metabox.io/modernizing-javascript-code-in-wordpress/
 */

import './css/frontend/hb.css'
import './css/frontend/fonts.css'
import './css/frontend/landing.css'
import './css/frontend/landing-dev.css'

import { dropdownControl } from './js/frontend/dropdown-control'
import { hideHeader } from './js/frontend/hideheader'
import { mobilePopupMenu } from './js/frontend/mobile-popup-menu'
import { modal } from './js/frontend/modal'
import { screenClass } from './js/frontend/screenclass'
import { uspSection } from './js/frontend/usp-section'

dropdownControl.initialise()
hideHeader()
mobilePopupMenu()
modal()
screenClass()
uspSection()
