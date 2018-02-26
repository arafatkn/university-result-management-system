<?php

	
	include '../init.php';

	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	if(isset($_GET["act"]))
		$act = get("act");
	else
		$act="";

	if($act=="getDeptbySession" && isset($_GET["session"]))
	{
		$session = get("session");
		$qu = "SELECT DISTINCT d.id as did,d.name,d.sname FROM s_d_c as sdc INNER JOIN department as d ON sdc.session='$session' AND sdc.dept_id=d.id ORDER BY d.id";
		$sql = $db->query($qu);
	}
	else if($act=="getCoursebyDept" && isset($_GET["session"],$_GET["dept_id"]))
	{
		$session = get("session");
		$dept_id = get("dept_id");
		$qu = "SELECT DISTINCT c.id as cid,c.title,c.code FROM s_d_c as sdc INNER JOIN department as d ON sdc.session='$session' AND sdc.dept_id='$dept_id' AND sdc.dept_id=d.id INNER JOIN course as c ON sdc.course_id=c.id ORDER BY session";
		$sql = $db->query($qu);
	}

	$arr = array();
	if($sql->num_rows<1)
	{
		$arr[] = array("error"=>1,
						"query"=>$qu,
						"msg"=>"No Data Found.",
						"lastdberr"=>$db->error
					);
	}
	else
	{
		$arr[] = array("error"=>0);
		while($res=$sql->fetch_assoc())
		{
			$arr[]=$res;
		}
	}

	echo json_encode($arr);


?>