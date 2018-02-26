<?php

	include 'init.php';

	if(isset($_GET["act"]))
		$act = get("act");
	else
		$act="";

	if(isset($_GET["id"]))
	{
		$id=get("id");
	}
	if(isset($_GET["roll"]))
	{
		$roll = get("roll");
	}
	if($act=="edit" && isset($id,$roll)) {
		$title  = "Edit Continuous Assessment Marks of Roll- ".$roll;
	}
	else {
		$title = "Manage CA";
	}
	$site->title  = $title;
	include 'header.php';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">'.$title.'</div>
	<div class="panel-body" style="padding: 5px;">';

	if($act=="edit" && isset($id,$roll))
	{
		
		if(count($_POST)>0)
		{
			extract($_POST);
			$error =array();
			
			if(empty($error))
			{
				$cc = 0;
				foreach($up as $type=>$var)
				{
					foreach($var as $num=>$marks)
					{
						$cc += $db->update("classtest",array("marks"=>$marks),array("sdc_id"=>$id,"roll"=>$roll,"type"=>$type,"num"=>$num));
					}
				}

				$cc += $db->update("attendence",array("mark"=>$atd),array("sdc_id"=>$id,"roll"=>$roll));

				if($cc>0)
				{
					$_SESSION["message"] .= $cc." Data(s) of Roll-".$roll." has been updated Successfully.";
					redir($site->url."/?sdcid=".$id);
				}
				else
				{
					$error[] = "Error in Database. Can not update data. ".$db->error;
					showErrors($error);
				}
				
			}
			else
			{
				showErrors($error);
			}
		}

		$sql = $db->select("classtest","type,num,marks",array("sdc_id"=>$id,"roll"=>$roll),"type,num ASC");
		if($sql->num_rows>0)
		{
			echo '<form method="post">';
			while($res=$sql->fetch_assoc())
			{
				$name = "up[".$res["type"]."][".$res["num"]."]";
				echo '
				<div class="form-group">
            		<label for="text">'.type_s2f($res["type"])." ".$res["num"].': *</label>
            		<input type="number" class="form-control" name="'.$name.'" value="'.$res["marks"].'" required>
        		</div>';
			}
			$sql = $db->select("attendence","mark",array("sdc_id"=>$id,"roll"=>$roll));
			if($sql->num_rows>0)
			{
				$res = $sql->fetch_assoc();
				$atd = $res["mark"];
			}
			else
			{
				$atd = 0;
			}
			echo '
			<div class="form-group">
        		<label for="text">Attendence: *</label>
        		<input type="text" class="form-control" name="atd" value="'.$atd.'" required>
    		</div>';

			echo '<button type="submit" class="btn btn-primary">Submit</button>
			</form>';
		}
	}

	else
	{
		redir($site->aurl);
	}
	echo '
		</div>
	</div>';

	include 'footer.php';
?>