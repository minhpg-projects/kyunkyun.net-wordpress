<?php
/**
 * Template Name: Embed Player
 */
$embed_url = isset($_GET['url']) ? HaLimCrypt::decrypt(sanitize_text_field($_GET['url'])) : '';
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
	<script src="<?php echo plugins_url('halimPlayer/assets/js/jwplayer-8.9.3.js'); ?>"></script>

</head>
<body>
	<div id="halim-embed" class="embed-responsive embed-responsive-16by9" style="display: none;">
		<iframe class="embed-responsive-item" src="<?php echo $embed_url; ?>" allowfullscreen></iframe>
	</div>

	<div id="halim-player"></div>

	<script>

		var ads	= [
			'<?php echo home_url(); ?>/wp-content/plugins/halimPlayer/assets/ads/vast-30s-ad.xml', // Thay bằng link ads
			'<?php echo home_url(); ?>/wp-content/plugins/halimPlayer/assets/ads/vast-30s-ad.xml', // Thay bằng link ads
		];
		var arrPreroll = ads[Math.floor(Math.random() * ads.length)]; // Hiển thị ngẫu nhiên ads
		var playerInstance = jwplayer('halim-player');
		jwplayer.key = "MBvrieqNdmVL4jV0x6LPJ0wKB/Nbz2Qq/lqm3g==";
		playerInstance.setup({
			file: '<?php echo HALIM_THEME_URI ?>/assets/images/1s_blank.mp4', // tải file mp4 về và thay thế link video ads hoặc giữ nguyên
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