<div class="container-fluid bg-info" style="height: 100%; min-height: 100%; position: absolute;">

<?php
if (isset($_POST["loginBtn"])) {
	$_POST["u"] = mysqli_real_escape_string($conn, $_POST["u"]);
	$_POST["p"] = md5($_POST["p"]);
	$sql = "SELECT * FROM users WHERE uName = '{$_POST["u"]}' AND not deleted";
	$res = mysqli_query($conn, $sql) or die("<div class='alert alert-danger' style='position: fixed; top: 0px; z-index: 9999; width: 100%'>" . mysqli_error($conn) . "</div>");
	if (mysqli_num_rows($res)) {
		$row = mysqli_fetch_assoc($res);
		if ($_POST["p"] == $row["uPass"]) {
				$_SESSION["uName"] = $row["uName"];
				$_SESSION["fullName"] = $row["fullName"];
				$_SESSION["uID"] = $row["uID"];
				$_SESSION["level"] = $row["uLevel"];
				logevent("Avia Login Success: User ({$_POST["u"]}).", $row["uID"]);
				exit("<script>window.location = './?mod=main';</script>");
		} else {
			logevent("Avia Login Fail: Invalid password. User ({$_POST["u"]}).", $row["uID"]);
			echo "
					<div class='alert alert-danger alert-dismissable fade in' style='width: 100%;'> 
						<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
						รหัสผ่านไม่ถูกต้อง 
					</div>
				";
		}
	} else {
		logevent("Avia Login Fail: Invalid user ({$_POST["u"]}).");
		echo "
				<div class='alert alert-danger alert-dismissable fade in' style='width: 100%;'> 
					<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
					ผู้ใช้งานไม่ถูกต้อง 
				</div>
			";
	}
}
?>

	<div class="row" style="margin-top: 85px;">
		<center>
		<img src="images/logo.png" class="img-responsive">
		</center>
	</div>
	
	<div class="row" style="margin-top: 20px;">
		<h4 class="text-center"><?php echo $head; ?> Login</h4>
	</div>
	
	<div class="row" style="margin-top: 10px;">
		<div class="col-sm-4 col-sm-offset-4">
			<div class="panel panel-warning">
				<div class="panel-body">
					<form method="post" role="form">
						<div class="input-group">
							<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
							<input type="text" name="u" placeholder="ผู้ใช้งาน" class="form-control input-lg" required data-errormessage-value-missing="กรุณากรอกข้อมูลนี้">
						</div>
						<br>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" name="p" placeholder="รหัสผ่าน" class="form-control input-lg" required data-errormessage-value-missing="กรุณากรอกข้อมูลนี้">
						</div>
						<br>
						<p class="text-right">
							<button name="loginBtn" class="btn btn-success btn-lg">
								<i class="fa fa-sign-in fa-lg"></i> เข้าใช้งาน
							</button>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	
</div>
