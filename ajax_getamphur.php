<?php
include("inc/connect.php");
$sql = "
		select *
		from amphur
		where pvID = '{$_POST["pvID"]}'
		order by convert(ampName using tis620)
";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$amp = "<option value=''>- เลือก -</option>";
if (mysqli_num_rows($rs)) {
	while ($ds = mysqli_fetch_assoc($rs)) {
		$amp .= "<option value='{$ds["ampID"]}'>{$ds["ampName"]}</option>";
	}
}
echo $amp;
?>