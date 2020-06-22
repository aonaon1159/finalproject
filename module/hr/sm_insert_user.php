<?php
if(isset($_POST["name"])){
    if ($_POST['level'] == 0) {
        ?>
        <script>
            alert("กรุณาเลือกระดับพนักงาน!");
            window.history.back();
        </script>
        <?php 
        exit();
}
?>
<?php 
$sql_select_old_username = "SELECT uName FROM users";
$query_old_username = mysqli_query($conn, $sql_select_old_username);
while (list($old_username) = mysqli_fetch_row($query_old_username)) {
    if ($_POST['name'] == $old_username) {
        ?>
        <script>
            alert("username ซ้ำกันในระบบ!");
            window.history.back();
        </script>
        <?php
        exit();
    }
}
    $sql_del = "UPDATE hr_person SET cre_login = 1 WHERE person_id='$_GET[id]'";
    $query_delete = mysqli_query($conn, $sql_del);

	$fullname = $_POST["fullname"];
	$addBy = $_SESSION["uName"];
	$uName = $_POST["name"];
	$uLevel = $_POST["level"];

	$uPass = md5($_POST["pass"]);
	$sql = "INSERT INTO users SET uID = '$_GET[id]' ,uName = '$uName',uPass = '$uPass',fullname = '$fullname',
	uLevel = '$uLevel',addBy = '$addBy'";
	$insert = mysqli_query($conn, $sql);
        
    }
?>

<script>
                alert("เพิ่มข้อมูลบุคลากร เรียบร้อยแล้ว!");
                window.history.go(-2);
            </script>