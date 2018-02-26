<?php

	include 'init.php';

	if(isset($_GET["act"]))
		$act = get("act");
	else
		$act="";

	if(isset($_GET["session"],$_GET["year"],$_GET["semester"]))
	{
		$title = "Add Results";
	}
	else {
		$title = "Add/Edit Results";
	}
	$site->title  = $title;

	$head[] = '<script type="text/javascript" src="'.$site->url.'/js/jquery.min.js"></script>';

	include 'header.php';

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">'.$title.'</div>
	<div class="panel-body" style="padding: 5px;">';

	if(isset($_GET["session"],$_GET["year"],$_GET["semester"]))
	{
		$session = get("session");
		$year = get("year");
		$semester = get("semester");

		$sql = "SELECT id FROM result as r INNER JOIN student as s ON s.session='$session' AND r.roll=s.roll LIMIT 0,1";
		$sql = $db->query($sql);
		if($sql->num_rows>0)
		{
			redir($site->aurl.'/editresult.php?'.$_SERVER["QUERY_STRING"]);
			exit;
		}

		//var_dump($_POST);

		if(isset($_POST["marks"]) && count($_POST["marks"])>0)
		{
			$error = array();

			if(empty($error))
			{
				$up=0;
				foreach($_POST["marks"] as $roll=>$arr)
				{
					foreach($arr as $cid=>$marks)
					{
						if($marks==="")
						{
							$marks = -1;
						}
						$up += $db->insert("result",array("roll"=>$roll,"year"=>$year,"semester"=>$semester,"c_id"=>$cid,"marks"=>$marks));
					}
					
				}
				if($up>0)
				{
					$_SESSION["message"] = $up." <i>Data(s)</i> have been added Successfully.";
					redir($site->aurl."/editresult.php?".$_SERVER['QUERY_STRING']);
				}
				else
				{
					$error[] = "Error in Database. Can not add data. ".$db->error;
					showErrors($error);
				}
				
			}
			else
			{
				showErrors($error);
			}
		}

		echo '
		<div class="panel-body" style="padding: 2px;"><div class="list-group">
			<li class="list-group-item list-group-item-info"> &#187; Session: '.$session.'</li>
			<li class="list-group-item list-group-item-info"> &#187; Year: '.$year.'</li>
			<li class="list-group-item list-group-item-info"> &#187; Semester: '.$semester.'</li>
		</div>';

		$sql = $db->select("student","roll",array("session"=>$session));

		$sql2 = $db->select("course","id,code,title",array("year"=>$year,"semester"=>$semester,"status"=>1));

		if($sql->num_rows<1)
		{
			echo '<h4>No Student Found for this criteria. Please <a href="student.php?act=add">add students</a> first.<h4>';
		}
		else if($sql2->num_rows<1)
		{
			echo '<h4>No Student Found for this criteria. Please <a href="student.php?act=add">add students</a> first.<h4>';
		}
		else
		{
			echo '<form method="post" id="marksForm">';
			echo '
		<table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Roll</th>';
		    $carr = array();
		    while($res=$sql2->fetch_assoc())
		    {
		    	echo '<th>'.$res["code"].'<br/><small>'.$res["title"].'</small></th>';
		    	$carr[] = $res["id"];
		    }
		    echo '    
		      </tr>
		    </thead>
		    <tbody>';
			while($result = $sql->fetch_assoc())
			{
				echo '
			  <tr>
		        <td>'.$result["roll"].'</td>';
		        $c = count($carr);
		        for($i=0;$i<$c;$i++)
		        {
		        	echo '
		        <td>
		        	 <div class="form-group" style="margin:0; padding:0">
			            <input type="number" class="form-control" name="marks['.$result["roll"].']['.$carr[$i].']" min="0" max="100">
			        </div>
		        </td>';

		        }
		        echo '
		      </tr>';

			}
			echo '<tr><td></td><td><button type="submit" class="btn btn-primary"  id="submitbtn1">Submit</button></td>';
			echo '
			</tbody>
		</table>';
			echo '</form>';
		}

	}

	else
	{
		$opval1 = generate_session();
		$ses_str="<option value='0'>Select Session</option>";
		foreach($opval1 as $val)
		{
			$ses_str .= '<option>'.$val.'</option>';
		}

		$opval1 = generate_year();
		$year_str="<option value='0'>Select Year</option>";
		foreach($opval1 as $key=>$val)
		{
			$year_str .= '<option value='.$key.'>'.$val.'</option>';
		}

		$opval1 = generate_semester();
		$sem_str="<option value='0'>Select Semester</option>";
		foreach($opval1 as $key=>$val)
		{
			$sem_str .= '<option value='.$key.'>'.$val.'</option>';
		}

		echo '<form method="get">';
		echo '
		<div class="col-md-3 col-sm-3 form-group">
            <label for="select">Session:</label>
            <select class="form-control" name="session" id="session">
            '.$ses_str.'
            </select>
        </div>
        <div class="col-md-3 col-sm-3 form-group">
            <label for="select">Year:</label>
            <select class="form-control" name="year" id="year">
            '.$year_str.'
            </select>
        </div>
        <div class="col-md-3 col-sm-3 form-group">
            <label for="select">Semester:</label>
            <select class="form-control" name="semester" id="semester">
            '.$sem_str.'
            </select>
        </div>
        <div class="col-md-3 col-sm-3 form-group">
        	<br/>
    		<button type="submit" class="btn btn-primary">Submit</button>
    	</div>';
        echo '</form>';
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