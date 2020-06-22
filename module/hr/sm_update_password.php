<?php 
	if(!isset($_POST["oldpass"])){
		exit("<script>window.location = './';</script>");
}
		$sql_select_pass = "SELECT uPass FROM users WHERE uID='{$_SESSION["uID"]}' ";
		$query_oldpass = mysqli_query($conn, $sql_select_pass);
		$oldpass = mysqli_fetch_array($query_oldpass);
		if($oldpass[0] != md5($_POST["oldpass"])) {
			?>        
        		<script>
            alert("รหัสเดิมไม่ถูกต้อง! <?=md5($_POST["oldpass"])?>");
            window.history.back();
        		</script>
        	<?php exit();
        	}if($_POST["newpass"] != $_POST["newpass2"]){
        		?>        
        		<script>
            alert("รหัสใหม่ไม่ตรงกัน! <?=md5($_POST["oldpass"])?>");
            window.history.back();
        		</script>
        		<?php exit();
			}
		$newpass = md5($_POST["newpass"]);
        $sql_update_pass = "UPDATE users SET uPass = '$newpass' WHERE uID = '{$_SESSION["uID"]}'";
        $query_update = mysqli_query($conn, $sql_update_pass);

    if ($query_update){
        mysqli_close($conn);
        ?>
        <script>
            alert("เปลี่ยนรหัสผ่าน เรียบร้อยแล้ว!");
            window.location = './';
        </script>
        <?php
    }
        ?>       	