<?php
/**
* Plugin Name: xBrowser Compatibility
* Plugin URI: https://virson.wordpress.com/
* Description: Cross-Browser and Mobile Compatibility plugin that allows custom CSS coding on different Viewport Resolutions and Browser User Agents. Also includes handy tools like: Equalizing Container Height, Custom Header and Footer scripts and Collapsed Mobile navigation menu.
* Version: 1.4.1
* Author: Virson Ebillo
*/

//Load Wordpress core get_plugins function if it was not loaded
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

//Check if Autoptimize plugin is activated
if( is_plugin_active('autoptimize/autoptimize.php') ) {
	
	//Exclude the following jquery libraries
	add_filter('autoptimize_filter_js_exclude','autoptimize_override_jsexclude',10,1);
	function autoptimize_override_jsexclude($exclude) {
		return $exclude.", jquery-1.12.4.min.js, jquery-2.2.4.min.js, jquery-3.1.0.min.js";
	}
	
}

//Define DB Query
global $wpdb;
$table = $wpdb->base_prefix . 'options';

//Define collapsed menu defaults
$plugin_query_cm_row = $wpdb->get_results("SELECT * from $table where option_name like '%wjmc_hide_mobile_submenu%'", OBJECT);
foreach($plugin_query_cm_row as $option_name) { $plugin_option_cm = $option_name->option_name; }

//Define Ajax saving defaults
$plugin_query_ajax_row = $wpdb->get_results("SELECT * from $table where option_name like '%wjmc_ajax_saving_mode%'", OBJECT);
foreach($plugin_query_ajax_row as $option_name) { $plugin_option_ajax = $option_name->option_name; }

//Define constants
define('XB_PLUGIN_VERSION', get_plugins( '/xbrowser-compatibility' )['xbrowser-compatibility.php']['Version']);
define('XB_PLUGIN_HOST_FILE', 'https://dl.dropboxusercontent.com/u/90662976/WP%20Plugins/xBrowser/version-host/xb_version.txt');
define('XB_PLUGIN_VERSION_DB', get_option('wjmc_host_version'));
define('XB_PLUGIN_CHANGELOG_HOST', 'https://dl.dropboxusercontent.com/u/90662976/WP%20Plugins/xBrowser/version-host/xb_changelog.txt');
define('XB_CM_SUBMENU_OPTION', get_option('wjmc_hide_mobile_submenu'));
define('XB_CM_SUBMENU_OPTION_ROW', $plugin_option_cm);
define('XB_AJAX_SAVING_MODE_ROW', $plugin_option_ajax);
define('XB_AJAX_SAVING_MODE', get_option('wjmc_ajax_saving_mode'));
define('XB_CURRENT_PAGE', $_GET['page']);
define('XB_PLUGIN_DIR_URL', preg_replace('/\s+/', '', plugin_dir_url(__FILE__)));
define('XB_PLUGIN_DIR_PATH', preg_replace('/\s+/', '', plugin_dir_path(__FILE__)));
define('XB_FOLDER_IS_WRITABLE', wp_is_writable(XB_PLUGIN_DIR_PATH));
define('XB_PLUGINS_FOLDER_IS_WRITABLE', wp_is_writable( ABSPATH . "wp-content/plugins/" ));

/* ---------------------- xBrowser Cron Jobs ------------------------- */
//Begin plugin activation hook
register_activation_hook(__FILE__, 'xb_activation');

function xb_activation() {
	
	//Read file with read and write permissions
	$handle = fopen( XB_PLUGIN_DIR_PATH . 'version.txt', 'w+' );
	
	//Write the version string to the file
	fwrite( $handle, XB_PLUGIN_VERSION);
	
	//Closes the file that was opened.
	fclose( $handle );
	
	//Set initial time to 3,600 seconds (1 hour)
	update_option('xb_schedule_event', time() + 3600);
	
	//Get plugin version content from external source (Dropbox)
	update_option('xb_host_version', @file_get_contents( XB_PLUGIN_HOST_FILE ));
	
}

//Begin plugin deactivation hook
register_deactivation_hook(__FILE__, 'xb_deactivation');
function xb_deactivation() {
	
	//For the old xBrowser Cron Job
	wp_clear_scheduled_hook('xb_schedule_event');
	
	//Delete option on deactivate
	delete_option('xb_schedule_event');
	
}

//Load function first-hand on each visit to Wordpress admin pages
add_action('init', 'xb_run_event');
function xb_run_event() {
	
	//Begin checking
	if(get_option('xb_schedule_event')) {
		if(time() > intval(get_option('xb_schedule_event'))) {
			
			//Get plugin version content from external source (Dropbox)
			update_option('xb_host_version', @file_get_contents( XB_PLUGIN_HOST_FILE ));
			
			//Store the new timestamp again with an additional 3,600 seconds (1 hour)
			update_option('xb_schedule_event', time() + 3600);
		}
	}
	
}

add_action('admin_head', 'xb_version_checker');
function xb_version_checker() {
	
	//Had to do it this way because doing the empty() function on a constant will result in a T_PAAMAYIM_NEKUDOTAYIM or double colon (::) error in PHP
	$xb_plugin_version_db = XB_PLUGIN_VERSION_DB;

	if( !empty( $xb_plugin_version_db ) ) {
		
		//String version num to Int version num
		$host_version = explode('.', XB_PLUGIN_VERSION_DB);
		$host_version = intval( implode('', $host_version) );
		
		//String version num to Int version num
		$xb_plugin_version = explode('.', XB_PLUGIN_VERSION);
		$xb_plugin_version = intval( implode('', $xb_plugin_version) );
		
		if( $xb_plugin_version < $host_version ) {
			
			echo "
			<script type='text/javascript'>
			jQuery(document).ready(function(){
				var update_html = jQuery('#xb_update_notif');
				jQuery('#xb_update_notif').remove();
				jQuery('.wrap').prepend(update_html);
			});
			</script>
			<div id='xb_update_notif' class='update-nag'>
				<span style='font-weight: 600;'>xBrowser version <span style='color: #F44336;'>" . XB_PLUGIN_VERSION_DB . "</span> is now available (<span style='color: #F44336;'>Click <a href='" . XB_PLUGIN_CHANGELOG_HOST . "' target='_blank'>here</a> to view the change log</span>).</span>
			</div>
			";
			
		}
		
	}
	
}
/* ---------------------- End of xBrowser Cron Jobs ------------------------- */

//Include action links on the plugins page
add_filter( 'plugin_action_links', 'xbrowser_action_links', 10, 5 );
function xbrowser_action_links( $actions, $plugin_file ) {
	
	static $plugin;
	
	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);
	
	if ($plugin == $plugin_file) {

			$css_options = array('css_options' => '<a href="admin.php?page=xbrowser-compatibility">' . __('CSS Options', 'xBrowser') . '</a>');
			$equalize_settings = array('equalize_settings' => '<a href="admin.php?page=xbrowser-equalize-settings">' . __('Equalize', 'xBrowser') . '</a>');
			$header_footer_settings = array('header_footer_settings' => '<a href="admin.php?page=xbrowser-header-footer-settings">' . __('Header and Footer', 'xBrowser') . '</a>');
			$settings = array('settings' => '<a href="admin.php?page=xbrowser-compatibility-settings">' . __('Settings', 'xBrowser') . '</a>');
			
			$actions = array_merge($settings, $actions);
			$actions = array_merge($header_footer_settings, $actions);
			$actions = array_merge($equalize_settings, $actions);
			$actions = array_merge($css_options, $actions);
			
		}
	return $actions;
	
}

//Require the Function Scripts
require('includes/function-scripts.php');

//Begin loading specific Scripts/CSS at the main plugin page
if (XB_CURRENT_PAGE == 'xbrowser-compatibility') {

	//Load Admin CSS
	add_action('admin_footer', 'xbrowser_admin_css');
	
	//Load Admin JS
	add_action('admin_footer', 'xbrowser_admin_js');
	
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) == 0 ) {
		//Load Code Mirror Library
		add_action('admin_head', 'load_code_mirror_lib');
	}
	
	if(XB_AJAX_SAVING_MODE == 'on' || XB_AJAX_SAVING_MODE_ROW == null) {
		//Load Ajax script on CSS Options section
		add_action('admin_head', 'css_options_ajax_script');
		
		//Load Ajax script on CSS Media Query section
		add_action('admin_head', 'css_media_query_ajax_script');
	}
	
	//Load CSS Media Query JS
	add_action('admin_footer', 'css_media_query');
	
}

//Begin loading specific Scripts/CSS at the equalize settings plugin page
if (XB_CURRENT_PAGE == 'xbrowser-header-footer-settings') {

	//Load Admin CSS
	add_action('admin_footer', 'xbrowser_admin_css');
	
	//Load Admin JS
	add_action('admin_footer', 'xbrowser_admin_js');
	
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) == 0 ) {
		//Load Code Mirror Library
		add_action('admin_head', 'load_code_mirror_lib');
	}
	
	if(XB_AJAX_SAVING_MODE == 'on' || XB_AJAX_SAVING_MODE_ROW == null) {
		//Load Ajax script on Header and Footer Script section
		add_action('admin_head', 'header_footer_ajax_script');
	}

}

//Begin loading specific Scripts/CSS at the header and footer settings plugin page
if (XB_CURRENT_PAGE == 'xbrowser-equalize-settings') {

	//Load Admin CSS
	add_action('admin_footer', 'xbrowser_admin_css');
	
	//Load Admin JS
	add_action('admin_footer', 'xbrowser_admin_js');
	
	if( strcasecmp(get_option('wjmc_plugin_reactivate'), XB_PLUGIN_VERSION) == 0 ) {
		//Load Code Mirror Library
		add_action('admin_head', 'load_code_mirror_lib');
	}

}

//Begin loading specific Scripts/CSS at the jquery lib settings plugin page
if (XB_CURRENT_PAGE == 'xbrowser-global-jquery-lib-settings') {

	//Load Admin CSS
	add_action('admin_footer', 'xbrowser_admin_css');

}

//Begin loading specific Scripts/CSS at the plugin admin settings page
if (XB_CURRENT_PAGE == 'xbrowser-compatibility-settings') {

	//Load Admin CSS
	add_action('admin_footer', 'xbrowser_admin_css');
	
	//Load Admin JS
	add_action('admin_footer', 'xbrowser_admin_js');

}

/* ############################################## Start of Ajax Action Hooks ############################################### */

//Define Ajax xBrowser Reactivate
function xb_reactivate() {
	
	if($_POST['xb_reactivate'] == 1) {
		deactivate_plugins( 'xbrowser-compatibility/xbrowser-compatibility.php' );
		activate_plugin( 'xbrowser-compatibility/xbrowser-compatibility.php' );
		update_option('wjmc_plugin_reactivate', XB_PLUGIN_VERSION);
		$xbr_json['xb_reactivate'] = true;
	}
	
	print_r( json_encode($xbr_json) );
	exit;
	
}

//Load ajax action hook for reactivation module
add_action('wp_ajax_xb_reactivate_ajax', 'xb_reactivate');

//Define Ajax script on CSS Options section
function css_options_php() {
	
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
	
	$post_data['xb_ajax_post_array'] = $_POST;
	print_r( json_encode($post_data) );
	exit;
	
}

//Load ajax action hook for CSS Options Section
add_action('wp_ajax_css_options_ajax', 'css_options_php');

//Define Ajax script on CSS Media Query section
function css_media_query_php(){
	
	if($_POST['xb_css_media_options_add']) {
		
		$data_add = $_POST['xb_css_media_options_add'];
		
		if( empty($data_add['dimensions'][0]) ) {
			$post_data['xb_ajax_css_media_query_add']['error_string'] .= "Dimension fields must not be empty!";
			$post_data['xb_ajax_css_media_query_add']['error_code'] = true;
		}elseif( empty($data_add['dimensions'][1]) ) {
			$post_data['xb_ajax_css_media_query_add']['error_string'] .= "Dimension fields must not be empty!";
			$post_data['xb_ajax_css_media_query_add']['error_code'] = true;
		}elseif( empty($data_add['css_code']) ) {
			$post_data['xb_ajax_css_media_query_add']['error_string'] .= "CSS Code must not be empty!";
			$post_data['xb_ajax_css_media_query_add']['error_code'] = true;
		}elseif( !ctype_digit($data_add['dimensions'][0]) ) {
			$post_data['xb_ajax_css_media_query_add']['error_string'] .= "Only integer numbers are allowed for the dimension fields!";
			$post_data['xb_ajax_css_media_query_add']['error_code'] = true;
		}elseif( !ctype_digit($data_add['dimensions'][1]) ) {
			$post_data['xb_ajax_css_media_query_add']['error_string'] .= "Only integer numbers are allowed for the dimension fields!";
			$post_data['xb_ajax_css_media_query_add']['error_code'] = true;
		}
		else {
			
			//Perform quick check in the database entry
			if( get_option('xb_media_query') ) {
				$array_post = get_option('xb_media_query');
			}
			else {
				$array_post = array();
			}
			
			//Place the new media query entry to the database array
			array_push($array_post, $data_add);
			
			function sort_by_dimensions($x, $y) {
				
				//Get maximum values from the dimensions array
				$x = max($x['dimensions']);
				$y = max($y['dimensions']);
				
				//Define the comparison operator
				return $y - $x;
				
			}
			
			//Sort arrays based on the given comparison operator
			usort($array_post, 'sort_by_dimensions');
			
			//Finally save it to the database
			update_option('xb_media_query', $array_post);
			
			//Get option and pass to json for error checks
			$post_data['xb_ajax_css_media_query_add'] = get_option('xb_media_query');
			
			//Pass the sorted array via json
			$post_data['xb_ajax_media_query_entries'] = get_option('xb_media_query');
			
		}
	}
	
	if( $_POST['xb_css_media_options_update']['entry'] == 'update' ) {
		
		$data_update = $_POST['xb_css_media_options_update'];
		
		if( empty($data_update['dimensions'][0]) ) {
			$post_data['xb_ajax_css_media_query_update']['error_string'] .= "Dimension fields must not be empty!";
			$post_data['xb_ajax_css_media_query_update']['error_code'] = true;
		}elseif( empty($data_update['dimensions'][1]) ) {
			$post_data['xb_ajax_css_media_query_update']['error_string'] .= "Dimension fields must not be empty!";
			$post_data['xb_ajax_css_media_query_update']['error_code'] = true;
		}elseif( empty($data_update['css_code']) ) {
			$post_data['xb_ajax_css_media_query_update']['error_string'] .= "CSS Code must not be empty!";
			$post_data['xb_ajax_css_media_query_update']['error_code'] = true;
		}elseif( !ctype_digit($data_update['dimensions'][0]) ) {
			$post_data['xb_ajax_css_media_query_update']['error_string'] .= "Only integer numbers are allowed for the dimension fields!";
			$post_data['xb_ajax_css_media_query_update']['error_code'] = true;
		}elseif( !ctype_digit($data_update['dimensions'][1]) ) {
			$post_data['xb_ajax_css_media_query_update']['error_string'] .= "Only integer numbers are allowed for the dimension fields!";
			$post_data['xb_ajax_css_media_query_update']['error_code'] = true;
		}
		else {
		
			//Get the array options
			$array_options = get_option('xb_media_query');
			
			//Update the portion of an array
			array_splice( $array_options, $data_update['array_index'], 1, $_POST);
			
			//Get the index of the action name that must not be included in the array
			$junk_item_index = array_search('css_media_query_ajax', $array_options);
			
			//Delete the action name from the array
			unset($array_options[$junk_item_index]);
			
			function sort_by_dimensions($x, $y) {
				
				//Get maximum values from the dimensions array
				$x = max($x['dimensions']);
				$y = max($y['dimensions']);
				
				//Define the comparison operator
				return $y - $x;
				
			}
			
			//Sort arrays based on the given comparison operator
			usort($array_options, 'sort_by_dimensions');
			
			//Finally save it to the database
			update_option('xb_media_query', $array_options);
			
			//Get option and pass to json for error checks
			$post_data['xb_ajax_css_media_query_update'] = get_option('xb_media_query');
			
			//Pass the updated data array via json
			$post_data['xb_ajax_media_query_entries'] = get_option('xb_media_query');
			
		}
		
	}
	
	if( $_POST['xb_css_media_options_update']['entry'] == 'delete' ) {
		
		$data_index = $_POST['xb_css_media_options_update']['array_index'];
		
		//Get the array options
		$array_options = get_option('xb_media_query');
		
		//Delete the item from array options by index
		unset($array_options[$data_index]);
		
		//Arrange keys of the array due to the unset method and save it to the database
		update_option('xb_media_query', array_values($array_options));
		
		//Pass the updated data array via json
		$post_data['xb_ajax_media_query_entries'] = get_option('xb_media_query');
		
	}
	
	print_r( json_encode($post_data) );
	exit;
	
}

//Load ajax action hook for CSS Media Query Section
add_action('wp_ajax_css_media_query_ajax', 'css_media_query_php');

//Define Ajax script on Header and Footer Script section
function header_footer_script_php() {
	
	if( $_POST['header_footer_script'] ) {
		update_option('wjmc_header_footer', $_POST['header_footer_script']);
	}
	
	$post_data['xb_ajax_post_array'] = $_POST;
	print_r( json_encode($post_data) );
	exit;
	
}

//Load ajax action hook for CSS Options Section
add_action('wp_ajax_header_footer_ajax', 'header_footer_script_php');

/* ############################################## End of Ajax Action Hooks ############################################### */

//Begin Global Debug Mode
debug_mode();
if($debug_mode == 'on') {
	add_action('admin_head', 'error_report');
}

//Load front-end header script (Header and Footer Script)
add_action('wp_head', 'xbrowser_header_script', 0);
function xbrowser_header_script() {
	require('jquery-lib/jquery-lib.php');
	require('includes/front-end-scripts/header-script-render.php');
}

//Load front-end JS
if(XB_CM_SUBMENU_OPTION == 'on' || XB_CM_SUBMENU_OPTION_ROW == null) {
	
	add_action('wp_footer', 'xbrowser_collapsed_menu_script');
	function xbrowser_collapsed_menu_script(){
		require('includes/front-end-scripts/collapsed-menu-script.php');
	}
	
}

//Load front-end footer scripts
add_action('wp_footer', 'xb_wp_footer_scripts', 99);
function xb_wp_footer_scripts() {
	
	//Load front-end CSS
	require('includes/front-end-scripts/front-end-css.php');
	
	//Load front-end script for equalize container height ( had to do it separately from the collapsed sub-menu feature. :\ )
	require('includes/front-end-scripts/equalize-script.php');
	
	//Load front-end special equalize script
	require('includes/front-end-scripts/special-equalize-script.php');
	
	//Load front-end footer script (Header and Footer Script)
	require('includes/front-end-scripts/footer-script-render.php');
	
}

//Load Wordpress built-in dashicons for collapsed menu icons
add_action('wp_enqueue_scripts', 'xb_wordpress_dash_icons');
function xb_wordpress_dash_icons(){
	wp_enqueue_style( 'dashicons' );
}

//Setup Menu pages
add_action('admin_menu', 'xb_menu_pages');
function xb_menu_pages() {
	
	//Require the plugin files
	require('includes/x-browser.php');
	require('includes/equalize-settings.php');
	require('includes/header-footer-settings.php');
	require('includes/jquery-lib-settings.php');
	require('includes/settings.php');
	
	add_menu_page('xBrowser Compatibility', 'xBrowser', 'administrator', 'xbrowser-compatibility', 'main_xbrowser_options', XB_PLUGIN_DIR_URL . 'img/xb-icon.png', 61);
	add_submenu_page('xbrowser-compatibility', 'xBrowser CSS Options', 'CSS Options', 'administrator', 'xbrowser-compatibility');
	add_submenu_page( 'xbrowser-compatibility', 'xBrowser Equalize Height Settings', 'Equalize Height', 'administrator', 'xbrowser-equalize-settings', 'xb_equalize_settings' );
	add_submenu_page( 'xbrowser-compatibility', 'xBrowser Header and Footer Settings', 'Header and Footer', 'administrator', 'xbrowser-header-footer-settings', 'xb_header_footer_settings' );
	add_submenu_page( 'xbrowser-compatibility', 'xBrowser Global jQuery Lib', 'Global jQuery Lib', 'administrator', 'xbrowser-global-jquery-lib-settings', 'xb_global_jquery_lib_settings' );
	add_submenu_page( 'xbrowser-compatibility', 'xBrowser Settings', 'Settings', 'administrator', 'xbrowser-compatibility-settings', 'xb_settings' );
	
}