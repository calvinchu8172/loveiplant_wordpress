<nav>
	<ul>
		<li>
			<a data-target="spread-style" href="javascript:;"><?php echo __("Style", "smart-footer-system") ?></a>
		</li>
	</ul>
</nav>
<div data-target="spread-style" class="sfs-footer-sub" id="sfs-footer-general-settings">
	<div class="table-tabs">
		<a data-tabtarget="spread-settings" href="javascript:;"><?php echo __("Settings", "smart-footer-system") ?></a>	
		<a data-tabtarget="spread-open" href="javascript:;"><?php echo __("Open", "smart-footer-system") ?></a>
		<a data-tabtarget="spread-close" href="javascript:;"><?php echo __("Close", "smart-footer-system") ?></a>
		<!-- <a data-tabtarget="spread-animation" href="javascript:;"><?php echo __("Animation", "smart-footer-system") ?></a> !-->
	</div>
	<div class="tab-targets">
		<div class="tab-target" data-tabtarget="spread-settings">
		<?php include_once(SFS_PATH.'inc/backend/spread/settings.php'); ?>
		</div>	
		<div class="tab-target" data-tabtarget="spread-open">
		<?php include_once(SFS_PATH.'inc/backend/spread/open.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="spread-close">
		<?php include_once(SFS_PATH.'inc/backend/spread/close.php'); ?>
		</div>
		<div class="tab-target" data-tabtarget="spread-animation">
		<?php include_once(SFS_PATH.'inc/backend/spread/animation.php'); ?>
		</div>
	</div>
</div>