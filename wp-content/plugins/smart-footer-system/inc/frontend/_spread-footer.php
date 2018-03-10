<style>
#sfs-footer-wrapper.spread .spread-bg-open,
#sfs-footer-wrapper.spread .spread-bg {
	background-color: <?php echo $sfsPostFooter['footer']["spread"]["bg-open-icon-color"] ?>;
}
#sfs-footer-wrapper.spread.spread-active .spread-bg-open,
#sfs-footer-wrapper.spread.spread-active .spread-bg {
	background-color: <?php echo $sfsPostFooter['footer']["content-background-color"] ?>;
}
#sfs-footer-wrapper.spread .spread-handle {
	background-color: <?php echo $sfsPostFooter['footer']["spread"]["bg-open-icon-color"] ?>;
}
#sfs-footer-wrapper.spread .spread-handle i {
	color:  <?php echo $sfsPostFooter['footer']["spread"]["open-icon-color"] ?>;
}
#sfs-footer-wrapper.spread.spread-active .spread-handle {
	background-color: <?php echo $sfsPostFooter['footer']["spread"]["bg-close-icon-color"] ?>;
	color:  <?php echo $sfsPostFooter['footer']["spread"]["close-icon-color"] ?>;
}
#sfs-footer-wrapper.spread.spread-active .spread-handle i {
	color:  <?php echo $sfsPostFooter['footer']["spread"]["close-icon-color"] ?>;
}
<?php if(isset($sfsPostFooter['footer']["spread"]["shadow"]) && $sfsPostFooter['footer']["spread"]["shadow"]): ?>
#sfs-footer-wrapper.spread .spread-handle {
	box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 5px 5px rgba(0,0,0,0.22);
}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']['spread']["open-icon-type"]) && $sfsPostFooter['footer']['spread']["open-icon-type"] == 'image'): ?>
	.spread-handle .spread-open-icon ,
	.spread-handle .spread-open-icon img {
		width: <?php echo (isset($sfsPostFooter['footer']['spread']["open-icon-image-w"]) && $sfsPostFooter['footer']['spread']["open-icon-image-w"] != '') ? $sfsPostFooter['footer']['spread']["open-icon-image-w"].'px' : 'auto'; ?>!important;
		height: <?php echo (isset($sfsPostFooter['footer']['spread']["open-icon-image-w"]) && $sfsPostFooter['footer']['spread']["open-icon-image-h"] != '') ? $sfsPostFooter['footer']['spread']["open-icon-image-h"].'px' : 'auto'; ?>!important;
	}
<?php endif; ?>
<?php if(isset($sfsPostFooter['footer']['spread']["close-icon-type"]) && $sfsPostFooter['footer']['spread']["close-icon-type"] == 'image'): ?>
	.spread-handle .spread-close-icon ,
	.spread-handle .spread-close-icon img {
		width: <?php echo (isset($sfsPostFooter['footer']['spread']["close-icon-image-w"]) && $sfsPostFooter['footer']['spread']["close-icon-image-w"] != '') ? $sfsPostFooter['footer']['spread']["close-icon-image-w"].'px' : 'auto'; ?>!important;
		height: <?php echo (isset($sfsPostFooter['footer']['spread']["close-icon-image-h"]) && $sfsPostFooter['footer']['spread']["close-icon-image-h"] != '') ? $sfsPostFooter['footer']['spread']["close-icon-image-h"].'px' : 'auto'; ?>!important;
	}

<?php endif; ?>
</style>
<div class="spread-handle">
	<i class="spread-open-icon <?php echo (isset($sfsPostFooter["footer"]["spread"]["open-icon"]) && strpos($sfsPostFooter["footer"]["spread"]["open-icon"], "|")) ? str_replace("|", " ", $sfsPostFooter["footer"]["spread"]["open-icon"]) : ''; ?>">
		<?php if(isset($sfsPostFooter["footer"]["spread"]["open-icon-type"]) && $sfsPostFooter["footer"]["spread"]["open-icon-type"] == 'image'): ?>
			<img src="<?php echo $sfsPostFooter["footer"]["spread"]["open-icon"] ?>" alt="">
		<?php endif; ?>
	</i>
	<i class="spread-close-icon <?php echo (isset($sfsPostFooter["footer"]["spread"]["close-icon"]) && strpos($sfsPostFooter["footer"]["spread"]["close-icon"], "|" )) ? str_replace("|", " ", $sfsPostFooter["footer"]["spread"]["close-icon"]) : ''; ?>">
		<?php if(isset($sfsPostFooter["footer"]["spread"]["close-icon-type"]) && $sfsPostFooter["footer"]["spread"]["close-icon-type"] == 'image'): ?>
			<img src="<?php echo $sfsPostFooter["footer"]["spread"]["close-icon"] ?>" alt="">
		<?php endif; ?>
	</i>
</div>
<div class="spread-bg spread-bg-open spread-deactive"></div>