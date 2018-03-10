<table class="form-table sfs-table sfs-spread-open-settings">
	<tbody>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon/image (optional).", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<?php SfsBackend::displayIconMarkup(@$sfsFooterSettings, 'spread', 'open-icon'); ?>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the background color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Background color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[spread][bg-open-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['spread']['bg-open-icon-color'])) ? $sfsFooterSettings['spread']['bg-open-icon-color'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th></th>
			<td>
				<button id="sfs-spread-copy-to-close-button" type="button" class="button button-large"><?php echo __("Copy to close", "smart-footer-system"); ?></button>
			</td>
		</tr>	
	</tbody>
</table>