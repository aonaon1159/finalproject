<?php

include("inc/check_page.php");
include("inc/topnav.php");
$id = $_GET['id'];
?>

<div id="page-wrapper-hr">
    <?php
    if (isset($_GET['page_id'])) {
        $page_id = $_GET['page_id'];
    } else {
        $page_id = 1;
    }

    $query_rows = mysqli_query($conn, "SELECT person_id FROM hr_person WHERE deleted!=1 ");
    $rows = mysqli_num_rows($query_rows);

    $rows_per_page = 15;
    $pages = ceil($rows / $rows_per_page);
    $start_rows = (($page_id - 1) * $rows_per_page);

    ?>
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">การลางาน</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-circle"></i> ตารางจัดการข้อมูลลางาน
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
                                    <?php
                                        $m = strtotime(date("Y-m-d"));
                                        $m_la = strtotime("-2 month" ,$m);
                                        $m_sql = date("m" ,$m);
                                        $m_la_sql = date("m" ,$m_la);
                                    $sql_select = "SELECT hr_person.person_id, person_prename, person_firstname_thai, person_lastname_thai, person_phone FROM `hr_person` INNER JOIN hr_person_leave ON hr_person.person_id = hr_person_leave.person_id WHERE hr_person_leave.person_leave_status = $id  AND hr_person_leave.confirm = 1 AND hr_person_leave.deleted = 0 AND hr_person.deleted = 0 AND(month(person_leave_begin) = '$m_sql' OR month(person_leave_begin) = '$m_la_sql') GROUP BY person_id ORDER BY file_createDate ASC LIMIT $start_rows,$rows_per_page ";
                                    $query_person = mysqli_query($conn, $sql_select);
                                    $rows_person = mysqli_num_rows($query_person);
                                    ?>
                                    <thead>
                                    <tr>
                                        <th style="text-align:center;">ลำดับ</th>
                                        <th style="text-align:center;">คำนำหน้า</th>
                                        <th style="text-align:center;">ชื่อ</th>
                                        <th style="text-align:center;">นามสกุล</th>
                                        <th style="text-align:center;">เบอร์โทรศัพท์</th>
                                        <th style="text-align:center;">สถานะพนักงาน</th>
                                        <th style="text-align:center;">จัดการข้อมูล</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $i = 1;
                                    while (list($person_id ,$person_prename ,$person_firstname_thai ,$person_lastname_thai ,$person_phone) = mysqli_fetch_row($query_person)) {
                                        $sql_select_employment = "SELECT employment_status , employment_work_status FROM hr_person_employment WHERE person_id='$person_id' ";
                                        $query_employment = mysqli_query($conn, $sql_select_employment);
                                        list($status,$work_status) = mysqli_fetch_row($query_employment);

                                        ?>
                                        <tr>
                                            <td>
                                                <?= $i ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ($person_prename == 1) echo "นาย";
                                                else if ($person_prename == 2) echo "นางสาว";
                                                else echo "นาง";
                                                ?>
                                            </td>
                                            <td><?= $person_firstname_thai ?></td>
                                            <td><?= $person_lastname_thai ?>
                                            <?php 
                                            if ($work_status == 1) {
                                                echo "";
                                             }elseif ($work_status == 2) {
                                                echo "(ลาออก)";
                                             }else echo "";
                                             ?>   
                                            </td>
                                            <td><?= $person_phone ?></td>
                                            <td style="text-align:center;">
                                                <?php
                                                if ($status == 1) {
                                                    ?>
                                                    <button class="btn btn-success btn-xs">พนักงาน</button>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <button class="btn btn-default btn-xs">ทดลองงาน</button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align:center;">

                                                <a href="index.php?mod=hr/detail_leave_person&id=<?=$person_id ?>&status=<?=$id?>"
                                                   class="btn btn-xs btn-info"><span class="fa fa-pencil-square-o"></span>  | ข้อมูล</a>

                                            </td>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    mysqli_free_result($query_person);
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
<!--                                         <th style="text-align:center;">ลำดับ</th>
                                        <th style="text-align:center;">คำนำหน้า</th>
                                        <th style="text-align:center;">ชื่อ</th>
                                        <th style="text-align:center;">นามสกุล</th>
                                        <th style="text-align:center;">เบอร์โทรศัพท์</th>
                                        <th style="text-align:center;">สถานะพนักงาน</th>
                                        <th style="text-align:center;">จัดการข้อมูล</th> -->
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div id='page_number' class="ibox-content">
                            <div class="col-sm-12" style="float:left;">
                                <?php
                                $first_page = 1;
                                $next_page = $page_id + 1;
                                $back_page = $page_id - 1;
                                $last_page = $pages;
                                if ($rows != 0)
                                    ?>
                                <?php if ($page_id != 1) ?>
                                <button class="btn btn-primary btn-sm"
                                        onclick='window.location="index.php?mod=hr/manage_leave&page_id=<?= $first_page ?>"'
                                        style="margin:0 2px;">หน้าแรก
                                </button>

                                <?php
                                if ($page_id > 1) {
                                    ?>
                                    <?php if ($page_id != 1) ?>
                                        <button class="btn btn-default btn-sm" onclick='window.location="index.php?mod=hr/manage_leave&page_id=<?= $back_page ?>"'
                                    style="margin:0 2px;">หน้าก่อนหน้านี้</button>
                                    <?php
                                }
                                //----------for button pages 1,2,3,4,n------------//
                                for ($i = 1; $i <= $pages; $i++) {
                                    if ($i == $page_id) {
                                        ?>
                                        <button class="btn btn-default btn-sm"
                                                onclick='window.location="index.php?mod=hr/manage_leave&page_id=<?= $i ?>"'
                                                style="margin:0 2px;"><?= $i ?></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button class="btn btn-default btn-sm"
                                                onclick='window.location="index.php?mod=hr/manage_leave&page_id=<?= $i ?>"'
                                                style="margin:0 2px;"><?= $i ?></button>
                                        <?php
                                    }
                                }
                                //--------next page-----//
                                if ($page_id < $pages) {
                                    ?>
                                    <button class="btn btn-default btn-sm"
                                            onclick='window.location="index.php?mod=hr/manage_leave&page_id=<?= $next_page ?>"'
                                            style="margin:0 2px;">ถัดไป
                                    </button>
                                    <?php

                                    ?>
                                    <button class="btn btn-default btn-sm"
                                            onclick='window.location="index.php?mod=hr/manage_leave&page_id=<?= $last_page ?>"'
                                            style="margin:0 2px;">หน้าสุดท้าย
                                    </button>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-sm-8"></div>
                        </div>

                        <div class="col-sm-8">
                            <div id="morris-bar-chart"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  <ul class="pager">
        <li><a href="?mod=main" class="btn btn-default">กลับสู่หน้าหลัก</a></li>
    </ul>
<script>
    $("#page_number").hide();
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


