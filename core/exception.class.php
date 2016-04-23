<?php

namespace Lara\Utils\Common;

/**
 * @package    Lara, Google Analytics Dashboard Widget
 * @author     Amr M. Ibrahim <mailamr@gmail.com>
 * @link       https://www.whmcsadmintheme.com
 * @copyright  Copyright (c) WHMCSAdminTheme 2016
 */

if (!defined("ABSPATH"))
    die("This file cannot be accessed directly");

class ErrorHandler {
  private static $errors;
  private static $debugMode = false;
  
  public static function FatalError( $error, $error_description = null, $code = null , $debug = array() ) {
	  self::$errors["error"] = $error;
	  self::$errors["error_description"] = $error_description;
	  self::$errors["code"] = $code;
	  if (self::$debugMode){
		  self::$errors["debug"] = $debug;
	  }
	  header('Content-Type: application/json'); 
	  echo json_encode(self::$errors, JSON_FORCE_OBJECT);
	  exit();	  
  }
  
  public static function setDebugMode($debugMode){
      self::$debugMode = $debugMode;
  }  
}

?>