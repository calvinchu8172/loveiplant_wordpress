<table class="form-table sfs-table sfs-spread-close-settings">
	<tbody>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon/image (optional).", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<?php SfsBackend::displayIconMarkup(@$sfsFooterSettings, 'spread', 'close-icon'); ?>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the background color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Background color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[spread][bg-close-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['spread']['bg-close-icon-color'])) ? $sfsFooterSettings['spread']['bg-close-icon-color'] : '' ?>">
			</td>
		</tr>	
	</tbody>
</table>