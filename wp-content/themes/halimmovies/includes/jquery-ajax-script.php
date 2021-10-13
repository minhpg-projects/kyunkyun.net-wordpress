<?php


function halim_ajax_force_delete_post() {
    // check_ajax_referer( 'trash-post_' . $_POST['post_id'] );
    wp_delete_post( $_POST['post_id'], true );
    die();
}
add_action('wp_ajax_halim_force_delete_post', 'halim_ajax_force_delete_post');

function halim_force_delete_post_script()
{
    ?>
    <script>

    jQuery(function($){
        // $('body.post-type-post .row-actions .delete a').click(function( event ){
        $('body.post-type-post .row-actions .trash a').click(function( event ){

            event.preventDefault();

            var url = new URL( $(this).attr('href') ),
                nonce = url.searchParams.get('_wpnonce'), // MUST for security checks
                row = $(this).closest('tr'),
                postID = url.searchParams.get('post'),
                postTitle = row.find('.row-title').text();
            row.css('background-color','#ffafaf').fadeOut(300, function(){
                row.removeAttr('style').html('<td colspan="5">Post <strong>' + postTitle + '</strong> has been deleted.</td>').show();
            });

            $.ajax({
                method:'POST',
                url: ajaxurl,
                data: {
                    'action' : 'halim_force_delete_post',
                    'post_id' : postID,
                    '_wpnonce' : nonce
                }
            });

        });
    });

    </script>

    <?php
}
add_action('admin_footer', 'halim_force_delete_post_script');



function halim_rss_ajax_widget()
{

    if(is_admin() && get_current_screen()->id == 'dashboard') :
    ?>
        <script>
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'halim_rss_ajax'
                },
                success: function(data) {
                    $('#halim-changelogs-ajax').html(data);
                },
                error: function(e) {
                    $('#halim-changelogs-ajax').html('Apparently, there are no updates to show!');
                }
            });
        </script>
    <?php
    endif;
}
// add_action('admin_head', 'halim_rss_ajax_widget');
add_action('admin_head', 'halim_widget_custom_css');

function halim_widget_custom_css() {
    ?>
    <style>
        #post-formats-select .post-format-icon::before,
        #formatdiv, #statusdiv,#tagsdiv-episode-types, #add-post_format, #post_optionsdiv,
        label[for=formatdiv-hide],
        label[for=post_optionsdiv-hide],
        label[for=tagsdiv-episode-types-hide],
        label[for=statusdiv-hide], label[for=add-post_format-hide] {
            display: none!important;
        }
        .notice-success.update-available {
            color: #ee7c1b!important;
            box-shadow: 0px 0px 16px 0px rgba(144, 144, 144, 0.59);
        }
        .notice-success.update-available p {
            color: #ee7c1b!important;
        }
        #halim-license-details .notice-success.update-available {
            box-shadow: none;
        }

        .cs-fieldset .button {
            margin-right: 3px;
        }
        .wpseo-metabox-content {
            max-width: 100%;
            padding-top: 16px;
        }
        .plugins tr[data-slug=halim-core] .plugin-title strong {
            color: #fd0909;
            font-weight: bold;
            font-family: monospace;
            font-size: 16px;
        }
        .cs-field-image-select [alt~=show_list_eps] {
            width: 230px;
        }
        .cs-field-image-select [alt~=show_tab_eps] {
            width: 295px;
        }
        .cs-field-image-select [alt~=show_paging_eps],
        .cs-field-image-select [alt~=default],
        .cs-field-image-select [alt~=style-1],
        .cs-field-image-select [alt~=style-2],
        .cs-field-image-select [alt~=style-3] {
            width: 250px;
        }

        .cs-field-image-select [alt~=style-1],
        .cs-field-image-select [alt~=style-2] {
            height: 165px;
        }

        .cs-field-text input[data-depend-id=halim_server_url], .cs-field-select select[data-depend-id=halim_url_type] {
            pointer-events: none;
            background: #f9f9f9;
        }

        .editinline {
            display: none
        }

        [id*=halim] .widget-top {
            background: #49749e;
            border: none;
        }
        [id*=halim] .widget-top .toggle-indicator {
            color: #e6e6e6;
        }
        [id*=halim] .widget-title h3 {
            color: #fff;
        }
        [id*=halim] .widget-title h3,
        [id*=halim] .widget-title h3 .in-widget-title{
            color: #fff;
        }
        [id*=halim] .widget-description {
            background: #ffffff;
            margin-bottom: 10px;
            color: #868686!important;
            border: none;
            box-shadow: 1px 6px 7px 2px rgba(0, 0, 0, 0.12);
        }
        [id*=fullwith-slider-widget] .widget-title h3 {
            padding-right: 0;
        }
        .postbox.enable_purge {
            display: none;
        }

        #halim_dashboard_widget {
            background: #53a9f7;
            display: flow-root;
        }
        #halim_dashboard_widget .rssSummary {
            margin-top: 15px;
        }
        #halim_dashboard_widget .rssSummary ul {
            padding-left: 20px;
            list-style: square;
        }
        #halim_dashboard_widget h2, #halim_dashboard_widget .toggle-indicator {
            color: #fff;
        }
        div#welcome-panel {
            overflow: hidden;
            position: relative;
        }
        .welcome-panel-content.halim-rssfeed {
            max-width: 100%;
        }
        .welcome-panel-column.rssfeed {
            margin-bottom: 50px;
        }
        .welcome-panel .welcome-panel-column {
            width: 100%;
        }
        @media (min-width: 1024px){
            .welcome-panel-column.rssfeed {
                width: 62%;
                border-left: 1px solid #f1f1f1;
                padding-left: 20px;
                position: relative;
            }
        }
        div#halim-changelogs-ajax {
            max-height: 280px;
            height: 280px;
            overflow-y: scroll;
            border-bottom: 1px solid #f1f1f1;
            position: relative;
        }
        .halim-change-log-item {
            border-top: 1px solid #f1f1f1;
            border-bottom: none!important;
            margin-bottom: 10px;
            padding-right: 15px;
            padding: 10px 15px 0 0;
        }
        #halim_dashboard_widget .halim-change-log-item {
            background: #fff;
            padding: 10px;
            margin: 10px 0;
            overflow:hidden;
            display:block;
            border-radius: 3px;
        }

        .halim-change-log-item span.date {
            font-size: 11px;
            margin-left: 10px;
            color: #a0a0a0;
            float: right;
        }
        .halim-change-log-item .title {
            font-size: 18px;
            color: #ff6464;
        }
        .more-change-logs {
            color: #68a21e;
            display: inline-block;
            text-align: right;
            border: 1px solid #68a21e;
            padding: 2px 8px;
            border-radius: 3px;
            margin-bottom: 10px;
            transition: .7s all;
            position: absolute;
            right: 0;
            bottom: -52px;
        }
        .more-change-logs:hover {
            color: #0c0c0c;
            border: 1px solid #000;
            transition: .5s all
        }
/*        .apsl-outer-wrapper {
            width: 100%!important
        }*/

        tbody#the-list img.post-thumb {
            width: 70px;
        }

        .movie_details .halim_episode, .movie_details .halim_quality {
            display: inline-block;
            background: #83b149;
            padding: 1px 5px;
            color: #fff;
            font-size: 11px;
            border-radius: 3px;
            margin-right: 3px;
        }
        .movie_details .halim_quality {
            background: #e05e5e
        }
        .movie_details .org_title span {
            font-size: 12px;
            color: #ff890c;
            font-weight: 600;
        }


        .movie_details .halim_formality, .movie_details .halim_status {
            display: inline-block;
            text-transform: capitalize;
            background: #bd4cba;
            padding: 1px 5px;
            color: #fff;
            font-size: 11px;
            border-radius: 3px;
            margin: 1px;
        }
        .movie_details .halim_status {
            background: #519ee4;
        }

        .column-halim-movie-title .org_title {
            display: block;
            font-size: 12px;
        }
        .column-halim-movie-title a.edit-post-link {
            font-weight: 600;
        }
        @media (min-width:1366px){

            th#taxonomy-release {
                width: 50px;
            }
            th#episode {
                width: 85px;
            }
            th#featured_image {
                width: 75px;
            }
            th#last_updated, th#taxonomy-director {
                width: 120px;
            }
            th#taxonomy-country {
                width: 100px;
            }
            th#movie_details {
                width: 200px;
            }
        }
        .column-halim-movie-title span.inline.hide-if-no-js {
            display: none;
        }
        .cs-element .cs-fieldset [data-depend-id="jw_player_custom_ads_code"] {
            height: 350px!important;
        }
        #adminmenu .wp-menu-image img {
            opacity: 1!important;
        }

    </style>

    <?php
}


function halim_custom_css()
{
    $style = cs_get_option('halim_post_item_title_display');
    ?>
    <style>
        <?php if($style == 'style-1') : ?>
        /*style 1*/
        .halim-post-title-box {
            position: unset!important;
            padding: 50px 0 0!important;
            text-align: center!important;
            background: #202a34!important;
        }
        .halim-post-title > h2 {
            color: #e6920e;
            font-weight: bold;
        }
        <?php elseif($style == 'style-2'): ?>
        /*style 2*/
        .halim-post-title-box {
            position: unset!important;
            padding: 50px 0 0!important;
            text-align: center!important;
            background: transparent!important;
        }
        .halim-post-title > h2 {
            color: #e6920e;
        }
        .halim-corner-rounded .halim_box .grid-item figure, .halim-corner-rounded .owl-carousel .grid-item figure {
            border-radius: 8.5px;
        }
        .halim-post-title.title-2-line h2 {
            -webkit-line-clamp: 2;
        }
        .grid-item .episode {
            right: 5px;
            bottom: 55px;
        }
        <?php elseif ($style == 'style-3') : ?>

        /*Style 3*/
        .halim-post-title {
            background: rgba(0, 0, 0, 0.63)!important;
            text-align: center;
            border-bottom-right-radius: 7px;
            border-bottom-left-radius: 7px;
        }
        .halim-post-title h2 {
            color: #ffa533!important;
        }
        .grid-item img {
            border-bottom-right-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        .halim-post-title.title-2-line h2 {
            -webkit-line-clamp: 2;
            font-size: 13px!important;
        }
        <?php endif; ?>
    </style>
    <?php
}
add_action('wp_head', 'halim_custom_css');


function add_csrf_token()
{
    $token = new RestrictCSRF();
    $csrf_token = $token->generateToken('halim');
    echo '<meta name="csrf-token" content="'.$csrf_token.'">'."\n";
}
add_action('wp_head', 'add_csrf_token', 2);


// add_action( 'admin_print_footer_scripts', 'func_hook_admin_footer_scripts', 99 );
function func_hook_admin_footer_scripts(){
    if( get_current_screen()->base !== 'post' )
        return;
    ?>
    <script>
        [ 'release', 'country' ].forEach(function(taxname){
            jQuery( '#' + taxname + 'div input[type="checkbox"]' ).prop( 'type', 'radio' );

            $('#' + taxname + 'checklist li :radio, #' + taxname + 'checklist-pop :radio').live( 'click', function(){
                var t = $(this), c = t.is(':checked'), id = t.val();
                $('#' + taxname + 'checklist li :radio, #' + taxname + 'checklist-pop :radio').prop('checked',false);
                $('#in-' + taxname + '-' + id + ', #in-popular-' + taxname + '-' + id).prop( 'checked', c );
            });

            $('#' + taxname +'-add .radio-tax-add').live( 'click', function(){
            term = $('#' + taxname+'-add #new'+taxname).val();
            nonce =$('#' + taxname+'-add #_wpnonce_radio-add-tag').val();
            $.post(ajaxurl, {
                action: 'radio_tax_add_taxterm',
                term: term,
                '_wpnonce_radio-add-tag':nonce,
                taxonomy: taxname
                }, function(r){
                    $('#' + taxname + 'checklist').append(r.html).find('li#'+taxname+'-'+r.term+' :radio').attr('checked', true);
                },'json');
            });

        });
    </script>
    <?php
}


add_action( 'admin_print_scripts', 'halim_admin_term_filter', 99 );
function halim_admin_term_filter() {
    $screen = get_current_screen();

    if( 'post' !== $screen->base ) return;
    ?>
    <script>
        jQuery(document).ready(function($){
            var $categoryDivs = $('.categorydiv');

            $categoryDivs.prepend('<input type="search" class="fc-search-field" placeholder="<?php _e('Search'); ?>" style="width:100%" />');

            $categoryDivs.on('keyup search', '.fc-search-field', function (event) {

                var searchTerm = event.target.value,
                    $listItems = $(this).parent().find('.categorychecklist li');

                if( $.trim(searchTerm) ){
                    $listItems.hide().filter(function () {
                        return $(this).text().toLowerCase().indexOf(searchTerm.toLowerCase()) !== -1;
                    }).show();
                }
                else {
                    $listItems.show();
                }
            });
        });
    </script>
    <?php
}
