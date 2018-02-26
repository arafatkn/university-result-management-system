<?php

	include "init.php";
	
	if($admin->logout())
	{
		$_SESSION["message"]="You have been Logged out successfully.";
		redir("login.php");
	}
	else
	{
		echo '<h4>Something is wrong. Contact with developer.</h4>';
	}
	
?>