<!doctype html>
<html class="no-js" lang="en">
<head> 
<meta http-equiv="content-type" content="application/xhtml xml; charset=utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1.0"/> 
<title><?=$site->title?></title> 
<meta name="robots" content="noindex,nofollow"/>
<?php
	if(isset($head) && !empty($head))
	{
		 foreach($head as $meta)
		    echo $meta;
	}
?>

<link rel="icon" href="<?=$site->url?>/favicon.png" type="image/png"/>
<link rel="stylesheet" href="<?=$site->url?>/css/bootstrap.mod.css">
<link rel="stylesheet" href="<?=$site->url?>/css/normalize.css">
<link rel="stylesheet" href="<?=$site->url?>/css/styles.css" type="text/css"/>
<script type="text/javascript" src="<?=$site->url?>/js/main.js"></script>
</head>
<body>
    <div class="container" id="maincon" style="padding: auto;">

<div style="background: #323232; height: auto; width: auto;">
    <div class="col-xs-12 sideboxHeader" style="height: auto;">
<a href="<?=$site->home?>"><span style="color: #ffffff;
font-family: Comic sans MS; font-weight: bold; font-size: 23px; text-align: center;"><?=$site->name?></span></a>
    </div>
</div>
<div class="clearfix"></div>
<?php
  if(isset($_SESSION["message"]))
  {
    echo '<pre><center>'.$_SESSION["message"].'</center></pre>';
    unset($_SESSION["message"]);
  }
  else
  {
    //echo '<br/>';
  }
?>
