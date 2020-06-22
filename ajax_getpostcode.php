<?php
include("inc/connect.php");
$sql = "
		select *
		from amphur
		where ampID = '{$_POST["ampID"]}'
";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
if (mysqli_num_rows($rs)) {
	$ds = mysqli_fetch_assoc($rs);
	echo $ds["postCode"];
}
?>