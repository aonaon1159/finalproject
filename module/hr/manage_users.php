    <?php
    include("inc/check_page.php");
    include("inc/topnav.php");
    ?>

    <div id="page-wrapper-hr">
        <?php
        if (isset($_GET['page_id'])) $page_id = $_GET['page_id'];
        else $page_id = 1;

        $query_rows = mysqli_query($conn, "SELECT * FROM hr_person");
        $rows = mysqli_num_rows($query_rows);

        $rows_per_page = $rows;
        $pages = ceil($rows / $rows_per_page);
        $start_rows = (($page_id - 1) * $rows_per_page);

        ?>
        <div class="row">
            <div class="col-sm-12" style="padding-left:30px;">
                <h3 class="page-header">Avia Users.</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12" style="padding:0 25px 0 30px;">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-user-circle"></i> ตารางการสร้างบัญชีของพนักงานใหม่
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
                                    $sql_select_users = "SELECT * FROM hr_person WHERE deleted=0 
                                    AND cre_login !=1 ORDER BY person_id DESC LIMIT $start_rows,$rows_per_page ";
                                    $query_users = mysqli_query($conn, $sql_select_users);
                                    $rows_users = mysqli_num_rows($query_users);
                                    ?>
                                    <thead>
                                        <tr>
                                            <th style="text-align:left;">ลำดับ</th>
                                            <th style="text-align:left;">คำนำหน้า</th>
                                            <th style="text-align:left;">ชื่อ</th>
                                            <th style="text-align:left;">นามสกุล</th>
                                            <th style="text-align:left;">เบอร์โทรศัพท์</th>
                                            <?php if ($_SESSION["level"] == 2) { ?>
                                            <th style="text-align:left;">จัดการข้อมูล</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $i = 1;
                                        while ($user = mysqli_fetch_array($query_users)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <?=$i ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                    if ($user[1] == 1){
                                                        echo "นาย";       
                                                       }elseif ($user[1] == 2) {
                                                        echo "นางสาว"; 
                                                        }else echo "นาง";       
                                                    ?>
                                                </td>
                                                <td><?=$user[2] ?></td>
                                                <td><?=$user[3] ?></td>
                                                <td><?=$user[12] ?></td>
                            <?php if ($_SESSION["level"] == 2) { ?>
                                            <td style="text-align:center;">
                                                 <a href="index.php?mod=hr/form_add_user&id=<?=$user[0] ?>"class="btn btn-xs btn-success">
                                                     <span class="fa fa-plus-square"></span> | สร้าง</a>
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
                                onclick='window.location="index.php?mod=hr/manage_users&page_id=<?= $first_page ?>"'
                                style="margin:0 2px;">หน้าแรก
                            </button>

                            <?php
                            if ($page_id > 1) {
                                ?>
                                <?php if ($page_id != 1) ?>
                                <button class="btn btn-default btn-sm" onclick='window.location="index.php?mod=hr/manage_users&page_id=<?= $back_page ?>"'
                                    style="margin:0 2px;">หน้าก่อนหน้านี้</button>
                                    <?php
                                }
                                //----------for button pages 1,2,3,4,n------------//
                                for ($i = 1; $i <= $pages; $i++) {
                                    if ($i == $page_id) {
                                        ?>
                                        <button class="btn btn-default btn-sm"
                                        onclick='window.location="index.php?mod=hr/manage_users&page_id=<?= $i ?>"'
                                        style="margin:0 2px;"><?= $i ?></button>
                                        <?php
                                    } else {
                                        ?>
                                        <button class="btn btn-default btn-sm"
                                        onclick='window.location="index.php?mod=hr/manage_users&page_id=<?= $i ?>"'
                                        style="margin:0 2px;"><?= $i ?></button>
                                        <?php
                                    }
                                }
                                //--------next page-----//
                                if ($page_id < $pages) {
                                    ?>
                                    <button class="btn btn-default btn-sm"
                                    onclick='window.location="index.php?mod=hr/manage_users&page_id=<?= $next_page ?>"'
                                    style="margin:0 2px;">ถัดไป
                                </button>
                                <?php

                                ?>
                                <button class="btn btn-default btn-sm"
                                onclick='window.location="index.php?mod=hr/manage_users&page_id=<?= $last_page ?>"'
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
                "sZeroRecords": "สร้างไอดีบุคลากรหมดแล้ว",
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

