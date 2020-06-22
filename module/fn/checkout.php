<?php
if ($_GET['id']) {
    $id = $_GET['id'];
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $sql_checkin = "UPDATE fn_check_time SET time_timeout = '$time' WHERE person_id = '$id' AND time_datetime = '$date'";
    $query_checkin = mysqli_query($conn, $sql_checkin);
    }

?>
        <script>
            alert("ลงชื่อออกแล้ว!");
            window.location = "./"
        </script>
        <?php
