<?php
    if (!isset($_SESSION["uID"])){
        exit("<script>window.location = './';</script>");
    }
if ($_GET['id']) {
	$id = $_GET['id'];
	$sql_update_gotit ="UPDATE hr_person_leave SET gotit = 1 WHERE person_id = $id";
	$query_gotit = mysqli_query($conn, $sql_update_gotit);

	if ($query_gotit){
        mysqli_close($conn);
        ?>
        <script>
            alert("รับทราบเรียบร้อยแล้ว!");
            window.location = "./";
        </script>
        <?php
    }

}
?>