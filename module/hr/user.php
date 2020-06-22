    <?php
    if (!isset($_SESSION["uID"]))
        exit("<script>window.location = './';</script>");

    include("inc/topnav.php");
    include("inc/leftbar.php");
    ?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin: 30px;">Avia Users.</h1>
            </div>
                <div id="page-wrapper-hr">
        <?php
        if (isset($_GET['page_id'])) $page_id = $_GET['page_id'];
        else $page_id = 1;

        $query_rows = mysqli_query($conn, "SELECT * FROM users");
        $rows = mysqli_num_rows($query_rows);

        $rows_per_page = $rows;
        $pages = ceil($rows / $rows_per_page);
        $start_rows = (($page_id - 1) * $rows_per_page);

        ?>
        <div class="row">
            <div class="col-sm-12" style="padding:0 25px 0 30px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-user-circle"></i> ตารางจัดการข้อมูลผู้ใช้.
                        <div class="pull-right">
                            <div class="btn-group">

                            </div>
                        </div>
                    </div><br>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id='user_table'
                                    class="table table-striped table-bordered table-hover dataTables-example " >
                                    <?php
                                    $sql_select = "SELECT * FROM users WHERE deleted=0 ORDER BY uLevel DESC LIMIT $start_rows,$rows_per_page ";
                                    $query_person = mysqli_query($conn, $sql_select);
                                    $rows_person = mysqli_num_rows($query_person);
                                    ?>
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อผู้ใช้</th>
                                            <th>รหัสผ่าน</th>
                                            <th>ชื่อ</th>
                                            <th>ระดับของผู้ใช้</th>
                                            <th>ถูกเพิ่มเมื่อ</th>
                                            <?php if ($_SESSION["level"] == 2) { ?>
                                            <th>จัดการข้อมูล</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $i = 1;
                                        while ($person = mysqli_fetch_array($query_person)) {

                                            $sql_select_employment = "SELECT uName,uPass,fullName,uLevel,addDate FROM users WHERE uID='$person[0]' ";
                                            $query_employment = mysqli_query($conn, $sql_select_employment);
                                            list($username, $password, $name, $position,) = mysqli_fetch_row($query_employment);
                                            ?>
                                            <tr>
                                                <td>
                                                    <?= $i ?>
                                                </td>
                                                <td>
                                                    <?= $username ?>
                                                </td>
                                                <td><?= $password ?></td>
                                                <td><?= $name ?></td>
                                                <td><?php
                                                if ($position == "3") {
                                                    echo "ผู้บริหาร";
                                                }else if ($person[4] == "2") {
                                                    echo "แอดมิน";
                                                }else echo "พนักงาน";?>
                                            </td>
                                            <td style="text-align:center;">
                                                <?= shortDate("th",$person["addDate"], true) ?>
                                            </td>
                            <?php if ($_SESSION["level"] == 2) { ?>
                                            <td style="text-align:center;">
                                                 <a href="index.php?mod=hr/sm_del_user&id=<?= $person[0] ?>"
                                                     class="btn btn-xs btn-danger"
                                                     onclick="return confirm('คุณต้องการลบข้อมูลจริงหรือไม่')">
                                                     <span class="fa fa-minus-square"></span> | ลบ</a>
                                                 </td>
                            <?php } ?>
                                             </tr>
                                             <?php
                                             $i++;
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
        window.location = 'index.php?mod=hr/form_add_user';
    }

</script>

</div>
</div>
