import jQuery from 'jquery'
window.$ 		= jQuery;
window.jQuery 	= jQuery;
import "../css/app.scss";

// Import the JS to handle the contact form.
import contactForm from './contactForm.js'

(function($) {
    'use strict';

    // Initialise the object
    contactForm.init();
})(jQuery);