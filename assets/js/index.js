import jQuery from 'jquery'
window.$ 		= jQuery;
window.jQuery 	= jQuery;
import "../css/app.scss";

// Import the JS to handle the contact form.
import ContactForm from './contactForm.js';

(function($) {
    'use strict';

    // Initialise the object
    const contactForm = new ContactForm();
    contactForm.init();
})(jQuery);