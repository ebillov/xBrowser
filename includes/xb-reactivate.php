<script>
jQuery(document).ready(function(){
	
	jQuery('#xb_reactivate').off('submit').submit(function(e){
		
		//Unpropagate submit event
		e.preventDefault();
		
		//Disable Submit button
		jQuery('#xb_reactivate_submit').attr('disabled', 'disabled');
		
		//Show ajax loader img
		jQuery('#ajax_load_img').show();
		
		//Get the form and serialize it for json data transport
		var form = jQuery(this).serialize();
		
		//Perform DOM manipulation of the submit button
		jQuery('#xb_reactivate_submit').removeClass('button-primary');
		jQuery('#xb_reactivate_submit').removeClass('button');
		jQuery('#xb_reactivate_submit').css({
			backgroundColor: '#607D8B',
			color: '#ffffff',
			fontStyle: 'italic',
			border: '1px solid #3f5965',
			borderRadius: '3px'
		});
		jQuery('#xb_reactivate_submit').val('Reactivating... Please wait!');
		
		//Perform the ajax function
		jQuery.ajax({
			url:'<?php echo admin_url("admin-ajax.php"); ?>',
			type:'POST',
			dataType: "json",
			data:'action=xb_reactivate_ajax&'+ form,
			error:function(data_1){
				if(data_1.statusText == 'error') {
					jQuery('#ajax_load_img').after('<span class="xb_reactivate_error"><span>Error:</span> Ajax could not connect to server!</span>');
				}
			},
			success:function(data){
				if(data['xb_reactivate'] == true){
					
					//Hide ajax loader img
					jQuery('#ajax_load_img').hide();
					
					jQuery('#xb_reactivate_submit').css({
						backgroundColor: '#4caf50',
						border: '1px solid #3f9643'
					});
					
					//Define countdown when refreshing page
					var counter = 5,
						interval = setInterval(function(){
							
							counter = counter - 1;
							render_interval(counter);
							
							if(counter == 0) {
								clearInterval(interval);
								window.location.replace('<?php echo get_admin_url() . 'admin.php?page=' . XB_CURRENT_PAGE; ?>');
							}
						}, 1000);
					
					//Init render interval
					render_interval(counter);
					function render_interval(counter){
						jQuery('#xb_reactivate_submit').val('xBrowser plugin is Activated!... Refreshing in ' + counter + 's !');
					}
						
				}else {
					jQuery('.notice_upgrade b').html('Something went wrong. Please contact the Plugin Developer!');
					jQuery('.notice_upgrade').css('border-left:', '3px solid #F44336');
					//Enable Submit button
					jQuery('#xb_reactivate_submit').removeAttr('disabled');
				}
			}
		});
	
	});
	
});
</script>
<p class="notice_upgrade">The <span style="color: #ff0000; font-weight: 600;">xBrowser</span> plugin was <b>updated or installed</b> with the new version. <span style="color: #ff0000; font-weight: 600;">Please reactivate!</span></p>
<form id="xb_reactivate" action="" method="post">
	<input type="hidden" name="xb_reactivate" value="1"/>
	<input id="xb_reactivate_submit" class="button button-primary" type="submit" value="Reactivate xBrowser Plugin"/>
	<img id="ajax_load_img" src="<?php echo XB_PLUGIN_DIR_URL; ?>/img/ajax-loader.gif"/>
</form>