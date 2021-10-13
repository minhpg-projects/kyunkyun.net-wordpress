var $ = jQuery.noConflict();
$(document).ready( function()
{
    $('.expand-act-box').click( function() {

        var collapse_content_selector = $(this).attr('id');
        var toggle_switch = $(this);
        $(collapse_content_selector).toggle( function() {
            if($(this).css('display')=='none') {
                toggle_switch.html('<i class="dashicons dashicons-unlock"></i> '+toggle_switch.text());
            } else {
                toggle_switch.html('<i class="dashicons dashicons-dismiss"></i> '+toggle_switch.text());
            }
            $('html, body').animate({
                scrollTop: $(collapse_content_selector).offset().top - 100
            }, 500);
        });
    });


    $('#update-license').click( () => {
        $('.license_status .txt').text('Checking...')
        $('#update-license').text('Updating...')
        $.ajax({
            type: 'POST',
            url: halim_license.ajax_url,
            dataType: 'json',
            data: {
                action: 'halim_check_license_details'
            },
            success: (res) => {
                $('#update-license').text('Update License')
                if(res.status == false) {
                    $('.license_status').addClass('license_invalid')
                    $('.license_invalid i').removeClass('dashicons-yes-alt').addClass('dashicons-dismiss')
                    $('.license_status .txt').text(res.message)
                    setTimeout( () => {
                        window.location.reload();
                    }, 1200)
                } else {
                    $('.license_status .txt').text('Your license is valid')
                }
            }
        });
    });

    $('#activate-license').click( () => {
        $('#activate-license').text('Activating...')
        $.ajax({
            type: 'POST',
            url: halim_license.ajax_url,
            dataType: 'json',
            data: {
                action: 'halim_activate_license',
                client_name: $('input[name="client_name"]').val(),
                license_key: $('input[name="license_key"]').val()
            },
            success: (res) => {
                $('#activate-status').show().text(res.message)
                if(res.status) {
                    $('#activate-license').text('Activated')
                    $('.license_status').removeClass('license_invalid')
                    $('.license_invalid i').addClass('dashicons-yes-alt').removeClass('dashicons-dismiss')
                    $('.license_status .txt').text('Your license is valid')
                    setTimeout( () => {
                        window.location.reload();
                    }, 1200)
                }
                 else {
                    $('#activate-license').text('Activate License')
                }
            }
        });
    });

    $('#deactivate-license').click( () => {
        $('#deactivate-license').text('Deactivating...')
        $.ajax({
            type: 'POST',
            url: halim_license.ajax_url,
            dataType: 'json',
            data: {
                action: 'halim_deactivate_license'
            },
            success: (res) => {
                if(res.status) {
                    $('#deactivate-license').text('Deactivated')
                    $('#deactivate-status').show().text(res.message)
                    $('.license_status').addClass('license_invalid')
                    $('.license_invalid i').removeClass('dashicons-yes-alt').addClass('dashicons-dismiss')
                    $('.license_status .txt').text('Your license is invalid')
                    setTimeout( () => {
                        window.location.reload();
                    }, 1200)
                } else {

                }
            }
        });
    });

});
