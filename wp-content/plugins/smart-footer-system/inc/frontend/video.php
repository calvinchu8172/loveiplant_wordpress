<?php
$videoData = [
	"autoplay" => true,
	"loop"	   => false,
	"sound"	   => false,
	"start"	   => false,
	"end"	   => false
];
if(isset($sfsPostFooter['footer']["background-video-loop"]) && $sfsPostFooter['footer']["background-video-loop"]) {
	$videoData["loop"] = true;
}
if(isset($sfsPostFooter['footer']["background-video-sound"]) && $sfsPostFooter['footer']["background-video-sound"]) {
	$videoData["sound"] = true;
}
if(isset($sfsPostFooter['footer']["background-video-youtube-start"]) && $sfsPostFooter['footer']["background-video-youtube-start"] != '') {
	$videoData["start"] = $sfsPostFooter['footer']["background-video-youtube-start"];
}
if(isset($sfsPostFooter['footer']["background-video-youtube-end"]) && $sfsPostFooter['footer']["background-video-youtube-end"] != '') {
	$videoData["end"] = $sfsPostFooter['footer']["background-video-youtube-end"];
}
?>
<section id="sfs-footer-background-video" class="sfs-footer-background-video">
	<?php if(isset($sfsPostFooter['footer']["background-video-type"]) && $sfsPostFooter['footer']["background-video-type"] == 'self'): ?>
	<video id="sfs-self-video-hosted" style="width:1920; height:1080px" autoplay="autoplay" poster="<?php echo @$sfsPostFooter['footer']["background-video-self-image"] ?>" <?php echo ($videoData['loop']) ? 'loop="loop" onended="var v=this;setTimeout(function(){v.play()},300)"' : '' ?> <?php echo (!$videoData['sound']) ? 'volume="0"' : '' ?>>
		<source src="<?php echo (isset($sfsPostFooter["footer"]['background-video-self-mp4']) && $sfsPostFooter["footer"]['background-video-self-mp4'] != '') ? $sfsPostFooter["footer"]['background-video-self-mp4'] : '' ?>" type="video/mp4" />
		<source src="<?php echo (isset($sfsPostFooter["footer"]['background-video-self-webm']) && $sfsPostFooter["footer"]['background-video-self-webm'] != '') ? $sfsPostFooter["footer"]['background-video-self-webm'] : '' ?>" type="video/webm" />
		<source src="<?php echo (isset($sfsPostFooter["footer"]['background-video-self-ogv']) && $sfsPostFooter["footer"]['background-video-self-ogv'] != '') ? $sfsPostFooter["footer"]['background-video-self-ogv'] : '' ?>" type="video/ogg" />
	</video>
	<script>
		jQuery(function(){
			<?php if(!$videoData['sound']): ?>
			document.getElementById('sfs-self-video-hosted').volume = 0;
			<?php endif; ?>
			setTimeout(function(){
				jQuery(window).trigger("resize");
			},1000);
		});
	</script>
	<?php 
	elseif(isset($sfsPostFooter['footer']["background-video-type"]) && $sfsPostFooter['footer']["background-video-type"] == 'youtube'): 
		$video_id = '';
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $sfsPostFooter['footer']["background-video-youtube"], $match)) {
		    $video_id = $match[1];
		}
	?>
	
	<iframe width="1920" height="1080" class="sfs-youtube-player" id="sfs-youtube-player" type="text/html" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id ?>?&hd=1&autoplay=1&enablejsapi=1&controls=0&start=<?php echo ($videoData['start']) ? $videoData['start'] : '0' ?>&end=<?php echo ($videoData['end']) ? $videoData['end'] : '' ?>&portrait=1&rel=0&showinfo=0
	" frameborder="0"></iframe>
		<script async id="youtube-iframe-api" src="//www.youtube.com/iframe_api"></script>
		<script>
		function sfsYoutubeVideoReady() {
			var player;
		    player = new YT.Player('sfs-youtube-player', {
		        events: {
		            'onReady': function(){
		            	<?php if(!$videoData["sound"]): ?>
		            	 player.mute();
		            	 <?php endif; ?>
		            },
		            onStateChange: function(e){
		            	<?php if($videoData['loop']): ?>
		            	if (e.data === YT.PlayerState.ENDED) {
		            		player.seekTo(<?php echo ($videoData['start']) ? $videoData['start'] : '0' ?>, true);
						}
						<?php endif; ?>
		            }
		        }
		    });
		};
		jQuery("#sfs-youtube-player").on("load", function(){
			setTimeout(function(){
				sfsYoutubeVideoReady();
			},10);
		});	
	</script>
	
	<?php 
	elseif(isset($sfsPostFooter['footer']["background-video-type"]) && $sfsPostFooter['footer']["background-video-type"] == 'vimeo'): 
		$video_id = '';
		$video_id = @rtrim(@end(@explode("/", @$sfsPostFooter['footer']["background-video-vimeo"])), "/");
		?>
		<script src="https://player.vimeo.com/api/player.js"></script>
		<script>
			var player = new Vimeo.Player('sfs-footer-background-video', {
				id: <?php echo $video_id ?>,
				autoplay: true,
				loop: <?php echo ($videoData["loop"]) ? 'true' : 'false' ?>,
				quality: '720p'
			});
			<?php if(!$videoData["sound"]): ?>
			player.setVolume(0);
			<?php endif; ?>
		</script>
	<?php endif; ?>
</section>