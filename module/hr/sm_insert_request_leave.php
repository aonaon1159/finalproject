
<?php

$id = $_POST['id'];

if(isset($_POST['leave_note']) && !empty($_POST['leave_begin'])){
    $date = date("Y-m-d H:i:s");

    list($year1, $month1 ,$day1) = explode("-", $_POST['leave_begin']);
    $leave_begin = $year1."-".$month1."-".$day1;
    // $check=0;

    if(!empty($_POST['leave_end'])){
        list($year2, $month2,$day2) = explode("-", $_POST['leave_end']);
        $leave_end = "'".$year2."-".$month2."-".$day2."'";
        // $check=1;
    }else $leave_end="0000-00-00";
    // else{
    //     $check=0;
    // }


    if($year1>9999 || $year2>9999 ){
    ?>
        <script>
            alert("กรุณากรอกข้อมูลให้ถูกต้อง");
            window.history.back();
        </script>
    <?php
        exit();
    }

    if(!empty($_POST['time_begin1'])){
        $time_begin1 = $_POST['time_begin1'];
    }else $time_begin1 = "00:00:00";
    if(!empty($_POST['time_begin2'])){
        $time_begin2 = $_POST['time_begin2'];
    }else $time_begin2 = "00:00:00";
    if(!empty($_POST['time_end1'])){
        $time_end1 = $_POST['time_end1'];
    }else $time_end1 = "00:00:00";
    if(!empty($_POST['time_end2'])){
        $time_end2 = $_POST['time_end2'];
    }else $time_end2 = "00:00:00";

    $type_leave = $_POST['type_leave'];
    $leave_note = $_POST['leave_note'];


    $sql_insert="INSERT INTO hr_person_leave (person_id ,
        leave_id ,
        person_leave_begin ,
        person_leave_end ,
        person_leave_time_begin1 ,
        person_leave_time_begin2 ,
        person_leave_time_end1 ,
        person_leave_time_end2 ,
        person_leave_status ,
        person_note ,
        file_createDate,
        file_createBy,
        confirm,
        gotit)
        VALUES ('$id',
            NULL,
            '$leave_begin',
            $leave_end,
            '$time_begin1',
            '$time_begin2',
            '$time_end1',
            '$time_end2',
            '$type_leave',
            '$leave_note',
            '$date',
            '$id',
            '0',
            '0'
        )";
    
    
    $query=mysqli_query($conn, $sql_insert);
    if($query) mysqli_close($conn);
    // echo  $sql_insert;
?>
    <script>
        alert("ส่งใบลา เรียบร้อยแล้ว");
        window.location = "./";
    </script>
<?php
}else{
?>
    <script>
        alert("กรุณากรอกข้อมูลให้ครบถ้วน!");
        window.history.back();
    </script>
<?php
}

?>
