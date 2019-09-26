import jQuery from 'jquery'
window.$ 		= jQuery;
window.jQuery 	= jQuery;
import 'bootstrap';
import selectpicker from 'bootstrap-select';

(function($) {

    'use strict';

    const contactForm = function() {

        this.init = function() {
            $('.selectpicker').selectpicker();

            this.eventListeners();

            return true;
        };

        this.eventListeners = function() {
            $('.js-form-submit').off().on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const data = form.serialize();
                const url = form.prop('action');
                const cardBody = $('.card-body');

                const submitButton = form.find('button[type="submit"]');
                const originalSubmitHtml = submitButton.html();

                const dismissButton = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                const errorAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+dismissButton+'<i class="fa fa-exclamation-circle"></i> Whoops! It looks like something went wrong. Please try again later.</div>';
                const successAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+dismissButton+'<i class="fa fa-check-circle"></i> Thanks for getting in touch. We will get back to you as soon as we can.</div>';

                $.ajax(url, {
                    method: 'POST',
                    data: data,
                    dataType: 'JSON',
                    beforeSend: function(xhr) {
                        const savingSpinner = 'Saving...&nbsp;<i class="fa fa-spin fa-spinner"></i>';
                        submitButton.html(savingSpinner);
                        $('.alert-dismissible').remove();
                    },
                    success: function(response) {
                        // If we have a 200 response code, but PHP tells us it has failed
                        if(response.success !== true) {
                            console.error(response);
                            cardBody.prepend(errorAlert);

                            if(Object.keys(response.errors).length > 0) {
                                // If there are validation errors, which got through the HTML validation and PHP has rejected them
                                // Show them to the user, so they can be corrected and re-submitted.
                                let errors = '<ul class="list-group mt-3">';
                                $.each(response.errors, function (key, value) {
                                    errors += '<li class="ml-5">'+value+'</li>';
                                });
                                errors += '</ul>';
                                cardBody.find('.alert-dismissible').append(errors);
                            }
                        } else {
                            cardBody.prepend(successAlert);
                            form[0].reset();
                            $('.selectpicker').selectpicker('refresh');
                        }
                        submitButton.html(originalSubmitHtml);
                    },
                    // A non-200 response code.
                    error: function(response) {
                        cardBody.prepend(errorAlert);
                        submitButton.html(originalSubmitHtml);
                        console.error(response);
                    },
                })
            });

            return true;
        };
    };

    //return the object for global use
    $.contactForm = function() {
        return new contactForm();
    };

})(jQuery);

window.contactForm = $.contactForm();

// Export the object so it could be imported into other Javascript files.
export default window.contactForm;