<?php

namespace Lara;
use Lara\Widgets\GoogleAnalytics as GoogleAnalytics;
use Lara\Utils\Common            as Common;

/**
 * @package    Lara, Google Analytics Dashboard Widget
 * @author     Amr M. Ibrahim <mailamr@gmail.com>
 * @link       https://www.whmcsadmintheme.com
 * @copyright  Copyright (c) WHMCSAdminTheme 2016
 */

if (!defined("ABSPATH"))
    die("This file cannot be accessed directly");

require("exception.class.php");

if (isset($lrdata['action']) && !empty($lrperm)){
	
	require("callURL.class.php");
	require("storage.class.php");
	require("GoogleAnalyticsAPI.class.php");
	require("lrgawidget.class.php");


	$call = new GoogleAnalytics\lrgawidget();

	$call->setDateRange(date('Y-m-d', strtotime('-1 month')), date('Y-m-d'));
	if (in_array("lrgawidget_perm_admin", $lrperm["widgets"])){
	    Common\ErrorHandler::setDebugMode(true);
	}
 	
	switch ($lrdata['action']) {
		case "getAuthURL":
			if (in_array("lrgawidget_perm_admin", $lrperm["widgets"])){$call->getAuthURL(trim($lrdata['client_id']), trim($lrdata['client_secret']));}
			else{ Common\ErrorHandler::FatalError("You don't have permission to access this tab!");}		
			break;	
		case "getAccessToken":
			if (in_array("lrgawidget_perm_admin", $lrperm["widgets"])){$call->getAccessToken(trim($lrdata['client_id']), trim($lrdata['client_secret']), trim($lrdata['code']));}
			else{ Common\ErrorHandler::FatalError("You don't have permission to access this tab!");}		
			break;	
		case "getProfiles":
			if (in_array("lrgawidget_perm_admin", $lrperm["widgets"])){$call->getProfiles();}
			else{ Common\ErrorHandler::FatalError("You don't have permission to access this tab!");}		
			break;
		case "setProfileID":
			if (in_array("lrgawidget_perm_admin", $lrperm["widgets"])){ $call->setProfileID($lrdata['account_id'],$lrdata['property_id'],$lrdata['profile_id']);}
			else{ Common\ErrorHandler::FatalError("You don't have permission to access this tab!");}			
			break;	
		case "settingsReset":
			if (in_array("lrgawidget_perm_admin", $lrperm["widgets"])){ $call->settingsReset();}
			else{ Common\ErrorHandler::FatalError("You don't have permission to reset data!");}			
			break;			
		case "getSessions":
			if (in_array("lrgawidget_perm_sessions", $lrperm["widgets"])){$call->getSessions();}
			else{ Common\ErrorHandler::FatalError("You don't have permission to access this tab!");}
			break;
		default:
		    exit;
	} 
}else{ Common\ErrorHandler::FatalError("Fatal :: Invalid Call!");}

?>