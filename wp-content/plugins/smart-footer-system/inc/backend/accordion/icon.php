<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define an icon to show on your handle footer in order to open your footer content.", "smart-footer-system"); ?>" for=""><?php echo __("Open Icon", 'smart-footer-system') ?></label>
			</th>
			<td>
				<?php SfsBackend::displayIconMarkup(@$sfsFooterSettings, 'accordion', 'open-icon'); ?>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Define an icon to show on your handle footer in order to close your footer content.", "smart-footer-system"); ?>" for=""><?php echo __("Close Icon", 'smart-footer-system') ?></label>
			</th>
			<td>
				<?php SfsBackend::displayIconMarkup(@$sfsFooterSettings, 'accordion', 'close-icon'); ?>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set a color for your icon.", "smart-footer-system"); ?>" for=""><?php echo __("Icon Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[accordion][icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['accordion']['icon-color'])) ? $sfsFooterSettings['accordion']['icon-color'] : '' ?>">
			</td>
		</tr>
	</tbody>
</table>