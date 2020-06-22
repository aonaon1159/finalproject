<?php
/**
 * Created by PhpStorm.
 * User: Avaibooking
 * Date: 1/4/2018
 * Time: 4:58 PM
 */
if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");
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
                            <button class="btn btn-default" type="button"
                                    id="btn_nextpage"
                                    class="btn btn-default"
                                    onclick="window.location='index.php?mod=fn/manage_time'">
                                <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
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
                                        <th class="text-center">รหัสเครื่อง</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ - สกุล (ไทย)</th>
                                        <th class="text-center">แผนก</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">จัดการ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $sql_select_time = "
                                        SELECT scanfile_id,
                                        time_machine_count,
                                        person_id,
                                        time_department,
                                        time_fullname,
                                        time_company
                                        FROM fn_scan 
                                        WHERE scanfile_id='{$_GET["id"]}' 
                                        GROUP BY time_machine_count,
                                        time_fullname,
                                        person_id,
                                        time_department,
                                        time_company,
                                        scanfile_id ASC
                                    ";
                                    $query_time = mysqli_query($conn, $sql_select_time) or die("Sql error is : " . mysqli_error($conn));

                                    while ($assoc_time = mysqli_fetch_assoc($query_time)) {
                                        $sql_select_machine_id="
                                          SELECT time_machine_id FROM fn_scan WHERE scanfile_id={$assoc_time["scanfile_id"]}
                                        ";
                                        $query_select_machine_id=mysqli_query($conn,$sql_select_machine_id);
                                        list($machine_id)=mysqli_fetch_row($query_select_machine_id);
                                        ?>
                                        <tr>
                                            <td><?= $assoc_time["time_machine_count"] ?></td>
                                            <td><?php
                                                if(str_replace("0","",$machine_id)==true){
                                                    echo str_replace("0","",$machine_id);
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($assoc_time["person_id"] != NULL) echo $assoc_time["person_id"];
                                                else echo " - ";
                                                ?>
                                            </td>
                                            <td><?= $assoc_time["time_fullname"] ?></td>
                                            <td><?= $assoc_time["time_department"] ?></td>
                                            <td><?= $assoc_time["time_company"] ?></td>

                                            <td style="text-align:center;">
                                                <a href="index.php?mod=fn/form_view_timedetail&count_id=<?= $assoc_time["time_machine_count"] ?>&file_id=<?= $assoc_time["scanfile_id"] ?>"
                                                   class="btn btn-xs btn-info"><span
                                                            class="fa fa-file-text">  | ข้อมูลเวลาทำงาน</span></a>
<!--                                                <a href="index.php?mod=fn/sm_del_time&time_id=--><?//= $assoc_time["time_id"] ?><!--&file_id=--><?//= $assoc_time["scanfile_id"] ?><!--"-->
<!--                                                   class="btn btn-xs btn-danger"-->
<!--                                                   onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')"><span-->
<!--                                                            class="fa fa-minus-square"> | ลบ</span></a>-->
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสเครื่อง</th>
                                        <th class="text-center">รหัสพนักงาน</th>
                                        <th class="text-center">ชื่อ - สกุล (ไทย)</th>
                                        <th class="text-center">แผนก</th>
                                        <th class="text-center">บริษัท</th>
                                        <th class="text-center">จัดการ</th>
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


