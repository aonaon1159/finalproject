<?php

if ($_GET['id']) {

    $deleted = 1;
    $sql_update_person = "UPDATE users SET deleted='$deleted' WHERE uID='{$_GET["id"]}' ";
    $query_delete = mysqli_query($conn, $sql_update_person);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบขข้อมูล เรียบร้อยแล้ว!");
            window.history.back();
        </script>
        <?php
    }
}
?>

