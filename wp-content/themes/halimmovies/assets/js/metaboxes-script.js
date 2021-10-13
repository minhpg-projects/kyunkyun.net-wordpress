jQuery(function ($) {
	$(document).on('keyup','.halimmovies_server_name', function(){
		var server = $(this).data("server");
		var value = $(this).val();
		// console.log(value);
		$('#tab_title_'+server).html(value);
	})

	$(".nav-tabs").on("click", "a", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('add-server')) {
            $(this).tab('show');
        }
    })
    .on("click", "span", function () {
        var anchor = $(this).siblings('a');
        $(anchor.attr('href')).remove();
        $(this).parent().remove();
        $(".nav-tabs li").children('a').first().click();
    });
    // add new server
	$('.add-server').click(function (e) {
	    e.preventDefault();
	    var server = $(".nav-tabs").children().length;
	    var tabId = 'server_' + server;
	    // var episode_slug_default = 'tap';
	    $(this).closest('li').before('<li><a href="#server_' + server + '" id="tab_title_'+server+'">Server #'+server+'</a> <span> x </span></li>');
	    var ep = 1;
	    var new_server = '<div class="tab-pane active" id="'+tabId+'" data-server="'+server+'"><div id="halimmovies_episodes_'+server+'" class="row form-horizontal"><div class="row"><div class="form-group col-lg-2"><label for="halimmovies_server_name_'+server+'"><h3>Server Name</h3></label><input id="halimmovies_server_name_'+server+'" type="text" class="halimmovies_server_name form-control" name="halimmovies_server_name['+server+']" value="Server #'+server+'" data-server="'+server+'"></div></div><h3>List Episode <a style="cursor: pointer;" class="add_new_ep" data-ep-total="1" data-server="'+server+'"><span class="dashicons dashicons-plus"></span><span>Add Eps</span></a></h3><div class="halimmovies_episodes episodes_'+ep+' row" data-ep="'+ep+'" data-server="'+server+'"><div class="form-group col-lg-1" style="margin-right: -1px"><label for="halimmovies_ep_name_'+server+'_'+ep+'">Episode Name</label><input id="halimmovies_ep_name_'+server+'_'+ep+'" name="halimmovies_ep_name['+server+']['+episode_slug_default+'_'+ep+']" type="text" class="form-control" value="'+episode_name_default+' 1" placeholder="Episode name"></div>'+

			'<div class="form-group col-lg-1" style="margin-right: -1px"><label for="halimmovies_ep_slug_'+server+'_'+ep+'">Episode Slug</label><input id="halimmovies_ep_slug_'+server+'_'+ep+'" name="halimmovies_ep_slug['+server+']['+episode_slug_default+'_'+ep+']" type="text" class="form-control" value="'+episode_slug_default+'-'+ep+'" placeholder="Episode slug"></div>'+

	    	'<div class="form-group col-lg-2" style="margin-right: -1px"><label>Type: </label><select name="halimmovies_ep_type['+server+']['+episode_slug_default+'_'+ep+']" id="halimmovies_ep_type_'+server+'_'+ep+'" style="display:block;width:100%;margin-top:5px;height: 30px;">'+episode_type+'</select></div>'+

	    	'<div class="form-group col-lg-8"><label for="halimmovies_ep_link_'+server+'_'+ep+'">Link: </label><input class="form-control" type="text" id="halimmovies_ep_link_'+server+'_'+ep+'" name="halimmovies_ep_link['+server+']['+episode_slug_default+'_'+ep+']" style="width:100%" value="" placeholder="Episode link"/></div>'+

	    	'<div class="form-group col-lg-12 list-subtitle"><a role="button" data-toggle="collapse" href="#halimmovies_subs_'+server+'_'+episode_slug_default+'_'+ep+'" aria-expanded="false" aria-controls="halimmovies_subs_'+server+'_'+episode_slug_default+'_'+ep+'" class="expand-list-subs"><span class="dashicons dashicons-leftright rotate-right"></span> Subtitle</a><div id="halimmovies_subs_'+server+'_'+episode_slug_default+'_'+ep+'" class="collapse listsub"><a style="cursor: pointer;" class="add_new_sub" data-ep="'+ep+'" data-server="'+server+'">Add Subtitle</a></div></div><div class="form-group col-lg-12"><a role="button" data-toggle="collapse" href="#halimmovies_listsv_'+server+'_'+episode_slug_default+'_'+ep+'" aria-expanded="false" aria-controls="halimmovies_listsv_'+server+'_'+episode_slug_default+'_'+ep+'" class="expand-list-sv"><span class="dashicons dashicons-leftright rotate-right"></span> Server</a><div id="halimmovies_listsv_'+server+'_'+episode_slug_default+'_'+ep+'" class="collapse list-server-sortable"><a style="cursor: pointer;" class="add_new_listsv" data-ep="'+ep+'" data-server="'+server+'"><span class="dashicons dashicons-leftright rotate-right"></span> Add Server</a></div></div></div></div></div>';
	    $('.tab-content').append('<div class="tab-pane" id="' + tabId + '" data-server="'+server+'">'+new_server+'</div>');
	   $('.nav-tabs li:nth-child(' + server + ') a').click();
	});

	// add new ep
	$(document).on("click", ".add_new_ep", function(){
		var ep_total = $(this).data("ep-total");
		var ep = ep_total + 1;
		$(this).data('ep-total',ep);
		var server = $(this).data("server");
		// var episode_slug_default = 'tap';
		var new_ep = '<div class="halimmovies_episodes episodes_'+episode_slug_default+'_'+ep+' row" data-ep="'+ep+'" data-server="'+server+'"><div class="form-group col-lg-1" style="margin-right: -1px"><label for="halimmovies_ep_name_'+server+'_'+ep+'">Episode Name</label><input id="halimmovies_ep_name_'+server+'_'+ep+'" name="halimmovies_ep_name['+server+']['+episode_slug_default+'_'+ep+']" type="text" class="form-control" value="'+ep+'" placeholder="Episode name"></div>'+

'<div class="form-group col-lg-1" style="margin-right: -1px"><label for="halimmovies_ep_slug_'+server+'_'+ep+'">Episode Slug</label><input id="halimmovies_ep_slug_'+server+'_'+ep+'" name="halimmovies_ep_slug['+server+']['+episode_slug_default+'_'+ep+']" type="text" class="form-control" value="'+episode_slug_default+'-'+ep+'" placeholder="Episode Slug"></div>'+

		'<div class="form-group col-lg-2" style="margin-right: -1px"><label>Type: </label><select name="halimmovies_ep_type['+server+']['+episode_slug_default+'_'+ep+']" id="halimmovies_ep_type_'+server+'_'+ep+'" style="display:block;width:100%;margin-top:5px;height: 30px;">'+episode_type+'</select></div>'+

		'<div class="form-group col-lg-8"><label for="halimmovies_ep_link_'+server+'_'+ep+'">Link: </label><input class="form-control" type="text" id="halimmovies_ep_link_'+server+'_'+ep+'" name="halimmovies_ep_link['+server+']['+episode_slug_default+'_'+ep+']" style="width:100%" value="" placeholder="Episode link"/></div>'+

		'<div class="form-group col-lg-12 list-subtitle"><a role="button" data-toggle="collapse" href="#halimmovies_subs_'+server+'_'+episode_slug_default+'_'+ep+'" aria-expanded="false" aria-controls="halimmovies_subs_'+server+'_'+episode_slug_default+'_'+ep+'" class="expand-list-subs"><span class="dashicons dashicons-leftright rotate-right"></span> Subtitle</a><div id="halimmovies_subs_'+server+'_'+episode_slug_default+'_'+ep+'" class="collapse listsub"><a style="cursor: pointer;" class="add_new_sub" data-ep="'+episode_slug_default+'_'+ep+'" data-server="'+server+'">Add Subtitle</a></div></div>'+

		'<div class="form-group col-lg-12"><a role="button" data-toggle="collapse" href="#halimmovies_listsv_'+server+'_'+episode_slug_default+'_'+ep+'" aria-expanded="false" aria-controls="halimmovies_listsv_'+server+'_'+episode_slug_default+'_'+ep+'" class="expand-list-sv"><span class="dashicons dashicons-leftright rotate-right"></span> Server</a><div id="halimmovies_listsv_'+server+'_'+episode_slug_default+'_'+ep+'" class="collapse list-server-sortable"><a style="cursor: pointer;" class="add_new_listsv" data-ep="'+episode_slug_default+'_'+ep+'" data-server="'+server+'"><span class="dashicons dashicons-leftright rotate-right"></span> Add Server</a></div></div><a class="del_ep"><span class="dashicons dashicons-no"></span></a><div class="clearfix"></div></div>';

		$('#server_'+server).find( '#halimmovies_episodes_'+server ).append( new_ep );
	});
	$(document).on("click", ".del_ep", function(){
	   $(this).parent('.halimmovies_episodes').remove();
	});
	// add new sub
	$(document).on("click", ".add_new_sub", function(){
		var server = $(this).data("server");
		var ep = $(this).data("ep");
		// var episode_slug_default = 'tap';

		var new_sub = '<div class="halimmovies_subs" style="margin-bottom: 10px"><label>Label: </label> <input  type="text" name="halimmovies_ep_sub_label['+server+']['+ep+'][]" style="width:15%" value="" placeholder="Vietnamese"/><span><label style="margin-left: 1%;">File: </label> <input type="text" name="halimmovies_ep_sub_file['+server+']['+ep+'][]" style="width:65.3%" value="" placeholder="http://example.com/files/subtitle/vietnamese.srt"/><a class="del_sub"><span class="dashicons dashicons-no"></span></a><span class="sortable"><span class="dashicons dashicons-move"></span></span></span></div>';
		$('#server_'+server).find( '#halimmovies_episodes_'+server ).find('.episodes_'+ep).find( "#halimmovies_subs_"+server+"_"+ep ).append( new_sub );
	});
	$(document).on("click", ".del_sub", function(){
	   $(this).parent().parent('.halimmovies_subs').remove();
	});


	// add new listsv
	$(document).on("click", ".add_new_listsv", function(){
		var server = $(this).data("server");
		var ep = $(this).data("ep");
		// var episode_slug_default = 'tap';
		var new_sub = '<div class="halimmovies_listsv" style="margin-bottom: 10px"><label>Name: </label> <input placeholder="Server name" type="text" name="halimmovies_ep_listsv_name['+server+']['+ep+'][]" style="width:15%" value="" /><label>Type: </label><select name="halimmovies_ep_listsv_type['+server+']['+ep+'][]" id="halimmovies_ep_listsv_type_'+server+'_'+ep+'">'+episode_type+'</select><label>Link: </label> <input type="text" name="halimmovies_ep_listsv_link['+server+']['+ep+'][]" style="width:71%" value="" placeholder="Link"/><a class="del_listsv"><span class="dashicons dashicons-no"></span></a><!--<span class="sortable"><span class="dashicons dashicons-move"></span>--></span></div>';
		$('#server_'+server).find( '#halimmovies_episodes_'+server ).find('.episodes_'+ep).find( "#halimmovies_listsv_"+server+"_"+ep ).append( new_sub );
	});
	$(document).on("click", ".del_listsv", function(){
	   $(this).parent('.halimmovies_listsv').remove();
	});

	// get link
	$("#halimmovies_getlink").click(function(){
		$('#enter_link_note').html('');
		var link = $('#enter_link').val();
		if(link)
		{
			$('#enter_link_note').html('<span class="text-info">Loading...</span>');
			var data = {
				'action': 'halimmovies_get_link',
				'link': link
			};
			jQuery.post(halimmovies_ajax_object.ajax_url, data, function(response) {
				if(response)
				{
					$("#enter_link_note").html('<span class="text-primary">Complete!</span>');
					$("#halimmovies-player-data").html(response);
				}
				else
				{
					$("#enter_link_note").html('<span class="text-danger">Error.</span>');
				}
			});
		}
		else
		{
			$('#enter_link_note').html('<span class="text-danger">Please enter link.</span>');
		}
	});

	$('<span id="fetch-imdb" class="button button-primary">Fetch from Imdb</span>').insertAfter('[data-depend-id="fetch_info_url"]');
	// $('<span id="fetch-btn2" class="button button-primary">Fetch2</span>').insertAfter('[data-depend-id="fetch_info_url"]');
	var img = $('.cs-fieldset [data-depend-id="halim_thumb_url"]').val()
	if(img != ''){
		$('.cs-nav-background').html('<img src="'+img+'" />');
	}

	$('#fetch-imdb').click(function(){
		var url = $('.cs-fieldset [data-depend-id="fetch_info_url"]').val();
		if(url) {
			$(this).html('Fetching...');
			$('body, html').find('.switch-html').click();
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'json',
				data: {
					action: 'halim_fetch_info',
					url : url,
				},
				success: function (res) {
					if(res) {
						var url = res.data.Url;
						$('#fetch-imdb').html('Fetch');
						$('#content').val(res.data.Content);
						// $('.editor-post-text-editor').val(res.data.Content);
						$('body, html').find('.switch-tmce').click();
						// if(url.indexOf('imdb.com') == -1) $('[name="halimmovies_get_link"]').val(res.data.Url);
						// $('.editor-post-title__input').val(res.data.Title).focus();
						$('[name=post_title]').val(res.data.Title).focus();
						$('#title-prompt-text').hide();
						$('[data-depend-id="halim_original_title"]').val(res.data.OrgTitle);
						$('[data-depend-id="halim_rating"]').val(res.data.Rating);
						$('[data-depend-id="halim_votes"]').val(res.data.Votes);
						$('[data-depend-id="halim_trailer_url"]').val(res.data.TrailerLinked);
						$('[data-depend-id="halim_runtime"]').val(res.data.Runtime);
						$('[data-depend-id="halim_episode"]').val(res.data.Episode);
						// $('[data-depend-id="halim_poster_url"]').val(res.data.Poster);
						$('[data-depend-id="halim_thumb_url"]').val(res.data.Thumb);
						$('.cs-nav-background').html('<img src="'+res.data.Thumb+'" />');
						$('#new-tag-post_tag').val(res.data.Tags);
						$('#new-tag-actor').val(res.data.Cast);
						$('#new-tag-director').val(res.data.Director);
						$('#new-tag-country').val(res.data.Country);
						$('#new-tag-release').val(res.data.Year);
						$('.tagadd').click();
						$('#new-tag-post_tag, #new-tag-actor, #new-tag-director, #new-tag-country, #new-tag-release').blur();
		                setTimeout(function () {
		                    $(document).find('#switch-tmce').click();
		                }, 950);

		                $('html, body').animate({
		                    scrollTop: $('.wp-heading-inline').offset().top
		                }, 1000);
					}

				}
			});
		} else{
			alert('Fetch inf URL cannot be empty!');
		}
		return false;
	});

});


$(".list-server-sortable, .listsub").sortable({ //.list_eps
    placeholder: 'slide-placeholder',
    axis: "y",
    revert: 150,
    start: function(e, ui){
        placeholderHeight = ui.item.outerHeight();
        ui.placeholder.height(placeholderHeight + 15);
        $('<div class="slide-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
    },
    change: function(event, ui) {
        ui.placeholder.stop().height(0).animate({
            height: ui.item.outerHeight() + 15
        }, 300);
        placeholderAnimatorHeight = parseInt($(".slide-placeholder-animator").attr("data-height"));
        $(".slide-placeholder-animator").stop().height(placeholderAnimatorHeight + 15).animate({
            height: 0
        }, 300, function() {
            $(this).remove();
            placeholderHeight = ui.item.outerHeight();
            $('<div class="slide-placeholder-animator" data-height="' + placeholderHeight + '"></div>').insertAfter(ui.placeholder);
        });
    },
    stop: function(e, ui) {
        $(".slide-placeholder-animator").remove();
    },
});