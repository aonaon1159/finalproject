<?php
if ($_GET['id']) {

    $sql_del = "UPDATE hr_person_leave SET deleted = 1 WHERE person_id='$_GET[id]' AND leave_id = '$_GET[leave]'";
    $query_delete = mysqli_query($conn, $sql_del);

    if ($query_delete){
        mysqli_close($conn);
        ?>
        <script>
            alert("ลบวันลารียบร้อยแล้ว!");
            window.location = "index.php?mod=hr/manage_leave_person&id="+<?=$_GET['id']?>+'&leave='+<?=$_GET['leave']?>;
        </script>
        <?php
    }
}
?>

