<?php
	include 'init.php';

	$site->title  = "Change Password";
	include 'header.php';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">Change Password</div>
	<div class="panel-body" style="padding: 5px;">';
	
	if( issetMulti($_POST,array("cpass","npass","npass2")) )
	{
	
		extract($_POST);
		
		$errors=array();
		
		if(empty($cpass) OR strlen($cpass)<1) $errors[] = "Current password is empty";
		if(empty($npass) OR strlen($npass)<1) $errors[] = "New Password is empty";
		if($npass!=$npass2) $errors[] = "Password Missmatch. Please try again.";
		if(empty($errors))
		{
			if(!$admin->login($admin->data("admin"),$cpass)) $errors[] = "Current password is wrong";
		}
		
		if(empty($errors))
		{
			$pass = password_hash($npass,PASSWORD_DEFAULT);
			$up = $db->update("admin",array("password"=>$pass),array("id"=>$admin->getId()));
			if($up)
			{
				if($admin->logout())
				{
					$_SESSION["message"]="Password has been change. Please log in again.";
					redir('login.php');
				}
				else
				{
					redir('logout.php');
				}
			}
			else
			{
				$errors[] = "Error in Database. Contact Developer. ".$db->link->error;
				showErrors($errors);
			}
		}
		else {
			showErrors($errors);
		}
	}
	
	$form->show("post","",
		array(
			array("multiPass",
				array("cpass","Current Password"),
				array("npass","New Password"),
				array("npass2","New Password Again")
			)
		)
	);


	echo '
	</div>
</div';


	include 'footer.php';
?>