<?php
session_start();

if(isset($_POST['holiday_date']) && !empty($_POST['holiday_date'])){
    $id = $_POST['id'];
    $date = date("Y-m-d");
    list($year, $month ,$day) = explode("-", $_POST['holiday_date']);
    $holiday = $year."-".$month."-".$day;
    $check=0;

    if(!empty($_POST['holiday_end'])){
        list($year2, $month2,$day2) = explode("-", $_POST['holiday_end']);
        $holiday_end = $year2."-".$month2."-".$day2;
        $check=1;
    }else{
        $check=0;
    }
    
    $holiday_title = $_POST['holiday_title'];
    $regular = isset($_POST['holiday_check'])?1:0;

    if($year>9999 && $year2>9999){
    ?>
        <script>
            alert("กรุณากรอกข้อมูลให้ถูกต้อง");
            window.location = "index.php?mod=hr/form_edit_holiday&id"+<?=$id?>;
        </script>
    <?php
        exit();
    }
    if($check==1){
        $sql_edit="UPDATE hr_year_holiday SET holiday_date = '$_POST[holiday_date]' ,holiday_end = '$holiday_end' ,holiday_end = '$_POST[holiday_end]',holiday_title = '$_POST[holiday_title]', holiday_regular = '$regular' ,file_updatedDate = '$date' ,file_updatedBy = '$_SESSION[uID]' WHERE holiday_id = '$id'";
    }else{
        $sql_edit="UPDATE hr_year_holiday SET holiday_date = '$_POST[holiday_date]' ,holiday_end = NULL ,holiday_title = '$_POST[holiday_title]', holiday_regular = '$regular' ,file_updatedDate = '$date' ,file_updatedBy = '$_SESSION[uID]' WHERE holiday_id = '$id'";
    }
    $query=mysqli_query($conn, $sql_edit);
    if($query) mysqli_close($conn);
?>
    <script>
        alert("แก้ไขวันหยุด เรียบร้อยแล้ว!");
        window.location = "index.php?mod=hr/manage_holiday";
    </script>
<?php
}else{
?>
    <script>
        alert("กรุณากรอกข้อมูลให้ครบถ้วน");
        window.location = "index.php?mod=hr/form_edit_holiday&id"+<?=$id?>;
    </script>
<?php
}
?>