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
                    <i class="fa fa-clock-o"></i> จัดการข้อมูล เวลาทำงาน.
                    <div class="pull-right">
                        <div class="btn-group">

                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id='hr_table'
                                       class="table table-striped table-bordered table-hover dataTables-example">
                                    <thead>
                                    <tr>
                                        <th style="text-align:center;">ลำดับ</th>
                                        <th style="text-align:center;">ข้อมูลของแต่ละเดือน</th>
                                        <th style="text-align:center;">วันที่เพิ่ม</th>
                                        <th style="text-align:center;">จัดการ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    $query_fn_salary_file = mysqli_query($conn, "SELECT * FROM fn_scan_file WHERE deleted=0");
                                    while ($file_assoc = mysqli_fetch_assoc($query_fn_salary_file)) {
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td><?= $file_assoc["scanfile_title"] ?></td>
                                            <td style="text-align:center;">
                                                <?= shortDate("th", $file_assoc["scanfile_createDate"], true); ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <a href="index.php?mod=fn/form_view_time&id=<?= $file_assoc["scanfile_id"] ?>"
                                                   class="btn btn-xs btn-info"><span
                                                            class="fa fa-file-o"></span>  | ข้อมูล</a>
                                                <a href="index.php?mod=fn/form_edit_time&id=<?= $file_assoc["scanfile_id"] ?>"
                                                   class="btn btn-xs btn-warning"><span
                                                            class="fa fa-pencil-square-o"></span>  | แก้ไข</a>
                                                <a href="index.php?mod=fn/sm_del_scanfile&id=<?= $file_assoc["scanfile_id"] ?>"
                                                   class="btn btn-xs btn-danger"
                                                   onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')"><span
                                                            class="fa fa-minus-square"></span> | ลบ</a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
<!--                                         <th style="text-align:left;">ลำดับ</th>
                                        <th style="text-align:left;">บริษัท</th>
                                        <th style="text-align:left;">หัวข้อ</th>
                                        <th style="text-align:left;">วันที่เพิ่ม</th>
                                        <th style="text-align:left;">จัดการ</th> -->
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div id="morris-bar-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="pager">
        <li><a href="?mod=main" class="btn btn-default">กลับสู่หน้าหลัก</a></li>
    </ul>
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

    function add_time() {
        window.location = 'index.php?mod=fn/form_add_time';
    }

</script>


