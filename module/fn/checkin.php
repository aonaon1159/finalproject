<?php
if(!isset($_GET['id'])){
    exit("<script>window.location = './';</script>");
}

$id = $_GET['id'];
$date = date('Y-m-d');
$sql_checkdate = "SELECT time_datetime FROM fn_check_time WHERE person_id = $id";
$query_checkdate = mysqli_query($conn, $sql_checkdate);
while (list($checkdate) = mysqli_fetch_row($query_checkdate)) {
    if ($date == $checkdate) {
        ?> <script>
            alert("วันนี้เช็คชื่อไปแล้ว!");
            window.location= './';
        </script>
        <?php exit();
    }
}



$time = date('H:i:s');
$month = date('m');
$year = date('Y');
$comment = "";
$discount = 0;
if (date('H') < 8){
  $comment = "เข้างานตรงเวลา";
}elseif (date('H') > 8){ 
    $comment = "สาย"; 
    $discount = 1;
}
$sql_checkin = "INSERT INTO fn_check_time SET person_id = '$id' ,
month = '$month',
year = '$year',
time_datetime = '$date', 
time_timein = '$time', 
time_discount = $discount,
time_comment = '$comment'";
$query_checkin = mysqli_query($conn, $sql_checkin);


?>
<script>
    alert("เช็คชื่อแล้ว!");
    window.location = "./"
</script>
<?php
