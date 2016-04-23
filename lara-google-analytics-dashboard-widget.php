<?php

/*
Plugin Name: Lara, Google Analytics Dashboard Widget
Plugin URI: https://www.whmcsadmintheme.com
Description: Full width Google Analytics dashboard widget for Wordpress admin interface, which also inserts latest Google Analytics tracking code to your pages.
Version: 1.0.2
Author: Amr M. Ibrahim
Author URI: https://www.whmcsadmintheme.com
License: GPL2
*/

define ("lrgawidget_plugin_version", "1.0.2");
define ("lrgawidget_plugin_scripts_version", "12");
define ("lrgawidget_plugin_prefiex", "lrgalite-");
define ("lrgawidget_plugin_dist_dir", plugin_dir_url( __FILE__ ).'dist/');
define ("lrgawidget_plugin_plugins_dir", plugin_dir_url( __FILE__ ).'dist/plugins/');

global $wpdb;
define ("lrgawidget_plugin_table", $wpdb->base_prefix . 'lrgawidget_global_settings');

register_activation_hook(__FILE__,'lrgawidget_activate');
register_uninstall_hook(__FILE__, 'lrgawidget_uninstall' );
add_action( 'admin_enqueue_scripts', 'lrgawidget_enqueue',1000 );
add_action( 'wp_ajax_lrgawidget_hideShowWidget', 'lrgawidget_callback' );
add_action( 'wp_ajax_lrgawidget_getAuthURL', 'lrgawidget_callback' );
add_action( 'wp_ajax_lrgawidget_getAccessToken', 'lrgawidget_callback' );
add_action( 'wp_ajax_lrgawidget_getProfiles', 'lrgawidget_callback' );
add_action( 'wp_ajax_lrgawidget_setProfileID', 'lrgawidget_callback' );
add_action( 'wp_ajax_lrgawidget_settingsReset', 'lrgawidget_callback' );
add_action( 'wp_ajax_lrgawidget_getSessions', 'lrgawidget_callback' );
add_action( 'wp_head', 'lrgawidget_ga_code');

function lrgawidget_enqueue($hook) {
    if ( 'index.php' != $hook ) {
        return;
    }
	$user_id = get_current_user_id();
	$wstate = get_user_option( 'lrgawidget_hideShowWidget', $user_id );	
	
	if ($wstate !== "hide"){

		wp_enqueue_style( lrgawidget_plugin_prefiex.'bootstrap-custom', lrgawidget_plugin_plugins_dir.'bootstrap/bootstrap.custom.min.css' ,array(),lrgawidget_plugin_scripts_version);
		wp_enqueue_style( lrgawidget_plugin_prefiex.'fontawesome', lrgawidget_plugin_plugins_dir.'font-awesome/css/font-awesome.min.css' ,array(),lrgawidget_plugin_scripts_version);
		wp_enqueue_style( lrgawidget_plugin_prefiex.'fuelux', lrgawidget_plugin_plugins_dir.'fuelux/fuelux.min.css'  ,array(),lrgawidget_plugin_scripts_version);
		wp_enqueue_style( lrgawidget_plugin_prefiex.'colorbox', lrgawidget_plugin_plugins_dir.'colorbox/colorbox.css'  ,array(),lrgawidget_plugin_scripts_version);
		wp_enqueue_style( lrgawidget_plugin_prefiex.'lrgawidget', plugin_dir_url( __FILE__ ).'dist/css/lrgawidget.css'  ,array(),lrgawidget_plugin_scripts_version);
		
		wp_dequeue_script( 'jquery-flot' );
		wp_deregister_script('jquery-flot');
		
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( lrgawidget_plugin_prefiex.'bootstrap', lrgawidget_plugin_plugins_dir.'bootstrap/bootstrap.min.js'  ,array('jquery'),lrgawidget_plugin_scripts_version);
		wp_enqueue_script( lrgawidget_plugin_prefiex.'fuelux', lrgawidget_plugin_plugins_dir.'fuelux/wizard.min.js' ,array('jquery'),lrgawidget_plugin_scripts_version);	
		wp_enqueue_script( lrgawidget_plugin_prefiex.'flot', lrgawidget_plugin_plugins_dir.'flot/jquery.flot.min.js' ,array('jquery'),lrgawidget_plugin_scripts_version);	
		wp_enqueue_script( lrgawidget_plugin_prefiex.'flot-time', lrgawidget_plugin_plugins_dir.'flot/jquery.flot.time.min.js' ,array('jquery'),lrgawidget_plugin_scripts_version);	
		wp_enqueue_script( lrgawidget_plugin_prefiex.'sparkline', lrgawidget_plugin_plugins_dir.'sparkline/sparkline.min.js' ,array('jquery'),lrgawidget_plugin_scripts_version);
		wp_enqueue_script( lrgawidget_plugin_prefiex.'moment', lrgawidget_plugin_plugins_dir.'daterangepicker/moment.min.js' ,array('jquery'),lrgawidget_plugin_scripts_version);
		wp_enqueue_script( lrgawidget_plugin_prefiex.'colorbox', lrgawidget_plugin_plugins_dir.'colorbox/jquery.colorbox-min.js' ,array('jquery'),lrgawidget_plugin_scripts_version);		
		wp_enqueue_script( lrgawidget_plugin_prefiex.'main', plugin_dir_url( __FILE__ ).'dist/js/lrgawidget.js' ,array('jquery'),lrgawidget_plugin_scripts_version);	
		wp_localize_script( lrgawidget_plugin_prefiex.'main', 'lrgawidget_ajax_object', array( 'lrgawidget_ajax_url' => admin_url( 'admin-ajax.php' ) ));	
		
		add_action( 'admin_notices', 'lrga_welcome_panel' );
	}else{
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( lrgawidget_plugin_prefiex.'main', plugin_dir_url( __FILE__ ).'dist/js/lrgawidget_control.js' ,array('jquery'),lrgawidget_plugin_scripts_version);
		wp_localize_script( lrgawidget_plugin_prefiex.'main', 'lrgawidget_ajax_object', array( 'lrgawidget_ajax_url' => admin_url( 'admin-ajax.php' ) ));
	}
}



function lrgawidget_internal_permissions(){
	$parray = array();
	$globalWidgetPermissions = array("lrgawidget_perm_admin",
									 "lrgawidget_perm_sessions",
									 "lrgawidget_perm_promo");	 
	$parray["widgets"] = $globalWidgetPermissions;
	return $parray;
}

function lrgawidget_callback() {
	global $wpdb;
	$user_id = get_current_user_id();
	$lrperm = lrgawidget_internal_permissions();
	$lrdata = $_POST;
	$modifiedAction = explode("_", $lrdata['action']);
	$lrdata['action'] = $modifiedAction[1];

	if ($lrdata['action'] == "setProfileID"){
		if ( (isset($lrdata['enable_universal_tracking'])) && !empty($lrdata['property_id'])){
			update_option('lrgawidget_property_id', $lrdata['property_id']);
		}else{
			delete_option('lrgawidget_property_id');
		}
	}
	if ($lrdata['action'] == "settingsReset"){
		delete_option('lrgawidget_property_id');
	}
	
	if ($lrdata['action'] == "hideShowWidget"){
		update_user_option( $user_id, 'lrgawidget_hideShowWidget', $lrdata['wstate'] );
		lrgawidget_jsonOutput();
	};
	
	
	require (dirname(__FILE__).'/core/lrgawidget.handler.php');
}

function lrgawidget_jsonOutput(){
	header('Content-Type: application/json');
	$output['status'] = "done";
	echo json_encode($output);	
	exit();
}

function lrga_welcome_panel() {
	$actLrgaTabs= array(); 
	$lrperm = lrgawidget_internal_permissions();
	$globalWidgetPermissions = $lrperm['widgets']; 
	require_once (dirname(__FILE__).'/widgets/lrgawidget.php');
}
 
function lrgawidget_ga_code(){
	$lrgawidget_property_id = get_option('lrgawidget_property_id',"");
	if (!is_admin() &&  !empty($lrgawidget_property_id) ) {
?>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $lrgawidget_property_id ?>', 'auto');
  ga('send', 'pageview');

</script>	
<?php
	}
	
} 

function lrgawidget_activate() {
   	global $wpdb;
	$sql = "CREATE TABLE IF NOT EXISTS `".lrgawidget_plugin_table."` (`id` int(10) NOT NULL AUTO_INCREMENT, `name` TEXT NOT NULL, `value` TEXT NOT NULL, PRIMARY KEY (`id`))";
	$wpdb->query($sql);
}


function lrgawidget_uninstall() {
   	global $wpdb;
	$sql = "DROP TABLE `".lrgawidget_plugin_table."`";
	$wpdb->query($sql);
	delete_option('lrgawidget_property_id');
}

?>