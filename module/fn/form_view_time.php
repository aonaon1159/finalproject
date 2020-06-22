<?php
include("inc/check_page.php");
include("inc/topnav.php");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Time of work management.</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-clock-o"></i> จัดการข้อมูลเวลาทำงาน.
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-9" style="padding-bottom:5px;">

                        </div>
                        <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;">
<!--                            <button type="button" class="btn btn-success btn-sm"-->
<!--                                    onclick="">-->
<!--                                <i class="fa fa-sm fa-file-text"></i> | ข้อมูลสรุปเวลาทำงาน-->
<!--                            </button>-->
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
                                        <th class="text-center">ชื่อ - สกุล (ไทย)</th>
                                        <th class="text-center">แผนก</th>
                                        <th class="text-center">ตำแหน่ง</th>
                                        <th class="text-center">จัดการ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 0;
                                    $sql_select_time = "
                                        SELECT *
                                        FROM hr_person WHERE deleted = 0
                                        GROUP BY person_id ASC
                                    ";
                                    $query_time = mysqli_query($conn, $sql_select_time) or die("Sql error is : " . mysqli_error($conn));

                                    while ($assoc_time = mysqli_fetch_assoc($query_time)) {
                                        $i++;
                                        $sql_person = mysqli_query($conn,"SELECT person_firstname_thai , person_lastname_thai FROM hr_person WHERE person_id = {$assoc_time['person_id']}");
                                        $person_select = mysqli_fetch_array($sql_person);
                                        $sql_employment = mysqli_query($conn,"SELECT employment_department, employment_position FROM hr_person_employment WHERE person_id  = {$assoc_time['person_id']}");
                                        $employment = mysqli_fetch_array($sql_employment);
                                        $sql_department = mysqli_query($conn,"SELECT department_name FROM hr_person_department WHERE department_id = {$employment[0]}");
                                        $department = mysqli_fetch_array($sql_department);
                                        $sql_position = mysqli_query($conn,"SELECT position_name FROM hr_person_position WHERE position_id = {$employment[1]}");
                                        $position = mysqli_fetch_array($sql_position);

                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>

                                            <td><?= $assoc_time["person_id"]; ?></td>
                                            <td><?=$person_select[0]?> <?=$person_select[1]?></td>
                                            <td><?=$department[0]?></td>
                                            <td><?=$position[0]?></td>
                                            <td style="text-align:center;">
                                                <a href="index.php?mod=fn/form_view_timedetail&id=<?= $assoc_time["person_id"]; ?>"
                                                   class="btn btn-xs btn-info"><span
                                                            class="fa fa-file-text"></span>  
                                                        | ข้อมูลเวลาทำงาน</a>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
<!--                                         <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสเครื่อง</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ - สกุล (ไทย)</th>
                                        <th class="text-center">แผนก</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">จัดการ</th> -->
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <?php
                        //                            $sql_select_time = "SELECT * FROM fn_scan WHERE file_id='{$assoc_time["file_id"]}'";
                        //                            $query_time = mysqli_query($conn, $sql_select_time);
                        //                            $num_time = mysqli_num_rows($query_time);
                        //                            echo "num : ".$num_time; echo "<br>";
                        //                            $limit_row_time = $num_time - 1;
                        //                            $count = 1;
                        //                            while ($assoc_time_test = mysqli_fetch_assoc($query_time)) {
                        //                                if ($count < $limit_row_time){
                        //                                    echo $assoc_time_test["time_income_net"]; echo "<br>";
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


