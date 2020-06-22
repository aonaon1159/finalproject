<?php
include("inc/connect.php");
$sql = "
		select *
		from district
		where ampID = '{$_POST["ampID"]}'
		order by convert(distName using tis620)
";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$dist = "<option value=''>- เลือก -</option>";
if (mysqli_num_rows($rs)) {
	while ($ds = mysqli_fetch_assoc($rs)) {
		$dist .= "<option value='{$ds["distID"]}'>{$ds["distName"]}</option>";
	}
}
echo $dist;
?>