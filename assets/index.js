import _ from 'lodash';
import jQuery from 'jquery'
window.$ 		= jQuery;
window.jQuery 	= jQuery;
import 'bootstrap';
import selectpicker from 'bootstrap-select';
import "./css/app.scss";

function init() {

    $('.selectpicker').selectpicker();

    $('.js-form-submit').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const data = form.serialize();
        const url = form.prop('action');
        const cardBody = $('.card-body');

        const submitButton = form.find('button[type="submit"]');
        const originalSubmitHtml = submitButton.html();

        const dismissButton = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
            '    <span aria-hidden="true">&times;</span>\n' +
            '  </button>';
        const errorAlert = '<div class="alert alert-danger alert-dismissible fade show" role="alert">'+dismissButton+'<i class="fa fa-exclamation-circle"></i> Whoops! It looks like something went wrong. Please try again later.</div>';
        const successAlert = '<div class="alert alert-success alert-dismissible fade show" role="alert">'+dismissButton+'<i class="fa fa-check-circle"></i> Thanks for getting in touch. We will get back to you as soon as we can.</div>';

        $.ajax(url, {
            method: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function(xhr) {
                const savingSpinner = 'Saving... <i class="fa fa-spin fa-spinner">';
                submitButton.html(savingSpinner);
                $('.alert-dismissible').remove();
            },
            success: function(response) {
                // If we have a 200 response code, but PHP tells us it has failed
                if(response.success !== true) {
                    console.error(response);
                    cardBody.prepend(errorAlert);
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
}

$(document).ready(function() {
    init();
});