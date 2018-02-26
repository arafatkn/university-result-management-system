<?php

	include 'init.php';

	if(isset($_GET["act"]))
		$act = get("act");
	else
		$act="";

	if(isset($_GET["roll"]))
	{
		$roll=get("roll");
		$sql = $db->select("student","",array("roll"=>$roll));
		if($sql->num_rows==1)
		{
			$stu = $sql->fetch_assoc();
		}
		else
		{
			echo '<h3>Student Not Found</h3>';
			exit;
		}
	}
	if($act=="add") {
		$title  = "Add a new Student";
	}
	else if($act=="delete" && isset($roll))
	{

		$error = array();
		
		if(empty($error))
		{
			$del = $db->delete("student",array("roll"=>$roll));
			if($del)
			{
				$_SESSION["message"] = $stu["name"]." has been Deleted Successfully.";
			}
			else
			{
				$_SESSION["message"] = "Error in Database. Can not delete student. ".$db->error;
			}
			redir("?");
		}
		else
		{
			echo 'Student <i>'.$stu["name"].'</i> can not be deleted. Because-<br/>';
			showErrors($error);
		}

		exit;
	}
	else if($act=="edit" && isset($id)) {
		$title  = "Edit ".$stu["name"];
	}
	else {
		$title = "Manage Students";
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
		if(isset($roll,$name,$session))
		{
			$error = array();
			if(empty($roll)) $error[] = "Roll can not be empty";
			if(empty($name)) $error[] = "Full Name can not be empty";
			if(empty($session)) $error[] = "Session can not be empty";
			/*if($session[2]!=$roll[0] OR $session[3]!=$roll[1]) $error[] = "Session & Roll Prefix not Matched";*/

			if(empty($error))
			{
				$up = $db->insert("student",array("roll"=>$roll,"name"=>$name,"session"=>$session));
				if($up)
				{
					$_SESSION["message"] = "<i>".$roll." - ".$name."</i> has been added Successfully.";
				}
				else
				{
					$_SESSION["message"] = "Error in Database. Can not add Student. ".$db->error;
				}
				redir("?");
			}
			else
			{
				showErrors($error);
			}
		}

		$opval1 = generate_session();

		$form->show("post","",
			array(
				array("multiText",
					array("roll","Roll"),
					array("name","Full Name")
				),
				array("multiSelect",
					array("session","Session",false,$opval1,"")
				)
			)
		);
	}
	else if($act=="edit")
	{
		extract($_POST);
		if(isset($name,$session))
		{
			$error =array();
			if(empty($name)) $error[] = "Full Name can not be empty";
			if(empty($session)) $error[] = "Session can not be empty";
			if(empty($error))
			{
				$up = $db->update("student",array("name"=>$name,"session"=>$session),array("roll"=>$roll));
				if($up)
				{
					$_SESSION["message"] = "<i>".$roll." - ".$name."</i> has been edited Successfully.";
				}
				else
				{
					$_SESSION["message"] = "Error in Database. Can not edit Student. ".$db->error;
				}
				redir("?session=".$session);
			}
			else
			{
				showErrors($error);
			}
		}

		$opval1 = generate_session();

		$form->show("post","",
			array(
				array("multiText",
					array("name","Full Name",$stu["name"])
				),
				array("multiSelect",
					array("session","Session",false,$opval1,"",$stu["session"])
				)
			)
		);
	}

	else
	{
		if(isset($_GET["session"]))
		{
			$session=get("session");
			$sql = $db->select("student","",array("session"=>$session));
		}
		else
		{
			$session = "0";
			$sql = $db->select("student","");
		}

		$ses_str="<option value='0'>Select Session</option>";

		$opval1 = generate_session();
		
		foreach($opval1 as $val)
		{
			$ses_str .= '<option';
			if($val==$session)
				 $ses_str .= ' selected';
			$ses_str .= '>'.$val.'</option>';
		}
		echo '<div class="panel panel-default">
  		<div class="panel-body">
  		<form method="get">';
		echo '
		<div class="col-md-4 col-sm-4 col-xs-3 form-group">
	    </div>
		<div class="col-md-3 col-sm-4 col-xs-6 form-group">
	        <label for="select" style="text-align: center" align="center">Show Stduents by Session</label>
	        <select class="form-control" name="session" id="session" onchange="this.form.submit()">
	        '.$ses_str.'
	        </select>
	    </div>
	    <div class="col-md-4 col-sm-4 col-xs-3 form-group">
	    </div>';
	    echo '</form>
	    </div>
	    </div>';

	    echo '<div class="clearfix"></div>';

		echo '
		<div>
			<a href="?act=add" class="btn btn-primary" role="button">Add New Student</a>
		</div><br/>';
		
		if($sql->num_rows<1)
		{
			echo '<h4>No Student Found. Please <a href="?act=add">add a student</a> first.<h4>';
		}
		else
		{
			echo '
		<table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Roll</th>
		        <th>Full Name</th>
		        <th>Session</th>
		        <th>View Result</th>
		        <th>Edit</th>
		        <th>Delete</th>
		      </tr>
		    </thead>
		    <tbody>';
			while($result = $sql->fetch_assoc())
			{
				echo '
			  <tr>
		        <td>'.$result["roll"].'</td>
		        <td>'.$result["name"].'</td>
		        <td>'.$result["session"].'</td>
		        <td><a href="'.$site->url.'/individual.php?roll='.$result["roll"].'" class="btn btn-sm btn-info" role="button">View</a></td>
		        <td><a href="?act=edit&roll='.$result["roll"].'" class="btn btn-sm btn-warning" role="button">Edit</a></td>
		        <td><button type="button" onclick="confirmation(\'Are You Sure Want to Delete?\',\'?act=delete&roll='.$result["roll"].'\')" class="btn btn-sm btn-danger">Delete</button></td>
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