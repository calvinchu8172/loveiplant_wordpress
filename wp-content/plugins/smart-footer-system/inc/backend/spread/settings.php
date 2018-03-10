<table class="form-table sfs-table sfs-spread-animation-settings">
	<tbody>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose the icon position.", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon position", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[spread][icon-position]" id="sfs-footer-icon-shape-select">
					<option data-hide-on="" <?php echo (isset($sfsFooterSettings['spread']['icon-position']) && $sfsFooterSettings['spread']['icon-position'] == 'left') ? 'selected' : '' ?> value="left"><?php echo __("Left", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['spread']['icon-position']) && $sfsFooterSettings['spread']['icon-position'] == 'center') ? 'selected' : '' ?> value="center"><?php echo __("Center", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['spread']['icon-position']) && $sfsFooterSettings['spread']['icon-position'] == 'right') ? 'selected' : '' ?> value="right"><?php echo __("Right", 'smart-footer-system') ?></option>				
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Choose icon shape.", "smart-footer-system"); ?>" for="sfs-footer-type-select">
					<?php echo __("Icon shape", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<select name="sfs[spread][icon-shape]" id="sfs-footer-icon-shape-select">
					<option data-hide-on="" <?php echo (isset($sfsFooterSettings['spread']['icon-shape']) && $sfsFooterSettings['spread']['icon-shape'] == 'squared') ? 'selected' : '' ?> value="squared"><?php echo __("Squared", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['spread']['icon-shape']) && $sfsFooterSettings['spread']['icon-shape'] == 'rounded') ? 'selected' : '' ?> value="rounded"><?php echo __("Rounded", 'smart-footer-system') ?></option>
					<option <?php echo (isset($sfsFooterSettings['spread']['icon-shape']) && $sfsFooterSettings['spread']['icon-shape'] == 'circle') ? 'selected' : '' ?> value="circle"><?php echo __("Circle", 'smart-footer-system') ?></option>				
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set it if you want a shadow on the icon.", "smart-footer-system"); ?>" for="sfs-shadow-footer-check"><?php echo __("Icon shadow", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input <?php echo ( isset($sfsFooterSettings['spread']['shadow']) && $sfsFooterSettings['spread']['shadow']) ? 'checked': '' ?> id="sfs-shadow-footer-check" name="sfs[spread][shadow]" type="checkbox" class="regular-text">
			</td>
		</tr>	
		<tr>
			<th>
				<label data-hint="<?php echo __("If you switch on this option the handle footer hide on scroll top and show on scroll down", "smart-footer-system"); ?>" for="sfs-open-on-bottom-footer-check"><?php echo __("Show/Hide on mouse scroll event", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input <?php echo ( isset($sfsFooterSettings['spread']['mouse-scroll-event']) && $sfsFooterSettings['spread']['mouse-scroll-event']) ? 'checked': '' ?> id="sfs-spread-mouse-scroll-event-footer-check" name="sfs[spread][mouse-scroll-event]" type="checkbox" class="regular-text">
			</td>
		</tr>
	</tbody>
</table>