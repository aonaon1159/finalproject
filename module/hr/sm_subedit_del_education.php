<?php

    //    echo "coming del : ".$_GET['education_id'];
    //    echo "fgdafds : ".$_GET['edit_id'];
        //exit();
if (isset($_GET['edit_id']) && isset($_GET['education_id'])) {
    $sql_del_education = "DELETE FROM hr_person_education WHERE person_id='{$_GET['edit_id']}' AND education_id='{$_GET["education_id"]}'";
    $query_del = mysqli_query($conn, $sql_del_education);
    if ($query_del) {
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบข้อมูลประวัติวุฒิการศึกษา เรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/form_edit_history&edit_id=<?=$_GET['edit_id']?>";
        </script>
        <?php
    }
}
?>

