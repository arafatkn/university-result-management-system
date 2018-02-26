<?php

	//error_reporting(1);
	ob_start();
	session_start();
	date_default_timezone_set('Asia/Dhaka');

	define ('ROOTDIR',"C:/xampp/htdocs/result");
	
	include (ROOTDIR.'/includes/class.database.php');
	$db = new Database("localhost","root","","result_management");
    $db->query("set character_set_results='utf8'");
	$db->set_charset("utf8");
	
// Global Settings
	include (ROOTDIR.'/includes/info.php');
	include (ROOTDIR."/includes/functions.php");

	include (ROOTDIR.'/includes/class.admin.php');
	$admin = new Admin();
	if(!isset($lp) && !$admin->is_admin())
	{
		$_SESSION["message"]="You must log in first";
		redir("login.php");
		exit;
	}

	include (ROOTDIR.'/includes/class.result.php');
	$Result = new Result();

	include (ROOTDIR."/includes/class.BootstrapForm.php");
	$form = new BootstrapForm();
	
	$date=date("d-m-Y");
	$time = date("H:i:s A");
	$dt = $date.' '.$time;
	
	$init = true;
	
	$head = array();
	
?>