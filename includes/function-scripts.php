<?php
//Load Admin CSS
function xbrowser_admin_css() {
	
	/* There needs to declare the CSS version using a url parameter in order to apply the updated CSS file accross the plugin. */
	?>
	
	<link rel='stylesheet' href='<?php echo XB_PLUGIN_DIR_URL; ?>css/admin-css.css?version=<?php echo XB_PLUGIN_VERSION; ?>' type='text/css' media='all' />
	<style type="text/css">
		<?php
		//Toggle Hide / Show Options
		$toggle_show_hide = get_option('wjmc_toggle_show_hide');
		
		if($toggle_show_hide == 'on') {
			echo "
			#autoUpdate, #autoUpdate_mobile, #autoUpdate-x {
				display: block!important;
			}
			";
		}
		?>
	</style>
	
	<?php
}

//Load Admin JS
function xbrowser_admin_js() {
	
	?>
	
	<script type="text/javascript">
		var toggle_content = function() {
			
			jQuery('#checkbox-x').change(function () {
				jQuery('#autoUpdate-x').slideToggle('fast');
			});
		
			jQuery('#checkbox1').change(function () {
				jQuery('#autoUpdate').slideToggle('fast');
			});

			jQuery('#checkbox2').change(function () {
				jQuery('#autoUpdate_mobile').slideToggle('fast');
			});
			
			jQuery('#mopbile_menu_id').click(function () {
				jQuery('#collapsed_label_show').slideToggle('fast');
			});
			
			//Define display toggle based on sessions
			<?php if( $_SESSION['checkbox_x'] ): ?>
			jQuery('#autoUpdate-x').attr('style', 'display: block;');
			
			//Auto scroll to the textarea fields when saving
			jQuery(window).scrollTop(
				( jQuery('#xbrowser_fields').offset().top ) - 40
			);
			<?php endif; ?>
			
			<?php if( $_SESSION['checkbox_1'] ): ?>
			jQuery('#autoUpdate').attr('style', 'display: block;');
			
			//Auto scroll to the textarea fields when saving
			jQuery(window).scrollTop(
				( jQuery('#desktop_fields').offset().top ) - 40
			);
			<?php endif; ?>
			
			<?php if( $_SESSION['checkbox_2'] ): ?>
			jQuery('#autoUpdate_mobile').attr('style', 'display: block;');
			
			//Auto scroll to the textarea fields when saving
			jQuery(window).scrollTop(
				( jQuery('#mobile_fields').offset().top ) - 40
			);
			<?php endif; ?>
			
			//Load an iframe to the settings page.
			jQuery('#iframe_changelog').append('<p id="changelog-label">Changelog</p><iframe src="<?php echo XB_PLUGIN_DIR_URL; ?>changelog.txt?version=<?php echo XB_PLUGIN_VERSION; ?>"/>');
			
			//Add a fade effect popup save info message
			<?php if( XB_CURRENT_PAGE == 'xbrowser-compatibility' && ( $_SESSION['checkbox_x'] || $_SESSION['checkbox_1'] || $_SESSION['checkbox_2'] ) ): ?>
			jQuery('#main-xbrowser-page').append('<div id="save-popup-info">Options Saved!</div>');
			
			jQuery('#save-popup-info').css({
				top: ( ( jQuery(window).height() / 2 ) - jQuery('#save-popup-info').height() - 50 ), 
				left: ( ( jQuery(window).width() / 2 ) - ( jQuery('#save-popup-info').width() / 2 ) )
			});

			setTimeout(function() {
				jQuery('#save-popup-info').fadeOut();
			}, 1500);
			<?php else: ?>
			setTimeout(function() {
			   jQuery('.save-info').fadeOut();
		   }, 7000);
			<?php endif; ?>
			
			jQuery('#checkbox-x').css('display', 'inline-block');
			jQuery('#checkbox1').css('display', 'inline-block');
			jQuery('#checkbox2').css('display', 'inline-block');
			
			/*
			jQuery(window).on('scroll', function() {
				jQuery('#css_fields').each(function() {
					if( jQuery(window).scrollTop() >= jQuery(this).offset().top ) {
						jQuery('.right_submit').css('display', 'block');
					}
				});
			}); */
			
			<?php if(get_option('wjmc_toggle_show_hide') == 'on'): ?>
				jQuery('.right_submit').css('display', 'block');
			<?php endif; ?>
			
			//Detect if slideToggle is triggered and then display the save icon
			jQuery('#checkbox-x, #checkbox1, #checkbox2').change(function () {
				jQuery('.right_submit').css('display', 'block');
			});
			
			if( jQuery('#checkbox-x:checked, #checkbox1:checked, #checkbox2:checked')[0] != null ) {
				jQuery('.right_submit').css('display', 'block');
			}
			
			//For Ajax save overlay
			var overlay_height = jQuery(window).height();
			jQuery('body').append('<div id="xb_ajax_overlay_save"><p>Saving...</p></div>');
			jQuery('#xb_ajax_overlay_save p').css('top', (overlay_height/2) - 50 + 'px');
			
			//For Ajax update overlay
			var overlay_height = jQuery(window).height();
			jQuery('body').append('<div id="xb_ajax_overlay_update"><p>Updating...</p></div>');
			jQuery('#xb_ajax_overlay_update p').css('top', (overlay_height/2) - 50 + 'px');
			
			//For Ajax delete overlay
			var overlay_height = jQuery(window).height();
			jQuery('body').append('<div id="xb_ajax_overlay_delete"><p>Deleting...</p></div>');
			jQuery('#xb_ajax_overlay_delete p').css('top', (overlay_height/2) - 50 + 'px');
			
			//Special Equalize Settings toggle function
			jQuery('#add_special_equalize').toggle(function () {
				
				jQuery('#special_equalize').append( jQuery('#se_hidden_html').html() );
				jQuery('#special_equalize').attr('style', 'padding: 5px; margin-top: 10px; display: block;');
				jQuery('#se_html_contents').slideDown('fast');
				
			},function(){
				jQuery('#special_equalize #se_html_contents').remove();
				jQuery('#special_equalize').attr('style', 'padding: 0; margin-top: 0;');
				jQuery('#special_equalize').hide();
				
			});
			
			//Variable for xpanding CodeMirror Instances
			var css_options_width = "";
			
			//For expanding CodeMirror instances in the CSS Options section
			jQuery('#main-xbrowser-page .CodeMirror').each(function(index){
				
				jQuery(jQuery('.xb_expand_collapse_btn')[index]).toggle(function(e){
					e.preventDefault();
					css_options_width = jQuery('#main-xbrowser-page').width();
					jQuery( jQuery('.CodeMirror')[index] ).animate({
						'width' : css_options_width / 1.5,
						'height' : '600px'
					});
				},function(e){
					e.preventDefault();
					jQuery( jQuery('.CodeMirror')[index] ).animate({
						'width' : '350px',
						'height' : '400px'
					});
				});
				
			});
			
			//For expanding CodeMirror instances in the Header and Footer script section
			jQuery('#x-browser-header-footer-settings .CodeMirror').each(function(index){
				
				jQuery(jQuery('.xb_expand_collapse_btn')[index]).toggle(function(e){
					e.preventDefault();
					css_options_width = jQuery('#x-browser-header-footer-settings').width();
					jQuery( jQuery('.CodeMirror')[index] ).animate({
						//'width' : css_options_width / 1.7,
						'width' : css_options_width,
						'height' : '600px'
					});
				},function(e){
					e.preventDefault();
					jQuery( jQuery('.CodeMirror')[index] ).animate({
						'width' : '500px',
						'height' : '400px'
					});
				});
				
			});
		   
		}
		
		// Launch function after window load.
		jQuery(window).load(toggle_content);
	</script>
	
	<?php
	
	//Unset session variables
	unset( $_SESSION['checkbox_x'] );
	unset( $_SESSION['checkbox_1'] );
	unset( $_SESSION['checkbox_2'] );
	unset( $_SESSION['chrome_event'] );
	unset( $_SESSION['firefox_event'] );
	unset( $_SESSION['ie_event'] );
	unset( $_SESSION['safari_event'] );
	unset( $_SESSION['general_event'] );
	//unset( $_SESSION['extra_large_event'] );
	//unset( $_SESSION['large_1_event'] );
	unset( $_SESSION['large_event'] );
	unset( $_SESSION['medium_event'] );
	unset( $_SESSION['small_event'] );
	unset( $_SESSION['generic_mobile_event'] );
	unset( $_SESSION['ipad_event'] );
	unset( $_SESSION['nexus_event'] );
	unset( $_SESSION['ipod_event'] );
	
}

//Load Code Mirror Library
function load_code_mirror_lib() {
	
	?>
	
	<link rel="stylesheet" href="<?php echo XB_PLUGIN_DIR_URL; ?>lib/ambiance.css">
	<link rel="stylesheet" href="<?php echo XB_PLUGIN_DIR_URL; ?>lib/codemirror.css">
	
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>lib/codemirror.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>mode/css/css.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>mode/javascript/javascript.js"></script>
    <script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/edit/matchbrackets.js"></script>
    <script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/edit/closebrackets.js"></script>
    <script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/display/autorefresh.js"></script>
    <script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/selection/active-line.js"></script>
    <script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/display/placeholder.js"></script>
    <script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/selection/selection-pointer.js"></script>
	<!-- <script src="<?php //echo $plugin_path; ?>lib/script.js"></script> -->
	
	<!-- Lint Lib -->
	<link rel="stylesheet" href="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/lint.css">
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/lint.js"></script>
	
	<!-- CSS Lint Lib -->
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/css-lint.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/css-lint-lib.js"></script>
	
	<!-- Javascript Lint Lib -->
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/jshint.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/jsonlint.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/javascript-lint.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/lint/json-lint.js"></script>
	
	<!-- HTML Mixed -->
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>mode/htmlmixed/htmlmixed.js"></script>
	
	<!-- XML Mixed -->
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>mode/xml/xml.js"></script>
	
	<!-- VB Script -->
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>mode/vbscript/vbscript.js"></script>

	<!-- Search, Dialog, Scroll Lib -->
	<link rel="stylesheet" href="<?php echo XB_PLUGIN_DIR_URL; ?>addon/dialog/dialog.css"></link>
	<link rel="stylesheet" href="<?php echo XB_PLUGIN_DIR_URL; ?>addon/search/matchesonscrollbar.css"></link>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/dialog/dialog.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/search/searchcursor.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/search/search.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/scroll/annotatescrollbar.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/search/match-highlighter.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/search/matchesonscrollbar.js"></script>
	<script src="<?php echo XB_PLUGIN_DIR_URL; ?>addon/search/jump-to-line.js"></script>
	
	<?php
}

//Begin error report/display
function error_report() {

	echo "<div style='width: 89%; float: right;'><pre>";
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	echo "</pre></div>";

}

//Define global Debug Mode variable
function debug_mode() {
	
	global $debug_mode;
	$debug_mode = get_option('wjmc_debug_mode');
	
}

//Define Ajax saving on CSS Options section
function css_options_ajax_script(){
	?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			
			jQuery('#css_options_form').submit(function(e){
				
				e.preventDefault();
				
				jQuery('#xb_ajax_overlay_save').css('display', 'block');
				
				var form = jQuery('#css_options_form').serialize();
				
				jQuery.ajax({
					url:'<?php echo admin_url("admin-ajax.php"); ?>',
					type:'POST',
					dataType: "json",
					data:'action=css_options_ajax&'+ form,
					error:function(data_1){
						if(data_1.statusText == 'error') {
							jQuery('#xb_ajax_overlay_save p').html('<span style="color: #fff000;">Error:</span> Ajax could not connect to server!');
							jQuery('#xb_ajax_overlay_save p').css({
								width: 'auto',
								maxWidth: '300px'
							});
						}
					},
					success:function(data){
						
						if(data['xb_ajax_post_array']['cache_override'] == 'on') {
							jQuery('.override_cache_info').html('Enabled');
						}
						else {
							jQuery('.override_cache_info').html('Disabled');
						}
						
						jQuery('#xb_ajax_overlay_save p').hide();
						jQuery('#xb_ajax_overlay_save').append('<div id="save-popup-info">Options Saved!<span class="dashicons dashicons-yes"></span></div>');
						jQuery('#save-popup-info').css({
							top: ( ( jQuery(window).height() / 2 ) - jQuery('#save-popup-info').height() - 30 ), 
							left: ( ( jQuery(window).width() / 2 ) - ( jQuery('#save-popup-info').width() / 2 ) - 30 )
						});
						setTimeout(function() {
							jQuery('#save-popup-info').fadeOut('fast', function(){
								jQuery('#xb_ajax_overlay_save').css('display', 'none');
								jQuery('#xb_ajax_overlay_save p').show();
							});
						}, 1500);
						setTimeout(function() {
							jQuery('#save-popup-info').remove();
						}, 2000);
						
					}
				});
			});
			
		});
		</script>
	<?php
}

//Define CSS Media Query script
function css_media_query(){
	?>
		<script type="text/javascript">
		
				//Define function to initialize css media query script and make it a global function
				var init_css_media_query = function(){
					
					//Define initial value
					var css_media_type = "",
						looped_fields = "",
						css_media_type_val = "",
						dimension_1 = "",
						dimension_2 = "",
						each_cm_element = "",
						each_cm_instance = "",
						each_css_code_val = "",
						css_options_width = "",
						add_new_btn_element = jQuery('#css_media_add_btn');
					
					//Remove the add new css media query button to reset the click event handler
					jQuery(add_new_btn_element).remove();
					
					//Render again the button
					jQuery('#css_media_add_btn_wrapper').append(add_new_btn_element);
					
					//Define Add new CSS media query event
					jQuery('#css_media_add_btn, .edit_media_query').off('click').on('click', function(e){
						
						//Unpropagate event on click
						e.preventDefault();
						
						if( jQuery(e.target).is('button#css_media_add_btn') ) {
							
							//Remove success info
							jQuery('#css_media_query_info_success').remove();
							
							//Disable click event
							jQuery(this).attr('disabled','disabled');
							
							//Slide and show the form
							jQuery('#css_media_add_form').slideDown('slow');
							
							//Define data names
							jQuery('#css_browser_user_agent').attr('name', 'xb_css_media_options_add[user_agent]');
							jQuery('#css_media_query').attr('name', 'xb_css_media_options_add[media_query]');
							jQuery('#css_media_code_cmq').attr('name', 'xb_css_media_options_add[css_code]');
							var media_query_data_name = "xb_css_media_options_add[dimensions][]";
							
							//Get initial media type value
							css_media_type = jQuery('#css_media_query').val();
							
							//Define if media query values are in loop of entries or not
							looped_fields = false;
							
							//Init media type and pass the media query data name
							render_fields_media_val( media_query_data_name, css_media_type, looped_fields );
							
							//Run the function again on change event
							jQuery('#css_media_query').on('change', function(){
								
								//Get the new field value
								css_media_type = jQuery(this).val();
								
								//Rwemove the elements that was added due to the change event
								jQuery('#media_type_dimensions').remove();
								
								//Run the function again
								render_fields_media_val( media_query_data_name, css_media_type, looped_fields );
								
							});
							
							//Run function for expanding CodeMirror instances in th CSS Options section. A delay timeout is necessary so that the codemirror can be loaded first-hand
							setTimeout(expand_collapse_codemirror(e.target), 100);
							
						}
						
						if( jQuery(e.target).is('button.edit_media_query') ) {
							
							//Run reset function for add form
							reset_media_type_val();
							
							//Define data names
							jQuery('.css_browser_user_agent').attr('name', 'xb_css_media_options_update[user_agent]');
							jQuery('.css_media_query').attr('name', 'xb_css_media_options_update[media_query]');
							jQuery('.media_query_hidden_input input').attr('name', 'xb_css_media_options_update[dimensions][]');
							jQuery('.css_media_code_cmq_entry').attr('name', 'xb_css_media_options_update[css_code]');
							var media_query_data_name = "xb_css_media_options_update[dimensions][]";
							
							/* ################################################## Start of defining variable elements ###################################################### */
							
							//Get parent table element
							var parent_table = jQuery(e.target).parents()[3],
							
								//Get dimension data from the table element attribute
								dimension_1 = jQuery(parent_table).attr('dimension-1'),
								dimension_2 = jQuery(parent_table).attr('dimension-2'),
								
								//Find the tr or class of media query type from the table element
								tr_media_query_type = jQuery(parent_table).find('.media_query_type')[0],
								
								//Find the user agent select element
								select_user_agent = jQuery(parent_table).find('.css_browser_user_agent')[0],
								
								//Find the css media query select element
								select_media_query = jQuery(parent_table).find('.css_media_query')[0],
								
								//Define selected index(es)
								select_user_agent_index = jQuery(select_user_agent)[0]['selectedIndex'],
								select_media_query_index = jQuery(select_media_query)[0]['selectedIndex'],
								
								//Find the parent tr element from the two hidden dimension fields
								tr_dimension_element = jQuery(parent_table).find('.media_query_hidden_input')[0],
								
								//Find the parent tr element for the default diemnsions
								tr_dimension_default_element = jQuery(parent_table).find('.default_dimensions')[0],
								
								//Find the css code textarea element
								tr_css_code_element = jQuery(parent_table).find('.css_code_entry')[0],
								textarea_css_code = jQuery(parent_table).find('.css_media_code_cmq_entry')[0],
								
								//Find the edit and delete button tr element
								tr_edit_delete_element = jQuery(parent_table).find('.edit_delete_media_query')[0],
								
								//Find the update and cancel button tr element
								tr_update_cancel_element = jQuery(parent_table).find('.update_cancel_media_query')[0];
								
							/* ################################################## End of defining variable elements ###################################################### */
							
							//Show the tr element for the textarea
							jQuery(tr_media_query_type).show();
							
							//Show the textarea tr element
							jQuery(tr_css_code_element).show();
							
							//Initialize CodeMiror instance for each target textarea element in the DOM HTML
							jQuery(document).each(function(){
								
								//Create codemirror instance
								var cmq_edit = CodeMirror.fromTextArea(jQuery(textarea_css_code)[0], {
									mode: "text/css",
									theme: "ambiance",
									lineNumbers: true,
									matchBrackets: true,
									autoRefresh: true,
									autoCloseBrackets: true,
									styleActiveLine: true,
									selectionPointer: true,
									gutters: ["CodeMirror-lint-markers"],
									lint: true
								});

								//Store the codemirror instance for use in reset function
								jQuery(jQuery(textarea_css_code)[0]).data('CodeMirrorInstance', cmq_edit);
								
								//Pass the css code element
								get_each_code_mirror_instance( jQuery(textarea_css_code)[0] );
								
								//Save value to the textarea to serialize for Ajax
								cmq_edit.save();
								
								//Get change event and then place the scroll info to a hidden field
								cmq_edit.on('change', function(){
									
									//Save value to the textarea to serialize for Ajax
									cmq_edit.save();
									
								});
							
							});
							
							//Run function for expanding CodeMirror instances in th CSS Options section. A delay timeout is necessary so that the codemirror can be loaded first-hand
							setTimeout(expand_collapse_codemirror(e.target), 100);
							
							//Run function and pass the button element and textarea element for the search script on each CSS Media Query CodeMirror entries
							search_each_codemirror(e.target, textarea_css_code);
							
							//Define function to get each css code element and then define codemirror instance for each css code textarea elements
							function get_each_code_mirror_instance( each_cm_element ) {
								each_cm_instance = jQuery(each_cm_element).data('CodeMirrorInstance');
								each_css_code_val = jQuery(each_cm_element).val();
							}
							
							//Remove the parent tr element for the dimension fields when editing
							jQuery(tr_dimension_element).remove();
							
							//Enable the select elements
							jQuery( select_user_agent ).removeAttr('disabled');
							jQuery( select_media_query ).removeAttr('disabled');
							
							//Define the select value from the media query
							css_media_type = jQuery( jQuery(parent_table).find('.css_media_query')[0] ).val();
							css_media_type_val = css_media_type;
							
							//Define if media query values are in loop of entries or not
							looped_fields = true;
							
							//Init media type and pass the media query data name
							render_fields_media_val( media_query_data_name, css_media_type, looped_fields, tr_media_query_type, css_media_type_val, dimension_1, dimension_2 );
							
							//Run the function again on change event
							jQuery( select_media_query ).on('change', function(){
								
								//Get the new field value
								css_media_type = jQuery(this).val();
								
								//Find the class(es) from the table element
								var media_type_dimensions_element = jQuery(parent_table).find('.media_type_dimensions')[0];
								
								//Rwemove the elements that was added due to the change event
								jQuery( media_type_dimensions_element ).remove();
								
								//Run the function again
								render_fields_media_val( media_query_data_name, css_media_type, looped_fields, tr_media_query_type, css_media_type_val, dimension_1, dimension_2 );
								
							});
							
							//Show and hide tr elements containing the buttons
							jQuery(tr_edit_delete_element).hide();
							jQuery(tr_dimension_default_element).hide();
							jQuery(tr_update_cancel_element).show();
							
							//Begin event handler for the cancel button
							jQuery( jQuery(parent_table).find('.cancel_media_query')[0] ).off('click').on('click', function(c){
								
								//Unpropagate cancel button
								c.preventDefault();
								
								//Reset select fields and hidden dimension fields to cancel editing
								reset_media_query_entry( parent_table, tr_media_query_type, tr_dimension_element, select_user_agent, select_media_query, select_user_agent_index, select_media_query_index, tr_css_code_element, each_cm_instance, each_css_code_val );
								
								//Show and hide tr elements containing the buttons
								jQuery(tr_edit_delete_element).show();
								jQuery(tr_dimension_default_element).show();
								jQuery(tr_update_cancel_element).hide();
								
								//Hide the textarea tr element
								jQuery(tr_css_code_element).hide();
								
							});
							
						}
						
					});
					
					//For expanding CodeMirror instances in the CSS Media Query section
					function expand_collapse_codemirror(button_element) {
						
						var table_element = "",
							codemirror_element = "",
							expand_btn_element = "";
						
						//Get table elements
						if( jQuery(button_element).is('button#css_media_add_btn') ) {
							table_element = jQuery(jQuery(jQuery(button_element).parents()[1]).find('#css_media_new_wrapper')[0]).find('table')[0];
						}
						
						if( jQuery(button_element).is('button.edit_media_query') ) {
							table_element = jQuery(button_element).parents()[3];
						}
						
						//Get the CodeMirror and Expand button elements
						codemirror_element = jQuery(table_element).find('.CodeMirror')[0];
						expand_btn_element = jQuery(table_element).find('.xb_expand_collapse_btn')[0];
						
						//Perform toggle function
						jQuery(expand_btn_element).off('click').toggle(function(e){
							e.preventDefault();
							css_options_width = jQuery('#xbrowser-css-overrides').width();
							jQuery( codemirror_element ).animate({
								'width' : css_options_width / 1.9,
								'height' : '600px'
							});
						},function(e){
							e.preventDefault();
							jQuery( codemirror_element ).animate({
								'width' : '390px',
								'height' : '400px'
							});
						});
						
					}
					
					//Define the search function for each CodeMirror instances
					function search_each_codemirror(button_element, textarea_css_code){
						
						if( jQuery(button_element).is('button.edit_media_query') ) {
							
							//Get search button element and CodeMirror instances
							var search_btn_element = jQuery(jQuery(button_element).parents()[4]).find('.xb_css_media_entry_search_wrapper a')[0],
								cm_instance = jQuery(textarea_css_code).data('CodeMirrorInstance');
							
							//Initiate search event by executing the find command on click
							jQuery(search_btn_element).off('click').on('click', function(s){
								s.preventDefault();
								cm_instance.execCommand("find");
							});
							
						}
						
					}
					
					//Define the media type function
					function render_fields_media_val( media_query_data_name, css_media_type, looped_fields, tr_media_query_type, css_media_type_val, dimension_1, dimension_2 ) {
						if( parseInt(css_media_type) == 1 ) {
							if( !looped_fields ) {
								jQuery('#media_query_type').after('<tr id="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							} else {
								jQuery( tr_media_query_type ).after('<tr class="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 1) ? dimension_1 : '') + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							}
						}else if( parseInt(css_media_type) == 2 ) {
							if( !looped_fields ) {
								jQuery('#media_query_type').after('<tr id="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (max-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							} else {
								jQuery( tr_media_query_type ).after('<tr class="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (max-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 2) ? dimension_1 : '') + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							}
						}else if( parseInt(css_media_type) == 3 ) {
							if( !looped_fields ) {
								jQuery('#media_query_type').after('<tr id="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							} else {
								jQuery( tr_media_query_type ).after('<tr class="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 3) ? dimension_1 : '') + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							}
						}else if( parseInt(css_media_type) == 4 ) {
							if( !looped_fields ) {
								jQuery('#media_query_type').after('<tr id="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (max-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							} else {
								jQuery( tr_media_query_type ).after('<tr class="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (max-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 4) ? dimension_1 : '') + '"/> <b>px)</b><input type="hidden" name="'+ media_query_data_name + '" value="1"/></td></tr>');
							}
						}else if( parseInt(css_media_type) == 5 ) {
							if( !looped_fields ) {
								jQuery('#media_query_type').after('<tr id="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '"/> <b>px) and</b> (<b>max-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '"/> <b>px)</b></td></tr>');
							} else {
								jQuery( tr_media_query_type ).after('<tr class="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 5) ? dimension_1 : '') + '"/> <b>px) and</b> (<b>max-width:</b> <input placeholder="xxxx" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 5) ? dimension_2 : '') + '"/> <b>px)</b></td></tr>');
							}
						}else {
							if( !looped_fields ) {
								jQuery('#media_query_type').after('<tr id="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '"/> <b>px) and</b> (<b>max-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '"/> <b>px)</b></td></tr>');
							} else {
								jQuery( tr_media_query_type ).after('<tr class="media_type_dimensions"><td><label>Dimensions:</label></td><td class="field_dimensions"><b>@media (min-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 6) ? dimension_1 : '') + '"/> <b>px) and</b> (<b>max-height:</b> <input placeholder="yyyy" name="'+ media_query_data_name + '" value="' + ((parseInt(css_media_type_val) == 6) ? dimension_2 : '') + '"/> <b>px)</b></td></tr>');
							}
						}
					}
					
					//Define reset function for each media query entries
					function reset_media_query_entry( parent_table, tr_media_query_type, tr_dimension_element, select_user_agent, select_media_query, select_user_agent_index, select_media_query_index, tr_css_code_element, each_cm_instance, each_css_code_val ) {
						
						//Hide the tr element for the textarea
						jQuery(tr_media_query_type).hide();
						
						//Render back the diemnsion fields tr element
						jQuery(tr_media_query_type).after(tr_dimension_element);
						
						//Get the parent element td from the select elements and remove the select elements to cancel editing
						var td_parent_user_agent = jQuery( jQuery(select_user_agent).parent()[0] ).html(''),
							td_parent_media_query = jQuery( jQuery(select_media_query).parent()[0] ).html(''),
							
							//Find the class(es) from the table element
							media_type_dimensions_element = jQuery(parent_table).find('.media_type_dimensions')[0];
						
						//Place back the default select elements
						jQuery(td_parent_user_agent[0]).append(select_user_agent);
						jQuery(td_parent_media_query[0]).append(select_media_query);
						
						//Reset the select index(es)
						jQuery(select_user_agent).prop('selectedIndex', select_user_agent_index);
						jQuery(select_media_query).prop('selectedIndex', select_media_query_index);
						
						//Disable the select attributes
						jQuery( select_user_agent ).attr('disabled', 'disabled');
						jQuery( select_media_query ).attr('disabled', 'disabled');
						
						//Rwemove the elements that was added due to the change event
						jQuery( media_type_dimensions_element ).remove();
						
						//Remove CodeMirror from DOM completely
						jQuery(jQuery(tr_css_code_element).find('.CodeMirror')[0]).remove();
						
						//Set each default CodeMirror values
						each_cm_instance.setValue(each_css_code_val);
						
					}
					
					//Cancel button for Add form
					jQuery('#cancel_media_query').off('click').on('click', function(e){
						
						//Unpropagate submit event on click
						e.preventDefault();
						
						//Run reset function for add form
						reset_media_type_val();
						
					});
					
					//Define reset function for the add form
					function reset_media_type_val() {
						
						//Slide and hide the form
						jQuery('#css_media_add_form').slideUp('slow');
						
						//Rwemove the elements that was added due to the change event
						jQuery('#media_type_dimensions').remove();
						
						//Re-enable click event
						jQuery('#css_media_add_btn').removeAttr('disabled');
						
						//Get the codemirror instance
						var cm_css_code = jQuery('#css_media_code_cmq').data('CodeMirrorInstance');
						
						//Clear the codemirror values and history
						cm_css_code.setValue("");
						cm_css_code.clearHistory();
						
						//Reset select tags
						jQuery('#css_browser_user_agent').prop('selectedIndex', 0);
						jQuery('#css_media_query').prop('selectedIndex', 0);
						
						media_query_data_name = "";
						css_media_type = "1";
						render_fields_media_val( media_query_data_name );
						
						jQuery('#media_type_dimensions').remove();
						
						//Remove error info
						jQuery('#css_media_query_info_error').remove();
						
						//Remove success info
						jQuery('#css_media_query_info_success').remove();
						
						//Reset exapanded CodeMirror textarea
						jQuery('#css_media_new_wrapper .CodeMirror').css({
							'width' : '390px',
							'height' : '400px',
						});
						
					}
				
				}
		
			jQuery(document).ready(function(){
				
				//Had to do it this way to avoid unwanted click event error
				setTimeout(function(){
					//Initialize the css media query script
					init_css_media_query();
				}, 100);
				
			});
		</script>
	<?php
}

//Define Ajax saving on CSS Media Query section
function css_media_query_ajax_script(){
	?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			
			//For adding new css media query
			jQuery('#css_media_add_form').submit(function(e){
				
				e.preventDefault();
				
				//Disable the add button element
				jQuery('#css_media_query_add_btn').attr('disabled', 'disabled');
				jQuery('#css_media_query_add_btn').removeClass('button-primary');
				jQuery('#css_media_query_add_btn').val('Adding CSS Media Query Entry...');
				
				//Show ajax loader img
				jQuery('#ajax_load_img').show();
				
				var form = jQuery('#css_media_add_form').serialize();
				
				//Remove error info
				jQuery('#css_media_query_info_error').remove();
				jQuery('#css_media_query_info_success').remove();
				
				jQuery.ajax({
					url:'<?php echo admin_url("admin-ajax.php"); ?>',
					type:'POST',
					dataType: "json",
					data:'action=css_media_query_ajax&'+ form,
					error:function(data_1){
						if(data_1.statusText == 'error') {
							jQuery('#ajax_load_img').after('<span class="xb_reactivate_error"><span>Error:</span> Ajax could not connect to server!</span>');
						}
					},
					success:function(data){
						
						//Un-comment this for debug
						//console.log( data );
						
						//Restore button element style
						jQuery('#css_media_query_add_btn').val('Add/Save CSS Media Query');
						jQuery('#css_media_query_add_btn').addClass('button-primary');
						jQuery('#css_media_query_add_btn').removeAttr('disabled');
						
						//Hide the ajax loader img
						jQuery('#ajax_load_img').hide();
						
						if( data['xb_ajax_css_media_query_add']['error_code'] ) {
							
							//Render info error message
							jQuery('#css_media_add_btn').before('<p id="css_media_query_info_error">' + data['xb_ajax_css_media_query_add']['error_string'] + '</p>');
							
							//Scroll to CSS Media Query section
							jQuery('body').scrollTop( jQuery('#xbrowser-css-overrides').offset().top - 40);
							
						}else {
							
							//######################### Start of Resetting elements #########################
								//Get the codemirror instance
								var cm_css_code = jQuery('#css_media_code_cmq').data('CodeMirrorInstance');
								
								//Clear the codemirror values and history
								cm_css_code.setValue("");
								cm_css_code.clearHistory();
								
								//Reset select tags
								jQuery('#css_browser_user_agent').prop('selectedIndex', 0);
								jQuery('#css_media_query').prop('selectedIndex', 0);
								
								//Reset field values
								jQuery('#media_type_dimensions').remove();
								
								//Hide and slide up the form
								jQuery('#css_media_add_form').slideUp('slow');
								
								jQuery('#css_media_query').val('1');
								
								//Re-enable click event
								jQuery('#css_media_add_btn').removeAttr('disabled');
								
								//Reset exapanded CodeMirror textarea
								jQuery('#css_media_new_wrapper .CodeMirror').css({
									'width' : '390px',
									'height' : '400px',
								});
								
							//######################### End of Resetting elements #########################
							
							//Pass the data and render entries
							css_media_entry_update_script(data);
							
							//Render info success message
							jQuery('#css_media_add_btn').before('<p id="css_media_query_info_success">CSS Media Query is Added!<span class="dashicons dashicons-yes"></span></p>');
							
							//Remove the info success message in fade out animation after 5 seconds.
							setTimeout(function() {
								jQuery('#css_media_query_info_success').fadeOut('slow', function(){
									jQuery(this).remove();
								});
							}, 5000);
							
							//Scroll to CSS Media Query section
							jQuery('body').scrollTop( jQuery('#xbrowser-css-overrides').offset().top - 40);
							
						}
						
					}
				});
			});
			
			//Define function for updating the css media entries. Defined this way to be used for the add entry ajax function
			css_media_update_ajax_script();
			function css_media_update_ajax_script(){
				
				//For updating css media query
				jQuery('.css_media_ud').each(function(e){
					
					//Get the hidden input element
					var p_error_info_element = jQuery( jQuery('.css_media_ud')[e] ).find('.css_media_query_info_error')[0],
						p_success_info_element = jQuery( jQuery('.css_media_ud')[e] ).find('.css_media_query_info_success')[0];
					
					//Define button elements for updating entries and add it to the click event
					jQuery( jQuery('.update_media_query')[e] ).off('click').on('click', function(d){
						
						d.preventDefault();
						
						jQuery('#xb_ajax_overlay_update').css('display', 'block');
						
						jQuery( jQuery('.css_media_ud')[e] ).off('submit').submit(function(d){
							
							d.preventDefault();
							
							var form = jQuery(this).serialize();
							
							jQuery.ajax({
								url:'<?php echo admin_url("admin-ajax.php"); ?>',
								type:'POST',
								dataType: "json",
								data:'action=css_media_query_ajax&'+ form + '&xb_css_media_options_update[entry]=update',
								error:function(data_1){
									if(data_1.statusText == 'error') {
										jQuery('#xb_ajax_overlay_update p').html('<span style="color: #fff000;">Error:</span> Ajax could not connect to server!');
										jQuery('#xb_ajax_overlay_update p').css({
											width: 'auto',
											maxWidth: '300px'
										});
									}
								},
								success:function(data){
									//console.log(data);
									
									if( data['xb_ajax_css_media_query_update']['error_code'] ) {
										
										//Render info error message
										jQuery(p_error_info_element).html(data['xb_ajax_css_media_query_update']['error_string']);
										jQuery(p_error_info_element).show();
										
										//Scroll to CSS Media Query section
										jQuery('body').scrollTop( jQuery( jQuery('.css_media_ud')[e] ).offset().top - 40);
										
										jQuery('#xb_ajax_overlay_update').css('display', 'none');
										
									}else {
										
										//Pass the data and render entries
										css_media_entry_update_script(data);
										
										//Render info success message
										jQuery('#xb_ajax_overlay_update p').hide();
										jQuery('#xb_ajax_overlay_update').append('<div id="save-popup-info">CSS Media Query Updated!<span class="dashicons dashicons-yes"></span></div>');
										jQuery('#save-popup-info').css({
											top: ( ( jQuery(window).height() / 2 ) - jQuery('#save-popup-info').height() - 50 ), 
											left: ( ( jQuery(window).width() / 2 ) - ( jQuery('#save-popup-info').width() / 2 ) - 30 )
										});
										setTimeout(function() {
											jQuery('#save-popup-info').fadeOut('fast', function(){
												jQuery('#xb_ajax_overlay_update').css('display', 'none');
												jQuery('#xb_ajax_overlay_update p').show();
											});
										}, 1500);
										setTimeout(function() {
											jQuery('#save-popup-info').remove();
										}, 2000);

									}
									
								}
							});
							
						});
						
						//Trigger submit on click
						jQuery( jQuery('.css_media_ud')[e] ).trigger('submit');
						
						//Disable the update button element
						jQuery(this).attr('disabled', 'disabled');
						
					});
					
					//Define button elements for deleting entries and add it to the click event
					jQuery( jQuery('.delete_media_query')[e] ).off('click').on('click', function(d){
						
						d.preventDefault();
						
						//Disable the delete button element
						jQuery(this).attr('disabled', 'disabled');
						
						//Pass the index number and target element
						popup_del_box(e, d);
						
						jQuery( jQuery('.css_media_ud')[e] ).off('submit').submit(function(d){
							
							d.preventDefault();
							
							var form = jQuery(this).serialize();
							
							jQuery.ajax({
								url:'<?php echo admin_url("admin-ajax.php"); ?>',
								type:'POST',
								dataType: "json",
								data:'action=css_media_query_ajax&'+ form + '&xb_css_media_options_update[entry]=delete',
								error:function(data_1){
									if(data_1.statusText == 'error') {
										jQuery('#xb_ajax_overlay_delete p').html('<span style="color: #fff000;">Error:</span> Ajax could not connect to server!');
										jQuery('#xb_ajax_overlay_delete p').css({
											width: 'auto',
											maxWidth: '300px'
										});
									}
								},
								success:function(data){
									
									//Pass the data and render entries
									css_media_entry_update_script(data);
									
									//Render info success message
									jQuery('#xb_ajax_overlay_delete p').hide();
									jQuery('#xb_ajax_overlay_delete').append('<div id="save-popup-info">CSS Media Query Deleted!<span class="dashicons dashicons-yes"></span></div>');
									jQuery('#save-popup-info').css({
										top: ( ( jQuery(window).height() / 2 ) - jQuery('#save-popup-info').height() - 50 ), 
										left: ( ( jQuery(window).width() / 2 ) - ( jQuery('#save-popup-info').width() / 2 ) - 30 )
									});
									setTimeout(function() {
										jQuery('#save-popup-info').fadeOut('fast', function(){
											jQuery('#xb_ajax_overlay_delete').css('display', 'none');
											jQuery('#xb_ajax_overlay_delete p').show();
										});
									}, 1500);
									setTimeout(function() {
										jQuery('#save-popup-info').remove();
									}, 2000);
									
								}
							});
							
						});
						
					});

				});
				
				//Define delete popup box
				function popup_del_box(e, d) {
					
					jQuery('body').append('\
						<div id="pop_up_del_box">\
							<div class="pop_del_wrapper">\
								<h5>Are you sure you want to delete this entry?</h5>\
								<p><b>Note:</b> The highlighted entry will be deleted.</p>\
								<button class="button-primary" value="yes">Yes</button>\
								<button class="cancel_delete" value="no">Cancel</button>\
							</div>\
						</div>\
					');
					
					jQuery('#pop_up_del_box button').off('click').on('click', function(b){
						
						b.preventDefault();
						
						if( jQuery(b.target).val() == 'yes') {
							
							//Show delete notif text
							jQuery('#xb_ajax_overlay_delete').css('display', 'block');
							
							//Trigger submit on click
							jQuery( jQuery('.css_media_ud')[e] ).trigger('submit');
							
							//Remove delete popup box
							jQuery('#pop_up_del_box').remove();
							
						}else {
							
							//Remove delete popup box
							jQuery('#pop_up_del_box').remove();
							
							//Remove the inline style when cancelling delete
							jQuery(jQuery(d.target).parent().parent().parent().parent().parent()[0]).removeAttr('style');
							
							//Enable the delete button again
							jQuery(d.target).removeAttr('disabled');
							
						}
						
					});
					
					//Highlight the target wrapper element prior to the triggered target delete element
					jQuery(jQuery(d.target).parent().parent().parent().parent().parent()[0]).css({
						border: '1px solid #ff6868',
						backgroundColor: '#ffe5e5'
					});
					
				}
				
			}
			
			function css_media_entry_update_script(data) {
			
				//Remove static entries
				jQuery('#media_query_entry_wrapper form').remove();
				
				//Render updated entries
				data['xb_ajax_media_query_entries'].forEach(data_elements);
				function data_elements( item, index ){
					
					jQuery('#media_query_entry_wrapper').append('\
					<form class="css_media_ud" action="" method="post">\
						<div class="media_query_div_entry">\
							<p class="css_media_query_info_error"></p>\
							<p class="css_media_query_info_success"></p>\
							<input class="css_media_index" type="hidden" name="xb_css_media_options_update[array_index]" value="' + index +'"/>\
							<table dimension-1="' + item['dimensions'][0] + '" dimension-2="' + item['dimensions'][1] + '">\
								<tr>\
									<td><label>Browser User Agent:</label></td>\
									<td>\
										<select class="css_browser_user_agent" disabled>\
											<option value="all" ' + ((item['user_agent'] == 'all') ? 'selected' : '') + '>All Browser User Agents</option>\
											<option value="chrome" ' + ((item['user_agent'] == 'chrome') ? 'selected' : '') + '>Chrome</option>\
											<option value="firefox" ' + ((item['user_agent'] == 'firefox') ? 'selected' : '') + '>Mozilla FireFox</option>\
											<option value="ie" ' + ((item['user_agent'] == 'ie') ? 'selected' : '') + '>Internet Explorer 8, 9, 10, 11, Edge</option>\
											<option value="edge" ' + ((item['user_agent'] == 'edge') ? 'selected' : '') + '>Microsoft Edge</option>\
											<option value="safari" ' + ((item['user_agent'] == 'safari') ? 'selected' : '') + '>Safari</option>\
										</select>\
									</td>\
								</tr>\
								<tr class="media_query_type">\
									<td><label>Media Query:</label></td>\
									<td>\
										<select class="css_media_query" disabled>\
											<option value="1" ' + ((item['media_query'] == '1') ? 'selected' : '') + '>@media (min-width: [xxxx]px)</option>\
											<option value="2" ' + ((item['media_query'] == '2') ? 'selected' : '') + '>@media (max-width: [xxxx]px)</option>\
											<option value="3" ' + ((item['media_query'] == '3') ? 'selected' : '') + '>@media (min-height: [yyyy]px)</option>\
											<option value="4" ' + ((item['media_query'] == '4') ? 'selected' : '') + '>@media (max-height: [yyyy]px)</option>\
											<option value="5" ' + ((item['media_query'] == '5') ? 'selected' : '') + '>@media (min-width: [xxxx]px) and (max-width: [xxxx]px)</option>\
											<option value="6" ' + ((item['media_query'] == '6') ? 'selected' : '') + '>@media (min-height: [yyyy]px) and (max-height: [yyyy]px)</option>\
										</select>\
									</td>\
								</tr>\
								<tr class="media_query_hidden_input">\
									<td><input type="hidden" value="' + item['dimensions'][0] + '"/></td>\
									<td><input type="hidden" value="' + item['dimensions'][1] + '"/></td>\
								</tr>\
								<tr class="default_dimensions">\
									<td><label>Dimensions:</label></td>\
									<td>\
										<p class="info_dimensions_default">\
										' + ((item['media_query'] == '1') ? '@media (min-width: <span>' + item['dimensions'][0] + 'px</span>)' : '') + '\
										' + ((item['media_query'] == '2') ? '@media (max-width: <span>' + item['dimensions'][0] + 'px</span>)' : '') + '\
										' + ((item['media_query'] == '3') ? '@media (min-height: <span>' + item['dimensions'][0] + 'px</span>)' : '') + '\
										' + ((item['media_query'] == '4') ? '@media (max-height: <span>' + item['dimensions'][0] + 'px</span>)' : '') + '\
										' + ((item['media_query'] == '5') ? '@media (min-width: <span>' + item['dimensions'][0] + 'px</span>) and (max-width: <span>' + item['dimensions'][1] + 'px</span>)' : '') + '\
										' + ((item['media_query'] == '6') ? '@media (min-height: <span>' + item['dimensions'][0] + 'px</span>) and (max-height: <span>' + item['dimensions'][1] + 'px</span>)' : '') + '\
										</p>\
									</td>\
								</tr>\
								<tr class="css_code_entry">\
									<td><label>Custom CSS Code:</label></td>\
									<td>\
										<div class="xb_css_media_entry_search_wrapper">\
											<a class="xb_search_btn" href="#">Click to Search</a>\
										</div>\
										<textarea id="css_media_code_cmq_entry' + index + '" class="css_media_code_cmq_entry">' + (item['css_code'].replace(/\\/g, '')) +'</textarea>\
									<a class="xb_expand_collapse_btn" href="#">Click to Expand / Collapse</a>\
									<div style="clear: both;"></div>\
									</td>\
								</tr>\
								<tr class="edit_delete_media_query">\
									<td></td>\
									<td>\
										<button class="edit_media_query">Edit</button>\
										<button class="delete_media_query">Delete</button>\
									</td>\
								</tr>\
								<tr class="update_cancel_media_query">\
									<td></td>\
									<td>\
										<button class="update_media_query button-primary">Update</button>\
										<button class="cancel_media_query">Cancel</button>\
									</td>\
								</tr>\
							</table>\
						</div>\
					</form>\
					');
				}
				
				//Initialize the css media query script again because of the new entries set via Ajax
				init_css_media_query();
				
				//Reload the script again due to new elements added via Ajax
				css_media_update_ajax_script();
			}
			
		});
		</script>
	<?php
}

//Define Ajax saving on Header and Footer Script section
function header_footer_ajax_script(){
	
	?>
		<script type="text/javascript">
		jQuery(document).ready(function(){
			
			jQuery('#header_footer_form').submit(function(e){
				
				e.preventDefault();
				
				//Disable the submit button
				jQuery('#hf_submit_btn').attr('disabled', 'disabled');
				jQuery('#xb_blocked_request').remove();
				
				jQuery('#xb_ajax_overlay_save').css('display', 'block');
				
				var form = jQuery('#header_footer_form').serialize();
				
				jQuery.ajax({
					url:'<?php echo admin_url("admin-ajax.php"); ?>',
					type:'POST',
					dataType: "json",
					data:'action=header_footer_ajax&'+ form,
					statusCode: {
						403: function(data){
							jQuery('#xb_ajax_overlay_save').hide();
							jQuery('#hf_submit_btn').after('\
								<span id="xb_blocked_request" style="font-style: italic; color: #ff0000; font-size: 14px; position: relative; top: 5px; margin-left: 10px;">Error: 403 Forbidden! The request was interrupted! Please resolve the issue and try saving again!</span>\
							');
							jQuery('#hf_submit_btn').removeAttr('disabled');
						}
					},
					error:function(data_1){
						if(data_1.statusText == 'error') {
							jQuery('#xb_ajax_overlay_save p').html('<span style="color: #fff000;">Error:</span> Ajax could not connect to server!');
							jQuery('#xb_ajax_overlay_save p').css({
								width: 'auto',
								maxWidth: '300px'
							});
						}
					},
					success:function(data){
						
						//Uncomment for debug
						//console.log(data['xb_ajax_post_array']);
						
						//Enable the submit button
						jQuery('#hf_submit_btn').removeAttr('disabled');
						
						//Remove the blocked messages due to 403 error when doing ajax request
						jQuery('#xb_blocked_request').remove();
						
						jQuery('#xb_ajax_overlay_save p').hide();
						jQuery('#xb_ajax_overlay_save').append('<div id="save-popup-info">Scripts are Saved!<span class="dashicons dashicons-yes"></span></div>');
						jQuery('#save-popup-info').css({
							top: ( ( jQuery(window).height() / 2 ) - jQuery('#save-popup-info').height() - 30 ), 
							left: ( ( jQuery(window).width() / 2 ) - ( jQuery('#save-popup-info').width() / 2 ) - 30 )
						});
						setTimeout(function() {
							jQuery('#save-popup-info').fadeOut('fast', function(){
								jQuery('#xb_ajax_overlay_save').css('display', 'none');
								jQuery('#xb_ajax_overlay_save p').show();
							});
						}, 1500);
						setTimeout(function() {
							jQuery('#save-popup-info').remove();
						}, 2000);
						
					}
				});
			});
			
		});
		</script>
	<?php
}