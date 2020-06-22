<?php

if (!isset($_SESSION["uID"]))
    exit("<script>window.location = './';</script>");


include("inc/topnav.php");
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
                    <i class="fa fa-group"></i> เพิ่มบริษัท
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="index.php?mod=hr/sm_insert_company_fedit&id=<?=$_GET['id']?>" style="margin-top:15px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-1 control-label ">บริษัท
                                        : </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="company_name" placeholder="บริษัท" autofocus="autofocus">
                                    </div>
                                    <label class="col-sm-2 control-label ">รายละเอียด
                                        : </label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" name="company_description" placeholder="รายละเอียด">
                                    </div>
                                    <div class="col-sm-12">
                                       <hr> 
                                    </div>
                                    <div class="pull-right" style="margin-right:15px;">
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
    window.location = "index.php?mod=hr/manage_edit_company&id=<?= $_GET['id']?>";
}
</script>


