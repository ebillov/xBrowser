<?php
function xb_css_options_main_script() {
	
?>
	<script type='text/javascript'>
	var cmr = jQuery.noConflict();
	function init_code_mirror () {
		
		var chrome_event = CodeMirror.fromTextArea(document.getElementById('chrome'), {
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
		
		//Execute search input on click
		cmr('#search_chrome').off('click').on('click', function(e){
			e.preventDefault();
			chrome_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		chrome_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		chrome_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			chrome_event.save();
			
			var chrome_event_array = chrome_event.getScrollInfo();
			jQuery('#chrome_event').val( chrome_event_array['left'] + ',' + chrome_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['chrome_event'] ):
		$chrome_scroll_cor = explode(',', $_SESSION['chrome_event']);
		?>
		function chrome_scroll(){
			chrome_event.scrollTo(<?php if( $chrome_scroll_cor[0] ){ echo $chrome_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $chrome_scroll_cor[1] ){ echo $chrome_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(chrome_scroll, 300);
		<?php endif; ?>
		
		
		var firefox_event = CodeMirror.fromTextArea(document.getElementById('firefox'), {
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
		
		//Execute search input on click
		cmr('#search_firefox').off('click').on('click', function(e){
			e.preventDefault();
			firefox_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		firefox_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		firefox_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			firefox_event.save();
			
			var firefox_event_array = firefox_event.getScrollInfo();
			jQuery('#firefox_event').val( firefox_event_array['left'] + ',' + firefox_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['firefox_event'] ):
		$firefox_scroll_cor = explode(',', $_SESSION['firefox_event']);
		?>
		function firefox_scroll(){
			firefox_event.scrollTo(<?php if( $firefox_scroll_cor[0] ){ echo $firefox_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $firefox_scroll_cor[1] ){ echo $firefox_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(firefox_scroll, 300);
		<?php endif; ?>
		
		var ie_event = CodeMirror.fromTextArea(document.getElementById('internet_explorer'), {
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
		
		//Execute search input on click
		cmr('#search_ie').off('click').on('click', function(e){
			e.preventDefault();
			ie_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		ie_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		ie_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			ie_event.save();
			
			var ie_event_array = ie_event.getScrollInfo();
			jQuery('#ie_event').val( ie_event_array['left'] + ',' + ie_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['ie_event'] ):
		$ie_scroll_cor = explode(',', $_SESSION['ie_event']);
		?>
		function ie_scroll(){
			ie_event.scrollTo(<?php if( $ie_scroll_cor[0] ){ echo $ie_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $ie_scroll_cor[1] ){ echo $ie_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(ie_scroll, 300);
		<?php endif; ?>
		
		var edge_event = CodeMirror.fromTextArea(document.getElementById('microsoft_edge'), {
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
		
		//Execute search input on click
		cmr('#search_edge').off('click').on('click', function(e){
			e.preventDefault();
			edge_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		edge_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		edge_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			edge_event.save();
			
			var edge_event_array = edge_event.getScrollInfo();
			jQuery('#edge_event').val( edge_event_array['left'] + ',' + edge_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['edge_event'] ):
		$edge_scroll_cor = explode(',', $_SESSION['edge_event']);
		?>
		function edge_scroll(){
			edge_event.scrollTo(<?php if( $edge_scroll_cor[0] ){ echo $edge_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $edge_scroll_cor[1] ){ echo $edge_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(edge_scroll, 300);
		<?php endif; ?>
		
		var safari_event = CodeMirror.fromTextArea(document.getElementById('safari'), {
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
		
		//Execute search input on click
		cmr('#search_safari').off('click').on('click', function(e){
			e.preventDefault();
			safari_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		safari_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		safari_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			safari_event.save();
			
			var safari_event_array = safari_event.getScrollInfo();
			jQuery('#safari_event').val( safari_event_array['left'] + ',' + safari_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['safari_event'] ):
		$safari_scroll_cor = explode(',', $_SESSION['safari_event']);
		?>
		function safari_scroll(){
			safari_event.scrollTo(<?php if( $safari_scroll_cor[0] ){ echo $safari_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $safari_scroll_cor[1] ){ echo $safari_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(safari_scroll, 300);
		<?php endif; ?>
		
		var general_event = CodeMirror.fromTextArea(document.getElementById('general'), {
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
		
		//Execute search input on click
		cmr('#search_general').off('click').on('click', function(e){
			e.preventDefault();
			general_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		general_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		general_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			general_event.save();
			
			var general_event_array = general_event.getScrollInfo();
			jQuery('#general_event').val( general_event_array['left'] + ',' + general_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['general_event'] ):
		$general_scroll_cor = explode(',', $_SESSION['general_event']);
		?>
		function general_scroll(){
			general_event.scrollTo(<?php if( $general_scroll_cor[0] ){ echo $general_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $general_scroll_cor[1] ){ echo $general_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(general_scroll, 300);
		<?php endif; ?>
		
		/*var extra_large_event = CodeMirror.fromTextArea(document.getElementById('extra_large'), {
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
		
		//Get change event and then place the scroll info to a hidden field
		extra_large_event.on('change', function(){
			var extra_large_event_array = extra_large_event.getScrollInfo();
			jQuery('#extra_large_event').val( extra_large_event_array['left'] + ',' + extra_large_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['extra_large_event'] ):
		$extra_large_scroll_cor = explode(',', $_SESSION['extra_large_event']);
		?>
		function extra_large_scroll(){
			extra_large_event.scrollTo(<?php if( $extra_large_scroll_cor[0] ){ echo $extra_large_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $extra_large_scroll_cor[1] ){ echo $extra_large_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(extra_large_scroll, 300);
		<?php endif; ?>
		
		var large_1_event = CodeMirror.fromTextArea(document.getElementById('large_1'), {
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
		
		//Get change event and then place the scroll info to a hidden field
		large_1_event.on('change', function(){
			var large_1_event_array = large_1_event.getScrollInfo();
			jQuery('#large_1_event').val( large_1_event_array['left'] + ',' + large_1_event_array['top'] );
		});*/
		
		<?php
		//Get the event session
		if( $_SESSION['large_1_event'] ):
		$large_1_scroll_cor = explode(',', $_SESSION['large_1_event']);
		?>
		function large_1_scroll(){
			large_1_event.scrollTo(<?php if( $large_1_scroll_cor[0] ){ echo $large_1_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $large_1_scroll_cor[1] ){ echo $large_1_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(large_1_scroll, 300);
		<?php endif; ?>
		
		var large_event = CodeMirror.fromTextArea(document.getElementById('large'), {
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
		
		//Execute search input on click
		cmr('#search_large').off('click').on('click', function(e){
			e.preventDefault();
			large_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		large_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		large_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			large_event.save();
			
			var large_event_array = large_event.getScrollInfo();
			jQuery('#large_event').val( large_event_array['left'] + ',' + large_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['large_event'] ):
		$large_scroll_cor = explode(',', $_SESSION['large_event']);
		?>
		function large_scroll(){
			large_event.scrollTo(<?php if( $large_scroll_cor[0] ){ echo $large_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $large_scroll_cor[1] ){ echo $large_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(large_scroll, 300);
		<?php endif; ?>
		
		var medium_event = CodeMirror.fromTextArea(document.getElementById('medium'), {
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
		
		//Execute search input on click
		cmr('#search_medium').off('click').on('click', function(e){
			e.preventDefault();
			medium_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		medium_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		medium_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			medium_event.save();
			
			var medium_event_array = medium_event.getScrollInfo();
			jQuery('#medium_event').val( medium_event_array['left'] + ',' + medium_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['medium_event'] ):
		$medium_scroll_cor = explode(',', $_SESSION['medium_event']);
		?>
		function medium_scroll(){
			medium_event.scrollTo(<?php if( $medium_scroll_cor[0] ){ echo $medium_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $medium_scroll_cor[1] ){ echo $medium_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(medium_scroll, 300);
		<?php endif; ?>
		
		var small_event = CodeMirror.fromTextArea(document.getElementById('small'), {
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
		
		//Execute search input on click
		cmr('#search_small').off('click').on('click', function(e){
			e.preventDefault();
			small_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		small_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		small_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			small_event.save();
			
			var small_event_array = small_event.getScrollInfo();
			jQuery('#small_event').val( small_event_array['left'] + ',' + small_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['small_event'] ):
		$small_scroll_cor = explode(',', $_SESSION['small_event']);
		?>
		function small_scroll(){
			small_event.scrollTo(<?php if( $small_scroll_cor[0] ){ echo $small_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $small_scroll_cor[1] ){ echo $small_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(small_scroll, 300);
		<?php endif; ?>
		
		var generic_mobile_event = CodeMirror.fromTextArea(document.getElementById('generic_mobile'), {
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
		
		//Execute search input on click
		cmr('#search_generic_mobile').off('click').on('click', function(e){
			e.preventDefault();
			generic_mobile_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		generic_mobile_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		generic_mobile_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			generic_mobile_event.save();
			
			var generic_mobile_event_array = generic_mobile_event.getScrollInfo();
			jQuery('#generic_mobile_event').val( generic_mobile_event_array['left'] + ',' + generic_mobile_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['generic_mobile_event'] ):
		$generic_mobile_scroll_cor = explode(',', $_SESSION['generic_mobile_event']);
		?>
		function generic_mobile_scroll(){
			generic_mobile_event.scrollTo(<?php if( $generic_mobile_scroll_cor[0] ){ echo $generic_mobile_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $generic_mobile_scroll_cor[1] ){ echo $generic_mobile_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(generic_mobile_scroll, 300);
		<?php endif; ?>
		
		var ipad_event = CodeMirror.fromTextArea(document.getElementById('ipad'), {
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
		
		//Execute search input on click
		cmr('#search_ipad').off('click').on('click', function(e){
			e.preventDefault();
			ipad_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		ipad_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		ipad_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			ipad_event.save();
			
			var ipad_event_array = ipad_event.getScrollInfo();
			jQuery('#ipad_event').val( ipad_event_array['left'] + ',' + ipad_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['ipad_event'] ):
		$ipad_scroll_cor = explode(',', $_SESSION['ipad_event']);
		?>
		function ipad_scroll(){
			ipad_event.scrollTo(<?php if( $ipad_scroll_cor[0] ){ echo $ipad_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $ipad_scroll_cor[1] ){ echo $ipad_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(ipad_scroll, 300);
		<?php endif; ?>
		
		var nexus_event = CodeMirror.fromTextArea(document.getElementById('nexus'), {
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
		
		//Execute search input on click
		cmr('#search_nexus').off('click').on('click', function(e){
			e.preventDefault();
			nexus_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		nexus_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		nexus_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			nexus_event.save();
			
			var nexus_event_array = nexus_event.getScrollInfo();
			jQuery('#nexus_event').val( nexus_event_array['left'] + ',' + nexus_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['nexus_event'] ):
		$nexus_scroll_cor = explode(',', $_SESSION['nexus_event']);
		?>
		function nexus_scroll(){
			nexus_event.scrollTo(<?php if( $nexus_scroll_cor[0] ){ echo $nexus_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $nexus_scroll_cor[1] ){ echo $nexus_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(nexus_scroll, 300);
		<?php endif; ?>
		
		var ipod_event = CodeMirror.fromTextArea(document.getElementById('ipod'), {
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
		
		//Execute search input on click
		cmr('#search_ipod').off('click').on('click', function(e){
			e.preventDefault();
			ipod_event.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		ipod_event.save();
		
		//Get change event and then place the scroll info to a hidden field
		ipod_event.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			ipod_event.save();
			
			var ipod_event_array = ipod_event.getScrollInfo();
			jQuery('#ipod_event').val( ipod_event_array['left'] + ',' + ipod_event_array['top'] );
		});
		
		<?php
		//Get the event session
		if( $_SESSION['ipod_event'] ):
		$ipod_scroll_cor = explode(',', $_SESSION['ipod_event']);
		?>
		function ipod_scroll(){
			ipod_event.scrollTo(<?php if( $ipod_scroll_cor[0] ){ echo $ipod_scroll_cor[0]; } else { echo "null"; } ?>, <?php if( $ipod_scroll_cor[1] ){ echo $ipod_scroll_cor[1]; } else { echo "null"; } ?>);
		}
		setTimeout(ipod_scroll, 300);
		<?php endif; ?>
		
	}
	cmr(window).load(init_code_mirror);
	</script>
<?php
}

function xb_css_media_query_script(){
?>
	<script type='text/javascript'>
	var cmq = jQuery.noConflict();
	function load_codemirror_css_media_query() {
		
		//Create codemirror instance
		var add_new_cmq = CodeMirror.fromTextArea(document.getElementById('css_media_code_cmq'), {
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
		
		//Store the codemirror instance for use on the Ajax action call
		jQuery('#css_media_code_cmq').data('CodeMirrorInstance', add_new_cmq);
		
		//Save value to the textarea to serialize for Ajax
		add_new_cmq.save();
		
		//Get change event and then place the scroll info to a hidden field
		add_new_cmq.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			add_new_cmq.save();
			
		});
		
	}
	cmq(window).load(load_codemirror_css_media_query);
	</script>
<?php
}

function xb_equalize_settings_script() {
?>
	<script type='text/javascript'>
	var xb_eqs = jQuery.noConflict();
	function load_codemirror_equalize() {
		CodeMirror.fromTextArea(document.getElementById('equalize'), {
			mode: "text/css",
			theme: "ambiance",
			lineNumbers: true,
			matchBrackets: true,
			autoRefresh: true,
			autoCloseBrackets: true,
			styleActiveLine: true,
			selectionPointer: true
		});
	}
	xb_eqs(window).load(load_codemirror_equalize);
	</script>
<?php
}

function xb_header_footer_settings_script(){
?>
	<script type='text/javascript'>
	var xb_h_f = jQuery.noConflict();
	function load_codemirror_h_f() {
		
		var mixedMode = {
			name: "htmlmixed",
			scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i,
						   mode: null},
						  {matches: /(text|application)\/(x-)?vb(a|script)/i,
						   mode: "vbscript"}]
		};
		
		var header_script_instance = CodeMirror.fromTextArea(document.getElementById('head-script'), {
			mode: mixedMode,
			theme: "ambiance",
			lineNumbers: true,
			matchBrackets: true,
			autoRefresh: true,
			autoCloseBrackets: true,
			styleActiveLine: true,
			selectionPointer: true
			//gutters: ["CodeMirror-lint-markers"],
			//lint: true
		});
		
		//Execute search input on click
		xb_h_f('#search_header').off('click').on('click', function(e){
			e.preventDefault();
			header_script_instance.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		header_script_instance.save();
		
		//Get change event and then place the scroll info to a hidden field
		header_script_instance.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			header_script_instance.save();
			
		});
		
		var footer_script_instance = CodeMirror.fromTextArea(document.getElementById('footer-script'), {
			mode: mixedMode,
			theme: "ambiance",
			lineNumbers: true,
			matchBrackets: true,
			autoRefresh: true,
			autoCloseBrackets: true,
			styleActiveLine: true,
			selectionPointer: true
			//gutters: ["CodeMirror-lint-markers"],
			//lint: true
		});
		
		//Execute search input on click
		xb_h_f('#search_footer').off('click').on('click', function(e){
			e.preventDefault();
			footer_script_instance.execCommand("find");
		});
		
		//Save value to the textarea to serialize for Ajax
		footer_script_instance.save();
		
		//Get change event and then place the scroll info to a hidden field
		footer_script_instance.on('change', function(){
			
			//Save value to the textarea to serialize for Ajax
			footer_script_instance.save();
			
		});
		
	}
	xb_h_f(window).load(load_codemirror_h_f);
	</script>
<?php } ?>