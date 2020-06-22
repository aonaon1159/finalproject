    <?php
    include("inc/check_page.php");
    include("inc/topnav.php");
    ?>

    <div id="page-wrapper-hr">
        <?php
        if (isset($_GET['page_id'])) $page_id = $_GET['page_id'];
        else $page_id = 1;

        $query_rows = mysqli_query($conn, "SELECT * FROM hr_person WHERE deleted!=1 ");
        $rows = mysqli_num_rows($query_rows);

        $rows_per_page = 15;
        $pages = ceil($rows / $rows_per_page);
        $start_rows = (($page_id - 1) * $rows_per_page);
        $resign = "SELECT * FROM hr_person WHERE deleted != 0";
        $leave = "SELECT * FROM hr_person WHERE deleted = 0";

        $query_resgin = mysqli_query($conn,$resign);
        $amount_resgin = mysqli_num_rows($query_resgin);
        $query_leave = mysqli_query($conn,$leave);
        $amount_leave = mysqli_num_rows($query_leave);

        ?>
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <h3 class="page-header">Human Resources.</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" style="padding:0 25px 0 30px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-user-circle"></i> ตารางจัดการข้อมูลพนักงาน.
                        <div class="pull-right">
                            <div class="btn-group">

                            </div>
                        </div>
                    </div>

                    <?php
                    $present_date=date("Y-m-d");
                    ?>
                    <div class="ibox-tools">
                        <div class="table-responsive">
                            <div class="col-sm-12" style="padding:10px 15px 5px 0; text-align:right;">
                                <button type="button" class="btn btn-success btn-sm"
                                onclick="window.location.href='index.php?mod=hr/manage_person'">
                                <span class='badge'><?=number_format($amount_leave)?></span> พนักงานทั่วไป
                            </button>
                            <button type="button" class="btn btn-danger btn-sm"
                            onclick="window.location.href='index.php?mod=hr/manage_person_resign';">
                            <span class='badge'><?=number_format($amount_resgin)?></span> พนักงาน ลาออก
                        </button>
                        <?php if ($_SESSION["level"] ==  2) { ?>
                            <button type="button" class="btn btn-primary btn-sm" onclick="add_person();">
                                <i class="fa fa-sm fa-user-plus"></i> | เพิ่มข้อมูลพนักงาน
                            </button>
                        <?php } ?>
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
                            $sql_select = "SELECT * FROM hr_person WHERE deleted=0 ORDER BY person_createDate DESC LIMIT $start_rows,$rows_per_page ";
                            $query_person = mysqli_query($conn, $sql_select);
                            $rows_person = mysqli_num_rows($query_person);
                            ?>
                            <thead>
                                <tr>
                                    <th style="text-align:left;">ลำดับ</th>
                                    <th style="text-align:left;">คำนำหน้า</th>
                                    <th style="text-align:left;">ชื่อ</th>
                                    <th style="text-align:left;">นามสกุล</th>
                                    <th style="text-align:left;">เบอร์โทรศัพท์</th>
                                    <th style="text-align:left;">สถานะพนักงาน</th>
                                    <th style="text-align:left;">สถานะการทำงาน</th>
                                    <th style="text-align:left;">สถานะการพักงาน</th>
                                    <th style="text-align:left;">จัดการข้อมูล</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $i = 1;
                                while ($assoc_person_chk = mysqli_fetch_assoc($query_person)) {

                                    $sql_select_employment_chk = "
                                    SELECT person_id FROM hr_person_employment 
                                    WHERE person_id='{$assoc_person_chk["person_id"]}' AND employment_status!='0' AND employment_work_status!='2'
                                    ";
                                    $query_emp_chk = mysqli_query($conn, $sql_select_employment_chk);

                                    while ($assoc_emp_chk = mysqli_fetch_assoc($query_emp_chk)) {

                                        $sql_select_person = "
                                        SELECT * FROM hr_person WHERE person_id='{$assoc_emp_chk["person_id"]}'
                                        ";
                                        $query_person_table = mysqli_query($conn, $sql_select_person);

                                        while ($person = mysqli_fetch_array($query_person_table)) {

                                            $sql_select_employment = "SELECT employment_status,employment_work_status,employment_break_status,employment_start_break,employment_finish_break FROM hr_person_employment WHERE person_id='$person[0]' ";
                                            $query_employment = mysqli_query($conn, $sql_select_employment);
                                            list($status, $work_status, $break_status, $break_start, $break_finish) = mysqli_fetch_row($query_employment);
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $i ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($person[1] == 1) echo "นาย";
                                                    else if ($person[1] == 2) echo "นางสาว";
                                                    else echo "นาง";
                                                    ?>
                                                </td>
                                                <td><?= $person[2] ?></td>
                                                <td><?= $person[3] ?></td>
                                                <td><?= $person[12] ?></td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    if ($status == 1) {
                                                        ?>
                                                        <button class="btn btn-success btn-xs"
                                                        <?php if ($_SESSION["level"] == 2) { ?>
                                                            onclick="window.location.href='index.php?mod=hr/form_edit_employment&edit_id=<?= $person[0] ?>';"
                                                            <?php } ?> >
                                                            พนักงาน <i class="fa fa-sm fa fa-cog"></i>
                                                        </button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button class="btn btn-default btn-xs"
                                                        <?php if ($_SESSION["level"] == 2) { ?>
                                                            onclick="window.location.href='index.php?mod=hr/form_edit_employment&edit_id=<?= $person[0] ?>';"
                                                            <?php } ?>>
                                                            ทดลองงาน <i class="fa fa-sm fa fa-cog"></i></button>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="text-align:center;">
                                                        <?php
                                                        if ($work_status == 2) {
                                                            ?>
                                                            <button class="btn btn-danger btn-xs"
                                                            onclick="window.location.href='index.php?mod=hr/form_edit_employment&edit_id=<?= $person[0] ?>';">
                                                            ลาออก <i class="fa fa-sm fa fa-cog"></i>
                                                        </button>
                                                        <?php
                                                    } else if ($work_status == 1) {
                                                        ?>
                                                        <button class="btn btn-default btn-xs">
                                                            ทำงาน ปกติ
                                                        </button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button class="btn btn-default btn-xs"> -</button>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td style="text-align:center;">
                                                    <?php
                                                    if ($work_status != 2) {
                                                        if ($break_status == 2) {
                                                            ?>
                                                            <button class="btn btn-primary btn-xs"
                                                            data-toggle="popover"
                                                            data-trigger="focus"
                                                            title="วันเริ่มต้น - วันสิ้นสุดการพักงาน"
                                                            data-content="<?= showThaiDate($break_start, "T", true) ?> ถึง <?= showThaiDate($break_finish, "T", true) ?>">
                                                            พักงาน <i class="fa fa-sm fa fa-search"></i>
                                                        </button>
                                                        <?php
                                                    } else if ($break_status == 1) {
                                                        ?>
                                                        <button class="btn btn-default btn-xs">
                                                            ทำงาน ปกติ
                                                        </button>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <button class="btn btn-default btn-xs"> -</button>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <button class="btn btn-default btn-xs"> -</button>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align:center;">
                                                <a href="index.php?mod=hr/form_view_person&id=<?= $person[0] ?>"
                                                 class="btn btn-xs btn-info"><span
                                                 class="fa fa-search"></span> | ข้อมูล</a>
                                                 <?php if ($_SESSION["level"] ==  2) { ?>
                                                    <a href="index.php?mod=hr/form_edit_person&id=<?= $person[0] ?>"
                                                     class="btn btn-xs btn-warning"><span
                                                     class="fa fa-pencil-square-o"> </span> | แก้ไข</a>
                                                     <a href="index.php?mod=hr/sm_del_person&id=<?= $person[0] ?>"
                                                         class="btn btn-xs btn-danger"
                                                         onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')">
                                                         <span class="fa fa-minus-square"></span> | ลบ</a>
                                                     <?php } ?>
                                                 </td>
                                             </tr>
                                             <?php
                                             $i++;
                                         }
                                     }
                                 }
                                 ?>
                             </tbody>

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
                        onclick='window.location="index.php?mod=hr/manage_person&page_id=<?= $first_page ?>"'
                        style="margin:0 2px;">หน้าแรก
                    </button>

                    <?php
                    if ($page_id > 1) {
                        ?>
                        <?php if ($page_id != 1) ?>
                        <button class="btn btn-default btn-sm" onclick='window.location="index.php?mod=hr/manage_person&page_id=<?= $back_page ?>"'
                            style="margin:0 2px;">หน้าก่อนหน้านี้</button>
                            <?php
                        }
                                //----------for button pages 1,2,3,4,n------------//
                        for ($i = 1; $i <= $pages; $i++) {
                            if ($i == $page_id) {
                                ?>
                                <button class="btn btn-default btn-sm"
                                onclick='window.location="index.php?mod=hr/manage_person&page_id=<?= $i ?>"'
                                style="margin:0 2px;"><?= $i ?></button>
                                <?php
                            } else {
                                ?>
                                <button class="btn btn-default btn-sm"
                                onclick='window.location="index.php?mod=hr/manage_person&page_id=<?= $i ?>"'
                                style="margin:0 2px;"><?= $i ?></button>
                                <?php
                            }
                        }
                                //--------next page-----//
                        if ($page_id < $pages) {
                            ?>
                            <button class="btn btn-default btn-sm"
                            onclick='window.location="index.php?mod=hr/manage_person&page_id=<?= $next_page ?>"'
                            style="margin:0 2px;">ถัดไป
                        </button>
                        <?php

                        ?>
                        <button class="btn btn-default btn-sm"
                        onclick='window.location="index.php?mod=hr/manage_person&page_id=<?= $last_page ?>"'
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
<ul class="pager">
    <li><a href="?mod=main" class="btn btn-default">กลับสู่หน้าหลัก</a></li>
</ul>
</div>

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

        $("[data-toggle='popover']").popover();

    });

    function add_person() {
        window.location = 'index.php?mod=hr/form_add_person';
    }

</script>


