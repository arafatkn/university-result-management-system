<?php

	include 'init.php';

	if(isset($_GET["act"]))
		$act = get("act");
	else
		$act="";

	if(isset($_GET["id"]))
	{
		$id=get("id");
		$sql = $db->select("course","",array("id"=>$id));
		if($sql->num_rows==1)
		{
			$course = $sql->fetch_assoc();
		}
		else
		{
			echo '<h3>Course Not Found</h3>';
			exit;
		}
	}
	if($act=="add") {
		$title  = "Add a new Course";
	}
	else if($act=="delete" && isset($id))
	{

		$error = array();
		
		if(empty($error))
		{
			$del = $db->delete("course",array("id"=>$id));
			if($del)
			{
				$_SESSION["message"] = $course["title"]." (".$course["code"].") has been Deleted Successfully.";
			}
			else
			{
				$_SESSION["message"] = "Error in Database. Can not delete course. ".$db->error;
			}
			redir("?");
		}
		else
		{
			echo 'Course <i>'.$course["title"].' ('.$course["code"].')</i> can not be deleted. Because-<br/>';
			showErrors($error);
		}

		exit;
	}
	else if($act=="edit" && isset($id)) {
		$title  = "Edit ".$course["title"]." (".$course["code"].")";
	}
	else {
		$title = "Manage Courses";
	}
	$site->title  = $title;
	include 'header.php';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">'.$title.'</div>
	<div class="panel-body" style="padding: 5px;">';

	if($act=="add")
	{
		extract($_POST);
		if(isset($code,$title,$year,$semester,$status,$credit))
		{
			$error = array();
			if(empty($code)) $error[] = "Course Code can not be empty";
			if(empty($title)) $error[] = "Course Title can not be empty";
			if(empty($credit)) $error[] = "Course Credit can not be empty";
			if(empty($year)) $error[] = "Please select Year";
			if(empty($semester)) $error[] = "Please select Semester";
			if(empty($status)) $error[] = "Please select Status";

			if(empty($error))
			{
				$up = $db->insert("course",array("code"=>$code,"title"=>$title,"credit"=>$credit,"year"=>$year,"semester"=>$semester,"status"=>$status));
				if($up)
				{
					$_SESSION["message"] = "<i>".$title." (".$code.")</i> has been added Successfully.";
				}
				else
				{
					$_SESSION["message"] = "Error in Database. Can not add Course. ".$db->error;
				}
				redir("?");
			}
			else
			{
				showErrors($error);
			}
		}

		$opyear = generate_year();
		$opsem = generate_semester();

		$opsts = array("ON", "OFF");
		$opsts2 = array("1", "0");

		$form->show("post","",
			array(
				array("multiText",
					array("code","Course Code"),
					array("title","Course Title"),
					array("credit","Course Credit")
				),
				array("multiSelect",
					array("year","Year",false,$opyear,""),
					array("semester","Semester",false,$opsem,""),
					array("status","Status",false,$opsts,$opsts2,1)
				)
			)
		);
	}
	else if($act=="edit")
	{
		extract($_POST);
		if(isset($code,$title,$credit,$year,$semester,$status))
		{
			$error = array();
			if(empty($code)) $error[] = "Course Code can not be empty";
			if(empty($title)) $error[] = "Course Title can not be empty";
			if(empty($credit)) $error[] = "Course Credit can not be empty";
			if(empty($year)) $error[] = "Please select Year";
			if(empty($semester)) $error[] = "Please select Semester";
			if(empty($status)) $error[] = "Please select Status";
			
			if(empty($error))
			{
				$up = $db->update("course",array("code"=>$code,"title"=>$title,"credit"=>$credit,"year"=>$year,"semester"=>$semester,"status"=>$status),array("id"=>$id));
				if($up)
				{
					$_SESSION["message"] = "<i>".$title." (".$code.")</i> has been edited Successfully.";
				}
				else
				{
					$_SESSION["message"] = "Error in Database. Can not edit Course. ".$db->error;
				}
				redir("?");
			}
			else
			{
				showErrors($error);
			}
		}

		$op = generate_year();
		$opyear = array(); $opyear2 = array();
		foreach ($op as $key => $value)
		{
			$opyear2[] = $key;
			$opyear[] = $value;
		}
		$op = generate_semester();
		$opsem = array(); $opsem2 = array();
		foreach ($op as $key => $value)
		{
			$opsem2[] = $key;
			$opsem[] = $value;
		}

		$opsts = array("OFF", "ON");
		$opsts2 = array("0", "1");

		$form->show("post","",
			array(
				array("multiText",
					array("code","Course Code",$course["code"]),
					array("title","Course Title",$course["title"]),
					array("credit","Course Credit",$course["credit"])
				),
				array("multiSelect",
					array("year","Year",false,$opyear,$opyear2,$course["year"]),
					array("semester","Semester",false,$opsem,$opsem2,$course["semester"]),
					array("status","Status",false,$opsts,$opsts2,$course["status"])
				)
			)
		);
	}

	else
	{
		echo '
		<div>
			<a href="?act=add" class="btn btn-primary" role="button">Add New Course</a>
		</div><br/>';

		$sql = $db->select("course","","","year,semester,code");
		if($sql->num_rows<1)
		{
			echo '<h4>No Course Found. Please <a href="?act=add">add a course</a> first.<h4>';
		}
		else
		{
			echo '
		<table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Course Code</th>
		        <th>Course Title</th>
		        <th>Course Credit</th>
		        <th>Year</th>
		        <th>Semester</th>
		        <th>Status</th>
		        <th>Edit</th>
		        <th>Delete</th>
		      </tr>
		    </thead>
		    <tbody>';
			while($result = $sql->fetch_assoc())
			{
				echo '
			  <tr>
		        <td>'.$result["code"].'</td>
		        <td>'.$result["title"].'</td>
		        <td>'.$result["credit"].'</td>
		        <td>'.$result["year"].'</td>
		        <td>'.$result["semester"].'</td>
		        <td>'.($result["status"]==1?'On':'Off').'</td>
		        <td><a href="?act=edit&id='.$result["id"].'" class="btn btn-sm btn-warning" role="button">Edit</a></td>
		        <td><button type="button" onclick="confirmation(\'Are You Sure Want to Delete?\',\'?act=delete&id='.$result["id"].'\')" class="btn btn-sm btn-danger">Delete</button></td>
		      </tr>';

			}
			echo '
			</tbody>
		</table>';
		}
	}
	echo '
		</div>
	</div>';

	include 'footer.php';
?>