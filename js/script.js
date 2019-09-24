$(document).ready(function() {
    const jq_form = $('#contact-form');
    const a_inputs = jq_form.find('input, textarea');
    const jq_submit = jq_form.find('button');
    const jq_error_container = $('#error-container');
    const jq_country = $('#country');
    const jq_phone = $('#phone');

    // Sets mask for phone input.
    maskPhone(jq_country, jq_phone);

    // Switches masks for phone input on change country.
    jq_country.on('change', function (e) {
       maskPhone(jq_country, jq_phone);
    });

    // Checks if form can be submit.
    a_inputs.on('keyup', function(e){
        if(canSubmit(a_inputs))
            jq_submit.prop('disabled', false).css({'background-color': '#42A9FF'});
        else
            jq_submit.prop('disabled', true).removeAttr('style');
    });

    /**
     * Submits form.
     *
     * @link http://jquery.page2page.ru/index.php5/Ajax-%D0%B7%D0%B0%D0%BF%D1%80%D0%BE%D1%81 jQuery.ajax()
     */
    jq_form.on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "./ajax_form.php",
            type: "POST",
            dataType: false, // data type of response from server, false - auto detect.
            data: jq_form.serialize(),
            success: function(response) {
                let a_result = $.parseJSON(response);
                if(a_result.a_errors.length > 0) {
                    let html_errors = '';
                   $.each(a_result.a_errors, function (i, text_error) {
                        html_errors += '<div>' + text_error + '</div>';
                    });
                    jq_error_container.html(html_errors)
                } else {
                    jq_error_container.empty();
                    let text_storage = $('#storage option:selected').text();
                    $('#contact-container').html('Спасибо, ' + a_result.html_name + '!<br> Данные сохранены в \"'
                        + text_storage + '\".'
                    );
                }
            },
            error: function(response) {
                jq_error_container.html('<div>Ошибка. Данные не отправлены.</div>');
            }
        });
    });
});

/**
 * Checks that all inputs are not empty.
 *
 * @param {[jQuery]} a_inputs Array of inputs for check.
 * @returns {boolean} Whether form can be submitted.
 */
function canSubmit (a_inputs){
    let can_submit = true;
    a_inputs.each(function () {
        let text_value = $(this).val().trim();
        if(text_value.length == 0){
            can_submit = false;
            return false;
        }
    });

    return can_submit;
}

/**
 * Switches masks for phone in dependence of country.
 *
 * @param {jQuery} jq_country Select of country.
 * @param {jQuery} jq_phone Input of phone number.
 *
 * @link https://itchief.ru/lessons/javascript/input-mask-for-html-input-element Masked input
 */
function maskPhone(jq_country, jq_phone) {
    const text_country = jq_country.find('option:selected').val();
    switch (text_country) {
        case "ru":
            jq_phone.mask("+7 (999) 999-99-99");
            break;
        case "ua":
            jq_phone.mask("+38 (099) 999-99-99");
            break;
        case "by":
            jq_phone.mask("+37 (599) 999-99-99");
            break;
    }
}