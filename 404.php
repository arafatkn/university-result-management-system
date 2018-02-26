<?php
    header("HTTP/1.0 404 Not Found");
    include 'init.php';
    
    $site->title = "404 Content Not Found :: ".$site->name;
    include 'header.php';
?>
<h1>404 Not Found</h1>
<?php 
    include 'footer.php';
?>