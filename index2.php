<?php

ini_set('display_errors', '1');
ini_set('upload_max_filesize', '1000M');
ini_set('post_max_size', '1000M');
/*
php_value post_max_size 2000M
php_value upload_max_filesize 2500M
php_value max_execution_time 6000000
php_value max_input_time 6000000
php_value memory_limit 2500M
*/
//upload_max_filesize = 1000M ;1GB
//post_max_size = 1000M

include('parser.php');

if(isset($_POST['btn-upload'])){
//	$pic = rand(1000,100000)."-".$_FILES['pic']['name'];
	$pic = $_FILES['pic']['name'];
	//$pic = date("Ymd H:i:s");

	$pic_loc = $_FILES['pic']['tmp_name'];
	$folder="pgn/";
	if(move_uploaded_file($pic_loc,$folder.$pic)){
		
		echo "<p>PGN file successfully uploaded ".$_FILES['pic']['name']."</p>";
		upload_pgn($file_name=$_FILES['pic']['name']);
	}else{
		echo "<p>error while uploading PGN file ".$_FILES['pic']['name']."</p>";
	}
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>chess db - upload PGN file</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
<input type="file" name="pic" />
<button type="submit" name="btn-upload">upload PGN file</button>
</form>
</body>
</html>
