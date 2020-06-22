<?php
// session_start();
$id = $_POST['id'];

if(isset($_POST['leave_note']) && !empty($_POST['leave_begin'])){
    $date = date("Y-m-d");

    list($year1, $month1 ,$day1) = explode("-", $_POST['leave_begin']);
    $leave_begin = $year1."-".$month1."-".$day1;
    // $check=0;

    if(!empty($_POST['leave_end'])){
        list($year2, $month2,$day2) = explode("-", $_POST['leave_end']);
        $leave_end = "'".$year2."-".$month2."-".$day2."'";
        // $check=1;
    }else $leave_end="NULL";
    // else{
    //     $check=0;
    // }


    if($year1>9999 || $year2>9999 ){
    ?>
        <script>
            alert("กรุณากรอกข้อมูลให้ถูกต้อง");
            window.location = "index.php?mod=hr/form_add_leave&id="+<?=$id?>;
        </script>
    <?php
        exit();
    }

    if(!empty($_POST['time_begin1'])){
        $time_begin1 = $_POST['time_begin1'];
    }else $time_begin1 = "";
    if(!empty($_POST['time_begin2'])){
        $time_begin2 = $_POST['time_begin2'];
    }else $time_begin2 = "";
    if(!empty($_POST['time_end1'])){
        $time_end1 = $_POST['time_end1'];
    }else $time_end1 = "";
    if(!empty($_POST['time_end2'])){
        $time_end2 = $_POST['time_end2'];
    }else $time_end2 = "";

    $type_leave = $_POST['type_leave'];
    $leave_note = $_POST['leave_note'];

    $sel_max = mysqli_query($conn ,"SELECT max(leave_id) FROM hr_person_leave WHERE person_id = '$id'");
    list($max) = mysqli_fetch_row($sel_max);
    $max++;

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
        confirm,gotit)
        VALUES ('$id',
            'NULL',
            '$leave_begin',
            $leave_end,
            '$time_begin1',
            '$time_begin2',
            '$time_end1',
            '$time_end2',
            '$type_leave',
            '$leave_note',
            '$date',
            '$_SESSION[uID]',
            '1',
            '1'
        )";
    
    
    $query=mysqli_query($conn, $sql_insert);
    if($query) mysqli_close($conn);
?>
    <script>
        alert("เพิ่มวันลา เรียบร้อยแล้ว!");
        window.location = "index.php?mod=hr/manage_leave_person&id="+<?=$id?>;
    </script>
<?php
}else{
?>
    <script>
        alert("กรุณากรอกข้อมูลให้ครบถ้วน");
        window.location = "index.php?mod=hr/form_add_leave&id="+<?=$id?>;
    </script>
<?php
}
?>