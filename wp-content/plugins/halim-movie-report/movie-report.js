  jQuery(document).ready(function ($) {
        var clickedButton;
        var currentForm;
        $('.halim-submit').prop("disabled", false);
        $('.halim-switch').click(function () {
            jQuery('body').append('<div class="modal fade" id="ajax-reportModal" tabindex="-1" role="dialog"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title text-success"><i class="hl-attention"></i> '+halim_cfg.report_lng.report_btn+'</h4></div><div class="modal-body" style="overflow:hidden;"><div class="halim-content col-xs-12"><div class="halim-message"></div><div class="halim-form"><div class="col-xs-12"><div class="form-group"><label for="input-name">'+halim_cfg.report_lng.name_or_email+'*</label><div class="col-md-12"><input type="text" class="form-control input-name" id="input-name"></div></div><div class="form-group"><label for="input-content"><br/>'+halim_cfg.report_lng.msg+'*</label><div class="col-md-12"><textarea rows="5" class="form-control input-content col-md-12" id="input-content"></textarea></div></div></div></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">'+halim_cfg.report_lng.close+'</button><button type="button" class="btn btn-danger pull-right halim-submit"> '+halim_cfg.report_lng.report_btn+'</button><img class="loading-img" style="display:none;" src="'+halim_cfg.report_lng.loading_img+'"></div></div></div></div>');
            jQuery('#ajax-reportModal').modal('show');
   });

   $('body').on('click', '.halim-submit', function () {
        clickedButton = $(this);
        currentForm = $('.halim-content');
        var _content = currentForm.find('.input-content').val();
        var _name = currentForm.find('.input-name').val();

        if(_name == '' || _content == '') {
             currentForm.find('.halim-message').html('<div class="alert alert-danger" role="alert">'+ halim_cfg.report_lng.alert +'</div>');
             return false;
        }
        clickedButton.prop("disabled", true);
        currentForm.find('.loading-img').show();
        $.ajax({
            type: 'POST',
            url: ajax_player.url,
            data: {
                action: 'halim_report',
                id_post: halim_cfg.post_id,
                server: halim_cfg.server,
                episode: halim_cfg.episode,
                post_name: $('h1.entry-title').text() + ' server ' + halim_cfg.server,
                halim_error_url: encodeURI(window.location) + '#by_user',
                content: _content,
                name: _name
            },
            success: function (data) {
                currentForm.find('.halim-message').html('<div class="alert alert-success" role="alert">'+ halim_cfg.report_lng.msg_success +'</div>');
                currentForm.find('.halim-form, .loading-img').hide();
            },
            error: function (e) {
                alert('Error!');
            }
        });
    });
});