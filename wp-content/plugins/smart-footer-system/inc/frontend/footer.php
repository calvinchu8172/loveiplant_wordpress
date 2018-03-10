<?php 
$sfsPostFooter = SfsPostType::getPostFooter();
$sfsSettings   = SfsSettings::get();
?>
<?php if($sfsPostFooter["footer"] && !$sfsPostFooter['disable']): ?>
<?php if($sfsPostFooter["hide_footer"]): ?>
<style>
	footer <?php echo (isset($sfsSettings['classes'] ) && $sfsSettings['classes'] != '') ? ', '. $sfsSettings['classes'] : '' ?>,
	#footer-outer {
		display: none!important;
		height: 0px!important;
		min-height: 0px!important;
		max-height: 0px!important;
		visibility: hidden!important;
		overflow: hidden!important;
	}
</style>
<?php endif; ?>
<?php if($sfsPostFooter["currentFooterCss"]!=''): ?>
<style type="text/css" data-type="vc_custom-css">
<?php echo $sfsPostFooter["currentFooterCss"]; ?>
</style>
<style type="text/css" data-type="vc_shortcodes-custom-css">
<?php echo $sfsPostFooter["shortcodesCustomCss"]; ?>
</style>
<?php endif; ?>

<style>

	#sfs-footer-wrapper .sfs-footer-content <?php echo (isset($sfsPostFooter['footer']["type"]) && $sfsPostFooter['footer']["type"] == 'bottom') ? ', #sfs-footer-wrapper .sfs-footer-content' : '' ?> <?php echo (isset($sfsPostFooter['footer']["type"]) && $sfsPostFooter['footer']["type"] == 'accordion' && (isset($sfsPostFooter['footer']["background-video-type"]) && $sfsPostFooter['footer']["background-video-type"] == 'none')) ? ', #sfs-footer-wrapper .sfs-footer-content > div' : '' ?> {
		position: relative;
		<?php if(isset($sfsPostFooter['footer']["type"]) && $sfsPostFooter['footer']["type"] != 'keyring'): ?>

		<?php if($sfsPostFooter["footer"]["content-background-color"]): ?>
		background-color: <?php echo $sfsPostFooter["footer"]["content-background-color"] ?>;
		<?php endif; ?>		
		<?php if($sfsPostFooter["footer"]["content-background-image"]): ?>
		background-image: url(<?php echo $sfsPostFooter["footer"]["content-background-image"] ?>);
		<?php endif; ?>
		<?php if($sfsPostFooter["footer"]["content-background-image-position"]): ?>
		background-position: <?php echo $sfsPostFooter["footer"]["content-background-image-position"] ?>;
		<?php endif; ?>
		<?php if($sfsPostFooter["footer"]["content-background-image-size"]): ?>
		background-size: <?php echo $sfsPostFooter["footer"]["content-background-image-size"] ?>;
		<?php endif; ?>
		<?php if($sfsPostFooter["footer"]["content-background-image-repeat"]): ?>
		background-repeat: <?php echo $sfsPostFooter["footer"]["content-background-image-repeat"] ?>;
		<?php endif; ?>

		<?php endif; ?>

		<?php if(isset($sfsPostFooter['footer']["content-background"])): ?>
		background-color: <?php echo $sfsPostFooter['footer']["content-background"] ?>;
		<?php endif; ?>
	}

	#sfs-footer-wrapper .sfs-footer-content > div {
		position: relative;
		<?php if(isset($sfsPostFooter['footer']["content-max-width"]) && $sfsPostFooter['footer']["content-max-width"] != ''): ?>
		max-width: <?php echo $sfsPostFooter['footer']["content-max-width"] ?>px;
		margin: auto auto;
		<?php endif; ?>
	}

	<?php if(
		isset($sfsPostFooter["footer"]["content-border-size"]) && $sfsPostFooter["footer"]["content-border-size"] != '' 
		&& isset($sfsPostFooter["footer"]["content-border-type"]) && $sfsPostFooter["footer"]["content-border-type"] != ''
		&& isset($sfsPostFooter["footer"]["content-border-color"]) && $sfsPostFooter["footer"]["content-border-color"] != '' 
	): ?>
	#sfs-footer-wrapper .sfs-footer-content {
		border: <?php echo $sfsPostFooter["footer"]["content-border-size"] ?>px <?php echo $sfsPostFooter["footer"]["content-border-type"] ?> <?php echo $sfsPostFooter["footer"]["content-border-color"] ?>;
	}
	<?php endif; ?>

	@media only screen and (max-width: 480px) {
		#sfs-footer-wrapper .sfs-footer-content > div {
			padding: 0px 15px;
		}
		
	}
	<?php if($sfsPostFooter["footer"]["content-overlay-color"] && $sfsPostFooter["footer"]["type"] !='keyring'): ?>
	#sfs-footer-wrapper .sfs-footer-content > div::before {
	<?php else: ?>
	#sfs-footer-wrapper .sfs-footer-content .sfs-footer-background-video::after {
	<?php endif; ?>
		content: '';
		display: block;
		width: 300%;
		height: 100%;
		min-height: 100%;
		max-height: 100%;
		min-width: 300%;
		max-width: 300%;
		position: absolute;
		top: 0px;
		left:-100%;
		background-color: <?php echo $sfsPostFooter["footer"]["content-overlay-color"] ?>;
		pointer-events: none!important;
	}
	#sfs-footer-wrapper .sfs-footer-content > div::after {
		content: '';
		display: table;
		clear: both;
	}

	#sfs-footer-wrapper .sfs-footer-content > div > * {
		position: relative;
		z-index: 1;
	}
	
	<?php 
	$sfsContentPadding = SfsFrontend::getFooterContentPaddings($sfsPostFooter);
	?>
	@media only screen and (min-width: 0px) {
		#sfs-footer-wrapper .sfs-footer-content > div {
			padding: <?php echo $sfsContentPadding["mobile"]["vertical"] ?> <?php echo $sfsContentPadding["mobile"]["horizontal"] ?>!important;
		}
	}
	@media only screen and (min-width: 768px) {
		#sfs-footer-wrapper .sfs-footer-content > div {
			padding: <?php echo $sfsContentPadding["tablet"]["vertical"] ?> <?php echo $sfsContentPadding["tablet"]["horizontal"] ?>!important;
		}
	}
	@media only screen and (min-width: 1025px) {
		#sfs-footer-wrapper .sfs-footer-content > div {
			padding: <?php echo $sfsContentPadding["desktop"]["vertical"] ?> <?php echo $sfsContentPadding["desktop"]["horizontal"] ?>!important;
		}
	}
	<?php if(isset($sfsPostFooter["footer"]["hide-on-mobile"]) && $sfsPostFooter["footer"]["hide-on-mobile"]): ?>
	@media only screen and (max-width: 768px) {
		#sfs-footer-wrapper,
		#sfs-banner-temp,
		#sfs-footer-temp-div {
			display: none!important;
			visibility: hidden!important;
		}
	}
	<?php endif; ?>
	<?php if(isset($sfsPostFooter["footer"]["hide-on-tablet"]) && $sfsPostFooter["footer"]["hide-on-tablet"]): ?>
	@media only screen and (min-width: 769px) and (max-width: 1024px) {
		#sfs-footer-wrapper,
		#sfs-banner-temp,
		#sfs-footer-temp-div {
			display: none!important;
			visibility: hidden!important;
		}
	}
	<?php endif; ?>	
	<?php if(isset($sfsPostFooter["footer"]["hide-on-desktop"]) && $sfsPostFooter["footer"]["hide-on-desktop"]): ?>
	@media only screen and (min-width: 1025px) {
		#sfs-footer-wrapper,
		#sfs-banner-temp,
		#sfs-footer-temp-div {
			display: none!important;
			visibility: hidden!important;
		}
	}
	<?php endif; ?>	

	@media only screen and ( max-width: 1024px) {
		#sfs-footer-wrapper .sfs-footer-content > div <?php echo (isset($sfsPostFooter['footer']["type"]) && $sfsPostFooter['footer']["type"] == 'bottom') ? ', #sfs-footer-wrapper .sfs-footer-content' : '' ?> 
					<?php if($sfsPostFooter["footer"]["content-mobile-background-image-position"]): ?> {
		background-position: <?php echo $sfsPostFooter["footer"]["content-mobile-background-image-position"] ?>;
		<?php endif; ?>
		}	
	}
</style>
<div id="sfs-footer-wrapper" class="<?php echo SfsFrontend::getFooterClasses($sfsPostFooter) ?> sfs-footer-<?php echo $sfsPostFooter["name"] ?>" style="<?php echo SfsFrontend::getFooterStyle($sfsPostFooter) ?>" <?php echo SfsFrontend::getFooterData($sfsPostFooter) ?>>
	<?php
	if($sfsPostFooter['footer']['type'] == 'normal') {
		include_once(SFS_PATH.'inc/frontend/_normal-footer.php');
	}
	else if($sfsPostFooter['footer']['type'] == 'bottom') {
		include_once(SFS_PATH.'inc/frontend/_slideup-footer.php');
	}	
	else if($sfsPostFooter['footer']['type'] == 'banner') {
		include_once(SFS_PATH.'inc/frontend/_banner-footer.php');
	}
	else if($sfsPostFooter['footer']['type'] == 'keyring') {
		include_once(SFS_PATH.'inc/frontend/_keyring-footer.php');
	}	
	else if($sfsPostFooter['footer']['type'] == 'accordion') {
		include_once(SFS_PATH.'inc/frontend/_accordion-footer.php');
	}		
	else if($sfsPostFooter['footer']['type'] == 'reveal') {
		include_once(SFS_PATH.'inc/frontend/_reveal-footer.php');
	}	
	else if($sfsPostFooter['footer']['type'] == 'spread') {
		include_once(SFS_PATH.'inc/frontend/_spread-footer.php');
	}		
	?>
	<div class="sfs-footer-content" style="<?php echo SfsFrontend::getFooterContentStyle($sfsPostFooter); ?>">
		<?php
				if(isset($sfsPostFooter['footer']["background-video-type"]) && $sfsPostFooter['footer']["background-video-type"] != 'none') {
			include_once(SFS_PATH.'inc/frontend/video.php'); 
		}
		?>
		<div>

		<?php 
		$sfsFooters = new WP_Query(array(
			'post_type' => 'sfs-footer',
			'p' => $sfsPostFooter['id'],
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'suppress_filters' => false,
		));
		$printed = false;
		if($sfsFooters->have_posts()){
			while($sfsFooters->have_posts()) {
				$sfsFooters->the_post();
				$currentPost = $sfsFooters->post;
				if($printed === true) continue;
				get_post_custom($currentPost->ID);
				setup_postdata($currentPost);
				ob_start();
				the_content();
				$sfsFooterContent = ob_get_clean();

				echo SfsFrontend::themeFixes($sfsFooterContent, $currentPost);
				$postCustomCss = get_post_meta($currentPost->ID, '_wpb_post_custom_css', true);
				if (!empty($postCustomCss)):
				?>
				<style type="text/css" data-type="vc_custom-css">
				<?php echo $postCustomCss; ?>
				</style>
				<?php
				endif;
				$shortcodeCustomCss = get_post_meta($currentPost->ID, '_wpb_shortcodes_custom_css', true);
				if (!empty( $shortcodeCustomCss)):
					?>
					<style type="text/css" data-type="vc_shortcodes-custom-css">
					<?php echo $shortcodeCustomCss ?>
					</style>
					<?php
				endif;
				?>
				<style type="text/css" data-type="sfs-theme-fixes">
				#mk-boxed-layout {
					position: relative!important;
					z-index: unset!important;
				}
				</style>
				<?php 
				$printed = true;
				wp_reset_postdata();
			}
			wp_reset_query();
		}
		
		?>
		</div>
	</div>
</div>
<?php if($sfsPostFooter["currentFooterCustomCss"]!=''): ?>
<style type="text/css" data-type="sfs_custom_css">
<?php echo $sfsPostFooter["currentFooterCustomCss"]; ?>
</style>
<?php endif; ?>
<?php endif; ?>
