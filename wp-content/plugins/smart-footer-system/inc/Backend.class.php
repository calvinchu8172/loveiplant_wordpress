<?php
/**
* Smart Footer System - Backend Class
*/
class SfsBackend {
	/**
	 * Initializate the class
	 * @return null
	 */
	public static function init() {
		if(!is_admin()) return;
		add_action("admin_menu", function(){
			self::registerAdminPage();
		});		
		add_action("admin_init", function(){
			if(isset($_REQUEST['page']) && $_REQUEST['page'] != 'smart-footer-system') return;
			self::save();
		});

		add_action("admin_enqueue_scripts", function(){
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script('jquery-ui-slider');	
			wp_enqueue_style('alpha-color-picker', SFS_URL.'vendor/alpha-color-picker/alpha-color-picker.css');
			wp_enqueue_script('alpha-color-picker', SFS_URL.'vendor/alpha-color-picker/alpha-color-picker.js', ['jquery', 'wp-color-picker']);	
			wp_enqueue_style('smart-footer-system-admin', SFS_URL.'dist/css/sfs.backend.css', null, SFS_VERSION );
			wp_enqueue_script('smart-footer-system-admin', SFS_URL.'dist/js/sfs.backend.js', ['jquery', 'jquery-ui-slider'], SFS_VERSION );

			wp_localize_script( 'smart-footer-system-admin', 'sfs', [
				'ajaxurl' => get_admin_url().'admin-ajax.php',
				'adminurl' => get_admin_url()
				]);

			global $post;
			if(isset($post) && $post->post_type != 'sfs-footer' || (isset($_GET['post_type'] ) && $_GET['post_type'] != 'sfs-footer')) return;
			
			wp_enqueue_style( 'wp-color-picker' );

			$font2 = SFS_URL. 'vendor/icon-picker/fonts/font-awesome/css/font-awesome.css';
			wp_enqueue_style( 'font-awesome', $font2,'','');

			$font3 = SFS_URL. 'vendor/icon-picker/fonts/genericons/genericons.css';
			wp_enqueue_style( 'genericons', $font3, '', '');

			$font4 = SFS_URL. 'vendor/icon-picker/fonts/eleganticons/eleganticons.css';
			wp_enqueue_style( 'elegant-icons', $font4, '', '');

			$css = SFS_URL. 'vendor/icon-picker/css/icon-picker.css';
			wp_enqueue_style( 'dashicons-picker', $css, array( 'dashicons' ), '1.0' );

			$js = SFS_URL. 'vendor/icon-picker/js/icon-picker.js';
			wp_enqueue_script( 'dashicons-picker', $js, array( 'jquery' ), '1.0' );
		});

		add_action( 'wp_ajax_sfs-import', function(){
			global $wpdb;
			$backup = base64_decode(sanitize_text_field($_POST['backup']));
			$backup = unserialize($backup);
			if(empty($backup)) {
				echo json_encode([
					"errors" 		=> 0,
					"errorsText"	=> [],
					"imported" 		=> 0,
					"empty"			=> true
					]);
				die();
				return;
			}
			$imported = 0;
			$errors   = [];
			foreach($backup as $sfsPost) {
				if(empty($sfsPost['meta']))	{
					continue;
				}				
				$returnInsertId = wp_insert_post([
					"post_title" 	=> $sfsPost['post_title'],
					"post_content"	=> $sfsPost['post_content'],
					"post_status"	=> 'publish',
					"post_type"	 	=> 'sfs-footer'
					], $wp_error );
				if(!$returnInsertId) {
					$errors[] =  $sfsPost["post_title"].": ".__("Cannot insert post", 'smart-footer-system');
					continue;
				}
				foreach($sfsPost["meta"] as $key => $sfsPostMeta){
					$metaValue = "";
					if(isset($sfsPostMeta[0])) {
						$metaValue = $sfsPostMeta[0];
					}
					else {
						$errors[] = $sfsPost["post_title"].": ". __("Post haven't meta", 'smart-footer-system');
						continue;
					}
					$unserializeData = @unserialize($metaValue);
					if($serializeData !== false) {
						$metaValue = $unserializeData;
					}
					add_post_meta($returnInsertId, $key, $metaValue);
				}
				$imported++;
			}
			echo json_encode([
				"errors" 		=> count($errors),
				"errorsText"	=> $errors,
				"imported" 		=> $imported,
				"empty"			=> false
				]);
			die();
			return;
		});

		add_action( 'wp_ajax_sfs-duplicate-footer', function(){
			if(wp_verify_nonce($_POST['nonce'], 'sfs-duplicate-footer')) {
				$sfsFooter = get_post($_POST['id']);
				$sfsFooterMeta = get_post_meta($sfsFooter->ID);
				$returnInsertId = wp_insert_post([
					"post_title" 	=> $sfsFooter->post_title.' copy',
					"post_content"	=> $sfsFooter->post_content,
					"post_status"	=> 'publish',
					"post_type"	 	=> 'sfs-footer'
					]);
				
				foreach($sfsFooterMeta as $key => $sfsPostMeta){
					$metaValue = "";
					if(isset($sfsPostMeta[0])) {
						$metaValue = $sfsPostMeta[0];
					}
					$unserializeData = @unserialize($metaValue);
					if(@$unserializeData !== false) {
						$metaValue = $unserializeData;
					}
					add_post_meta($returnInsertId, $key, $metaValue);
				}
				
				echo json_encode(['state' => 'ok', 'lastid' => $returnInsertId]);

			}
			die();
			return;
		});
		add_filter('post_row_actions', function($actions){
			$post = get_post();
			if($post->post_type == 'sfs-footer')  {
				$actions['sfs-duplicate'] = '<a data-type="list" data-nonce="'.wp_create_nonce('sfs-duplicate-footer').'" data-id="'.$post->ID.'" class="sfs-duplicate-footer" href="javascript:;">'.__("Duplicate Footer", 'smart-footer-system').'</a>';
			}
			return $actions;

		});		
		self::themeCompatibility();
	}
	/**
	 * Register admin page
	 * @return null
	 */
	public static function registerAdminPage() {
		add_submenu_page('edit.php?post_type=sfs-footer', __("Settings", 'smart-footer-system'), __("Settings", 'smart-footer-system'), 'manage_options', 'smart-footer-system', function(){	
			ob_start();
			require_once(SFS_PATH.'inc/backend/admin-page.php');
			echo ob_get_clean();
		});
	}
	/**
	 * Save settings
	 * @return null
	 */
	protected static function save() {
		if(isset($_REQUEST['_wpnonce']) && wp_verify_nonce($_REQUEST['_wpnonce'], 'sfs-save-settings')){
			SfsSettings::set($_POST['sfs']);
			add_action( 'admin_notices',  function(){
				?>
				<div class="notice notice-success is-dismissible">
					<p><?php echo __( 'Settings updated!', 'smart-footer-system' ); ?></p>
				</div>
				<?php
			});
		}
		
	}
	/**
	 * Check for theme compatibility
	 * @return null
	 */
	public static function themeCompatibility() {
		add_filter('avf_builder_boxes', function ($metabox) {
			foreach($metabox as &$meta) {
				if($meta['id'] == 'avia_builder' || $meta['id'] == 'layout') {
					$meta['page'][] = 'sfs-footer'; 
				}
			}

			return $metabox;
		});
	}

	/**
	 * Display icon font or image form markup html
	 * @param  array $sfsFooterSettings  footer settings
	 * @return form markup html
	 */
	public static function displayIconMarkup($sfsFooterSettings = []) {
		$funcArray        = func_get_args();
		$systemFieldName  = end($funcArray);
		$inputField       = "sfs";
		$postArray 		  = $sfsFooterSettings;
		$sub = false;
		$displayColor = true;
		$notDisplayColorArray = array('banner', 'accordion');
		for($i = 1; $i<count($funcArray)-1; $i++) {
			$sub = true;
			$inputField .= "[".$funcArray[$i]."]";
			$postArray = @$postArray[$funcArray[$i]];
			if(in_array($funcArray[$i], $notDisplayColorArray)) {
				$displayColor = false;
			}
		}
		$fieldNameIconType 	= $inputField."[".$systemFieldName.'-type]';
		$fieldNameIconColor = $inputField."[".$systemFieldName.'-color]';
		$fieldNameImageW 	= $inputField."[".$systemFieldName.'-image-w]';
		$fieldNameImageH 	= $inputField."[".$systemFieldName.'-image-h]';

		$fieldId = str_replace(array('[', ']'), '-', $inputField);
		$fieldId = rtrim(str_replace(array("--", '---'), '', $fieldId), '-');
		$fieldId = $fieldId."-".$systemFieldName."-target";
		$fontIconClass = SfsFrontend::getIconByString(@$postArray[$systemFieldName], true);
		$imageValue    = $fontIconClass;
		?>
		<div class="sfs-icon-picker-selector">
			<a class="icon-picker-selector-remove" href="javascript:;"><i class="fa fa-times"></i></a>
			<input class="regular-text sfs-icon-picker-type" type="hidden" id="<?php echo $fieldId ?>-type" name="<?php echo $fieldNameIconType ?>" value="<?php echo (@$postArray[$systemFieldName."-type"] != '') ? @$postArray[$systemFieldName."-type"] : 'font' ?>" />
			<input class="regular-text sfs-icon-picker-value" type="hidden" id="<?php echo $fieldId ?>" name="<?php echo $inputField ?>[<?php echo $systemFieldName ?>]" value="<?php echo @$postArray[$systemFieldName] ?>" />
			<div class="icon-picker-nav">
				<a title="icon" data-icon-type="font" href="javascript:;"><i class="fa fa-font"></i></a>
				<a title="image" data-icon-type="image" href="javascript:;"><i class="fa fa-image"></i></a>
			</div>
			<div class="icon-picker-content" data-icon-type="font">
				<div style="width: 90px; height: 90px; font-size: 55px; line-height: 90px;" id="preview_<?php echo $fieldId ?>" data-target="#<?php echo $fieldId ?>" class="button icon-picker <?php echo $fontIconClass ?>"></div>
				
				<div style="margin-top: 14px; <?php echo (!$displayColor) ? 'height:46px' : '' ?>">
				<?php if($displayColor): ?>
					<input title="Color" name="<?php echo $fieldNameIconColor ?>" class="sfs-color-picker" type="text" value="<?php echo @$postArray[$systemFieldName."-color"] ?>">
				<?php endif; ?>
				</div>
			</div>
			<div class="icon-picker-content" data-icon-type="image">
				<div style="width: 90px; height: 90px; padding:0px; vertical-align: middle; margin-bottom: 5px;" class="button icon-picker-image-button">
					<img style="width: 100%; height: auto" src="">
				</div>
				<div style="vertical-align: middle;">
					<input value="<?php echo @$postArray[$systemFieldName."-image-w"] ?>" style="width:90px; display: inline-block; vertical-align: middle; text-align: center; font-size:11px; " placeholder="width" name="<?php echo $fieldNameImageW ?>" class="regular-text" type="text">
				</div>
				<div style="vertical-align: middle; margin-top: 1px;">
					<input value="<?php echo @$postArray[$systemFieldName."-image-h"] ?>" style="width:90px; display: inline-block; vertical-align: middle; text-align: center; font-size:11px; " placeholder="height" name="<?php echo $fieldNameImageH ?>" class="regular-text" type="text">
				</div>
			</div>
		</div>
		<?php
	}
}