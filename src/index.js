/**
 * Index file for all js modules.
 * 
 * This file is used to import all JS modules providing an entry point for Webpack bundling.
 * 
 * @link https://metabox.io/modernizing-javascript-code-in-wordpress/
 */

import { dropdownMenu } from './js/dropdown-menu.js';
import { hideHeader } from './js/hideheader';
import { mobilePopupMenu } from './js/mobile-popup-menu';
import { cssAnimator } from './js/css-animator';
import { modal } from './js/modal';
import { screenClass } from './js/screenclass';
import { uspSection } from './js/usp-section';

dropdownMenu();
hideHeader();
mobilePopupMenu();
cssAnimator();
modal();
screenClass();
uspSection();
