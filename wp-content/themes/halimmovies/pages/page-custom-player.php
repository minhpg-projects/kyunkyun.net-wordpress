<?php
/**
 * Template Name: Custom Embed Player
 */
$link = isset($_GET['link']) ? HaLimCrypt::decrypt(sanitize_text_field($_GET['link'])) : '';
$type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'none';
$post_id = isset($_GET['post_id']) ? absint($_GET['post_id']) : '';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>HaLim Player</title>
		<style>
			html,body {
				padding:0;
				margin:0;
				background:#000;
				height:100%;
				overflow:hidden;
				position:relative
			}
			.embed-responsive {
				position:relative;
				display:block;
				height:0;
				padding:0;
				overflow:hidden
			}
			.embed-responsive .embed-responsive-item,
			.embed-responsive iframe,
			.embed-responsive embed,
			.embed-responsive object,
			.embed-responsive video {
				position:absolute;
				top:0;
				left:0;
				bottom:0;
				height:100%;
				width:100%;
				border:0
			}
			.embed-responsive-16by9 {
				padding-bottom:56.25%
			}
			.embed-responsive-4by3 {
				padding-bottom:75%
			}
		</style>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="<?php echo HALIM_THEME_URI ?>/player/assets/js/jwplayer-8.9.3.js?ver=5.4"></script>

	</head>
	<body>
	<!-- <?php echo $type; ?> -->


		<?php
			if($type == 'gpt') {
				// code getlink google photo
				// $sources = api response
			}
			elseif($type == 'youtube') {
				//code getlink youtube
				// $sources = api response
			}
			elseif($type == 'xxx') {
				//code..
			}
			else { //default
				//code
			}

		?>


		<?php $sources = halim_detect_server($link, $post_id)->sources; ?>

		<div id="ajax-player"></div>
		<script>

			var ads	= [
				'<?php echo home_url(); ?>/wp-content/plugins/halimPlayer/assets/ads/vast-30s-ad.xml', // Thay bằng link ads
				'<?php echo home_url(); ?>/wp-content/plugins/halimPlayer/assets/ads/vast-30s-ad.xml', // Thay bằng link ads
			];
			var arrPreroll = ads[Math.floor(Math.random() * ads.length)]; // Hiển thị ngẫu nhiên ads
			var playerInstance = jwplayer('ajax-player');

			playerInstance.setup({
				key: 'MBvrieqNdmVL4jV0x6LPJ0wKB/Nbz2Qq/lqm3g==',
				sources: <?php echo $sources; ?>,
				width: '100%',
				primary: 'html5',
				controls: true,
				autostart: true,
				aspectratio: '16:9',
				advertising: {
		            tag: arrPreroll,
		            client: "vast",
		            vpaidmode: "insecure",
		            skipoffset: 5, // Bỏ qua quảng cáo trong vòng 5 giây
		            skipmessage: "Bỏ qua sau xx giây",
		            skiptext: "Bỏ qua"
		        }
			});

		    playerInstance.on('error', function() {
		    	//custom error handler
		    });


			playerInstance.on('complete', function(event){ // Loại bỏ ads và hiển thị embed khi visitor click Bỏ qua
				jQuery('#halim-embed').show();
				playerInstance.remove();
			});

			playerInstance.on('adSkipped', function(event){ // Loại bỏ ads và hiển thị embed khi visitor click Bỏ qua
				jQuery('#halim-embed').show();
				playerInstance.remove();
				console.log('Quảng cáo đã bị bỏ qua!');
			});

			playerInstance.on('adComplete', function(event){ // Tự động loại bỏ ads và hiển thị embed sau khi ads đã chạy hết thời lượng quy định
				jQuery('#halim-embed').show();
				playerInstance.remove();
				console.log('Quảng cáo đã được xem đầy đủ!');
			});

		</script>

	</body>
</html>