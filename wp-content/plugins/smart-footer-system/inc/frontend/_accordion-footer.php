<style>
	#sfs-footer-wrapper.accordion .handle-wrapper::before
	<?php if(isset($sfsPostFooter['footer']["background-video-type"]) && $sfsPostFooter['footer']["background-video-type"] == 'none'): ?>, #sfs-footer-wrapper.accordion .sfs-footer-content > div <?php endif; ?> {
		background-color: <?php echo $sfsPostFooter["footer"]["content-background-color"] ?>;
	}
	#sfs-footer-wrapper.accordion .handle-wrapper span {
		<?php if(isset($sfsPostFooter["footer"]['accordion']["text-color"])): ?>
		color: <?php echo $sfsPostFooter["footer"]['accordion']["text-color"] ?>;
		<?php endif; ?>
		<?php if(isset($sfsPostFooter["footer"]['accordion']["font-style"])): ?>
		font-style: <?php echo $sfsPostFooter["footer"]['accordion']["font-style"] ?>;
		<?php endif; ?>
		<?php if(isset($sfsPostFooter["footer"]['accordion']["font-size"])): ?>
		font-size: <?php echo $sfsPostFooter["footer"]['accordion']["font-size"] ?>px;
		<?php endif; ?>	
		<?php if(isset($sfsPostFooter["footer"]['accordion']["font-weight"])): ?>
		font-weight: <?php echo $sfsPostFooter["footer"]['accordion']["font-weight"] ?>;
		<?php endif; ?>		
		<?php if(isset($sfsPostFooter["footer"]['accordion']["line-height"])): ?>
		line-height: <?php echo $sfsPostFooter["footer"]['accordion']["line-height"] ?>px;
		<?php endif; ?>		
	}	
	<?php if( 
		(!isset($sfsPostFooter["footer"]['accordion']["left-text"]) || $sfsPostFooter["footer"]['accordion']["left-text"] == '') 
		&& (!isset($sfsPostFooter["footer"]['accordion']["right-text"]) || $sfsPostFooter["footer"]['accordion']["right-text"] == '') 
		): ?>
	#sfs-footer-wrapper.accordion .handle-wrapper {
		justify-content: center!important;
		-webkit-box-align: center!important;
		-webkit-box-pack: center!important;
	}
	<?php endif; ?>
</style>
<div class="handle-wrapper">
	<?php if(isset($sfsPostFooter["footer"]['accordion']["left-text"]) && $sfsPostFooter["footer"]['accordion']["left-text"] != ''): ?>
	<span class="accordion-left-area"><?php echo $sfsPostFooter["footer"]['accordion']["left-text"] ?></span>
	<?php endif; ?>
	<i style="<?php echo SfsFrontend::getAccordionFooterIconStyles($sfsPostFooter, 'i', 'open'); ?>" class="<?php echo SfsFrontend::getAccordionFooterIconClasses($sfsPostFooter, 'i', 'open'); ?>">
		<?php if(@$sfsPostFooter["footer"]["accordion"]["open-icon-type"] == 'image'): ?>
			<img style="<?php echo SfsFrontend::getAccordionFooterIconStyles($sfsPostFooter, 'image', 'open'); ?>" src="<?php echo SfsFrontend::getAccordionFooterIconClasses($sfsPostFooter, 'image', 'open') ?>" alt="">
			<?php endif; ?>
	</i>
	<i style="<?php echo SfsFrontend::getAccordionFooterIconStyles($sfsPostFooter, 'i', 'close'); ?>" class="<?php echo SfsFrontend::getAccordionFooterIconClasses($sfsPostFooter, 'i', 'close'); ?>">
		<?php if(@$sfsPostFooter["footer"]["accordion"]["close-icon-type"] == 'image'): ?>
			<img style="<?php echo SfsFrontend::getAccordionFooterIconStyles($sfsPostFooter, 'image', 'close'); ?>" src="<?php echo SfsFrontend::getAccordionFooterIconClasses($sfsPostFooter, 'image', 'close') ?>" alt="">
			<?php endif; ?>
	</i>
	<?php if(isset($sfsPostFooter["footer"]['accordion']["right-text"]) && $sfsPostFooter["footer"]['accordion']["right-text"] != ''): ?>
	<span class="accordion-right-area"><?php echo $sfsPostFooter["footer"]['accordion']["right-text"] ?></span>
	<?php endif; ?>
</div>