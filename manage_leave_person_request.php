<?php
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}
include("inc/topnav.php");
$id = $_GET['id'];
$date = date('Y-m-d');

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
    $sql = mysqli_query($conn ,"SELECT person_prename ,person_firstname_thai ,person_lastname_thai FROM hr_person WHERE person_id = '$id' ");
    list($person_prename ,$person_firstname_thai ,$person_lastname_thai) = mysqli_fetch_row($sql);
    if ($person_prename == 1) $person_prename = "นาย";
    else if ($person_prename == 2) $person_prename = "นางสาว";
    else $person_prename = "นาง";
    mysqli_free_result($sql);
    ?>
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">การลางาน </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-user-circle"></i> ตารางจัดการข้อมูลลางาน (<?=$person_prename." ".$person_firstname_thai." ".$person_lastname_thai?>)

                </div>

                <div class="panel-body">
                    <div class="ibox-tools">
                        <div class="col-sm-9">
                            <button class="btn btn-default" type="button" onclick="window.location='index.php?mod=hr/confirm'">
                                <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
<br><br>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id='hr_table'
                                class="table table-striped table-bordered table-hover dataTables-example">
                                <?php
                                $sql_select = "SELECT leave_id ,person_leave_begin ,person_leave_end ,person_leave_time_begin1 ,person_leave_time_begin2 ,person_leave_time_end1 ,person_leave_time_end2 ,person_leave_status ,person_note, file_createDate 
                                FROM hr_person_leave 
                                WHERE person_id='$id' AND deleted = 0 AND confirm = 0  
                                ORDER BY person_leave_begin DESC 
                                LIMIT $start_rows,$rows_per_page ";
                                $query_person = mysqli_query($conn, $sql_select);
                                ?>
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">ลำดับ</th>
                                        <th style="text-align:center;">หยุดวันที่</th>
                                        <th style="text-align:center;">ถึงวันที่</th>
                                        <th style="text-align:center;">ประเภท</th>
                                        <th style="text-align:center;">หมายเหตุ</th>
                                        <th style="text-align:center;">เวลาที่สร้าง</th>
                                        <?php if ($_SESSION['level'] == 2){ ?>
                                        <th style="text-align:center;">จัดการข้อมูล</th>
                                    <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while (list($leave_id ,$person_leave_begin ,$person_leave_end ,$person_leave_time_begin1 ,$person_leave_time_begin2 ,$person_leave_time_end1 ,$person_leave_time_end2 ,$person_leave_status ,$person_note,$file_createDate) = mysqli_fetch_row($query_person)) {


                                        ?>
                                        <tr>
                                            <td>
                                                <?= $i ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <i class="fa fa-calendar"></i>
                                                <?php
                                                list($year ,$month ,$day) = explode("-", $person_leave_begin);
                                                echo "$day/$month/$year";
                                                ?>
                                                <div>
                                                    <i class="fa fa-clock-o"></i> <?=$person_leave_time_begin1." - ".$person_leave_time_end1?>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <?php if(!empty($person_leave_end)){ ?>
                                                    <i class="fa fa-calendar"></i>
                                                    <?php
                                                    list($year ,$month ,$day) = explode("-", $person_leave_end);
                                                    echo "$day/$month/$year";
                                                    ?>
                                                    <div>
                                                        <i class="fa fa-clock-o"></i> <?=$person_leave_time_begin2." - ".$person_leave_time_end2?>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                            <td><?=$person_leave_status==1?"ลาป่วย":"ลากิจ";?></td>
                                            <td><?= $person_note ?></td>
                                            <td><?= $file_createDate ?></td>
                                            <?php if ($_SESSION['level'] == 2){ ?>
                                            <td style="text-align:center;">

                                                <a onclick="add('<?=$id?>','<?=$leave_id?>')"
                                                 class="btn btn-xs btn-success"><span class="fa fa-check-square-o"></span>  | อนุมัติ</a>
                                                 <a class="btn btn-xs btn-danger" onclick="del('<?=$id?>','<?=$leave_id?>')"><span class="fa fa-minus-square"></span>  | ปฏิเสธ</a>

                                             </td>
                                         <?php } ?>
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
                                        <th style="text-align:center;">หยุดวันที่</th>
                                        <th style="text-align:center;">ถึงวันที่</th>
                                        <th style="text-align:center;">ประเภท</th>
                                        <th style="text-align:center;">หมายเหตุ</th>
                                        <th style="text-align:center;">จัดการข้อมูล</th>
 -->                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
    function del(id ,leave){
        var r = confirm("คุณต้องการปฏิเสธการลาใช่หรือไม่");
        if (r == true) {
            window.location='index.php?mod=hr/sm_del_leave&id='+id+'&leave='+leave;
        }
    }
    function add(id ,leave){
            window.location='index.php?mod=hr/sm_add_leave&id='+id+'&leave='+leave;
        }
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


