<?php
	get_header();
	global $current_user;
	$act = isset($_GET['act']) && $_GET['act'] ? wp_strip_all_tags($_GET['act']) : '';
	$user_meta = get_userdata($current_user->ID);
	$user_roles = $user_meta->roles[0];

?>

<aside id="sidebar" class="col-xs-12 col-sm-12 col-md-4">
	<div class="section-bar clearfix">
	   <h3 class="section-title">
	   		<span><?php _e('Profiles', 'halimthemes') ?></span>
	   </h3>

			<div class="profile-sidebar">
				<!-- SIDEBAR USERPIC -->
				<div class="profile-userpic">
					<?php echo get_avatar( $current_user->ID, 200); ?>
				</div>
				<!-- END SIDEBAR USERPIC -->
				<!-- SIDEBAR USER TITLE -->
				<div class="profile-usertitle">
					<div class="profile-usertitle-name">
						<a href="<?php echo home_url()."/author/".get_the_author_meta('user_login', $current_user->ID); ?>"><?php the_author(); ?></a>
					</div>
					<div class="profile-usertitle-job">
						<?php echo $user_roles; ?>
					</div>
				</div>
				<!-- END SIDEBAR USER TITLE -->
				<!-- SIDEBAR BUTTONS -->
				<div class="profile-userbuttons">
					<button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" title="Tính năng đang được xây dựng">Follow</button>
					<button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Tính năng đang được xây dựng">Message</button>
				</div>
				<!-- END SIDEBAR BUTTONS -->
				<!-- SIDEBAR MENU -->
				<div class="profile-usermenu">
					<ul class="nav">
						<li<?php echo $act == '' ? ' class="active"' : ''; ?>>
							<a href="<?php echo home_url()."/author/".get_the_author_meta('user_login', $current_user->ID); ?>"><i class="hl-user"></i> <?php _e('Overview', 'halimthemes'); ?></a>
						</li>
						<li<?php echo $act == 'change_pw' ? ' class="active"' : ''; ?>>
							<a href="<?php echo home_url()."/author/".get_the_author_meta('user_login', $current_user->ID); ?>/?act=change_pw"><i class="hl-lock-open-alt"></i> <?php _e('Change password', 'halimthemes'); ?></a>
						</li>
					</ul>
				</div>
				<!-- END MENU -->
			</div>
	</div>


</aside>

<main id="main-contents" class="col-xs-12 col-sm-12 col-md-12">
	<section>
		<div class="section-bar clearfix">
		   <h3 class="section-title">
		   		<span><?php _e('Bookmark list', 'halimthemes') ?></span><span class="count pull-right"><i></i> item</span>
		   </h3>
		</div>

		    <?php

		        $user_id    = get_current_user_id();
		        $get_author = get_user_by( 'slug', get_query_var( 'author_name' ) );
		        $author_id = $get_author->ID;
		        if($user_id == $author_id && $act == 'change_pw')
		        {
		            if( isset( $_POST['user_profile_nonce_field'] ) && wp_verify_nonce( $_POST['user_profile_nonce_field'], 'user_profile_nonce' ) )
		            {
						if(isset($_POST['current_password'])){
							$_POST = array_map('stripslashes_deep', $_POST);
							$current_password = sanitize_text_field($_POST['current_password']);
							$new_password = sanitize_text_field($_POST['new_password']);
							$confirm_new_password = sanitize_text_field($_POST['confirm_new_password']);
							$user_id = get_current_user_id();
							$errors = array();
							$current_user = get_user_by('id', $user_id);
							// Check for errors
							if (empty($current_password) && empty($new_password) && empty($confirm_new_password) ) {
							$errors[] = 'All fields are required';
							}
							if($current_user && wp_check_password($current_password, $current_user->data->user_pass, $current_user->ID)){
							//match
							} else {
								$errors[] = 'Password is incorrect';
							}
							if($new_password != $confirm_new_password){
								$errors[] = 'Password does not match';
							}
							if(strlen($new_password) < 6){
								$errors[] = 'Password is too short, minimum of 6 characters';
							}
							if(empty($errors)){
								wp_set_password( $new_password, $current_user->ID );
								echo '<div class="alert alert-success"><strong>Password successfully changed!</strong></div>';
							} else {
							    foreach($errors as $error){
							        echo '<div class="alert alert-danger"><strong>'.$error.'</strong></div>';
							    }
							}
					    }

			        }

		        ?>
		        <div class="halim_box">
					<div class="col-sm-4">
						<form action="" method="post">
							<?php wp_nonce_field('user_profile_nonce', 'user_profile_nonce_field'); ?>
						    <label>Current Password</label>
						    <div class="form-group pass_show">
				                <input type="password" class="form-control" name="current_password" placeholder="Current Password">
				            </div>
						       <label>New Password</label>
				            <div class="form-group pass_show">
				                <input type="password" class="form-control" name="new_password" placeholder="New Password">
				            </div>
						       <label>Confirm Password</label>
				            <div class="form-group pass_show">
				                <input type="password" class="form-control" name="confirm_new_password" placeholder="Confirm Password">
				            </div>
						    <div class="form-group"><button type="submit" class="btn btn-success"><?php _e('Update', 'halimthemes'); ?></button></div>
						</form>
					</div>
					<style>
						.pass_show{position: relative}
						.pass_show .ptxt {
							position: absolute;
							top: 50%;
							right: 10px;
							z-index: 1;
							color: #f36c01;
							margin-top: -10px;
							cursor: pointer;
							transition: .3s ease all;
						}
						.pass_show .ptxt:hover{color: #333333;}
					</style>
					<script>
						jQuery(document).ready(function(){
							jQuery('.pass_show').append('<span class="ptxt">Show</span>');
						});
						jQuery(document).on('click','.pass_show .ptxt', function(){
							jQuery(this).text($(this).text() == "Show" ? "Hide" : "Show");
							jQuery(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });

						});
					</script>
			    </div>

		        <?php
		    }
		    else
		    {

		    ?>
				<div class="halim_box">
					<?php if(!is_user_logged_in()) {
						echo '<div class="alert alert-danger"><strong>Please login again!</strong></div>';
					} ?>
					<ul class="halim-bookmark-lists" id="bookmarkList" style="max-height: 350px;"></ul>
				</div>
				<?php
			}
			?>

		<div class="clearfix"></div>
	</section>
	<?php echo do_shortcode('[halim-recentlyviewed]'); ?>
</main>

<?php get_footer(); ?>