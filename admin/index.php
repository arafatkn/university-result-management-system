<?php

	include 'init.php';

	$site->title  = $site->name.' :: Admin Area'; //Edit Homepage Title
	
	include 'header.php';
	
	echo '
<div class="panel panel-primary">
	<div class="panel-heading">Admin Area</div>
	<div class="panel-body" style="padding: 2px;"><div class="list-group">
		<a href="student.php" class="list-group-item list-group-item-danger"> &#187; Manage Students</a>
		<a href="course.php" class="list-group-item list-group-item-info"> &#187; Manage Courses</a>
		<a href="addresult.php" class="list-group-item list-group-item-danger"> &#187; Add/Edit Result</a>
		<a href="'.$site->url.'" class="list-group-item list-group-item-warning"> &#187; View Results</a>
	</div></div>
</div>';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">Account Functions</div>
	<div class="panel-body" style="padding: 2px;"><div class="list-group">
		<a href="changepass.php" class="list-group-item list-group-item-danger"> &#187; Change Password</a>
		<a href="logout.php" class="list-group-item list-group-item-info"> &#187; Log Out</a>
	</div></div>
</div>';

	include 'footer.php';
?>
