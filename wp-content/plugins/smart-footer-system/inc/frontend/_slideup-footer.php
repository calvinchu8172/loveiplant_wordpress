<style>
<?php if(isset($sfsPostFooter['footer']["open-icon-type"]) && $sfsPostFooter['footer']["open-icon-type"] == 'image'): ?>
	#sfs-footer-head .slideup-icon.open-icon,
	#sfs-footer-head .slideup-icon.open-icon img {
		width: <?php echo ($sfsPostFooter['footer']["open-icon-image-w"] != '') ? $sfsPostFooter['footer']["open-icon-image-w"].'px' : 'auto'; ?>!important;
		min-width: <?php echo ($sfsPostFooter['footer']["open-icon-image-w"] != '') ? $sfsPostFooter['footer']["open-icon-image-w"].'px' : 'auto'; ?>!important;

		height: <?php echo ($sfsPostFooter['footer']["open-icon-image-h"] != '') ? $sfsPostFooter['footer']["open-icon-image-h"].'px' : 'auto'; ?>!important;
	}
	#sfs-footer-head .slideup-icon.open-icon {
		padding: 15px;
	}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']["close-icon-type"]) && $sfsPostFooter['footer']["close-icon-type"] == 'image'): ?>
	#sfs-footer-head .slideup-icon.close-icon,
	#sfs-footer-head .slideup-icon.close-icon img {
		width: <?php echo ($sfsPostFooter['footer']["close-icon-image-w"] != '') ? $sfsPostFooter['footer']["close-icon-image-w"].'px' : 'auto'; ?>!important;
		min-width: <?php echo ($sfsPostFooter['footer']["close-icon-image-w"] != '') ? $sfsPostFooter['footer']["close-icon-image-w"].'px' : 'auto'; ?>!important;

		height: <?php echo ($sfsPostFooter['footer']["close-icon-image-h"] != '') ? $sfsPostFooter['footer']["close-icon-image-h"].'px' : 'auto'; ?>!important;
	}
	#sfs-footer-head .slideup-icon.close-icon {
		padding: 15px;
	}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']["bg-open-icon-color"])): ?>
	#sfs-footer-head .slideup-icon.open-icon {
		background-color: <?php echo $sfsPostFooter['footer']["bg-open-icon-color"] ?>;
	}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']["bg-close-icon-color"])): ?>
	#sfs-footer-head .slideup-icon.close-icon {
		background-color: <?php echo $sfsPostFooter['footer']["bg-close-icon-color"] ?>;
	}	
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']["open-icon-color"])): ?>
	#sfs-footer-head .slideup-icon.open-icon i  {
		color: <?php echo $sfsPostFooter['footer']["open-icon-color"] ?>;
	}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']["close-icon-color"])): ?>
	#sfs-footer-head .slideup-icon.close-icon i {
		color: <?php echo $sfsPostFooter['footer']["close-icon-color"] ?>;
	}	
<?php endif; ?>	
<?php if(isset($sfsPostFooter['footer']["open-text-color"])): ?>
	#sfs-footer-head .slideup-icon.open-icon span  {
		color: <?php echo $sfsPostFooter['footer']["open-text-color"] ?>;
	}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']["close-text-color"])): ?>
	#sfs-footer-head .slideup-icon.close-icon span {
		color: <?php echo $sfsPostFooter['footer']["close-text-color"] ?>;
	}	
<?php endif; ?>		
<?php if(isset($sfsPostFooter['footer']["transparency-alpha"])): ?>
	#sfs-footer-wrapper.bottom.w-transparency #sfs-footer-head {
		opacity: <?php echo $sfsPostFooter['footer']["transparency-alpha"]; ?>;
	}
<?php endif; ?>	

#sfs-footer-wrapper.bottom #sfs-footer-head .slideup-icon span {
	<?php if(isset($sfsPostFooter["footer"]["font-style"])): ?>
	font-style: <?php echo $sfsPostFooter["footer"]["font-style"] ?>;
<?php endif; ?>
<?php if(isset($sfsPostFooter["footer"]["font-size"])): ?>
	font-size: <?php echo $sfsPostFooter["footer"]["font-size"] ?>px;
<?php endif; ?>	
<?php if(isset($sfsPostFooter["footer"]["font-weight"])): ?>
	font-weight: <?php echo $sfsPostFooter["footer"]["font-weight"] ?>;
<?php endif; ?>		
<?php if(isset($sfsPostFooter["footer"]["line-height"])): ?>
	line-height: <?php echo $sfsPostFooter["footer"]["line-height"] ?>px;
<?php endif; ?>		
}

</style>
<div id="sfs-footer-head" data-border="<?php echo (isset($sfsPostFooter['footer']['divider-height'])) ? $sfsPostFooter['footer']['divider-height'] : 0 ?>" class="<?php echo SfsFrontend::getFooterHeadClasses($sfsPostFooter) ?>" style="<?php echo SfsFrontend::getFooterHeadStyle($sfsPostFooter); ?>">
	<div class="slideup-icon <?php echo SfsFrontend::getFooterIconClasses($sfsPostFooter, 'div', 'open') ?>" style="<?php echo SfsFrontend::getFooterIconStyle($sfsPostFooter, 'div', 'open'); ?>">
		<i style="<?php echo SfsFrontend::getFooterIconStyle($sfsPostFooter, 'i', 'open'); ?>" class="<?php echo SfsFrontend::getFooterIconClasses($sfsPostFooter, @$sfsPostFooter["footer"]["open-icon-type"], 'open') ?>">
			<?php if(@$sfsPostFooter["footer"]["open-icon-type"] == 'image'): ?>
			<img src="<?php echo SfsFrontend::getFooterIconClasses($sfsPostFooter, 'i', 'open') ?>" alt="">
			<?php endif; ?>
		</i>
		<?php SfsFrontend::getFooterIconText($sfsPostFooter, 'open') ?>			
	</div>
	<div class="slideup-icon <?php echo SfsFrontend::getFooterIconClasses($sfsPostFooter, 'div', 'close') ?>" style="<?php echo SfsFrontend::getFooterIconStyle($sfsPostFooter, 'div', 'close'); ?>">
		<i style="<?php echo SfsFrontend::getFooterIconStyle($sfsPostFooter, @$sfsPostFooter["footer"]["close-icon-type"], 'close'); ?>" class="<?php echo SfsFrontend::getFooterIconClasses($sfsPostFooter, @$sfsPostFooter["footer"]["close-icon-type"], 'close') ?>">
			<?php if(@$sfsPostFooter["footer"]["close-icon-type"] == 'image'): ?>
			<img src="<?php echo SfsFrontend::getFooterIconClasses($sfsPostFooter, 'i', 'close') ?>" alt="">
			<?php endif; ?>
		</i>
		<?php SfsFrontend::getFooterIconText($sfsPostFooter, 'close') ?>		
	</div>
</div>