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
<script type="text/javascript" src="<?=$site->url?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$site->url?>/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse" style="border-radius: 0">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">View Results</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?=$site->url?>">Home</a></li>
      <li><a href="<?=$site->url?>/index.php">By Session</a></li>
      <li><a href="<?=$site->url?>/individual.php">By Roll</a></li>
    </ul>
  </div>
</nav>
<div class="clearfix"></div>
    <div class="container" id="maincon" style="padding: auto;">

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
