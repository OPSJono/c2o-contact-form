import _ from 'lodash';
import jQuery from 'jquery'
window.$ 		= jQuery;
window.jQuery 	= jQuery;
// import 'bootstrap'; ///add the full javascript functions for bootstrap 4 (if you need it)
import "./css/app.scss";

function init() {
    const showError = function() {
        $('.js-has-error').show();
    };

    const hideError = function() {
        $('.js-has-error').hide();
    };

    const hideSuccess = function() {
        $('.js-has-success').hide();
    };

    const showSuccess = function() {
        $('.js-has-success').show();
    };

    const showSaving = function() {
        $('.js-has-saving').show();
    };

    const hideSaving = function() {
        $('.js-has-saving').hide();
    };

    const resetForm = function() {
        $('.js-form-submit')[0].reset();
    };

    $('.js-form-submit').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let data = form.serialize();
        let url = form.prop('action');

        $.ajax(url, {
            method: 'POST',
            data: data,
            dataType: 'JSON',
            beforeSend: function(xhr) {
                showSaving();
            },
            success: function(response) {
                hideSaving();

                // If we have a 200 response code, but PHP tells us it has failed
                if(response.success !== true) {
                    hideSuccess();
                    showError();
                    console.error(response);
                } else {
                    // Successful response
                    hideError();
                    showSuccess();
                    resetForm();
                }
            },
            // A non-200 response code.
            error: function(response) {
                hideSaving();
                hideSuccess();
                showError();
                console.error(response);
            },
        })
    });
}

$(document).ready(function() {
    init();
});