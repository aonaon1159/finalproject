<?php

if (!isset($_SESSION["uID"]))
    exit("<script>window.location = './';</script>");


include("inc/topnav.php");
$this_year = date("Y");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">บริษัท</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-group"></i> ตารางบริษัท
                    <div class="pull-right">
                        <div class="ibox-tools">
                            <a href="index.php?mod=hr/form_add_company&id=<?=$_GET[id]?>"><i class="fa fa-sm fa-group"></i> | เพิ่มบริษัท</a>
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-default" type="button"
                                id="btn_nextpage"
                                class="btn btn-default"
                                onclick="window.location='index.php?mod=hr/form_add_employment&add_id=<?= $_GET['id']?>'">
                            <i class="fa fa-long-arrow-left"></i> ย้อนกลับ
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th style="width:70px;text-align: center;">ลำดับ</th>
                                    <th style="width: 80px;text-align: center;">จำนวนคน</th>
                                    <th>บริษัท</th> 
                                    <th style="text-align: center;">จัดการ</th>
                                </thead>
                                <?php
                                $round=1;
                                $sql_company = mysqli_query($conn ,"SELECT company_id ,company_name FROM hr_person_company ORDER BY company_name ASC");
                                while(list($company_id ,$company_name) = mysqli_fetch_row($sql_company)){
                                    $sql_count = mysqli_query($conn ,"SELECT count(employment_id) FROM hr_person_employment WHERE employment_company = '$company_id'");
                                    list($count) = mysqli_fetch_row($sql_count);
                                ?>
                                
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;"><?=$round?></td>
                                        <td style="text-align: center;"><?=$count?></td>
                                        <td><?=$company_name?></td>
                                        <td style="text-align: center;">
                                            <i class='btn btn-xs btn-danger fa fa-minus-square' onclick="del(<?=$company_id?>,<?=$_GET['id']?>)" style="cursor: pointer;"></i>

                                        </td>
                                    </tr>
                                </tbody>
                                <?php 
                                    $round++;
                                }
                                mysqli_free_result($sql_company);
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
    var r = confirm("คุณต้องการลบบริษัทนี้ใช่หรือไม่");
    if (r == true) {
        window.location='index.php?mod=hr/sm_del_company&id='+id+'&edit_id='+edit_id;
    }
}
</script>

