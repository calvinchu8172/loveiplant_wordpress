<table class="form-table sfs-table sfs-spread-animation-settings">
	<tbody>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose animation type", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Animation type", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[spread][animation-type]" id="sfs-footer-spread-animation-type-select">
					<option <?php echo (isset($sfsFooterSettings['spread']['animation-type']) && $sfsFooterSettings['spread']['animation-type'] == 'spread') ? 'selected' : '' ?> value="spread"><?php echo __("Spread", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['spread']['animation-type']) && $sfsFooterSettings['spread']['animation-type'] == 'zig-zag') ? 'selected' : '' ?> value="zig-zag"><?php echo __("Zig-Zag", 'smart-footer-system') ?></option>
				</select>
			</td>
		</tr>		
	</tbody>
</table>