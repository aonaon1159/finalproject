<?php

if (!isset($_SESSION["uID"])) exit("<script>window.location = './';</script>");

include("inc/topnav.php");

$id = $_GET['id'];
$sql_holiday = mysqli_query($conn ,"SELECT holiday_date ,holiday_end ,holiday_title ,holiday_regular FROM hr_year_holiday WHERE holiday_id = '$id'");
list($holiday_date ,$holiday_end ,$holiday_title ,$holiday_regular) = mysqli_fetch_row($sql_holiday);
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">วันหยุดประจำปี</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-calendar"></i> เพิ่มวันหยุดประจำปี
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="index.php?mod=hr/sm_update_holiday" style="margin-top:15px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-1 control-label ">ชื่อวันหยุด
                                        : </label>
                                    <div class="col-sm-11">
                                        <input type="text" class="form-control" name="holiday_title" placeholder="ชื่อวันหยุด" value="<?=$holiday_title?>" autofocus="autofocus">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-3 control-label ">วันที่หยุด : </label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="holiday_date" placeholder="วันหยุด" value="<?=$holiday_date?>">
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label ">ถึง</label>
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-4 control-label ">วันที่ (ถ้ามี)
                                        : </label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="holiday_end" placeholder="สิ้นสุด" value="<?=$holiday_end?>">
                                    </div>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label class="col-sm-5 control-label ">ประจำทุกปี
                                        : </label>
                                    <div class="col-sm-7">
                                        <input type="checkbox" id="holiday_check" name="holiday_check"
                                            <?php 
                                            if(!empty($holiday_regular)) echo "checked";
                                            ?>
                                               data-toggle="toggle" data-onstyle="success"
                                               data-on="ประจำทุกปี" data-offstyle="danger"
                                               data-off="ปีนี้เท่านั้น" data-width="100%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                               <hr> 
                            </div>
                            <div class="pull-right" style="margin-right:15px;">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-sm fa-plus-square"></i> | แก้ไขข้อมูล </button>
                                <button type="reset" class="btn btn-default" onclick="back_page();">ยกเลิก</button>
                            </div>
                            <input type="hidden" name="id" value="<?=$id?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    
</div>

<script>
function back_page(){
    window.location = "index.php?mod=hr/manage_holiday";
}
</script>


