import jQuery from 'jquery'
window.$ 		= jQuery;
window.jQuery 	= jQuery;
import 'bootstrap';
import selectpicker from 'bootstrap-select';

const ContactForm = function() {

    'use strict';

    const form = $('#contactForm');
    const formCard = $('#formCard');

    const submitButton = form.find('button[type="submit"]');
    const originalSubmitHtml = submitButton.html();

    const dismissButton = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    const errorAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+dismissButton+'<i class="fa fa-exclamation-circle"></i> Whoops! It looks like something went wrong. Please correct any errors listed and try again.</div>';
    const successAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+dismissButton+'<i class="fa fa-check-circle"></i> Thanks for getting in touch. We will get back to you as soon as we can.</div>';

    function eventListeners() {
        form.submit(function(e) {
            e.preventDefault();

            const data = form.serialize();

            $.ajax(form.prop('action'), {
                method: form.prop('method'),
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
                        formCard.prepend(errorAlert);

                        if(Object.keys(response.errors).length > 0) {
                            // If there are validation errors, which got through the HTML validation and PHP has rejected them
                            // Show them to the user, so they can be corrected and re-submitted.
                            let errors = '<ul class="list-group mt-3">';
                            $.each(response.errors, function (key, value) {
                                errors += '<li class="ml-5">'+value+'</li>';
                            });
                            errors += '</ul>';
                            formCard.find('.alert-dismissible').append(errors);
                        }
                    } else {
                        formCard.prepend(successAlert);
                        form[0].reset();
                        $('.selectpicker').selectpicker('refresh');
                    }
                    submitButton.html(originalSubmitHtml);
                },
                // A non-200 response code.
                error: function(response) {
                    formCard.prepend(errorAlert);
                    submitButton.html(originalSubmitHtml);
                    console.error(response);
                },
            })
        });
    };

    this.init = function() {
        $('#categoryId').addClass('selectpicker').selectpicker();

        eventListeners();
    };
};

// Export the object so it could be imported into other Javascript files.
export default ContactForm;