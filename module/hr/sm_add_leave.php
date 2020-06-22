<?php
if ($_GET['id']) {

    $sql_del = "UPDATE hr_person_leave SET confirm = 1 WHERE person_id='$_GET[id]' AND leave_id = '$_GET[leave]'";
    $query_delete = mysqli_query($conn, $sql_del);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("อนุมัติวันลารียบร้อยแล้ว!");
            window.location = "index.php?mod=main";
        </script>
        <?php
    }
}
?>

