<?php
	
	$lp=1;
	include "init.php";
	if($admin->is_admin()){
		redir($site->aurl);
		exit;
	}
	$site->title  = "Log In to System";
	include 'header.php';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">Log In</div>
	<div class="panel-body" style="padding: 5px;">';
	
	if( issetMulti($_POST,array("username","password")) )
	{
	
		$user = post("username");
		$pass = post("password");
		
		$errors=array();
		
		if(empty($user) OR strlen($user)<1) $errors[] = "Username is empty";
		if(empty($pass) OR strlen($pass)<1) $errors[] = "Password is empty";
		if(!$admin->login($user,$pass)) $errors[] = "Wrong Username or Password";
		
		
		if(empty($errors))
		{
			$id = $admin->gdata("id",array("username"=>$user));
			$_SESSION["adminid"]=$id;
			redir($site->aurl);
		}
		else {
			showErrors($errors);
		}
	}
	
	$form->show("post","",
		array(
			array("multiText",
				array("username","Username")
			),
			array("multiPass",
				array("password","Password")
			)
		)
	);


	echo '
	</div>
</div';
	
	include 'footer.php';
	
?>
		