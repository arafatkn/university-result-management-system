<?php

// Functions
function url_get_contents($url)
{
    $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch,CURLOPT_ENCODING,'gzip');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '1');
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $header[] = "Accept-Language: en";
    $header[] = "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; de; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3
    ";
    $header[] = "Pragma: no-cache";
    $header[] = "Cache-Control: no-cache";
    $header[] = "Accept-Encoding: gzip,deflate";
    $header[] = "Content-Encoding: gzip";
    $header[] = "Content-Encoding: deflate";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $load = curl_exec($ch);
    curl_close($ch);
    return $load;
    
}

	function get($var){
		if(!isset($_GET[$var]))
			return '';
		return sanitize($_GET[$var]);
			
	}
	function post($var){
		if(!isset($_POST[$var]))
			return '';
		return sanitize($_POST[$var]);
			
	}
	function request($var){
		if(!isset($_REQUEST[$var]))
			return '';
		return sanitize($_REQUEST[$var]);
			
	}
	function cookie($var){
		
		return sanitize($_COOKIE[$var]);
	}
	function redir($to){
		return header('Location:'.$to.'');
	}
	function sanitize($var){
		return addslashes(htmlspecialchars(trim($var)));
			
	}

	function is_ajax_supported()
	{
	    $ua = $_SERVER['HTTP_USER_AGENT'];
	    if(stristr($ua,"opera mini")) return false;
        if(stristr($ua,"j2me")) return false;
        if(stristr($ua,"uc mini")) return false;
        if(stristr($ua,"java")) return false;
        if(stristr($ua,"symbian")) return false;
        return true;
	}
	
	function issetMulti($name,$index)
	{
		foreach($index as $ind)
		{
			if(!isset($name[$ind]))
				return false;
		}
		return true;
	}
	function showErrors($errors)
	{
		echo '<pre>';
		foreach($errors as $error)
		{
			echo $error.'<br/>';
		}
		echo '</pre>';
	}

	function generate_session($start="2008",$end="")
	{
		if(empty($end))
			$end = date("Y");
		$arr = array();
		for($i=$end;$i>$start;$i--)
		{
			$arr[] = ($i-1).'-'.substr($i, -2);
		}
		return $arr;
	}

	function generate_year($start=1,$end=4)
	{
		$th = array("", "st", "nd", "rd", "th", "th", "th", "th", "th"
				);
		$arr = array();
		for($i=$start;$i<=$end;$i++)
		{
			//$arr[] = ($i-1).'-'.substr($i, -2);
			$arr[$i] = $i.$th[$i];
		}
		return $arr;
	}

	function generate_semester($start=1,$end=2)
	{
		$th = array("", "st", "nd", "rd", "th");
		$arr = array();
		for($i=$start;$i<=$end;$i++)
		{
			//$arr[] = ($i-1).'-'.substr($i, -2);
			$arr[$i] = $i.$th[$i];
		}
		return $arr;
	}

	function type_s2f($tp)
	{
		$arr = array(
				"ct"=>"Class Test",
				"am"=>"Assignment",
				"pt"=>"Presentation"
			);

		return $arr[$tp];
	}

	function get_dept_full($id)
	{
		if(isset($_POST["get_dept_full"][$id]))
			return $_POST["get_dept_full"][$id];
		global $db;
		$sql = $db->select("department","name,sname",array("id"=>$id));
		$res = $sql->fetch_assoc();
		$data = $res["sname"].' - '.$res["name"];
		$_POST["get_dept_full"][$id] = $data;
		return $data;
	}

	function get_course_full($id)
	{
		if(isset($_POST["get_course_full"][$id]))
			return $_POST["get_course_full"][$id];
		global $db;
		$sql = $db->select("course","code,title",array("id"=>$id));
		$res = $sql->fetch_assoc();
		$data = $res["code"].' - '.$res["title"];
		$_POST["get_course_full"][$id] = $data;
		return $data;
	}

	function get_sdc_id($s,$d,$c)
	{
		global $db;
		$sql = $db->select("s_d_c","id",array("session"=>$s,"dept_id"=>$d,"course_id"=>$c));
		if($sql->num_rows<1)
		{
			return 0;
		}
		$res = $sql->fetch_assoc();
		return $res["id"];
	}
	

?>
