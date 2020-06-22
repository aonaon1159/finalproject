<?php
include("main.php");

if (isset($_POST["saveBtn"])) {
		
	$img = "";
	$phpFileUploadErrors = array(
		0 => 'There is no error, the file uploaded with success',
		1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
		2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
		3 => 'The uploaded file was only partially uploaded',
		4 => 'No file was uploaded',
		6 => 'Missing a temporary folder',
		7 => 'Failed to write file to disk.',
		8 => 'A PHP extension stopped the file upload.',
	);
	if ($_FILES["imgFile"]["name"] != "") {
		$check = getimagesize($_FILES["imgFile"]["tmp_name"]);
		if($check !== false) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$rds = '';
			for ($i = 0; $i < 5; $i++) {
				$rds .= $characters[rand(0, strlen($characters) - 1)];
			}
			
			$target_dir = "storages/plan/" . date("Ymd");
			if (!file_exists($target_dir)) {
				mkdir($target_dir, 0777, true);
			}
			$upload_file = $target_dir . "/" . basename($_FILES["imgFile"]["name"]);
			$ext = pathinfo($upload_file,PATHINFO_EXTENSION);
			
			$new_name = "PLAN_" . date("His") . "_{$rds}_{$_SESSION["uID"]}." . $ext;
			$target_file = $target_dir . "/" . basename($new_name);
			if (move_uploaded_file($_FILES["imgFile"]["tmp_name"], $target_file)) {
				$img = $target_file;
			} else {
				die("
					Sorry, there was an error uploading your file. Please contact system administrator.<br>
					File Upload Name: {$_FILES["imgFile"]["name"]}<br>
					New Upload Name: $newName<br>
					Target File Name: $target_file<br>
					Error #: {$_FILES["imgFile"]["error"]} : " . $phpFileUploadErrors[$_FILES["imgFile"]["error"]]
				);
			}
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}
	}
}
?>

<div class="container" style="margin-top: 50px;">
	<div class="row">
		<h3 class="page-header">เพิ่มรูป</h3>
		
		<form method="post" enctype="multipart/form-data" role="form">
		
		<div class="form-group col-sm-4">
			<label>รูป</label>
			<input type="file" 
				name="imgFile" 
				id="image"
				accept="image/*" 
				class="form-control" 
			required>
		</div>
		
		<div class="form-group col-sm-2 col-xs-6">
			<label>&nbsp;</label>
			<button name="saveBtn" class="btn btn-block btn-success">
				<i class="fa fa-check"></i> บันทึก
			</button>
		</div>
		
		<div class="form-group col-sm-2 col-xs-6">
			<label>&nbsp;</label>
			<a href="" class="btn btn-block btn-warning">
				<i class="fa fa-remove"></i> ยกเลิก
			</a>
		</div>
		
		</form>
	</div>
	<div class="row">
		<div class="col-sm-4">
			<img id="preview" width="100%" border="1">
		</div>
	</div>
</div>

<script>
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#preview').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

$("#image").change(function(){
	readURL(this);
});
</script>