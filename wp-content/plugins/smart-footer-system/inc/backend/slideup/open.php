<table class="form-table sfs-table sfs-slideup-open-settings">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("Insert a text message to show on the handle (optional).", "smart-footer-system"); ?>" for=""><?php echo __("Text", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text" name="sfs[open-text]" type="text" value="<?php echo (isset($sfsFooterSettings['open-text'])) ? $sfsFooterSettings['open-text'] : '' ?>">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose an icon/image (optional).", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<?php SfsBackend::displayIconMarkup(@$sfsFooterSettings, 'open-icon'); ?>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the background color of the handle.", "smart-footer-system"); ?>" for=""><?php echo __("Background color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[bg-open-icon-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['bg-open-icon-color'])) ? $sfsFooterSettings['bg-open-icon-color'] : '' ?>">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose a color for your text.", "smart-footer-system"); ?>" for=""><?php echo __("Text color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input name="sfs[open-text-color]" class="sfs-color-picker" type="text" value="<?php echo (isset($sfsFooterSettings['open-text-color'])) ? $sfsFooterSettings['open-text-color'] : '' ?>">
			</td>
		</tr>		
		<tr>
			<th></th>
			<td>
				<button id="sfs-slideup-copy-to-close-button" type="button" class="button button-large"><?php echo __("Copy to close", "smart-footer-system"); ?></button>
			</td>
		</tr>	
	</tbody>
</table>