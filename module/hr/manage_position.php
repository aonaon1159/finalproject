<?php

include("inc/check_page.php");
include("inc/topnav.php");
$this_year = date("Y");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">ตำแหน่งงาน</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-group"></i> ตารางตำแหน่งงาน
                    <div class="pull-right">
                        <div class="ibox-tools">
                            <a href="index.php?mod=hr/form_add_position&id=<?=$_GET[id]?>"><i class="fa fa-sm fa-group"></i> | เพิ่มตำแหน่งงาน</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-default" type="button"
                                id="btn_nextpage"
                                class="btn btn-default"
                                onclick="window.location='index.php?mod=hr/form_edit_employment&edit_id=<?= $_GET['id']?>'">
                            <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th style="width:70px;text-align: center;">ลำดับ</th>
                                    <th style="width:80px;text-align: center;">จำนวนคน</th>
                                    <th>ตำแหน่ง</th> 
                                    <th style="text-align: center;">จัดการ</th>
                                </thead>
                                <?php
                                $round=1;
                                $sql_position = mysqli_query($conn ,"SELECT position_id ,position_name FROM hr_person_position ORDER BY position_name ASC");
                                while(list($position_id ,$position_name) = mysqli_fetch_row($sql_position)){
                                    $sql_count = mysqli_query($conn ,"SELECT count(employment_id) FROM hr_person_employment WHERE employment_position = '$position_id'");
                                    list($count) = mysqli_fetch_row($sql_count);
                                ?>
                                
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;"><?=$round?></td>
                                        <td style="text-align: center;"><?=$count?></td>
                                        <td><?=$position_name?></td>
                                        <td style="text-align: center;">
                                            <i class='btn btn-xs btn-danger fa fa-minus-square' onclick="del(<?=$position_id?>,<?=$_GET['id']?>)" style="cursor: pointer;"></i>

                                        </td>
                                    </tr>
                                </tbody>
                                <?php 
                                    $round++;

                                    // $weekend += isweekend($holiday_date, $holiday_end);
                                }
                                mysqli_free_result($sql_position);
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<script>
function del(id,edit_id){
    var r = confirm("คุณต้องการลบตำแหน่งใช่หรือไม่");
    if (r == true) {
        window.location='index.php?mod=hr/sm_del_position&id='+id+'&edit_id='+edit_id;
    }
}
</script>

