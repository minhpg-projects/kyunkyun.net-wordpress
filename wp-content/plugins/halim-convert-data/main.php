<?php
/*
	Plugin name: HaLim Rebuild Episode
	Plugin URI: http://halimthemes.com
	Author: HaLim
	Author URI: http://hoangha.net
	Version: 1.0
	Description: Rebuild all data
	Text Domain: halimthemes
*/


include 'func.php';

register_activation_hook(__FILE__, 'halim_convert_data_plugin_activate');
add_action('admin_init', 'halim_convert_data_plugin_redirect');


class AjaxDataConvert {

	function __construct() {
		add_action( 'admin_menu', array(&$this, 'addAdminMenu' ) );
	}

	function addAdminMenu() {
		add_management_page( 'HaLim Rebuild Data', 'HaLim Rebuild Data', 'manage_options', 'halim-ajax-data-converter', array( $this, 'settingsPage' ) );
	}

	function settingsPage() {

		$showpost = isset($_GET['showpost']) ? $_GET['showpost'] : 1000;
		$paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

	    $args = array(
	        'post_type'  => 'post',
	        'paged' => $paged,
	        'showposts'  => $showpost,
	    );
	    $wp_query = new WP_Query($args);

		$total = $wp_query->found_posts;
		echo '<span>Tổng cộng: '.$total.' phim</span>';

		echo '<ul id="checkBoxes">';
		echo '<li><input type="checkbox" id="select_all" /><label for="select_all" style="color: green;font-weight:bold;">Chọn/Bỏ chọn tất cả</label></li>';


	    foreach ($wp_query->posts as $post)
	    {
	    	$link = get_post_meta($post->ID, '_halimmovies', true);
	    	if($link != '') {
				echo '<li class="list-item"><input class="checkbox" id="post-id-'.$post->ID.'" type="checkbox" name="list_movie" value="'.$post->ID.'" checked="checked"/>
				<label for="post-id-'.$post->ID.'">'.$post->post_title.'</label></li>';
	    	}
	    }

		echo '</ul>';
		echo '<div style="clear: both;"></div>';
		$this->halim_page_nav($total, $showpost, $paged);

		wp_reset_query();

		?>
		<div id="halim-rebuild-data" style="margin-top: 30px;">
			<div id="message" class="updated fade" style="display:none;padding: 10px;"></div>
			<script>
				// <![CDATA[

				jQuery(function () {
				    $("#select_all").on("click", function () {
				        $("#checkBoxes input:checkbox").prop('checked', $(this).prop('checked'));
				    });

					$('#rebuild').click(function(){

				        var post_id = [];
				        jQuery('#checkBoxes [name=list_movie]:checked').each(function(i){
				          post_id[i] = jQuery(this).val();
				        });
				        console.log(post_id);
					});
				});

				function setMessage(msg) {
					jQuery("#message").html(msg).show();
				}



				function regenerate() {
					jQuery("#halim_data_rebuild").prop("disabled", true);
					setMessage("<p><?php _e('Reading data...', 'halimthemes') ?></p>");
			        var post_id = [];
			        jQuery('#checkBoxes [name=list_movie]:checked').each(function(i){
			          	post_id[i] = jQuery(this).val();
			        });

					jQuery.ajax({
						url: "<?php echo admin_url( 'admin-ajax.php' ); ?>",
						type: "POST",
						data: "action=halim_data_rebuild&do=getlist&post_ids="+post_id,
						success: function(result) {
							var list = eval(result), i = 0;
							if (!list) {
								setMessage("<?php _e( 'No data found.', 'halimthemes' ) ?>");
								jQuery("#halim_data_rebuild").prop("disabled", false);
								return;
							}
							console.log(list);
							function regenItem() {
								if (i >= list.length) {
									jQuery("#halim_data_rebuild").prop("disabled", false);
									jQuery('#status p:first-child').addClass('ok');
									setMessage("<?php _e('Done.', 'halimthemes') ?>");
									return;
								}

								if(list[i].post_id)
								{
									setMessage( '<?php printf( __( 'Rebuilding %s of %s (%s)...', 'halimthemes' ), "' + (i + 1) + '", "' + list.length + '", "' + list[i].post_id + '" ); ?>' );
									jQuery.ajax({
										url: "<?php echo admin_url('admin-ajax.php'); ?>",
										type: "POST",
										data: {
											action: 'halim_data_rebuild',
											do: 'regen',
											post_id: list[i].post_id,
										},
										success: function(result) {
											i = i + 1;
											if (result != '-1') {
												$('#status').prepend('<p><span style="color:#46b450;font-size: 17px;font-weight: bold;">✓</span> '+result+'</p>');
											}
											regenItem();
										}
									});
								}
							}

							regenItem();
						},
						error: function(request, status, error) {
							setMessage("<?php _e( 'Error: ', 'halimthemes' ) ?>" + request.status);
						}
					});
				}

				// ]]>
			</script>
			<input type="button" onClick="javascript:regenerate();" class="button" id="halim_data_rebuild" value="<?php _e( 'Rebuild All Data', 'halimthemes' ) ?>" />
			<style>
				div#status {
				    margin-top: 20px;
				}
				div#status p {
				    margin: 0;
				}
				div#status p:first-child {
				    background: #272727;
				    padding: 3px 10px;
				    color: #fff;
				    font-weight: bold;
				}
				p.ok {
				    background: transparent!important;
				    color: #333!important;
				    padding: 0!important;
				    font-weight: normal!important;
				}
				ul.xpagination li {
				    display: -webkit-inline-box;
				}
				ul.xpagination li a{

				    border: 1px solid #cacaca;
				    padding: 2px 10px;
				}

				ul.xpagination li.active a{
				    border-color: #ff0505;
				}
				ul#checkBoxes li.list-item {
				    width: 33.333333%;
				    float: left;
				}
			</style>
			<div id="status"></div>
		</div>
		<?php

	}

	function halim_page_nav($total, $showpost, $paged) {

		$total_page = ceil($total / $showpost);

		$max   = intval( $total_page );

		if ( $paged >= 1 )
			$links[] = $paged;

		if ( $paged >= 3 ) {
			$links[] = $paged - 1;
			$links[] = $paged - 2;
		}

		if ( ( $paged + 2 ) <= $max ) {
			$links[] = $paged + 2;
			$links[] = $paged + 1;
		}

		echo '<div class="text-center" style="clear: both;padding-top: 15px;"><ul class="xpagination">' . "\n";

		echo '<li style="margin-right: 3px;">Trang '.$paged.'/'.$max.' của '.$total.' phim</li>';

		if ( ! in_array( 1, $links ) ) {
			$class = 1 == $paged ? ' class="active"' : '';

			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		}

		sort( $links );
		foreach ( (array) $links as $link ) {
			$class = $paged == $link ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
		}

		if ( ! in_array( $max, $links ) ) {

			$class = $paged == $max ? ' class="active"' : '';
			printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
		}

		echo '</ul></div>' . "\n";


	    echo '<form action="admin.php" method="GET">
	    <input name="page" type="hidden" value="halim-ajax-data-converter"/>
	    <span>Số bài viết hiển thị: </span>
	    <input type="number" name="showpost" value="'.$showpost.'" required style="width: 4%;">
	    <span>Đi đến trang: </span>
	    <input name="paged" type="number" value="'.($paged+1).'" class="regular-text" style="width: 4%;"/>
	    <button class="button">GO</button>
	    </form>';

	}


}

