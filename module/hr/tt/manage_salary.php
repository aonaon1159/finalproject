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

                <div class="ibox-tools">
                    <div class="col-sm-9"></div>
                    <div class="col-sm-3" style="padding:10px 15px 5px 0; text-align:right;">
                        <button type="button" class="btn btn-primary btn-sm" onclick="add_salary();">
                            <i class="fa fa-sm fa-folder-open"></i> | เพิ่มข้อมูลเงินเดือน
                        </button>
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
                                        <th style="text-align:left;">ลำดับ</th>
                                        <th style="text-align:left;">บริษัท</th>
                                        <th style="text-align:left;">หัวข้อ</th>
                                        <th style="text-align:left;">วันที่เพิ่ม</th>
                                        <th style="text-align:left;">จัดการ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    $query_fn_salary_file = mysqli_query($conn, "SELECT * FROM fn_salary_file WHERE deleted=0");
                                    while ($file_assoc = mysqli_fetch_assoc($query_fn_salary_file)) {
                                        ?>
                                        <tr>
                                            <td><?= $i ?></td>
                                            <td>
                                                <?php
                                                $sql_select_company = "SELECT * FROM hr_person_company";
                                                $query_select_company = mysqli_query($conn, $sql_select_company);
                                                while ($assoc_company = mysqli_fetch_assoc($query_select_company)) {
                                                    echo $company = ($assoc_company["company_id"] == $file_assoc["file_company"]) ? $assoc_company["company_name"] : "";
                                                }
                                                ?>
                                            </td>
                                            <td><?= $file_assoc["file_title"] ?></td>
                                            <td>
                                                <?php
//                                                echo "date : ".$file_assoc["file_createDate"];
                                                //                                                $exp_createDate = explode(" ", $file_assoc["file_createDate"]);
                                                //                                                echo "$exp_createDate[0]";
                                                echo shortDate("th",$file_assoc["file_createDate"], true);
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <a href="index.php?mod=fn/form_view_salary&id=<?= $file_assoc["file_id"] ?>"
                                                   class="btn btn-xs btn-info"><span
                                                            class="fa fa-calendar"> | ข้อมูล</span></a>
                                                <a href="index.php?mod=fn/form_edit_file&id=<?= $file_assoc["file_id"] ?>"
                                                   class="btn btn-xs btn-warning"><span
                                                            class="fa fa-pencil-square-o">  | แก้ไข</span></a>
                                                <a href="index.php?mod=fn/sm_del_file&id=<?= $file_assoc["file_id"] ?>"
                                                   class="btn btn-xs btn-danger"
                                                   onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')"><span
                                                            class="fa fa-minus-square"> | ลบ</span></a>
                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th style="text-align:left;">ลำดับ</th>
                                        <th style="text-align:left;">บริษัท</th>
                                        <th style="text-align:left;">หัวข้อ</th>
                                        <th style="text-align:left;">วันที่เพิ่ม</th>
                                        <th style="text-align:left;">จัดการ</th>
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

    function add_salary() {
        window.location = 'index.php?mod=fn/form_add_file';
    }

</script>


