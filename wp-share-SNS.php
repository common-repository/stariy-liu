<?php
/*
 Plugin Name: Share to SNS
 Version: 1.0
 Plugin URI: http://blog.stariy.info/2010-08/wp-sns-share.html
 Description: Click the icon, share your blog to your favourite SNS.
 Author: Stariy Liu
 Author URI: http://stariy.info/
 */

define('SHARESNS_NAME', dirname(plugin_basename(__FILE__)));
define('SHARESNS_HOME', get_bloginfo('wpurl').'/wp-content/plugins/'.SHARESNS_NAME);
define('SHARESNS_IMAGE_HOME', SHARESNS_HOME.'/images');
define('SHARESNS_VERSION', '1.0');

if (!class_exists('ShareSNS')) {
	class ShareSNS {
		var $optionsName = 'ShareSNSOptions';
		var $options;

		function ShareSNS() {}

		function init() {
			$options = get_option($this->optionsName);
			if(empty($options)){
				$options = $this->defaultOptions();
				update_option($this->optionsName, $options);
			}
			else if($options['version'] != SHARESNS_VERSION){
				$options = $this->updateOptions();
			}
			$this->options = $options;
		}
		
		function defaultOptions() {
			return array(
				'version' => SHARESNS_VERSION,
				'SNS' => array(
					'renren' => array('c'=>1,'site'=>'人人网','width'=>626,'height'=>436),
					'kaixin' => array('c'=>1,'site'=>'开心','width'=>1050,'height'=>600),
					'qqzone' => array('c'=>1,'site'=>'QQ空间','width'=>1050,'height'=>600),
					'douban' => array('c'=>1,'site'=>'豆瓣','width'=>626,'height'=>436),
					'sina' => array('c'=>1,'site'=>'新浪微博','width'=>626,'height'=>436),
					'baidu' => array('c'=>1,'site'=>'百度空间','width'=>1050,'height'=>600),
					'twitter' => array('c'=>0,'site'=>'twitter','width'=>800,'height'=>515),
					'facebook' => array('c'=>0,'site'=>'facebook','width'=>626,'height'=>436),
				),
				'output' => array(
					'share' => 'share to:',
					'ending' => ''
				)
			);
		}
		
		function updateOptions() {
			$newOptions = $this->defaultOptions();
			$oldOptions = get_option($this->optionsName);
			if(!empty($oldOptions['SNS'])){
				foreach($oldOptions['SNS'] as $sns => $array ){
					if(in_array($sns, array_keys($newOptions['SNS']))){
						$newOptions['SNS'][$sns]['c'] = $array['c'];
					}
				}
			}
			if(!empty($oldOptions['output'])){
				foreach($oldOptions['output'] as $key => $value ){
					if(in_array($key, array_keys($newOptions['output']))){
						$newOptions['output'][$key] = $value;
					}
				}
			}
			update_option($this->optionsName, $newOptions);
			return $newOptions;
		}

		function printAdminPage() {
			$this->init();
			if(isset($_POST['shareSNS_update'])){
				$options = $this->defaultOptions();
				foreach ($options['SNS'] as $sns => $array){
					$options['SNS'][$sns]['c'] = 0;
				}
				$snsList = $_POST['c'];
				if(count($snsList) > 0){
					foreach ( $snsList as $sns ){
						if(in_array($sns, array_keys($options['SNS']))){
							$options['SNS'][$sns]['c'] = 1;
						}
					}
				}
				$options['output']['share'] = $_POST['output_share'];
				$options['output']['ending'] = $_POST['output_ending'];
				update_option($this->optionsName, $options);
				$this->options = $options;
			}
			?>
<style>
<!--
.sns td{
	text-align:center;
	height: 25px;
}
-->
</style>
<div class='wrap'>
	<h2><?php _e('Share to SNS', SHARESNS_NAME); ?></h2>
	<form action="" method="post">
	<p class='submit'><input type='submit' value='Update Options' name='Submit'></p>
	<div id='iconPenel'>
		<h3>SNS website setting</h3>
		<table class='sns'>
			<tr>
				<th width="50"><?php _e('choose', SHARESNS_NAME)?></th>
				<th width="100"><?php _e('logo', SHARESNS_NAME)?></th>
				<th width="100"><?php _e('name', SHARESNS_NAME)?></th>
				<th width="100"><?php _e('website', SHARESNS_NAME)?></th>
				<th width="150"><?php _e('window width', SHARESNS_NAME)?></th>
				<th width="150"><?php _e('window height', SHARESNS_NAME)?></th>
			</tr>
			<?php
				foreach ($this->options['SNS'] as $sns => $array){
			?>
			<tr>
				<td><input name="c[]" type="checkbox" <?php if($array['c']) echo 'checked'?> value="<?php _e($sns, SHARESNS_NAME)?>"></td>
				<td><img src='<?php echo SHARESNS_IMAGE_HOME."/$sns.ico"?>'></td>
				<td><?php _e($sns, SHARESNS_NAME)?></td>
				<td><?php _e($array['site'], SHARESNS_NAME)?></td>
				<td><?php _e($array['width'], SHARESNS_NAME) ?>px</td>
				<td><?php _e($array['height'], SHARESNS_NAME) ?>px</td>
			</tr>
			<?php 
				}
			?>
		</table>
	</div>
	<div id='output'>
		<h3>output setting</h3>
		<table>
			<tr>
				<td width="300">The saying before sns icon list</td>
				<td><input type="text" name="output_share" value="<?php _e($this->options['output']['share'], SHARESNS_NAME)?>"></td>
			</tr>
			<tr>
				<td>The saying after sns icon list</td>
				<td><input type="text" name="output_ending" value="<?php _e($this->options['output']['ending'], SHARESNS_NAME)?>"></td>
			</tr>
		</table>
	</div>
		<input type="hidden" name="shareSNS_update" value="1">
		<p class='submit'><input type='submit' value='Update Options' name='Submit'></p>
	</form>
</div>

			<?php
		}
		
		function createShareBar($content) {
			if(!is_single()){
				return $content;
			}
			$this->options = get_option($this->optionsName);
			$first = true;
			$css = '<style type="text/css">'.
					'.share{'.
					'	margin:20px 0 20px 0;'.
					'}'.
					'.share .share_item{'.
					'	margin-left: 10px;'.
					'	margin-right: 10px;'.
					'}'.
					'</style>';
			$text = '<div class="share">';
			foreach ($this->options['SNS'] as $sns => $array){
				if($array['c'] == 1){
					if($first) {
						$text .= '<hr width="70%" align="left" style="color:#666666">'.$this->options['output']['share'];
						$first = false;
					}
					$text .= '<a rel="nofollow" class="share_item" href="javascript:shareToSNS(\''.$sns.'\')" title="分享到'.$array['site'].'">';
					$text .= '<img src="'.SHARESNS_IMAGE_HOME.'/'.$sns.'.ico">';
					$text .= '</a>';
				}
			}
			$text .= $this->options['output']['ending'].'</div>';
			return $content.$css.$text;
		}
		
		function addJS() {
			$js = SHARESNS_HOME.'/'.SHARESNS_NAME.'.js';
			echo '<script type="text/javascript" src="'.$js.'"></script>';
		}
		
		function addCSS() {
			
		}
	}
}

if (class_exists('ShareSNS')) {
	$wp_shareSNS = new ShareSNS();
}

//Initialize the admin panel
if (!function_exists("ShareAdminPanel")) {
	function ShareAdminPanel() {
		global $wp_shareSNS;
		if (!isset($wp_shareSNS)) {
			return;
		}
		if (function_exists('add_options_page')) {
			add_options_page('Share to SNS', 'Share to SNS', 9,
			basename(__FILE__), array(&$wp_shareSNS, 'printAdminPage'));
		}
	}
}
add_action('admin_menu', 'ShareAdminPanel');
add_action('wp_head', array(&$wp_shareSNS, 'addJS'));
//add_action('wp_head', array(&$wp_shareSNS, 'addCSS'));
add_filter('the_content', array(&$wp_shareSNS, 'createShareBar'));
