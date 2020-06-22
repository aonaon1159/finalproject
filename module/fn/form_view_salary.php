<?php

include("inc/check_page.php");
include("inc/topnav.php");

$salary_income_rate = 0;
$salary_work_day = 0;
$salary_income = 0;
$salary_income_position = 0;
$salary_income_commission = 0;
$salary_commission_stock = 0;
$salary_holiday = 0;
$salary_income_holiday = 0;
$salary_income_overtime_hours = 0;
$salary_income_overtime = 0;
$salary_income_journey = 0;
$salary_income_other = 0;
$salary_income_othersum = 0;
$salary_income_bonus = 0;
$salary_income_bonusyear = 0;
$salary_income_total = 0;
$salary_expense_late = 0;
$salary_expense_before = 0;
$salary_expense_accident = 0;
$salary_expense_leave = 0;
$salary_expense_subtract = 0;
$salary_expense_bail = 0;
$salary_expense_other = 0;
$salary_expense_total = 0;
$salary_income_sum = 0;
$salary_expense_insurance = 0;
$salary_expense_tax = 0;
$salary_income_net = 0;

?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Salary management.</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-money"></i> จัดการข้อมูลเงินเดือน.
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-9" style="padding-bottom:5px;">
                            <button class="btn btn-default" type="button"
                                    id="btn_nextpage"
                                    class="btn btn-default"
                                    onclick="window.location='index.php?mod=fn/manage_salary'">
                                <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
                        <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;">
                            <button type="button" class="btn btn-success btn-sm"
                                    onclick="window.location='index.php?mod=fn/form_view_summarize&id=<?= $_GET['id'] ?>'">
                                <i class="fa fa-sm fa-calendar"></i> | ข้อมูลสรุปเงินเดือน
                            </button>
                        </div>
                        <div class="col-sm-12">
                            <hr>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id='hr_table'
                                       class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อเต็ม (Thai)</th>
                                        <th class="text-center">ประเภทการจ่ายเงิน</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">แผนก</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">จัดการ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    $sql_select_salary = "
                                        SELECT * FROM fn_salary WHERE file_id='{$_GET["id"]}'
                                    ";
                                    $query_salary = mysqli_query($conn, $sql_select_salary);
                                    $num_salary = mysqli_num_rows($query_salary);

                                    $limit_row_salary = $num_salary;
                                    $count = 1;
                                    while ($assoc_salary = mysqli_fetch_assoc($query_salary)) {
                                        if ($count <= $limit_row_salary) {

                                            // ______________ Start calculating income && expense ___________________//
                                            $salary_income_rate += str_replace('|', '', $assoc_salary["salary_income_rate"]);
                                            $salary_work_day += str_replace('|', '', $assoc_salary["salary_work_day"]);
                                            $salary_income += str_replace('|', '', $assoc_salary["salary_income"]);

                                            if($assoc_salary["salary_income_position"]==""){
                                                $tmp_salary_income_position=0;
                                                $salary_income_position+=$tmp_salary_income_position;
                                            }else{
                                                $salary_income_position += str_replace('|', '', $assoc_salary["salary_income_position"]);
                                            }

                                            if($assoc_salary["salary_income_commission"]==""){
                                                $tmp_salary_income_commission=0;
                                                $salary_income_commission+=$tmp_salary_income_commission;
                                            }else{
                                                $salary_income_commission += str_replace('|', '', $assoc_salary["salary_income_commission"]);
                                            }

                                            if($assoc_salary["salary_commission_stock"]==""){
                                                $tmp_salary_commission_stock=0;
                                                $salary_commission_stock+=$tmp_salary_commission_stock;
                                            }else{
                                                $salary_commission_stock += str_replace('|', '', $assoc_salary["salary_commission_stock"]);
                                            }

                                            if($assoc_salary["salary_holiday"]==""){
                                                $tmp_salary_holiday=0;
                                                $salary_holiday+=$tmp_salary_holiday;
                                            }else{
                                                $salary_holiday += str_replace('|', '', $assoc_salary["salary_holiday"]);
                                            }

                                            if($assoc_salary["salary_income_holiday"]==""){
                                                $tmp_salary_income_holiday=0;
                                                $salary_income_holiday+=$tmp_salary_income_holiday;
                                            }else{
                                                $salary_income_holiday += str_replace('|', '', $assoc_salary["salary_income_holiday"]);
                                            }

                                            if(!is_numeric($assoc_salary["salary_income_overtime_hours"])){
                                                $tmp_income_overtime_hours=0;
                                                $salary_income_overtime_hours+=$tmp_income_overtime_hours;
                                            }else{
                                                $salary_income_overtime_hours += str_replace('|', '', $assoc_salary["salary_income_overtime_hours"]);
                                            }

                                            if($assoc_salary["salary_income_overtime"]==""){
                                                $tmp_salary_income_overtime=0;
                                                $salary_income_overtime+=$tmp_salary_income_overtime;
                                            }else{
                                                $salary_income_overtime += str_replace('|', '', $assoc_salary["salary_income_overtime"]);
                                            }

                                            if($assoc_salary["salary_income_journey"]==""){
                                                $tmp_salary_income_journey=0;
                                                $salary_income_journey+=$tmp_salary_income_journey;
                                            }else{
                                                $salary_income_journey += str_replace('|', '', $assoc_salary["salary_income_journey"]);
                                            }

                                            if($assoc_salary["salary_income_other"]==""){
                                                $tmp_salary_income_journey=0;
                                                $salary_income_other+=$tmp_salary_income_journey;
                                            }else{
                                                $salary_income_other += str_replace('|', '', $assoc_salary["salary_income_other"]);
                                            }

                                            if($assoc_salary["salary_income_othersum"]==""){
                                                $tmp_salary_income_othersum=0;
                                                $salary_income_othersum+=$tmp_salary_income_othersum;
                                            }else{
                                                $salary_income_othersum += str_replace('|', '', $assoc_salary["salary_income_othersum"]);
                                            }

                                            if($assoc_salary["salary_income_bonus"]==""){
                                                $tmp_salary_income_bonus=0;
                                                $salary_income_bonus+=$tmp_salary_income_bonus;
                                            }else{
                                                $salary_income_bonus += str_replace('|', '', $assoc_salary["salary_income_bonus"]);
                                            }

                                            if($assoc_salary["salary_income_bonusyear"]==""){
                                                $tmp_salary_income_bonusyear=0;
                                                $salary_income_bonusyear+=$tmp_salary_income_bonusyear;
                                            }else{
                                                $salary_income_bonusyear += str_replace('|', '', $assoc_salary["salary_income_bonusyear"]);
                                            }

                                            if($assoc_salary["salary_income_total"]==""){
                                                $tmp_salary_income_total=0;
                                                $salary_income_total+=$tmp_salary_income_total;
                                            }else{
                                                $salary_income_total += str_replace('|', '', $assoc_salary["salary_income_total"]);
                                            }

                                            if($assoc_salary["salary_expense_late"]==""){
                                                $tmp_salary_expense_late=0;
                                                $salary_expense_late+=$tmp_salary_expense_late;
                                            }else{
                                                $salary_expense_late += str_replace('|', '', $assoc_salary["salary_expense_late"]);
                                            }

                                            if($assoc_salary["salary_expense_before"]==""){
                                                $tmp_salary_expense_before=0;
                                                $salary_expense_before+=$tmp_salary_expense_before;
                                            }else{
                                                $salary_expense_before += str_replace('|', '', $assoc_salary["salary_expense_before"]);
                                            }

                                            if($assoc_salary["salary_expense_accident"]==""){
                                                $tmp_salary_expense_accident=0;
                                                $salary_expense_accident+=$tmp_salary_expense_accident;
                                            }else{
                                                $salary_expense_accident += str_replace('|', '', $assoc_salary["salary_expense_accident"]);
                                            }

                                            if($assoc_salary["salary_expense_leave"]==""){
                                                $tmp_salary_expense_leave=0;
                                                $salary_expense_leave+=$tmp_salary_expense_leave;
                                            }else{
                                                $salary_expense_leave += $assoc_salary["salary_expense_leave"];
                                            }

                                            if($assoc_salary["salary_expense_subtract"]==""){
                                                $tmp_salary_expense_subtract=0;
                                                $salary_expense_subtract+=$tmp_salary_expense_subtract;
                                            }else{
                                                $salary_expense_subtract += str_replace('|', '', $assoc_salary["salary_expense_subtract"]);
                                            }

                                            if($assoc_salary["salary_expense_bail"]==""){
                                                $tmp_salary_expense_bail=0;
                                                $salary_expense_bail+=$tmp_salary_expense_bail;
                                            }else{
                                                $salary_expense_bail += str_replace('|', '', $assoc_salary["salary_expense_bail"]);
                                            }

                                            if($assoc_salary["salary_expense_other"]==""){
                                                $tmp_salary_expense_other=0;
                                                $salary_expense_other+=$tmp_salary_expense_other;
                                            }else{
                                                $salary_expense_other += str_replace('|', '', $assoc_salary["salary_expense_other"]);
                                            }

                                            if($assoc_salary["salary_expense_total"]==""){
                                                $tmp_salary_expense_total=0;
                                                $salary_expense_total+=$tmp_salary_expense_total;
                                            }else{
                                                $salary_expense_total += str_replace('|', '', $assoc_salary["salary_expense_total"]);
                                            }

                                            if($assoc_salary["salary_income_sum"]==""){
                                                $tmp_salary_income_sum=0;
                                                $salary_income_sum+=$tmp_salary_income_sum;
                                            }else{
                                                $salary_income_sum += str_replace('|', '', $assoc_salary["salary_income_sum"]);
                                            }

                                            if($assoc_salary["salary_expense_insurance"]==""){
                                                $tmp_salary_expense_insurance=0;
                                                $salary_expense_insurance+=$tmp_salary_expense_insurance;
                                            }else{
                                                $salary_expense_insurance += str_replace('|', '', $assoc_salary["salary_expense_insurance"]);
                                            }

                                            if($assoc_salary["salary_expense_tax"]==""){
                                                $tmp_salary_expense_tax=0;
                                                $salary_expense_tax+=$tmp_salary_expense_tax;
                                            }else{
                                                $salary_expense_tax += str_replace('|', '', $assoc_salary["salary_expense_tax"]);
                                            }

                                            if($assoc_salary["salary_income_net"]==""){
                                                $tmp_salary_income_net=0;
                                                $salary_income_net+=$tmp_salary_income_net;
                                            }else{
                                                $salary_income_net += str_replace('|', '', $assoc_salary["salary_income_net"]);
                                            }

                                            ?>
                                            <tr>
                                                <td><?= $assoc_salary["salary_count"] ?></td>
                                                <td><?= $assoc_salary["person_id"] ?></td>
                                                <td><?= $assoc_salary["salary_fullname_thai"] ?></td>
                                                <td>
                                                    <?php 
                                                        if ($assoc_salary["salary_payment"] == null) { echo "กรุณาเลือกประเภทการจ่ายเงิน"; }
                                                        else echo  $assoc_salary["salary_payment"];
                                                    ?>    
                                                </td>
                                                <td>
                                                    <?php
                                                       if ($assoc_salary["salary_position"] == null) { echo "กรุณาเลือกตำแหน่งงาน"; }
                                                       else echo $assoc_salary["salary_position"]; 
                                                   ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                       if ($assoc_salary["salary_department"] == null) { echo "กรุณาเลือกแผนกงาน"; }
                                                       else echo $assoc_salary["salary_department"];
                                                   ?> 
                                               </td>
                                                <td>
                                                    <?php 
                                                       if  ($assoc_salary["salary_status"] == null ) { echo "กรุณาเลือกสถานะ"; }
                                                       else echo $assoc_salary["salary_status"];
                                                   ?>  
                                               </td>

                                                <td style="text-align:center;">
                                                    <a href="index.php?mod=fn/form_view_detail&salary_id=<?= $assoc_salary["salary_id"] ?>&file_id=<?= $assoc_salary["file_id"] ?>"
                                                       class="btn btn-xs btn-info"><span
                                                                class="fa fa-calendar"></span>  | ข้อมูล</a>
                                                    <a href="index.php?mod=fn/form_edit_salary&salary_id=<?= $assoc_salary["salary_id"] ?>&file_id=<?= $assoc_salary["file_id"] ?>"
                                                       class="btn btn-xs btn-warning"><span
                                                                class="fa fa-pencil-square-o"></span>  | แก้ไข</a>
                                                    <a href="index.php?mod=fn/sm_del_salary&salary_id=<?= $assoc_salary["salary_id"] ?>&file_id=<?= $assoc_salary["file_id"] ?>"
                                                       class="btn btn-xs btn-danger"
                                                       onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')"><span
                                                                class="fa fa-minus-square"></span> | ลบ</a>
                                                </td>
                                            </tr>
                                            <?php
                                        } else break;

                                        $count++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
<!--                                         <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อเต็ม (Thai)</th>
                                        <th class="text-center">ประเภทการจ่ายเงิน</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">แผนก</th>
                                        <th class="text-center">ส่วนงาน</th>
                                        <th class="text-center">สถานะ</th>
                                        <th class="text-center">จัดการ</th> -->
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <?php
                        //                            $sql_select_salary = "SELECT * FROM fn_salary WHERE file_id='{$assoc_salary["file_id"]}'";
                        //                            $query_salary = mysqli_query($conn, $sql_select_salary);
                        //                            $num_salary = mysqli_num_rows($query_salary);
                        //                            echo "num : ".$num_salary; echo "<br>";
                        //                            $limit_row_salary = $num_salary - 1;
                        //                            $count = 1;
                        //                            while ($assoc_salary_test = mysqli_fetch_assoc($query_salary)) {
                        //                                if ($count < $limit_row_salary){
                        //                                    echo $assoc_salary_test["salary_income_net"]; echo "<br>";
                        //                                    echo "count is : ".$count;
                        //                                }
                        //                                $count++;
                        //                            }
                        ?>

                        <div class="col-sm-8">
                            <div id="morris-bar-chart"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <div>
    <?php
    $cut_salary = test2(1,2,"test","yes");
    print_r($cut_salary);
    echo "<br>";
    echo $cut_salary['s'];
    echo "<br>";
    echo $cut_salary['r'];
    ?>
</div> -->
<script>

    $(document).ready(function () {
        $('.dataTables-example').DataTable({
            // dom: '<"html5buttons"B>lTfgitp',
            // buttons: [],
            "language": {
                "sProcessing": "กำลังดำเนินการ...",
                "sLengthMenu": "แสดง  _MENU_  แถว",
                "sZeroRecords": "ไม่พบข้อมูล",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sSearch": "ค้นหา:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "เิริ่มต้น",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "สุดท้าย"
                }
            }
        });

    });

</script>


