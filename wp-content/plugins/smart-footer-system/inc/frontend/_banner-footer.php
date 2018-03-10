<?php 
$currentFooterBannerSettings = []; 
if(isset($sfsPostFooter["footer"]["banner"])) {
	$currentFooterBannerSettings = $sfsPostFooter["footer"]["banner"];
}
?>
<?php foreach($currentFooterBannerSettings as $res => $bannerSettings): 
$paddingV = str_replace("x", "",$bannerSettings["v-padding"])*45;
$paddingH = str_replace("x", "",$bannerSettings["h-padding"])*30;

?>
<style>
	#sfs-banner-<?php echo $res ?> {
		cursor: pointer;
		<?php if($bannerSettings["background-color"]): ?>
		background-color: <?php echo $bannerSettings["background-color"] ?>;
		<?php endif; ?>		
		<?php if($bannerSettings["background-image"]): ?>
		background-image: url(<?php echo $bannerSettings["background-image"] ?>);
		<?php endif; ?>
		<?php if($bannerSettings["background-image-position"]): ?>
		background-position: <?php echo $bannerSettings["background-image-position"] ?>;
		<?php endif; ?>
		<?php if($bannerSettings["background-image-size"]): ?>
		background-size: <?php echo $bannerSettings["background-image-size"] ?>;
		<?php endif; ?>
		<?php if($bannerSettings["background-image-repeat"]): ?>
		background-repeat: <?php echo $bannerSettings["background-image-repeat"] ?>;
		<?php endif; ?>

		padding: <?php echo $paddingV ?>px <?php echo $paddingH ?>px;
	}

	<?php if(isset($bannerSettings["open-icon-type"]) && @$bannerSettings["open-icon-type"] == 'image'): ?>
		#sfs-banner-<?php echo $res ?> .sfs-banner-content-closed button img {
			width: <?php echo (@$bannerSettings["open-icon-image-w"] != '') ? @$bannerSettings["open-icon-image-w"].'px' : 'auto'; ?>!important;
			min-width: <?php echo (@$bannerSettings["open-icon-image-w"] != '') ? @$bannerSettings["open-icon-image-w"].'px' : 'auto'; ?>!important;

			height: <?php echo (@$bannerSettings["open-icon-image-h"] != '') ? @$bannerSettings["open-icon-image-h"].'px' : 'auto'; ?>!important;
		}
	<?php endif; ?>
	<?php if(isset($bannerSettings["close-icon-type"]) && @$bannerSettings["close-icon-type"] == 'image'): ?>
		#sfs-banner-<?php echo $res ?> .sfs-banner-content-opened button img
		#sfs-banner-<?php echo $res ?> .sfs-banner-content-closed .sfs-banner-close-right img {
			width: <?php echo (@$bannerSettings["close-icon-image-w"] != '') ? @$bannerSettings["close-icon-image-w"].'px' : 'auto'; ?>!important;
			min-width: <?php echo (@$bannerSettings["close-icon-image-w"] != '') ? @$bannerSettings["close-icon-image-w"].'px' : 'auto'; ?>!important;

			height: <?php echo (@$bannerSettings["close-icon-image-h"] != '') ? @$bannerSettings["close-icon-image-h"].'px' : 'auto'; ?>!important;
		}
	<?php endif; ?>
	#sfs-banner-<?php echo $res ?> .sfs-banner-content-closed .sfs-banner-close-right i {
		color: <?php echo $bannerSettings["font-color"] ?>;
		font-size: 30px;
	}

	#sfs-banner-<?php echo $res ?> .sfs-banner-content-closed h4 {
		<?php if(isset($bannerSettings["title-font-style"])): ?>
		font-style: <?php echo $bannerSettings["title-font-style"] ?>;
		<?php endif; ?>
		<?php if(isset($bannerSettings["title-font-size"])): ?>
		font-size: <?php echo $bannerSettings["title-font-size"] ?>px;
		<?php endif; ?>	
		<?php if(isset($bannerSettings["title-font-weight"])): ?>
		font-weight: <?php echo $bannerSettings["title-font-weight"] ?>;
		<?php endif; ?>		
		<?php if(isset($bannerSettings["title-line-height"])): ?>
		line-height: <?php echo $bannerSettings["title-line-height"] ?>px;
		<?php endif; ?>	
		<?php if(isset($bannerSettings["title-margin-bottom"])): ?>
		margin-bottom: <?php echo $bannerSettings["title-margin-bottom"] ?>px!important;
		<?php endif; ?>	
	}
	#sfs-footer-wrapper .sfs-banner-content-opened .sfs-banner-title h4 {
		font-size: 18px!important;
		line-height: 18px!important;
		font-style: normal!important;
	}
	#sfs-banner-<?php echo $res ?> .sfs-banner-content-closed h5 {
		<?php if(isset($bannerSettings["subtitle-font-style"])): ?>
		font-style: <?php echo $bannerSettings["subtitle-font-style"] ?>;
		<?php endif; ?>
		<?php if(isset($bannerSettings["subtitle-font-size"])): ?>
		font-size: <?php echo $bannerSettings["subtitle-font-size"] ?>px;
		<?php endif; ?>	
		<?php if(isset($bannerSettings["subtitle-font-weight"])): ?>
		font-weight: <?php echo $bannerSettings["subtitle-font-weight"] ?>;
		<?php endif; ?>		
		<?php if(isset($bannerSettings["subtitle-line-height"])): ?>
		line-height: <?php echo $bannerSettings["subtitle-line-height"] ?>px;
		<?php endif; ?>	
		<?php if(isset($bannerSettings["subtitle-margin-bottom"])): ?>
		margin-bottom: <?php echo $bannerSettings["subtitle-margin-bottom"] ?>px!important;
		<?php endif; ?>
	}

	#sfs-banner-<?php echo $res ?> h4,
	#sfs-banner-<?php echo $res ?> h5 {
		<?php if($bannerSettings["font-color"]): ?>
		color: <?php echo $bannerSettings["font-color"] ?>;
		<?php endif; ?>
	}
	#sfs-banner-<?php echo $res ?>:hover h4,
	#sfs-banner-<?php echo $res ?>:hover h5 {
		<?php if($bannerSettings["font-color-hover"] !=''): ?>
		color: <?php echo $bannerSettings["font-color-hover"] ?>;
		<?php endif; ?>	
	}
	#sfs-banner-<?php echo $res ?>::before {
		<?php if($bannerSettings["overlay-color"] != ''): ?>		
		background-color: <?php echo $bannerSettings["overlay-color"] ?>;
		<?php endif; ?>
	}
	#sfs-banner-<?php echo $res ?>:hover::before {
		<?php if(@$bannerSettings["overlay-hover-color"] != ''): ?>		
		background-color: <?php echo @$bannerSettings["overlay-hover-color"] ?>;
		<?php endif; ?>
	}
	#sfs-banner-<?php echo $res ?>:hover {
		<?php if($bannerSettings["background-color-hover"]!=''): ?>
		background-color: <?php echo $bannerSettings["background-color-hover"] ?>;
		<?php endif; ?>
	}
	#sfs-banner-<?php echo $res ?> button {
		<?php if(isset($bannerSettings["button-font-style"])): ?>
		font-style: <?php echo $bannerSettings["button-font-style"] ?>;
		<?php endif; ?>
		<?php if(isset($bannerSettings["button-font-weight"])): ?>
		font-weight: <?php echo $bannerSettings["button-font-weight"] ?>;
		<?php endif; ?>	
		<?php if(isset($bannerSettings["button-font-size"])): ?>
		font-size: <?php echo $bannerSettings["button-font-size"] ?>px;
		<?php endif; ?>		
		<?php if(isset($bannerSettings["button-line-height"])): ?>
		line-height: <?php echo $bannerSettings["button-line-height"] ?>px;
		<?php endif; ?>	
	}
	#sfs-banner-<?php echo $res ?> button {
		<?php if($bannerSettings["button-border-color"]!=''): ?>
		border: 2px solid <?php echo $bannerSettings["button-border-color"] ?>!important;
		<?php endif; ?>
		<?php if($bannerSettings["button-background-color"] !=''): ?>
		background-color: <?php echo $bannerSettings["button-background-color"] ?>!important;
		<?php endif; ?>
		<?php if($bannerSettings["button-font-color"] !=''): ?>
		color: <?php echo $bannerSettings["button-font-color"] ?>!important;
		<?php endif; ?>
		<?php if(
			$bannerSettings["button-border-color"] == '' 
			&& $bannerSettings["button-border-color-hover"] == ''
			&& $bannerSettings["button-background-color"] == '' 
			&& $bannerSettings["button-background-color-hover"] == ''
			): ?>
		padding-left: 0px!important;
		padding-right: 0px!important;
		padding-bottom: 0px!important;
		padding-top: 0px!important;
		<?php endif ?>
	}
	#sfs-banner-<?php echo $res ?> .sfs-banner-content-opened  button {
		font-size: 30px;
	}
	#sfs-banner-<?php echo $res ?> button:hover,
	#sfs-banner-<?php echo $res ?>:hover button {
		<?php if($bannerSettings["button-border-color-hover"]!=''): ?>
		border: 2px solid <?php echo $bannerSettings["button-border-color-hover"] ?>!important;
		<?php endif; ?>
		<?php if($bannerSettings["button-background-color-hover"]!=''): ?>
		background-color: <?php echo $bannerSettings["button-background-color-hover"] ?>!important;
		<?php endif; ?>
		<?php if($bannerSettings["button-font-color-hover"]!=''): ?>
		color: <?php echo $bannerSettings["button-font-color-hover"] ?>!important;
		<?php endif; ?>
	}
	<?php if(@$bannerSettings["force-close"] && @$bannerSettings["force-close-color"]): ?>
	#sfs-banner-<?php echo $res ?> .sfs-banner-close-right i {
		color: <?php echo @$bannerSettings["force-close-color"] ?>!important ;
	}
	<?php endif; ?>
</style>
<?php endforeach; ?>
<?php 
foreach($currentFooterBannerSettings as $res => $bannerSettings): 
$bannerSettings["s-height"] = 80;
$bannerSettings["open-icon-type"] = (isset($bannerSettings["open-icon-type"])) ? $bannerSettings["open-icon-type"] : 'font';
$bannerSettings["close-icon-type"] = (isset($bannerSettings["close-icon-type"])) ? $bannerSettings["close-icon-type"] : 'font';
if(@$bannerSettings['close-icon-type'] == 'image') {
	$bannerSettings["s-height"] = (@$bannerSettings['close-icon-image-w'] == '' ) ? $bannerSettings['close-icon-image-h'] : $bannerSettings['close-icon-image-w'];
}
?>
<div 
data-auto-show="<?php echo (isset($bannerSettings["auto-show"])) ? $bannerSettings["auto-show"] : '' ?>" 
data-auto-hide="<?php echo (isset($bannerSettings["auto-hide"])) ? $bannerSettings["auto-hide"] : '' ?>" 
data-auto-show-sec="<?php echo isset($bannerSettings["auto-show-seconds"]) ? $bannerSettings["auto-show-seconds"] : ''?>" data-auto-hide-sec="<?php echo isset($bannerSettings["auto-hide-seconds"]) ? $bannerSettings["auto-hide-seconds"] : ''?>" data-res="<?php echo $res ?>" id="sfs-banner-<?php echo $res ?>" class="sfs-banner-wrapper sfs-banner-<?php echo $res ?>" 
data-open-on-end="<?php echo (isset($bannerSettings["open-on-bottom"])) ? $bannerSettings["open-on-bottom"] : '' ?>"
data-speed="speed-<?php echo $bannerSettings["open-speed"]?>"
data-height="<?php echo $bannerSettings["s-height"]?>">
	<div class="sfs-banner-content sfs-banner-content-closed align-<?php echo $bannerSettings["content-aligment"] ?>" data-role="closed">
		<?php if($bannerSettings["title"] !='' || $bannerSettings["subtitle"] !=''): ?>
		<div class="sfs-banner-title">
			<h4><?php echo $bannerSettings["title"]?></h4>
			<h5><?php echo $bannerSettings["subtitle"]?></h5>
		</div>
		<?php endif; ?>
		<div class="sfs-banner-button">
			<button class="<?php echo $bannerSettings["button-shape"]?> <?php echo $bannerSettings["button-size"]?>" type="button">
				<?php if($bannerSettings["open-icon"] !=''): ?>
				<i class="<?php echo (isset($bannerSettings["open-icon"]) && @$bannerSettings["open-icon-type"] == 'font') ? str_replace("|", " ", $bannerSettings["open-icon"]) : ''; ?>">
					<?php if(@$bannerSettings["open-icon-type"] == 'image') : ?>
					<img src="<?php echo (isset($bannerSettings["open-icon"])) ? $bannerSettings["open-icon"] : ''?>">
					<?php endif; ?>
				</i>
				<?php endif; ?>
				<?php if($bannerSettings["button-text"] !=''): ?>
				<span><?php echo $bannerSettings["button-text"]?></span>
				<?php endif; ?>
			</button>
		</div>
		<?php if(@$bannerSettings["force-close"]): ?>
		<div class="sfs-banner-close-right">
			<i class="genericon genericon-close-alt"></i>
		</div>
		<?php endif; ?>
	</div>
	<div class="sfs-banner-content sfs-banner-content-opened align-<?php echo $bannerSettings["content-aligment"] ?> <?php echo ($bannerSettings["title"] =='') ? 'no-title' : '' ?>" data-role="closed">
		<?php if($bannerSettings["title"] !=''):  ?>
		<div class="sfs-banner-title">
			<h4><?php echo $bannerSettings["title"]?></h4>
		</div>
		<?php endif; ?>
		<div class="sfs-banner-button">
			<button class="<?php echo $bannerSettings["button-shape"]?> <?php echo $bannerSettings["button-size"]?>" type="button">
				<?php if($bannerSettings["close-icon"] !=''): ?>
				<i class="<?php echo (isset($bannerSettings["close-icon"]) && @$bannerSettings["close-icon-type"] == 'font') ? str_replace("|", " ", $bannerSettings["close-icon"]) : ''; ?>">
					<?php if(@$bannerSettings["close-icon-type"] == 'image') : ?>
					<img src="<?php echo (isset($bannerSettings["close-icon"])) ? $bannerSettings["close-icon"] : ''?>">
					<?php endif; ?>
				</i>
				<?php endif; ?>
			</button>
		</div>
	</div>	

</div>
<?php endforeach ?>