<?php
function main_xbrowser_options() {
	
	if( $_POST['is_submit']== '1' ) {
		
		//Define sessions
		$_SESSION['checkbox_x'] = $_POST['checkbox-x'];
		$_SESSION['checkbox_1'] = $_POST['checkbox1'];
		$_SESSION['checkbox_2'] = $_POST['checkbox2'];
		
		//Scroll Events
		$_SESSION['chrome_event'] = $_POST['chrome_event'];
		$_SESSION['firefox_event'] = $_POST['firefox_event'];
		$_SESSION['ie_event'] = $_POST['ie_event'];
		$_SESSION['safari_event'] = $_POST['safari_event'];
		$_SESSION['general_event'] = $_POST['general_event'];
		//$_SESSION['extra_large_event'] = $_POST['extra_large_event'];
		//$_SESSION['large_1_event'] = $_POST['large_1_event'];
		$_SESSION['large_event'] = $_POST['large_event'];
		$_SESSION['medium_event'] = $_POST['medium_event'];
		$_SESSION['small_event'] = $_POST['small_event'];
		$_SESSION['generic_mobile_event'] = $_POST['generic_mobile_event'];
		$_SESSION['ipad_event'] = $_POST['ipad_event'];
		$_SESSION['nexus_event'] = $_POST['nexus_event'];
		$_SESSION['ipod_event'] = $_POST['ipod_event'];
		
		update_option('wjmc_ipad', $_POST['ipad']);
		update_option('wjmc_nexus', $_POST['nexus']);
		update_option('wjmc_ipod', $_POST['ipod']);
		update_option('wjmc_general', $_POST['general']);
		
		update_option('wjmc_generic', $_POST['generic_mobile']);
		update_option('wjmc_small', $_POST['small']);
		update_option('wjmc_medium', $_POST['medium']);
		update_option('wjmc_large', $_POST['large']);
		//update_option('wjmc_large_1', $_POST['large_1']);
		//update_option('wjmc_extra_large', $_POST['extra_large']);
		
		update_option('wjmc_chrome', $_POST['chrome']);
		update_option('wjmc_safari', $_POST['safari']);
		update_option('wjmc_internet_explorer', $_POST['internet_explorer']);
		update_option('wjmc_microsoft_edge', $_POST['microsoft_edge']);
		update_option('wjmc_firefox', $_POST['firefox']);
		
		update_option('wjmc_cache_override', $_POST['cache_override']);
		
		echo "
		<div class='updated save-info'>
			<p>CSS Options Saved!</p>
		</div>
		";
		
	}
	
	//Mobile
	$general = stripslashes(get_option('wjmc_general'));
	$ipad = stripslashes(get_option('wjmc_ipad'));
	$nexus = stripslashes(get_option('wjmc_nexus'));
	$ipod = stripslashes(get_option('wjmc_ipod'));
	$generic_mobile = stripslashes(get_option('wjmc_generic'));
	
	//Desktop
	$small = stripslashes(get_option('wjmc_small'));
	$medium = stripslashes(get_option('wjmc_medium'));
	$large = stripslashes(get_option('wjmc_large'));
	$large_1 = stripslashes(get_option('wjmc_large_1'));
	$extra_large = stripslashes(get_option('wjmc_extra_large'));
	
	//Define New Cross Browser Settings
	$chrome = stripslashes(get_option('wjmc_chrome'));
	$firefox = stripslashes(get_option('wjmc_firefox'));
	$internet_explorer = stripslashes(get_option('wjmc_internet_explorer'));
	$microsoft_edge = stripslashes(get_option('wjmc_microsoft_edge'));
	$safari = stripslashes(get_option('wjmc_safari'));
	
	//Cache Override
	$cache_override = get_option('wjmc_cache_override');
	
	//Toggle Hide / Show Options
	$toggle_show_hide = get_option('wjmc_toggle_show_hide');
	
	//Require the CodeMirror Script. Needed to include it this way so that the CodeMirror's scrollTo function will work with PHP Sessions :\
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) == 0 ) {
		require('codemirror-script.php');
		xb_css_options_main_script();
		if(XB_AJAX_SAVING_MODE == 'on' || XB_AJAX_SAVING_MODE_ROW == null){
			xb_css_media_query_script();
		}
	}

?>
<div class="wrap">

	<h2>XBrowser CSS Options <span class="xb_version_txt"><?php echo XB_PLUGIN_VERSION; ?></span> <span class="change_log"><a href="<?php echo XB_PLUGIN_DIR_URL; ?>changelog.txt?version=<?php echo XB_PLUGIN_VERSION; ?>" target="_blank">View Change log</a></span></h2>
	
	<div id="main-xbrowser-page" style="background: url('<?php echo XB_PLUGIN_DIR_URL . 'img/strip-lines-overlay.jpg'; ?>');">
	
	<?php
	//Define reactivation of the xBrowser plugin to enable activation hook when upgrading from 1.3.4 and onwards
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) != 0 ) {
		require('xb-reactivate.php');
	}
	else { ?>
	
	<div class="xb_head_title_wrapper">
		<h4 class="xbrowser_head_title"><span class="dashicons dashicons-welcome-write-blog"></span> CSS Options</h4>
		<p>Enter CSS custom codes to pre-defined viewport resolutions.</p>
	</div>
	
		<form action="" id="css_options_form" method="post" class="xBrowser_form <?php if($toggle_show_hide == 'on') { echo "xBrowser_form_show_all"; } ?>">
			<div id="xbrowser_fields"></div>
			<p class="override_cache">Override Cache <input id="checkbox-cache" type="checkbox" name="cache_override" <?php if( $cache_override == 'on' ): ?>checked<?php endif; ?>/> <span class="override_cache_info"><?php if( $cache_override == 'on' ): ?>Enabled<?php else: ?>Disabled<?php endif; ?></span><br /><span>Enable this option if using a caching plugin.</span><br /><span><b>Note:</b> This applies to the <b>xBrowser User Agents</b> CSS options.</span></p>
			<p class="show-hide" <?php if($toggle_show_hide == 'on') { echo 'style="background-color: #D6DAFF;"'; }?>><?php if($toggle_show_hide == null): ?>Show / Hide <?php endif;?><span class="xbrowser_field">xBrowser</span> User Agents <?php if($toggle_show_hide == null): ?><input type="checkbox" id="checkbox-x" name="checkbox-x" <?php if( $_SESSION['checkbox_x'] == 'on' ): ?>checked<?php endif; ?>/><?php endif; ?></p>
			<div id="autoUpdate-x" class="autoUpdate-x">
				<fieldset>
					<a id="search_chrome" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Chrome<br /><span style="font-weight: normal;">User Agent: Chrome</span></legend>
					<textarea id="chrome" name="chrome" placeholder="Enter CSS for Chrome"><?php echo $chrome; ?></textarea>
					<input id="chrome_event" type="hidden" name="chrome_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_firefox" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Mozilla Firefox<br /><span style="font-weight: normal;">User Agent: Firefox</span></legend>
					<textarea id="firefox" name="firefox" placeholder="Enter CSS for Firefox"><?php echo $firefox; ?></textarea>
					<input id="firefox_event" type="hidden" name="firefox_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_edge" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Microsoft Edge<br /><span style="font-weight: normal;">User Agent: Edge</span></legend>
					<textarea id="microsoft_edge" name="microsoft_edge" placeholder="Enter CSS for Microsoft Edge"><?php echo $microsoft_edge; ?></textarea>
					<input id="edge_event" type="hidden" name="edge_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_ie" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Internet Explorer 8, 9, 10, 11<br /><span style="font-weight: normal;">User Agent: MSIE, Trident</span></legend>
					<textarea id="internet_explorer" name="internet_explorer" placeholder="Enter CSS for Internet Explorer"><?php echo $internet_explorer; ?></textarea>
					<input id="ie_event" type="hidden" name="ie_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_safari" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Safari<br /><span style="font-weight: normal;">User Agent: Safari</span></legend>
					<textarea id="safari" name="safari" placeholder="Enter CSS for Safari"><?php echo $safari; ?></textarea>
					<input id="safari_event" type="hidden" name="safari_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
			</div>
			
			<div style="clear:both;"></div>
			<hr>
			<div style="clear:both;"></div>
			
			<div id="desktop_fields"></div>
			<p class="show-hide" <?php if($toggle_show_hide == 'on') { echo 'style="background-color: #D6DAFF;"'; }?>><?php if($toggle_show_hide == null): ?>Show / Hide <?php endif;?><span class="xb_desktop_field">Desktop</span> Resolutions <?php if($toggle_show_hide == null): ?><input type="checkbox" id="checkbox1" name="checkbox1" <?php if( $_SESSION['checkbox_1'] == 'on' ): ?>checked<?php endif; ?>/><?php endif; ?></p>
			<div id="autoUpdate" class="autoUpdate">
				<div style="clear:both;"></div>
				<fieldset>
					<a id="search_general" class="xb_search_btn" href="#">Click to Search</a>
					<legend>General</legend>
					<textarea id="general" name="general" placeholder="Enter CSS for all screen resolutions"><?php echo $general; ?></textarea>
					<input id="general_event" type="hidden" name="general_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<!--<fieldset>
					<legend>Max-width: 1920px</legend>
					<textarea id="extra_large" name="extra_large" placeholder="Enter CSS for 1920px screen width"><?php //echo $extra_large; ?></textarea>
					<input id="extra_large_event" type="hidden" name="extra_large_event"></input>
				</fieldset>-->
				<!--<fieldset>
					<legend>Max-width: 1600px</legend>
					<textarea id="large_1" name="large_1" placeholder="Enter CSS for 1600px screen width"><?php //echo $large_1; ?></textarea>
					<input id="large_1_event" type="hidden" name="large_1_event"></input>
				</fieldset>-->
				<fieldset>
					<a id="search_large" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 1366px</legend>
					<textarea id="large" name="large" placeholder="Enter CSS for 1366px screen width"><?php echo $large; ?></textarea>
					<input id="large_event" type="hidden" name="large_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_medium" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 1288px</legend>
					<textarea id="medium" name="medium" placeholder="Enter CSS for 1288px screen width"><?php echo $medium; ?></textarea>
					<input id="medium_event" type="hidden" name="medium_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_small" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 1024px</legend>
					<textarea id="small" name="small" placeholder="Enter CSS for 1024px screen width"><?php echo $small; ?></textarea>
					<input id="small_event" type="hidden" name="small_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
			</div>
			
			<div style="clear:both;"></div>
			<hr>
			<div style="clear:both;"></div>
			
			<div id="mobile_fields"></div>
			<p class="show-hide" <?php if($toggle_show_hide == 'on') { echo 'style="background-color: #D6DAFF;"'; }?>><?php if($toggle_show_hide == null): ?>Show / Hide <?php endif;?><span class="xb_mobile_field">Mobile</span> Resolutions <?php if($toggle_show_hide == null): ?><input type="checkbox" id="checkbox2" name="checkbox2" <?php if( $_SESSION['checkbox_2'] == 'on' ): ?>checked<?php endif; ?>/><?php endif; ?></p>
			<div id="autoUpdate_mobile" class="autoUpdate_mobile">
				<fieldset>
					<a id="search_generic_mobile" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 980px</legend>
					<textarea id="generic_mobile" name="generic_mobile" placeholder="Enter CSS for 980px screen width"><?php echo $generic_mobile; ?></textarea>
					<input id="generic_mobile_event" type="hidden" name="generic_mobile_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_ipad" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 773px</legend>
					<textarea id="ipad" name="ipad" placeholder="Enter CSS for 773px screen width"><?php echo $ipad; ?></textarea>
					<input id="ipad_event" type="hidden" name="ipad_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_nexus" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 601px</legend>
					<textarea id="nexus" name="nexus" placeholder="Enter CSS for 601px screen width"><?php echo $nexus; ?></textarea>
					<input id="nexus_event" type="hidden" name="nexus_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
				<fieldset>
					<a id="search_ipod" class="xb_search_btn" href="#">Click to Search</a>
					<legend>Max-width: 480px</legend>
					<textarea id="ipod" name="ipod" placeholder="Enter CSS for 480px screen width"><?php echo $ipod; ?></textarea>
					<input id="ipod_event" type="hidden" name="ipod_event"></input>
					<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
					<div style="clear: both;"></div>
				</fieldset>
			</div>
			
			<div style="clear:both;"></div>
			<hr>
			<div style="clear:both;"></div>
			
			<input type="hidden" value="1" name="is_submit" />
			<input class="button button-primary" type="submit" value="Save CSS Options"/>
			<input class="right_submit" type="image" src="<?php echo XB_PLUGIN_DIR_URL . 'img/save-icon-long.jpg'; ?>" title="Save CSS Options"/>
		</form>
	</div>
	
	<?php if(XB_AJAX_SAVING_MODE == 'on' || XB_AJAX_SAVING_MODE_ROW == null): ?>
	
	<div id="xbrowser-css-overrides" style="background: url('<?php echo XB_PLUGIN_DIR_URL . 'img/strip-lines-overlay.jpg'; ?>');">
	
	<div class="xb_head_title_wrapper">
		<h4 class="xbrowser_head_title"><span class="dashicons dashicons-welcome-view-site"></span> CSS Media Queries</h4>
		<p>Enter CSS Media Query for custom viewport resolutions and browser user agent.</p>
	</div>
	
		<div id="css_media_add_btn_wrapper">
			<button id="css_media_add_btn">Add CSS Media Query</button>
		</div>
		
		<div id="css_media_new_wrapper">
		
			<form action="" id="css_media_add_form" method="post">
				<table>
					<tr>
						<td><label>Browser User Agent:</label></td>
						<td>
							<select id="css_browser_user_agent">
								<option value="all">All Browser User Agents</option>
								<option value="chrome">Chrome</option>
								<option value="firefox">Mozilla FireFox</option>
								<option value="ie">Internet Explorer 8, 9, 10, 11</option>
								<option value="edge">Microsoft Edge</option>
								<option value="safari">Safari</option>
							</select>
						</td>
					</tr>
					<tr id="media_query_type">
						<td><label>Media Query:</label></td>
						<td>
							<select id="css_media_query">
								<option value="1">@media (min-width: [xxxx]px)</option>
								<option value="2">@media (max-width: [xxxx]px)</option>
								<option value="3">@media (min-height: [yyyy]px)</option>
								<option value="4">@media (max-height: [yyyy]px)</option>
								<option value="5">@media (min-width: [xxxx]px) and (max-width: [xxxx]px)</option>
								<option value="6">@media (min-height: [yyyy]px) and (max-height: [yyyy]px)</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><label>Custom CSS Code:</label></td>
						<td>
							<textarea id="css_media_code_cmq"></textarea>
							<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
							<div style="clear: both;"></div>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input id="css_media_query_add_btn" class="button button-primary" type="submit" value="Add/Save CSS Media Query"/>
							<button id="cancel_media_query">Cancel</button>
							<img id="ajax_load_img" src="<?php echo XB_PLUGIN_DIR_URL; ?>/img/ajax-loader.gif"/>
						</td>
					</tr>
				</table>
			</form>
		
		</div>
		
		<div id="media_query_entry_wrapper">
		
		<?php
			if( get_option('xb_media_query') ):
			
			//Get array options
			$array_option = get_option('xb_media_query');
			foreach($array_option as $key => $option_val):
		?>
			<form class="css_media_ud" action="" method="post">
				<div class="media_query_div_entry">
					<p class="css_media_query_info_error"></p>
					<p class="css_media_query_info_success"></p>
					<input class="css_media_index" type="hidden" name="xb_css_media_options_update[array_index]" value="<?php echo $key; ?>"/>
					<table dimension-1="<?php echo $option_val['dimensions'][0]; ?>" dimension-2="<?php echo $option_val['dimensions'][1]; ?>">
						<tr>
							<td><label>Browser User Agent:</label></td>
							<td>
								<select class="css_browser_user_agent" disabled>
									<option value="all" <?php if($option_val['user_agent'] == 'all'){ echo "selected"; }?>>All Browser User Agents</option>
									<option value="chrome" <?php if($option_val['user_agent'] == 'chrome'){ echo "selected"; }?>>Chrome</option>
									<option value="firefox" <?php if($option_val['user_agent'] == 'firefox'){ echo "selected"; }?>>Mozilla FireFox</option>
									<option value="ie" <?php if($option_val['user_agent'] == 'ie'){ echo "selected"; }?>>Internet Explorer 8, 9, 10, 11</option>
									<option value="edge" <?php if($option_val['user_agent'] == 'edge'){ echo "selected"; }?>>Microsoft Edge</option>
									<option value="safari" <?php if($option_val['user_agent'] == 'safari'){ echo "selected"; }?>>Safari</option>
								</select>
							</td>
						</tr>
						<tr class="media_query_type">
							<td><label>Media Query:</label></td>
							<td>
								<select class="css_media_query" disabled>
									<option value="1" <?php if($option_val['media_query'] == '1'){ echo "selected"; }?>>@media (min-width: [xxxx]px)</option>
									<option value="2" <?php if($option_val['media_query'] == '2'){ echo "selected"; }?>>@media (max-width: [xxxx]px)</option>
									<option value="3" <?php if($option_val['media_query'] == '3'){ echo "selected"; }?>>@media (min-height: [yyyy]px)</option>
									<option value="4" <?php if($option_val['media_query'] == '4'){ echo "selected"; }?>>@media (max-height: [yyyy]px)</option>
									<option value="5" <?php if($option_val['media_query'] == '5'){ echo "selected"; }?>>@media (min-width: [xxxx]px) and (max-width: [xxxx]px)</option>
									<option value="6" <?php if($option_val['media_query'] == '6'){ echo "selected"; }?>>@media (min-height: [yyyy]px) and (max-height: [yyyy]px)</option>
								</select>
							</td>
						</tr>
						<tr class="media_query_hidden_input">
							<td><input type="hidden" value="<?php echo $option_val['dimensions'][0]; ?>"/></td>
							<td><input type="hidden" value="<?php echo $option_val['dimensions'][1]; ?>"/></td>
						</tr>
						<tr class="default_dimensions">
							<td><label>Dimensions:</label></td>
							<td>
								<p class="info_dimensions_default">
								<?php
									if($option_val['media_query'] == '1') {
										echo '@media (min-width: <span>'. $option_val['dimensions'][0] .'px</span>)';
									}elseif($option_val['media_query'] == '2') {
										echo '@media (max-width: <span>'. $option_val['dimensions'][0] .'px</span>)';
									}elseif($option_val['media_query'] == '3') {
										echo '@media (min-height: <span>'. $option_val['dimensions'][0] .'px</span>)';
									}elseif($option_val['media_query'] == '4') {
										echo '@media (max-height: <span>'. $option_val['dimensions'][0] .'px</span>)';
									}elseif($option_val['media_query'] == '5') {
										echo '@media (min-width: <span>' . $option_val['dimensions'][0] . 'px</span>) and (max-width: <span>' . $option_val['dimensions'][1] . 'px</span>)';
									}else {
										echo '@media (min-height: <span>' . $option_val['dimensions'][0] . 'px</span>) and (max-height: <span>' . $option_val['dimensions'][1] . 'px</span>)';
									}
								?>
								</p>
							</td>
						</tr>
						<tr class="css_code_entry">
							<td><label>Custom CSS Code:</label></td>
							<td>
								<div class="xb_css_media_entry_search_wrapper">
									<a class="xb_search_btn" href="#">Click to Search</a>
								</div>
								<textarea id="css_media_code_cmq_entry<?php echo $key; ?>" class="css_media_code_cmq_entry"><?php echo stripslashes($option_val['css_code']); ?></textarea>
								<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
								<div style="clear: both;"></div>
							</td>
						</tr>
						<tr class="edit_delete_media_query">
							<td></td>
							<td>
								<button class="edit_media_query">Edit</button>
								<button class="delete_media_query">Delete</button>
							</td>
						</tr>
						<tr class="update_cancel_media_query">
							<td></td>
							<td>
								<button class="update_media_query button-primary">Update</button>
								<button class="cancel_media_query">Cancel</button>
							</td>
						</tr>
					</table>
				</div>
			</form>
			<?php endforeach; endif; ?>
			
		</div>
		
	</div>
	
	<?php else: ?>
	
	<div class="css_media_query_notice_warning">
		<p><b><span style="color: #ff0000;">Warning:</span></b> <b>CSS Media Query</b> is only available when you enable <b>Ajax Saving mode</b>. Please go to <b>xBrowser -> Settings</b> to enable Ajax Saving mode.</p>
	</div>
	
	<?php endif; ?>
	
	<?php } ?>
	
</div>
<?php	
}