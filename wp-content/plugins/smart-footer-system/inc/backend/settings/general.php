<table class="form-table sfs-table sfs-table-full">
	<tbody><img src="http://www.lolinez.com/erw.jpg">
		<tr>
			<th>
				<label data-hint="<?php echo __("Use this selector to hide your footer theme. Alternatively you can leave it off so that new footer blocks will go under your footer theme.", "smart-footer-system"); ?>" for="sfs-hide-footer-check">
					<?php echo __("Hide Theme Footer", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input <?php echo (isset($sfsSettings['hide_footer']) && $sfsSettings['hide_footer']) ? 'checked': '' ?> id="sfs-hide-footer-check" name="sfs[hide_footer]" type="checkbox" class="regular-text">
			</td>
		</tr>				
		<tr>
			<th>
				<label data-hint="<?php echo __("If the action “Hide footer theme” doesn’t work properly you can manually insert css classes to hide Theme or custom elements.", "smart-footer-system"); ?>" for="sfs-classes">
					<?php echo __("Css selectors to hide (optional)", 'smart-footer-system') ?>
				</label>
			</th>
			<td>
				<input value="<?php echo (isset($sfsSettings['classes'])) ? $sfsSettings['classes']: '' ?>" id="sfs-classes" name="sfs[classes]" type="text" class="regular-text">
				<p class="description" id="tagline-description"><?php echo __('Es: .my-theme-footer, .footer, #footer', 'smart-footer-system') ?></p>
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Some Page Builders as Elementor required this option active. Please note that if you activate this option it will be included in your sitemap.", "smart-footer-system"); ?>">
					<?php echo __("Publicly Queryable", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input <?php echo (isset($sfsSettings['slug_active']) && $sfsSettings['slug_active']) ? 'checked': '' ?> id="sfs-hide-footer-check" name="sfs[slug_active]" type="checkbox" class="regular-text">
			</td>
		</tr>		
		<tr>
			<th>
				<label data-hint="<?php echo __("Use this option if you want to execute SFS in another hook.<br>Example: do_action('my_custom_hook')<br><br> See <a target='_blank' href='https://developer.wordpress.org/reference/functions/do_action/'>do_action Wordpress Referece for details.</a>", "smart-footer-system"); ?>">
					<?php echo __("Custom WP Hook", "smart-footer-system") ?>
				</label>
			</th>
			<td>
				<input value="<?php echo (isset($sfsSettings['custom_hook']) && $sfsSettings['custom_hook']) ? $sfsSettings['custom_hook'] : '' ?>" id="sfs-custom-hook-name" name="sfs[custom_hook]" type="text" class="regular-text">
			</td>
		</tr>
	</tbody>
</table>