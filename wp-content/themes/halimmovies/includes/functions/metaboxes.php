<?php
if(!function_exists('halimmovies_meta_box')){
	function halimmovies_meta_box() {
 		add_meta_box( 'halimmovies', 'Episode list', 'halimmovies_meta_box_output', 'post', 'normal', 'low' );
	}
	add_action( 'add_meta_boxes', 'halimmovies_meta_box' );
}

if(!function_exists('halimmovies_meta_box_output'))
{
	function halimmovies_meta_box_output()
	{
		wp_nonce_field( 'halimmovies_save_meta_posts', 'halimmovies_link_nonce' );
		global $post;
		$episode_meta = get_post_meta( $post->ID, '_halimmovies', true );
		$data = json_decode($episode_meta);
		$count = 1;
		if(json_decode($episode_meta, true)[0]['halimmovies_server_data']) {
			$count = count(json_decode($episode_meta, true)[0]['halimmovies_server_data']);
		}
		if($count >= 150) :
			?>
			<div class="inside">
				<div class="wp-die-message" style="text-align: center;margin-top: 30px;font-size: 15px;color: #ff4f4f;"><strong>This episode list is too large, please use the <a href="<?php echo admin_url('admin.php?page=halim-episode-manager&act=edit_ep&post_id='.$post->ID.'&server=0'); ?>" target="_blank">Episode Manager</a></strong></div>
			</div>
			<?php
			else :
		?>

		<div id="halimmovies-form" class="halim-episode-manager">
			<div class="clear"></div>
			<div id="halimmovies-player-data">
				<ul class="nav nav-tabs" role="tablist">
					<?php
						if($data) {
							foreach ($data as $key => $value) {
								$tabActive = ($key == 0) ? 'active' : '';
								$closeTab = ($key > 0) ? '<span> x </span>' : '';
					        	echo '<li class="'.$tabActive.'"><a href="#server_'.($key+1).'" data-toggle="tab" id="tab_title_'.($key+1).'">'.$value->halimmovies_server_name.'</a>'.$closeTab.'</li>';
					        }
					    }else{
					    	echo '<li class="active"><a href="#server_1" data-toggle="tab" id="tab_title_1">Server #1</a></li>';
					    }
				    ?>
			        <li><a href="#" class="add-server">+</a>
			        </li>
			    </ul>
			    <div class="clear"></div>
			    <div class="tab-content">
			    	<?php
			    		if($data) {
			    			foreach ($data as $key => $value) {
			    				$tabContentActive = ($key == 0) ? 'active' : '';


			    	?>
			        <div class="tab-pane <?php echo $tabContentActive; ?>" id="server_<?php echo ($key+1); ?>" data-server="<?php echo ($key+1); ?>">
						<div id="halimmovies_episodes_<?php echo ($key+1); ?>" class="form-horizontal">

							<div class="row">
								<div class="form-group col-lg-2">
						            <label for="halimmovies_server_name_<?php echo ($key+1); ?>"><h3>Server Name</h3></label>
						            <input id="halimmovies_server_name_<?php echo ($key+1); ?>" class="halimmovies_server_name form-control" data-server="<?php echo ($key+1); ?>" type="text" name="halimmovies_server_name[<?php echo ($key+1); ?>]" value="<?php echo esc_attr( $value->halimmovies_server_name ) ?>">
						        </div>
						    </div>
							<h3>List Episode <a id="server-<?php echo ($key+1); ?>" style="cursor: pointer;" class="add_new_ep pull-right" data-ep-total="<?php echo halim_get_last_episode_by_server_id($post->ID, $key) ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span><span>Add New Episode</span></a></h3>

							<div id="eps_contariner_<?php echo ($key+1); ?>" class="list_eps">
							<?php
					        	$dataServer = $value->halimmovies_server_data;

					        	if($dataServer)
					        	{
					        		foreach ($dataServer as $k => $v) {

					        		?>
									<div class="halimmovies_episodes episodes_<?php echo $k; ?> row" data-ep="<?php echo $k; ?>" data-server="<?php echo ($key+1); ?>">


								    	<div class="form-group col-lg-1" style="margin-right: -1px">
								            <label for="halimmovies_ep_name_<?php echo ($key+1); ?>_<?php echo $k; ?>">Episode Name</label>
								            <input id="halimmovies_ep_name_<?php echo ($key+1); ?>_<?php echo $k; ?>" type="text" class="form-control" name="halimmovies_ep_name[<?php echo ($key+1); ?>][<?php echo $k; ?>]" value="<?php echo esc_attr( $v->halimmovies_ep_name ) ?>" placeholder="Episode name">
								        </div>



                                        <div class="form-group col-lg-1" style="margin-right: -1px">
                                            <label for="halimmovies_ep_slug"><?php _e('Episode Slug', 'halimthemes'); ?></label>
                                            <input id="halimmovies_ep_slug_<?php echo ($key+1); ?>_<?php echo $k; ?>" type="text" class="form-control" name="halimmovies_ep_slug[<?php echo ($key+1); ?>][<?php echo $k; ?>]" value="<?php echo esc_attr( $v->halimmovies_ep_slug ) ?>" placeholder="<?php _e('Episode Slug', 'halimthemes'); ?>">
                                        </div>

										<div class="form-group col-lg-2" style="margin-right: -1px">
											<label>Type: </label>
											<select name="halimmovies_ep_type[<?php echo ($key+1); ?>][<?php echo $k; ?>]" id="halimmovies_ep_type_<?php echo ($key+1); ?>_<?php echo $k; ?>" style="display:block;width:100%;margin-top:5px;height: 30px;">
												<?php getPlayerTypes($v->halimmovies_ep_type); ?>
											</select>
										</div>
										<div class="form-group col-lg-8">
										    <label for="halimmovies_ep_link_<?php echo ($key+1); ?>_<?php echo $k; ?>">Link: </label>
										    <input class="form-control" type="text" id="halimmovies_ep_link_<?php echo ($key+1); ?>_<?php echo $k; ?>" name="halimmovies_ep_link[<?php echo ($key+1); ?>][<?php echo $k; ?>]" style="width:100%" value="<?php echo esc_attr( $v->halimmovies_ep_link ) ?>" placeholder="Episode link"/>
										</div>
										<div class="form-group col-lg-12 list-subtitle">
											<a role="button" data-toggle="collapse" href="#halimmovies_subs_<?php echo ($key+1); ?>_<?php echo $k; ?>" aria-expanded="false" aria-controls="halimmovies_subs_<?php echo ($key+1); ?>_<?php echo $k; ?>" class="expand-list-subs"><span class="dashicons dashicons-leftright rotate-right"></span> Subtitle</a>
										    <div id="halimmovies_subs_<?php echo ($key+1); ?>_<?php echo $k; ?>" class="collapse listsub">
										    	<a style="cursor: pointer;" class="add_new_sub" data-ep="<?php echo $k; ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span> Add Subtitle</a>
										    <?php
										    	if(isset($v->halimmovies_ep_subs) && $v->halimmovies_ep_subs)
										    	{
										    		foreach ($v->halimmovies_ep_subs as $s => $sub)
										    		{
										    			?>
										    			<div class="halimmovies_subs" style="margin-bottom: 10px">
														    <label>Label: </label> <input type="text" name="halimmovies_ep_sub_label[<?php echo ($key+1); ?>][<?php echo $k; ?>][<?php echo $s; ?>]" style="width:15%" value="<?php echo esc_attr( $sub->halimmovies_ep_sub_label ) ?>" />
														    <span>
															    <label style="margin-left: 5%;">File: </label> <input type="text" name="halimmovies_ep_sub_file[<?php echo ($key+1); ?>][<?php echo $k; ?>][<?php echo $s; ?>]" style="width:64.8%" value="<?php echo esc_attr( $sub->halimmovies_ep_sub_file ) ?>" />
															    <a class="del_sub"><span class="dashicons dashicons-no"></span></a>
															    <span class="sortable"><span class="dashicons dashicons-move"></span></span>
															</span>
														</div>
										    			<?php
										    		}
										    	}
										    ?>
									    	</div>
									    </div>

									    <div class="form-group col-lg-12 list-server">
										    <a role="button" data-toggle="collapse" href="#halimmovies_listsv_<?php echo ($key+1); ?>_<?php echo $k; ?>" aria-expanded="false" aria-controls="halimmovies_listsv_<?php echo ($key+1); ?>_<?php echo $k; ?>" class="expand-list-sv"><span class="dashicons dashicons-leftright rotate-right"></span> Server</a>

										    <div id="halimmovies_listsv_<?php echo ($key+1); ?>_<?php echo $k; ?>" class="collapse list-server-sortable">
										    	<a style="cursor: pointer;" class="add_new_listsv" data-ep="<?php echo $k; ?>"  data-server="<?php echo ($key+1); ?>"><span class="dashicons dashicons-plus"></span> Add Server</a>
										    <?php
										    	if(isset($v->halimmovies_ep_listsv) && $v->halimmovies_ep_listsv)
										    	{
										    		foreach ($v->halimmovies_ep_listsv as $s => $listsv)
										    		{
										    			?>
										    			<div class="halimmovies_listsv" style="margin-bottom: 10px">
														    <label>Name: </label>
														    <input type="text" name="halimmovies_ep_listsv_name[<?php echo ($key+1); ?>][<?php echo $k; ?>][<?php echo $s; ?>]" style="width:15%" value="<?php echo esc_attr( $listsv->halimmovies_ep_listsv_name ) ?>" />

															<label>Type: </label>
															<select name="halimmovies_ep_listsv_type[<?php echo ($key+1); ?>][<?php echo $k; ?>][<?php echo $s; ?>]">
																<?php getPlayerTypes($listsv->halimmovies_ep_listsv_type); ?>
															</select>
														    <label>Link: </label>
														    <input type="text" name="halimmovies_ep_listsv_link[<?php echo ($key+1); ?>][<?php echo $k; ?>][<?php echo $s; ?>]" style="width:71%" value="<?php echo esc_attr( $listsv->halimmovies_ep_listsv_link ) ?>" />
														    <a class="del_listsv"><span class="dashicons dashicons-no"></span></a>
														    <!-- <span class="sortable"><span class="dashicons dashicons-move"></span></span> -->
														</div>
										    			<?php
										    		}
										    	}
										    ?>
									    	</div>
									    </div>
									    <a class="del_ep"><span class="dashicons dashicons-no"></span></a>
									    <!-- <span class="sortable"><span class="dashicons dashicons-move"></span></span> -->
									</div>
									<?php
									}
								}
								else
								{
									?>
									<div class="halimmovies_episodes episodes_<?php echo cs_get_option('halim_episode_url'); ?>_1 row" data-ep="<?php echo cs_get_option('halim_episode_url'); ?>_1" data-server="<?php echo ($key+1); ?>">
								    	<div class="form-group col-lg-1" style="margin-right: -1px">
								            <label for="halimmovies_ep_name_1">Episode Name</label>
								            <input id="halimmovies_ep_name_1" type="text" class="form-control" name="halimmovies_ep_name[<?php echo ($key+1); ?>][<?php echo cs_get_option('halim_episode_url'); ?>_1]" value="<?php echo ucfirst(cs_get_option('halim_episode_name')); ?> 1" placeholder="Episode name">
								        </div>

								        <div class="form-group col-lg-1" style="margin-right: -1px">
								            <label for="halimmovies_ep_slug_1">Episode Slug</label>
								            <input id="halimmovies_ep_slug_1" type="text" class="form-control" name="halimmovies_ep_slug[<?php echo ($key+1); ?>][<?php echo cs_get_option('halim_episode_url'); ?>_1]" value="<?php echo cs_get_option('halim_episode_url'); ?>-1" placeholder="Episode slug">
								        </div>
										<div class="form-group col-lg-2"  style="margin-right: -1px">
											<label>Type: </label>
											<select name="halimmovies_ep_type[<?php echo ($key+1); ?>][<?php echo cs_get_option('halim_episode_url'); ?>_1]" id="halimmovies_ep_type_1" style="display:block;width:100%;margin-top:5px;height: 30px;">
												<?php getPlayerTypes(); ?>
											</select>
										</div>
										<div class="form-group col-lg-8">
										    <label for="halimmovies_ep_link_1_1">Link: </label>
										    <input class="form-control" type="text" id="halimmovies_ep_link_1_1" name="halimmovies_ep_link[<?php echo ($key+1); ?>][<?php echo cs_get_option('halim_episode_url'); ?>_1]" style="width:100%" value="" placeholder="Episode link"/>
										</div>
										<div class="form-group col-lg-12 list-subtitle">
											<a role="button" data-toggle="collapse" href="#halimmovies_subs_<?php echo ($key+1); ?>_1" aria-expanded="false" aria-controls="halimmovies_subs_<?php echo ($key+1); ?>_1" class="expand-list-subs"><span class="dashicons dashicons-leftright rotate-right"></span> Subtitle</a>
										    <div id="halimmovies_subs_<?php echo ($key+1); ?>_1" class="collapse listsub">
										    	<a style="cursor: pointer;" class="add_new_sub" data-ep="<?php echo cs_get_option('halim_episode_url'); ?>_1" data-server="1"><span class="dashicons dashicons-plus"></span> Add Subtitle</a>
									    	</div>
									    </div>

									    <div class="form-group col-lg-12 list-server">
									    	<a role="button" data-toggle="collapse" href="#halimmovies_listsv_<?php echo ($key+1); ?>_1" aria-expanded="false" aria-controls="halimmovies_listsv_<?php echo ($key+1); ?>_1" class="expand-list-sv"><span class="dashicons dashicons-leftright rotate-right"></span> Server</a>
										    <div id="halimmovies_listsv_<?php echo ($key+1); ?>_1" class="collapse list-server-sortable">
										    	<a style="cursor: pointer;" class="add_new_listsv" data-ep="<?php echo cs_get_option('halim_episode_url'); ?>_1" data-server="1"><span class="dashicons dashicons-plus"></span> Add Server</a>
									    	</div>
									    </div>
									</div>
									<?php
								}
							?>
					    </div>
						</div>
			        </div>
			        		<?php
			        		}
			        	}
			        	else
			        	{
			        		?>
			        		<div class="tab-pane active" id="server_1" data-server="1">
								<div id="halimmovies_episodes_1" class="form-horizontal">
										<div class="form-group">
								            <label for="halimmovies_server_name"><h3>Server Name</h3></label>
								            <input id="halimmovies_server_name_1" type="text" class="halimmovies_server_name" name="halimmovies_server_name[1]" data-server="1" value="Server #1">
								        </div>
										<h3>List Episode<a class="add_new_ep" data-ep-total="1"  data-server="1"><span class="dashicons dashicons-plus"></span><span>Add Eps</span></a></h3>
										<div class="halimmovies_episodes episodes_<?php echo cs_get_option('halim_episode_url'); ?>_1 row" data-ep="<?php echo cs_get_option('halim_episode_url'); ?>_1" data-server="1">
									    	<div class="form-group col-lg-1" style="margin-right: -1px">
									            <label for="halimmovies_ep_name_1_<?php echo cs_get_option('halim_episode_url'); ?>_1">Episode Name</label>
									            <input id="halimmovies_ep_name_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" type="text" class="form-control" name="halimmovies_ep_name[1][<?php echo cs_get_option('halim_episode_url'); ?>_1]" value="1" placeholder="Episode name">
									        </div>

									        <div class="form-group col-lg-1" style="margin-right: -1px">
									            <label for="halimmovies_ep_slug_1_<?php echo cs_get_option('halim_episode_url'); ?>_1">Episode SLug</label>
									            <input id="halimmovies_ep_slug_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" type="text" class="form-control" name="halimmovies_ep_slug[1][<?php echo cs_get_option('halim_episode_url'); ?>_1]" value="<?php echo cs_get_option('halim_episode_url'); ?>-1" placeholder="Episode slug">
									        </div>
											<div class="form-group col-lg-2" style="margin-right: -1px">
												<label>Type: </label>
												<select name="halimmovies_ep_type[1][<?php echo cs_get_option('halim_episode_url'); ?>_1]" id="halimmovies_ep_type_1_1" style="display:block;width:100%;margin-top:5px;height: 30px;">
													<?php getPlayerTypes(); ?>
												</select>
											</div>
											<div class="form-group col-lg-8">
											    <label for="halimmovies_ep_link_1_1">Link: </label>
											    <input class="form-control" type="text" id="halimmovies_ep_link_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" name="halimmovies_ep_link[1][<?php echo cs_get_option('halim_episode_url'); ?>_1]" style="width:100%" value="" placeholder="Episode link"/>
											</div>
											<div class="form-group col-lg-12 list-subtitle">
												<a role="button" data-toggle="collapse" href="#halimmovies_subs_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" aria-expanded="false" aria-controls="halimmovies_subs_1_1" class="expand-list-subs"><span class="dashicons dashicons-leftright rotate-right"></span> Subtitle</a>
											    <div id="halimmovies_subs_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" class="collapse listsub">
											    	<a style="cursor: pointer;" class="add_new_sub" data-ep="<?php echo cs_get_option('halim_episode_url'); ?>_1" data-server="1"><span class="dashicons dashicons-plus"></span> Add Subtitle</a>
										    	</div>
										    </div>
										    <div class="form-group col-lg-12 list-server">
										    	<a role="button" data-toggle="collapse" href="#halimmovies_listsv_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" aria-expanded="false" aria-controls="halimmovies_listsv_1_1" class="expand-list-sv"><span class="dashicons dashicons-leftright rotate-right"></span> Server</a>
											    <div id="halimmovies_listsv_1_<?php echo cs_get_option('halim_episode_url'); ?>_1" class="collapse list-server-sortable">
											    	 <a style="cursor: pointer;" class="add_new_listsv" data-ep="<?php echo cs_get_option('halim_episode_url'); ?>_1"  data-server="1"><span class="dashicons dashicons-plus"></span> Add Server</a>
										    	</div>
										    </div>
										</div>
								</div>
							</div>
			        		<?php
			        	}
			        ?>
			    </div>
			</div>
		</div>
	        <script>
	        	var $ = jQuery.noConflict();
	            var episode_slug_default = "<?php echo cs_get_option('halim_episode_url'); ?>",
	            	episode_name_default = "<?php echo ucfirst(cs_get_option('halim_episode_name')); ?>",
	                ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';

	            $("#halimmovies_ep_name, .edit-ep-name, input[placeholder=\"Episode name\"]").on('change keyup paste', function(){
	                var value = $(this).val(), slug_id = $(this).attr('id').replace('halimmovies_ep_name', 'halimmovies_ep_slug');
	                $('#'+slug_id).val( value.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a").replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e").replace(/ì|í|ị|ỉ|ĩ/g, "i").replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o").replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u").replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y").replace(/đ/g, "d").replace(/\+| /g, "-").toLowerCase() );
	            });
	            var episode_type = '<?php echo getPlayerTypesJs(); ?>';
	        </script>

	 	<?php
	 endif;
	}
}
if(!function_exists('halimmovies_meta_post_save'))
{
	/**
	 * [halimmovies_meta_post_save description]
	 * @param  [type] $post_id [description]
	 * @return [type]          [description]
	 */
	function halimmovies_meta_post_save( $post_id )
	{
		if(isset($_POST['halimmovies_link_nonce']))
			$halimmovies_link_nonce = $_POST['halimmovies_link_nonce'];
		if( !isset( $halimmovies_link_nonce ) ) {
		  	return;
		}
		if( !wp_verify_nonce( $halimmovies_link_nonce, 'halimmovies_save_meta_posts' ) ) {
		  	return;
		}
		$halimmovies_server_name    = isset($_POST['halimmovies_server_name']) ? $_POST['halimmovies_server_name'] : '';
		$halimmovies_ep_name        = isset($_POST['halimmovies_ep_name']) ? $_POST['halimmovies_ep_name'] : '';
		$halimmovies_ep_slug        = isset($_POST['halimmovies_ep_slug']) ? $_POST['halimmovies_ep_slug'] : '';
		$halimmovies_ep_link        = isset($_POST['halimmovies_ep_link']) ? $_POST['halimmovies_ep_link'] : '';
		$halimmovies_ep_type        = isset($_POST['halimmovies_ep_type']) ? $_POST['halimmovies_ep_type'] : '';
		$halimmovies_ep_sub_label   = isset($_POST['halimmovies_ep_sub_label']) ? $_POST['halimmovies_ep_sub_label'] : '';
		$halimmovies_ep_sub_file    = isset($_POST['halimmovies_ep_sub_file']) ? $_POST['halimmovies_ep_sub_file'] : '';
		$halimmovies_ep_listsv_name = isset($_POST['halimmovies_ep_listsv_name']) ? $_POST['halimmovies_ep_listsv_name'] : '';
		$halimmovies_ep_listsv_link = isset($_POST['halimmovies_ep_listsv_link']) ? $_POST['halimmovies_ep_listsv_link'] : '';
		$halimmovies_ep_listsv_type = isset($_POST['halimmovies_ep_listsv_type']) ? $_POST['halimmovies_ep_listsv_type'] : '';
		$input = array();
		if($halimmovies_server_name)
		{
			$ep_slug = cs_get_option('halim_episode_url');
			foreach ($halimmovies_server_name as $key => $value) {
				if(!$value){
					$value = 'Server #'.$key;
				}
				$var['halimmovies_server_name'] = esc_attr($value);
				$var['halimmovies_server_data'] = array();
				if(isset($halimmovies_ep_link[$key]) && $halimmovies_ep_link[$key])
				{
					foreach ($halimmovies_ep_link[$key] as $k => $v)
					{
	                	$episode_slug = preg_match('/([^0-9]+)/is', $halimmovies_ep_slug[$key][$k]) ?
				    	sanitize_title($halimmovies_ep_slug[$key][$k]) :
				    	sanitize_title($ep_slug.'-'.$halimmovies_ep_slug[$key][$k]);
				    	$_slug = str_replace('-', '_', $episode_slug);

						$var['halimmovies_server_data'][$_slug]['halimmovies_ep_name'] = isset($halimmovies_ep_name[$key][$k]) ? $halimmovies_ep_name[$key][$k] : '';
						$var['halimmovies_server_data'][$_slug]['halimmovies_ep_slug'] = isset($halimmovies_ep_slug[$key][$k]) ? $halimmovies_ep_slug[$key][$k] : '';
						$var['halimmovies_server_data'][$_slug]['halimmovies_ep_type'] = isset($halimmovies_ep_type[$key][$k]) ? $halimmovies_ep_type[$key][$k] : '';
						$var['halimmovies_server_data'][$_slug]['halimmovies_ep_link'] = $v;
						$var['halimmovies_server_data'][$_slug]['halimmovies_ep_subs'] = array();
						$var['halimmovies_server_data'][$_slug]['halimmovies_ep_listsv'] = array();
						if(isset($halimmovies_ep_sub_file[$key][$k]) && $halimmovies_ep_sub_file[$key][$k])
						{
							$countSub = 0;
							foreach ($halimmovies_ep_sub_file[$key][$k] as $s => $sub)
							{
								$countSub++;
								$varSub['halimmovies_ep_sub_file'] = trim($sub);
								$varSub['halimmovies_ep_sub_label'] = isset($halimmovies_ep_sub_label[$key][$k][$s]) ? trim($halimmovies_ep_sub_label[$key][$k][$s]) : '';
								$varSub['halimmovies_ep_sub_kind'] = 'captions';
								$varSub['halimmovies_ep_sub_default'] = ($countSub == 1) ? 'true' : 'false';
								array_push($var['halimmovies_server_data'][$_slug]['halimmovies_ep_subs'], $varSub);
							}

						}
						if(isset($halimmovies_ep_listsv_link[$key][$k]) && $halimmovies_ep_listsv_link[$key][$k])
						{
							foreach ($halimmovies_ep_listsv_link[$key][$k] as $s => $listsv)
							{
								$countSub++;
								$varSub['halimmovies_ep_listsv_link'] = trim($listsv);
								$varSub['halimmovies_ep_listsv_name'] = isset($halimmovies_ep_listsv_name[$key][$k][$s]) ? trim($halimmovies_ep_listsv_name[$key][$k][$s]) : '';
								$varSub['halimmovies_ep_listsv_type'] = isset($halimmovies_ep_listsv_type[$key][$k][$s]) ? trim($halimmovies_ep_listsv_type[$key][$k][$s]) : '';
								array_push($var['halimmovies_server_data'][$_slug]['halimmovies_ep_listsv'], $varSub);
							}
						}
						// array_push($var['halimmovies_server_data'], $varData);
					}
				}
				array_push($input, $var);
			}
	 		update_post_meta( $post_id, '_halimmovies', json_encode($input, JSON_UNESCAPED_UNICODE));
		}
	}
	add_action( 'save_post', 'halimmovies_meta_post_save' );
}