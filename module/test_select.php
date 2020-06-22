<?php
$sql = "
		select * 
		from province
		order by convert(pvName using tis620)
";
$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$province = "<option value=''>- เลือก -</option>";
if (mysqli_num_rows($rs)) {
	while ($ds = mysqli_fetch_assoc($rs)) {
		$province .= "<option value='{$ds["pvID"]}'>{$ds["pvName"]}</option>";
	}
}
?>

<div class="container">
	<form method="post" role="form">
		<div class="row">
			<div class="form-group col-sm-2">
				<label>จังหวัด</label>
				<select name="pvID" id="pvID" class="form-control" required>
					<?=$province?>
				</select>
			</div>
			<div class="form-group col-sm-2">
				<label>อำเภอ</label>
				<select name="ampID" id="ampID" class="form-control" required>
				</select>
			</div>
		</div>
	</form>
</div>

<script>
$(document).ready(function() {
	$("#pvID").change(function() {
		var id = $("option:selected", this).val();
		if (id != "") {
			$.post("ajax_getamphur.php", {pvID:id}, function( data ) {
				$("#ampID").html(data);
			});
		}
	});
});
</script>
