<table class="form-table sfs-table sfs-table-full">
	<tbody>
		<tr>
			<th>
				<label data-hint="<?php echo __("You can define a background image selecting by media.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image"><?php echo __("Bakground Content Image", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div style="<?php echo (isset($sfsFooterSettings['content-background-image']) && $sfsFooterSettings['content-background-image'] !='') ? 'background-image: url('.$sfsFooterSettings['content-background-image'].')' : '' ?>" class="sfs-element-image <?php echo (isset($sfsFooterSettings['content-background-image']) && $sfsFooterSettings['content-background-image'] !='' ) ? 'w-image' : '' ?>">
					<i class="dashicons dashicons-format-image"></i>
					<input id="sfs-footer-banner-background-image" name="sfs[content-background-image]" value="<?php echo (isset($sfsFooterSettings['content-background-image'])) ? $sfsFooterSettings['content-background-image'] : '' ?>" type="hidden">					
				</div>
			</td>
		</tr>

		<tr>
			<th>
				<label data-hint="<?php echo __("Choose the size of your image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-size"><?php echo __("Bakground Content Image Size", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-background-image-size]" id="sfs-footer-banner-background-image-size"">
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='auto') ? 'selected' : '' ?>  value="auto">auto</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='cover') ? 'selected' : '' ?>  value="cover">cover</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='contain') ? 'selected' : '' ?>  value="contain">contain</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-size"]) && $sfsFooterSettings["content-background-image-size"]=='strech') ? 'selected' : '' ?>  value="strech">strech</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>
				<label data-hint="<?php echo __("Set the position for your image.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-position"><?php echo __("Background Content Image Position", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-background-image-position]" id="sfs-footer-banner-background-image-position"">
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='left top') ? 'selected' : '' ?> value="left top">left top</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='left center') ? 'selected' : '' ?> value="left center">left center</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='left bottom') ? 'selected' : '' ?> value="left bottom">left bottom</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='right top') ? 'selected' : '' ?> value="right top">right top</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='right center') ? 'selected' : '' ?> value="right center">right center</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='right bottom') ? 'selected' : '' ?> value="right bottom">right bottom</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='center top') ? 'selected' : '' ?> value="center top">center top</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='center center') ? 'selected' : '' ?> value="center center">center center</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-position"]) && $sfsFooterSettings["content-background-image-position"]=='center bottom') ? 'selected' : '' ?> value="center bottom">center bottom</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("Set the position for your image on mobile devices.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-position"><?php echo __("Background Mobile Content Image Position", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-mobile-background-image-position]" id="sfs-footer-banner-background-image-position"">
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='left top') ? 'selected' : '' ?> value="left top">left top</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='left center') ? 'selected' : '' ?> value="left center">left center</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='left bottom') ? 'selected' : '' ?> value="left bottom">left bottom</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='right top') ? 'selected' : '' ?> value="right top">right top</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='right center') ? 'selected' : '' ?> value="right center">right center</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='right bottom') ? 'selected' : '' ?> value="right bottom">right bottom</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='center top') ? 'selected' : '' ?> value="center top">center top</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='center center') ? 'selected' : '' ?> value="center center">center center</option>
					<option <?php echo (isset($sfsFooterSettings["content-mobile-background-image-position"]) && $sfsFooterSettings["content-mobile-background-image-position"]=='center bottom') ? 'selected' : '' ?> value="center bottom">center bottom</option>
				</select>
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("If your image is too small you can use the repeat option to replicate it.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image-repeat"><?php echo __("Background Content Image Repeat", 'smart-footer-system') ?></label>
			</th>
			<td>
				<select name="sfs[content-background-image-repeat]" id="sfs-footer-banner-background-image-repeat"">
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='no-repeat') ? 'selected' : '' ?> value="no-repeat">no-repeat</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='repeat') ? 'selected' : '' ?> value="repeat">repeat</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='repeat-x') ? 'selected' : '' ?> value="repeat-x">repeat-x</option>
					<option <?php echo (isset($sfsFooterSettings["content-background-image-repeat"]) && $sfsFooterSettings["content-background-image-repeat"]=='repeat-y') ? 'selected' : '' ?> value="repeat-y">repeat-y</option>
				</select>
			</td>
		</tr>

		<tr>
			<th>
				<label data-hint="<?php echo __("Use this option to set a custom background color of the main content. Default value is transparent.", "smart-footer-system"); ?>" for="sfs-footer-banner-background-color"><?php echo __("Background Content Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-background-color" name="sfs[content-background-color]" class="sfs-color-picker" value="<?php echo (isset($sfsFooterSettings["content-background-color"]) && $sfsFooterSettings["content-background-color"] !='') ? $sfsFooterSettings["content-background-color"] : '' ?>" type="text">
			</td>
		</tr>
		<tr>
			<th>
				<label data-hint="<?php echo __("You can also set a custom overlay color from this option.", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Background Content Overlay Color", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input id="sfs-footer-banner-overlay-color" name="sfs[content-overlay-color]" class="sfs-color-picker" value="<?php echo (isset($sfsFooterSettings["content-overlay-color"]) && $sfsFooterSettings["content-overlay-color"] !='') ? $sfsFooterSettings["content-overlay-color"] : '' ?>" type="text">
			</td>
		</tr>
		<tr class="sfs-background-video-selector">
			<th>
				<label data-hint="<?php echo __("Upload a video or paste a link of a video on YouTube or Vimeo", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Background video", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div class="background-video-nav">
					<a title="none" data-video-type="none" href="javascript:;" ><i class="fa fa-ban"></i></a>
					<a title="Self hosted" data-video-type="self" href="javascript:;"><i class="fa fa-video-camera"></i></a>
					<a title="YouTube" data-video-type="youtube" href="javascript:;"><i class="fa fa-youtube"></i>
					</a>
					<a title="Vimeo" data-video-type="vimeo" href="javascript:;"><i class="fa fa-vimeo"></i>
					</a>
					<input class="background-video-type-value" type="hidden" value="<?php echo (isset($sfsFooterSettings["background-video-type"]) && $sfsFooterSettings["background-video-type"] !='') ? $sfsFooterSettings["background-video-type"] : 'none' ?>" name="sfs[background-video-type]">
				</div>				
			</td>
		</tr>	

		<tr class="tr-child sfs-background-video-type-form" data-video-type="self">
			<th>
				<label data-hint="<?php echo __("This image will be showed up until video is loaded. If video is not supported or could not load on user's machine, the image will stay in background", "smart-footer-system"); ?>" for="sfs-footer-banner-background-image"><?php echo __("Bakground Video Preview Image (Fallback Image)", 'smart-footer-system') ?></label>
			</th>
			<td>
				<div style="<?php echo (isset($sfsFooterSettings['background-video-self-image']) && $sfsFooterSettings['background-video-self-image'] !='') ? 'background-image: url('.$sfsFooterSettings['background-video-self-image'].')' : '' ?>" class="sfs-element-image <?php echo (isset($sfsFooterSettings['background-video-self-image']) && $sfsFooterSettings['background-video-self-image'] !='' ) ? 'w-image' : '' ?>">
					<i class="dashicons dashicons-format-image"></i>
					<input id="sfs-footer-banner-background-image" name="sfs[background-video-self-image]" value="<?php echo (isset($sfsFooterSettings['background-video-self-image'])) ? $sfsFooterSettings['background-video-self-image'] : '' ?>" type="hidden">					
				</div>
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="self">
			<th>
				<label data-hint="<?php echo __("Enter the url of your video with .MP4 extension. (Compatibility for Safari and IE9)", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Background video (.MP4)", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-self-mp4]" value="<?php echo (isset($sfsFooterSettings["background-video-self-mp4"]) && $sfsFooterSettings["background-video-self-mp4"] !='') ? $sfsFooterSettings["background-video-self-mp4"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="self">
			<th>
				<label data-hint="<?php echo __("Enter the url of your video with .WebM extension. (Compatibility for Firefox4, Opera and Chrome)", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Background video (.WebM)", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-self-webm]" value="<?php echo (isset($sfsFooterSettings["background-video-self-webm"]) && $sfsFooterSettings["background-video-self-webm"] !='') ? $sfsFooterSettings["background-video-self-webm"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="self">
			<th>
				<label data-hint="<?php echo __("Enter the url of your video with .OGV extension. (Compatibility for older Firefox and Opera versions)", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Background video (.OGV)", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-self-ogv]" value="<?php echo (isset($sfsFooterSettings["background-video-self-ogv"]) && $sfsFooterSettings["background-video-self-ogv"] !='') ? $sfsFooterSettings["background-video-self-ogv"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="youtube">
			<th>
				<label data-hint="<?php echo __("Enter the url of your YouTube video", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("YouTube URL", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-youtube]" value="<?php echo (isset($sfsFooterSettings["background-video-youtube"]) && $sfsFooterSettings["background-video-youtube"] !='') ? $sfsFooterSettings["background-video-youtube"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="youtube">
			<th>
				<label data-hint="<?php echo __("Enter the start time seconds. Example: 35", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("YouTube Start Time", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-youtube-start]" value="<?php echo (isset($sfsFooterSettings["background-video-youtube-start"]) && $sfsFooterSettings["background-video-youtube-start"] !='') ? $sfsFooterSettings["background-video-youtube-start"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="youtube">
			<th>
				<label data-hint="<?php echo __("Enter the end time seconds. Example: 35", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("YouTube End Time", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-youtube-end]" value="<?php echo (isset($sfsFooterSettings["background-video-youtube-end"]) && $sfsFooterSettings["background-video-youtube-end"] !='') ? $sfsFooterSettings["background-video-youtube-end"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="vimeo">
			<th>
				<label data-hint="<?php echo __("Enter the url of your Vimeo video", "smart-footer-system"); ?>" for="sfs-footer-banner-overlay-color"><?php echo __("Vimeo URL", 'smart-footer-system') ?></label>
			</th>
			<td>
				<input class="regular-text regular-text sfs-element-text" style="width:100%" name="sfs[background-video-vimeo]" value="<?php echo (isset($sfsFooterSettings["background-video-vimeo"]) && $sfsFooterSettings["background-video-vimeo"] !='') ? $sfsFooterSettings["background-video-vimeo"] : '' ?>">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="self-youtube-vimeo">
			<th>
				<label data-hint="<?php echo __("Activate it if you want the video restart at the end"); ?>" for="sfs-banner-hide-on-desktop"><?php echo __("Video Loop", "smart-footer-system") ?></label>
			</th>
			<td>
				<input <?php echo (isset($sfsFooterSettings['background-video-loop']) && $sfsFooterSettings['background-video-loop'] == 1) ? 'checked' : '' ?> data-type="auto-check" name="sfs[background-video-loop]" type="checkbox" value="1">
			</td>
		</tr>
		<tr class="tr-child sfs-background-video-type-form" data-video-type="youtube-vimeo-self">
			<th>
				<label data-hint="<?php echo __("You can turn on/off the sound of the video for streaming videos"); ?>" for="sfs-banner-hide-on-desktop"><?php echo __("Video Sound", "smart-footer-system") ?></label>
			</th>
			<td>
				<input <?php echo (isset($sfsFooterSettings['background-video-sound']) && $sfsFooterSettings['background-video-sound'] == 1) ? 'checked' : '' ?> data-type="auto-check" name="sfs[background-video-sound]" type="checkbox" value="1">
			</td>
		</tr>
	</tbody>
</table>