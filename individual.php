
<?php
	
	include 'init.php';
	
	$site->name = "Individual Results - Computer Science & Engineering";
	$site->title  = "Individual Results - Computer Science & Engineering";
	include 'header.php';

	if(isset($_GET["roll"]))
    {
		$roll = get("roll");
	}

	echo '
<div class="panel panel-primary">
	<div class="panel-heading">Query Result</div>
	<div class="panel-body" style="padding: 5px;">';

	if(isset($roll))
		$value=$roll;
	else
		$value="";

	echo '<div class="col-xs-12 clearfix">
	<form method="get">';
	echo '
	<div class="col-md-3 col-sm-3 form-group">
        <label for="select">Student\'s Roll:</label>
        <input type="number" class="form-control" name="roll" value="'.$value.'" required>
    </div>
    <div class="col-md-2 col-sm-3 form-group">
    	<br/>
    	<button type="submit" class="btn btn-primary">Submit</button>
    </div>
    <div class="clearfix"></div>';
    echo '</form>
    </div>';

    echo '<div class="clearfix"></div>';


    if(isset($roll))
    {

    	$sql = "SELECT c.code,r.year,r.semester,r.marks,c.credit FROM result as r INNER JOIN course as c ON r.roll='$roll' AND r.c_id=c.id ORDER BY r.year,r.semester,c.code ASC";
    	echo '<!--'.$sql.'-->';
    	$sql = $db->query($sql);
    	if($sql->num_rows<1)
    	{
    		echo '<h4>Result has not been published yet.</h4>';
    	}
    	else
    	{
    		$marks = array(); $credit=array();
			while($res=$sql->fetch_assoc())
			{
				$marks[$res["year"]][$res["semester"]][$res["code"]] = $res["marks"];
				$credit[$res["year"]][$res["semester"]][$res["code"]] = $res["credit"];
			}

			foreach($marks as $yr=>$semarr)
			{
				foreach($semarr as $sem=>$cour)
				{
					echo '
				<table class="table table-bordered">
				    <thead>
				      <tr>
				        <th>Year</th>
				        <th>Semester</th>';
				    foreach($cour as $code=>$val)
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

				    $tcredit[$yr][$sem] = array_sum($credit[$yr][$sem]);

					echo '
				  <tr>
			        <td>'.$yr.'</td>
			        <td>'.$sem.'</td>';
			        $tpoint[$yr][$sem] = 0;
			        $fail = false;
			        foreach($cour as $code=>$val)
			        {
			        	if($val==-1)
			        	{
			        		echo '<td>Absent</td>';
			        		$fail = true;
			        	}
			        	else
			        	{
			        		echo '<td>'.$Result->mark2grade($val).'</td>';
			        		$tpoint[$yr][$sem] += $credit[$yr][$sem][$code]*$Result->mark2gpa($val);
			        		if($val<40)
			        			$fail = true;
			        	}

			        }
			        if($fail)
			        	$sgpa[$yr][$sem] = "Fail";
			        else
			        	$sgpa[$yr][$sem] = number_format($tpoint[$yr][$sem]/$tcredit[$yr][$sem], 2);
			        echo '<td>'.$sgpa[$yr][$sem].'</td>';
			        if($admin->is_admin())
				    {
				    	echo '
				    	<td><a href="'.$site->aurl.'/editres.php?act=edit&roll='.$roll.'" class="btn btn-sm btn-warning" role="button">Edit</a></td>
				    	';
				    }
			        echo '
			      </tr>';
				    
		    		echo '
					</tbody>
				</table>';
				}
			}

			// Overall Result Started
			$total_p=0;
			$total_c=0;
			foreach($tcredit as $yr=>$semarr)
			{
				foreach($semarr as $sem=>$val)
				{
					$total_c += $tcredit[$yr][$sem];
					$total_p += $tpoint[$yr][$sem];
				}
			}

			if($fail)
				$cgpa = "Fail";
			else
				$cgpa = number_format($total_p/$total_c, 2);

			echo '
			<div class="list-group">
			<li class="list-group-item list-group-item-info">CGPA: '.$cgpa.'</li>
			</div>';
    		
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
		