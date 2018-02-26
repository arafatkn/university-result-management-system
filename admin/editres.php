<?php

	include 'init.php';

	if(isset($_GET["act"]))
		$act = get("act");
	else
		$act="";

	if($act=="edit" && isset($_GET["roll"]))
	{
		$roll = get("roll");
		if(isset($_GET["year"],$_GET["semester"]))
		{
			$year = get("year"); $semester = get("semester");
			$title = "Edit Results of ".$roll." of ".$year."-".$semester;
		}
		else
		{
			$title = "Edit Results of ".$roll;
		}
		
	}
	else {
		$title = "Edit Results";
	}
	$site->title  = $title;

	$head[] = '<script type="text/javascript" src="'.$site->url.'/js/jquery.min.js"></script>';

	include 'header.php';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">'.$title.'</div>
	<div class="panel-body" style="padding: 5px;">';

	if($act=="edit" && isset($roll))
	{

		$sql = "SELECT r.id,c.code,c.title,r.marks FROM result as r INNER JOIN course as c ON r.roll='$roll'";
		if(isset($year))
			$sql .= " AND r.year=$year";
		if(isset($semester))
			$sql .= " AND r.semester=$semester";
		$sql .= " AND r.c_id=c.id";

		$sql = $db->query($sql);
		if($sql->num_rows<1)
		{
			echo 'Student Result Not Found';
			exit;
		}

		//var_dump($_POST);

		if(isset($_POST["result"]) && count($_POST["result"])>0)
		{
			$error = array();

			if(empty($error))
			{
				$up=0;
				foreach($_POST["result"] as $id=>$marks)
				{
					if($marks==="")
					{
						$marks = -1;
					}
					$up += $db->update("result",array("marks"=>$marks),array("id"=>$id));
					
				}
				if($up>0)
				{
					$_SESSION["message"] = $up." <i>Data(s)</i> have been updated Successfully.";
					redir($site->aurl."/editres.php?".$_SERVER['QUERY_STRING']);
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

		if(!isset($year))
			$year="All";
		if(!isset($semester))
			$semester="All";

		echo '
		<div class="panel-body" style="padding: 2px;"><div class="list-group">
			<li class="list-group-item list-group-item-info"> &#187; Roll: '.$roll.'</li>
			<li class="list-group-item list-group-item-info"> &#187; Year: '.$year.'</li>
			<li class="list-group-item list-group-item-info"> &#187; Semester: '.$semester.'</li>
		</div>';

		echo '<form method="post" id="marksForm">';
		while($res=$sql->fetch_assoc())
		{
			if($res["marks"]==-1)
				$res["marks"] = "";
			echo '
		<div class="form-group">
            <label for="select">'.$res["title"].' ('.$res["code"].'):</label>
            <input type="number" class="form-control" name="result['.$res["id"].']" value="'.$res["marks"].'" min="0" max="100">
        </div>';
		}
		
        echo '
        <div class="form-group">
    		<button type="submit" class="btn btn-primary">Submit</button>
    	</div>
    	';
		echo '</form>';

	}

	else
	{
		redir($site->url);
	}
	echo '
		</div>
	</div>';

?>

<script type="text/javascript">
	
	$( "#submitbtn1" ).click(function(event) {
		
		event.preventDefault();
		var emp=0, min=false, max=false;
		$("form#marksForm input[type=number]").each(function(){
			var input = $(this);
			//alert('Type: ' + input.attr('type') + 'Name: ' + input.attr('name') + 'Value: ' + input.val());
			if(input.val()=="")
			{
				input.focus();
				emp++;
			}
			else if(input.val()>100)
				max = true;
			else if(input.val()<0)
				min = true;
		});
		if(min || max)
		{
			alert("Number can not be less than 0 and greater than 100. Please check.");
			return;
		}

		if(emp==0)
		{
			$( "#marksForm" ).submit();
		}
		else
		{
			var text = "Some Fields are empty. Do you sure want to submit ?";
			var chk = confirm(text);
		    if(chk)
		    {
		        $( "#marksForm" ).submit();
		    }
		}

	});

</script>

<?php

	include 'footer.php';
?>