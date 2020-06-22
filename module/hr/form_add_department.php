<?php

if (!isset($_SESSION["uID"]))
    exit("<script>window.location = './';</script>");


include("inc/topnav.php");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">แผนกงาน</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-group"></i> เพิ่มแผนกงาน
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="index.php?mod=hr/sm_insert_department_fadd&id=<?=$_GET['id']?>" style="margin-top:15px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-1 control-label ">แผนก
                                        : </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="department_name" placeholder="แผนก" autofocus="autofocus">
                                    </div>
                                    <div class="col-sm-5">
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-sm fa-plus-square"></i> | เพื่มข้อมูล </button>
                                        <button type="reset" class="btn btn-default" onclick="back_page();">ยกเลิก</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<script>
function back_page(){
    window.location = "index.php?mod=hr/manage_add_department&id=<?= $_GET['id']?>";
}
</script>


