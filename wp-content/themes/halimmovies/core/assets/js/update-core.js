var $ = jQuery.noConflict();
$('#check-update-btn').click(function(){
    $(this).html('Cheking update...');
    CheckUpdate();

});

$('#download-update-btn').click(function(){
    $('#msg, #status, #prog').show();
    $('#msg').html('<p>Preparing to download main update...</p>');
    DownloadUpdate();
});

function CheckUpdate() {
    $.ajax({
        type: 'POST',
        url: halim_license.ajax_url,
        data: {
            action: 'halim_check_update'
        },
        success: function(data) {
            console.log(data);
            $('#halim_check_update_box p strong').html(data.message);
            if(data.status) {
                // $('#msg').show().html('Click <a href="javascript:location.reload();"><strong>Reload Page</strong></a> to get the update');
                setTimeout( function() {
                    window.location.reload();
                }, 1200)
            }
            $('#check-update-btn').text('Check Update');
        }
    });
}


function DownloadUpdate() {
    var progressTimer;
    $.ajax({
        type: 'POST',
        url: halim_license.ajax_url,
        data: {
            action: 'halim_download_update',
            update_id: $('input[name=update_id]').val(),
            has_sql: $('input[name=has_sql]').val(),
            version: $('input[name=version]').val()
        },
        success: function(data) {
            console.log(data);
            // reset_percentage();
        }
    });
    progressTimer = setInterval(function() {
        getProgress(progressTimer);
    }, 1000);
}

function reset_percentage(){
    $.ajax({
        type: 'POST',
        url: halim_license.ajax_url,
        data: {
            action: 'halim_reset_percentage'
        },
        success: function(data) {
            console.log(data);
        }
    });

}

function getProgress(progressTimer) {

    $.ajax({
        url: halim_license.progress_url,
        type: 'GET',
        dataType: 'html',
        cache: false,
        success: function(data) {
            var percentage = parseInt(data);
            $('#status').html(percentage+'%');
            $('#prog')[0].value = percentage;
            if(percentage > 20) $('#msg').html('<p>Downloading main update... please don\'t refresh</p>');
            if(percentage >= 100) {
                clearInterval(progressTimer);
                $('#msg').html('<p>Done! <a href="update-core.php?force-check=1"><strong>Click here to Install Update</strong></a></p>');
                reset_percentage();
            }
        }
    });
}
