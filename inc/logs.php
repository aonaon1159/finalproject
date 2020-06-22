<?php
function logevent($event = "System Failure: An unidentified error has occurred.", $uID = 0) {
	include("connect.php");
	$ip =  $_SERVER["REMOTE_ADDR"];
	$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$logSql = "insert into logs set logEvent = '$event', url = '$url', ip = '$ip', uID = '$uID';";
	mysqli_query($conn, $logSql) or die("<p><b>Logs Event Error</b></p><p>" . mysqli_error($conn) . "</p><hr>");
}
?>