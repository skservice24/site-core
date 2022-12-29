import $ from 'jquery'
import merge from 'lodash/merge'
import ResizeSensor from '../vendor/ResizeSensor'
import ApplicationInit from './app/init.js'
import isDesktop from './utils/isDesktop';
import imageInCache from './utils/imageInCache';
import { show as showOverlay, hide as hideOverlay } from './utils/overlay'
import Panel from './panel';
import popup from './app/popup';

import './modules/jquery.setHtmlByUrl.js';
import './modules/readmore';

window.RS = window.RS || {};
merge(window.RS, {
	Init: ApplicationInit,
	Animations: {},
	EventHandlers: {},
	Utils: {
		Popper: Popper,
		ResizeSensor: ResizeSensor,
		isDesktop: isDesktop,
		imageInCache: imageInCache,
		popup: popup,
		overlay: {
			show: showOverlay,
			hide: hideOverlay
		}
	},
});


$(document).ready(function () {
	const panel = new Panel;

	merge(window.RS, {
		Panel: panel
	});
});

