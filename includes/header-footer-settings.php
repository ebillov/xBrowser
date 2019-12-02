<?php
//Begin settings script
function xb_header_footer_settings() {
	
	if( $_POST['header_footer_script']) {
		
		update_option('wjmc_header_footer', $_POST['header_footer_script']);
		
		echo "
		<div class='updated save-info'>
			<p>Header and Footer Settings Saved!</p>
		</div>
		";
		
	}
	
	//Get Header and Footer script array
	$header_footer_script = get_option('wjmc_header_footer');
	
	$header_script = stripslashes( $header_footer_script['header_script'] );
	$footer_script = stripslashes( $header_footer_script['footer_script'] );
	
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) == 0 ) {
		//Require the CodeMirror Script.
		require('codemirror-script.php');
		xb_header_footer_settings_script();
	}
?>
<div class="wrap">

	<h2>XBrowser Header and Footer Script <span class="xb_version_txt"><?php echo XB_PLUGIN_VERSION; ?></span> <span class="change_log"><a href="<?php echo XB_PLUGIN_DIR_URL; ?>changelog.txt?version=<?php echo XB_PLUGIN_VERSION; ?>" target="_blank">View Change log</a></span></h2>
	
	<div id="x-browser-header-footer-settings" style="background: url('<?php echo XB_PLUGIN_DIR_URL . 'img/strip-lines-overlay.jpg'; ?>');">
	
	<?php
	//Define reactivation of the xBrowser plugin to enable activation hook when upgrading from 1.3.4 and onwards
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) != 0 ) {
		require('xb-reactivate.php');
	}
	else { ?>
		<div class="xb_head_title_wrapper">
			<h4 class="xbrowser_head_title"><span class="dashicons dashicons-editor-code"></span> Header and Footer Script</h4>
			<p>Set Header and Footer scripts that is loaded in the front-end web page.</p>
		</div>
		
		<form id="header_footer_form" class="header_footer_script" action="" method="post">
			<fieldset class="header_script">
				<a id="search_header" class="xb_search_btn" href="#">Click to Search</a>
				<legend>
					Header Script
					<br /><span style="font-weight: normal;"><b>Note:</b> Script is placed before the &lt;&frasl;head&gt; tag.</span>
				</legend>
				<textarea id="head-script" name="header_footer_script[header_script]" placeholder="Enter header script"><?php echo $header_script; ?></textarea>
				<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
				<div style="clear: both;"></div>
			</fieldset>
			<fieldset class="footer_script">
				<a id="search_footer" class="xb_search_btn" href="#">Click to Search</a>
				<legend>
					Footer Script
					<br /><span style="font-weight: normal;"><b>Note:</b> Script is placed before the &lt;&frasl;body&gt; tag.</span>
				</legend>
				<textarea id="footer-script" name="header_footer_script[footer_script]" placeholder="Enter footer script"><?php echo $footer_script; ?></textarea>
				<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>
				<div style="clear: both;"></div>
			</fieldset>
			
			<div style="clear:both;"></div>
			<hr>
			<div style="clear:both;"></div>
			<input id="hf_submit_btn" class="button button-primary" type="submit" value="Save Header and Footer Settings" />
		</form>
		
		<div style="clear:both;"></div>
		
	<?php } ?>
		
	</div>
</div>
<?php } ?>