
<?php
	
	include 'init.php';
	
	$site->name = "View Results - Computer Science & Engineering";
	$site->title  = "View Results - Computer Science & Engineering";
	include 'header.php';

	if(isset($_GET["session"],$_GET["year"],$_GET["semester"]))
    {
		$session = get("session");
		$year = get("year");
		$semester = get("semester");
	}

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">Query Result</div>
	<div class="panel-body" style="padding: 5px;">';

	$opval1 = generate_session();
	$ses_str="<option value='0'>Select Session</option>";
	foreach($opval1 as $val)
	{
		$ses_str .= '<option';
		if(isset($session) && $session==$val)
			$ses_str .= ' selected';
		$ses_str .=  '>'.$val.'</option>';
	}

	$opval1 = generate_year();
	$year_str="<option value='0'>Select Year</option>";
	foreach($opval1 as $key=>$val)
	{
		$year_str .= '<option value="'.$key.'"';
		if(isset($year) && $year==$key)
			$year_str .= ' selected';
		$year_str .=  '>'.$val.'</option>';
	}

	$opval1 = generate_semester();
	$sem_str="<option value='0'>Select Semester</option>";
	foreach($opval1 as $key=>$val)
	{
		$sem_str .= '<option value="'.$key.'"';
		if(isset($semester) && $semester==$key)
			$sem_str .= ' selected';
		$sem_str .=  '>'.$val.'</option>';
	}

	echo '<div class="col-xs-12 clearfix">
	<form method="get">';
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
    <div class="col-md-2 col-sm-3 form-group">
    	<br/>
    	<button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <div class="clearfix"></div>';
    echo '</form>
    </div>';

    echo '<div class="clearfix"></div>';


    if(isset($session,$year,$semester))
    {

    	$sql = "SELECT c.code,r.roll,r.marks,c.credit FROM result as r INNER JOIN student as s ON s.session='$session' AND r.year=$year AND r.semester=$semester AND r.roll=s.roll INNER JOIN course as c ON r.c_id=c.id ORDER BY s.roll ASC";
    	echo '<!--'.$sql.'-->';
    	$sql = $db->query($sql);
    	if($sql->num_rows<1)
    	{
    		echo '<h4>Result has not been published yet.</h4>';
    	}
    	else
    	{
    		$marks = array();
			while($res=$sql->fetch_assoc())
			{
				$marks[$res["roll"]][$res["code"]] = $res["marks"];
				$credit[$res["code"]] = $res["credit"];
			}

    		echo '
		<table class="table table-bordered">
		    <thead>
		      <tr>
		        <th>Roll</th>';
		    
		    $arr = current($marks);
		    foreach($arr as $code=>$val)
		    {
		    	echo '<th>'.$code.'</th>';
		    }

		    echo '
		    	<th>SGPA</th>';
		    if($admin->is_admin())
		    {
		    	echo '<th>Edit</th>';
		    }
		    echo '
		      </tr>
		    </thead>
		    <tbody>';

		    $tcredit = array_sum($credit);

		    foreach($marks as $roll=>$arr)
			{
				echo '
			  <tr>
		        <td>'.$roll.'</td>';
		        $tpoint = 0;
		        $fail = false;
		        foreach($arr as $code=>$val)
		        {
		        	if($val==-1)
		        	{
		        		echo '<td>Absent</td>';
		        		$fail = true;
		        	}
		        	else
		        	{
		        		echo '<td>'.$Result->mark2grade($val).'</td>';
		        		$tpoint += $credit[$code]*$Result->mark2gpa($val);
		        		if($val<40)
		        			$fail = true;
		        	}

		        }
		        if($fail)
		        	$sgpa = "Fail";
		        else
		        	$sgpa = number_format($tpoint/$tcredit, 2);
		        echo '<td>'.$sgpa.'</td>';
		        if($admin->is_admin())
			    {
			    	echo '
			    	<td><a href="'.$site->aurl.'/editres.php?act=edit&roll='.$roll.'&year='.$year.'&semester='.$semester.'" class="btn btn-sm btn-warning" role="button">Edit</a></td>
			    	';
			    }
		        echo '
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

	if($admin->is_admin())
	{
		echo '<div class="list-group">
			<li class="list-group-item list-group-item-info"><a href="'.$site->aurl.'">Go To Admin Area</a></li>
			</div>';
	}

?>

<?php
	
	include 'footer.php';
	
?>
		