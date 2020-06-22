<?php
if ($_GET['id']) {

    $sql_del = "DELETE FROM hr_person_leave WHERE person_id ='$_GET[id]' AND deleted = 1";
    $query_delete = mysqli_query($conn, $sql_del);

    if ($query_delete){
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

