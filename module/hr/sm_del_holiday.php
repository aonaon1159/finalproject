<?php

if ($_GET['id']) {

    $sql_del = "UPDATE hr_year_holiday SET deleted = 1 WHERE holiday_id='$_GET[id]'";
    $query_delete = mysqli_query($conn, $sql_del);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบวันหยุดเรียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/manage_holiday";
        </script>
        <?php
    }
}
?>

