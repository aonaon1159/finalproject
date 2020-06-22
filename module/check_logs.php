<?php
include("inc/check_page.php");
include("inc/topnav.php");
include("inc/leftbar.php");
?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin: 30px;">Check Logs</h1>
            </div>
                <div id="page-wrapper-hr">
        <?php
        if (isset($_GET['page_id'])) $page_id = $_GET['page_id'];
        else $page_id = 1;

        $query_rows = mysqli_query($conn, "SELECT * FROM logs");
        $rows = mysqli_num_rows($query_rows);

        $rows_per_page = $rows;
        $pages = ceil($rows / $rows_per_page);
        $start_rows = (($page_id - 1) * $rows_per_page);

        ?>

        <div class="row">
            <div class="col-sm-12" style="padding:0 25px 0 30px;">
    
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id='user_table'
                                    class="table table-striped table-bordered table-hover dataTables-example " >
                                    <?php
                                    $sql_select = "SELECT * FROM logs  ORDER BY logID DESC LIMIT $start_rows,$rows_per_page ";
                                    $query_log = mysqli_query($conn, $sql_select);
                                    $rows_log = mysqli_num_rows($query_log);
                                    ?>
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>logEvent</th>
                                            <th>logTime</th>
                                            <th>URL</th>
                                            <th>IP</th>
                                            <th>User ID</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $i = 1;
                                        while ($logs = mysqli_fetch_array($query_log)) {

                                            $sql_select_logs = "SELECT * FROM logs WHERE uID='$logs[0]' ";
                                            $query_logs = mysqli_query($conn, $sql_select_logs);
                                            ?>
                                            <tr>
                                                <td><?=$i ?></td>
                                                <td><?=$logs[1] ?></td>
                                                <td><?=$logs[2] ?></td>
                                                <td><?=$logs[3] ?></td>
                                                <td><?=$logs[4] ?></td>
                                                <td><?=$logs[5] ?></td>
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


</script>
            
        </div>
    </div>
<script src="vendor/metisMenu/metisMenu.min.js"></script>
<script src="vendor/raphael/raphael.min.js"></script>
<script src="vendor/morrisjs/morris.min.js"></script>
<script src="dist/js/sb-admin-2.js"></script>