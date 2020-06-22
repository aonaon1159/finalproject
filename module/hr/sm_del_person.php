<?php

if ($_GET['id']) {

    $deleted = 1;
    $sql_update_person = "UPDATE hr_person SET deleted='$deleted' WHERE person_id='{$_GET["id"]}' ";
    $query_delete = mysqli_query($conn, $sql_update_person);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบขข้อมูล เรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/manage_person";
        </script>
        <?php
    }
}
?>

