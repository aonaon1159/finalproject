<?php session_start();  ?>
<?php 

$title = "Human Resource Management System Avia Booking";
$head = "Human Resource Management System Avia Booking";
date_default_timezone_set('Asia/Bangkok');
$info = getdate();
$day = $info['mday'];
$month = $info['mon'];
$year = $info['year'];
$hour = $info['hours'];
$min = $info['minutes'];
$sec = $info['seconds'];
$current_dated = "$year-$month-$day $hour:$min:$sec";
$time = "$hour:$min:$sec";
$date = "$year-$month-$day";
?>
<!DOCTYPE html>

<html lang="th">

<head>
<title><?php echo $title; ?></title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="Human Resource Management System Avia Booking">
  <meta name="keywords" content="avia,hr,bis,hr avia bis,business information system">
  <meta name="author" content="Aritad Thipchak,Supagin Tipara,Sittiwat Kammai">

<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />

<link rel="stylesheet" href="css/bootstrap.min.css">

<link rel="stylesheet" href="font-awesome/css/all.css">
<link rel="stylesheet" href="font-awesome/css/v4-shims.css">
<link rel='stylesheet' href='css/dataTables.bootstrap.min.css' />
<link rel="stylesheet" href="bootstrap-toggle/css/bootstrap-toggle.min.css">
<link rel='stylesheet' href='css/lightbox.min.css' />
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/civem-0.0.7.min.js"></script>
<script src='js/jquery.dataTables.min.js'></script>
<script src='js/dataTables.bootstrap.min.js'></script>
<script src='bootstrap-toggle/js/bootstrap-toggle.min.js'></script>
<script src="js/jquery.validate.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="inc/date.js"></script>
<script src="inc/func.js"></script>
<script src='js/lightbox.min.js'></script>
<script defer src="font-awesome/js/all.js"></script>
<script defer src="font-awesome/js/v4-shims.js"></script>


<style>
	    @font-face{
  font-family: Kanit;
  src: url('fonts/Kanit-Regular.ttf');
}
.bg-red-avia { background-color: #ee3338; color: #fff; }
.bg-gray-avia { background-color: #4e4e4e; color: #ee3338; }
.bg-black-avia { background-color: #303030; color: #ee3338; }
.hr-big { height: 10px; border: 0; box-shadow: 0 10px 10px -10px #8c8b8b inset; }
body {
	font-family: Kanit;
}
</style>
</head>

<body>
	<!-- Begin Load -->
	<?php
	include("inc/function.php");
	include("inc/connect.php");

	if (isset($_GET["mod"]) and !empty($_GET["mod"])) {
		$load =  $_GET["mod"];
	} elseif (isset($_SESSION["uID"]) and !empty($_SESSION["uID"])) {
		$load = "main";
	} else {
		$load = "login";
	}
	
	$module = "module/$load.php";
	if (file_exists($module)) {
		include($module);
	} else {
		include("404.php");
	}
	error_reporting(0);

	?>
	<!-- End Load -->
</body>
</html>