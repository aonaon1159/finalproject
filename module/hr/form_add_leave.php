<?php

include("inc/check_page.php");
include("inc/topnav.php");
$id = $_GET['id'];

$sql = mysqli_query($conn ,"SELECT person_prename ,person_firstname_thai ,person_lastname_thai FROM hr_person WHERE person_id = '$id' ");
list($person_prename ,$person_firstname_thai ,$person_lastname_thai) = mysqli_fetch_row($sql);
if ($person_prename == 1) $person_prename = "นาย";
else if ($person_prename == 2) $person_prename = "นางสาว";
else $person_prename = "นาง";
mysqli_free_result($sql);

?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header"> การลางาน</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-calendar"></i> เพิ่มวันลาหยุด (<?=$person_prename." ".$person_firstname_thai." ".$person_lastname_thai?>)
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="post" action="index.php?mod=hr/sm_insert_leave" style="margin-top:15px;">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group col-sm-12">
                                    <label class="col-sm-1 control-label ">หมายเหตุ
                                        : </label>
                                    <div class="col-sm-11">
                                        <input type="text" class="form-control" name="leave_note" placeholder="หมายเหตุ" autofocus="autofocus">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-3 control-label ">ประเภท : </label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="type_leave">
                                            <option value="1">ลาป่วย</option>
                                            <option value="2">ลากิจ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-3 control-label ">วันที่หยุด : </label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="leave_begin" placeholder="วันหยุด">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-4 control-label ">(ถ้ามี) เวลา : </label>
                                    <div class="col-sm-8">
                                        <input type="time" class="form-control" name="time_begin1">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-3 control-label ">ถึง : </label>
                                    <div class="col-sm-8">
                                        <input type="time" class="form-control" name="time_end1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-4 control-label ">ถึงวันที่ (ถ้ามี)
                                        : </label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="leave_end" placeholder="สิ้นสุด" value="">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-4 control-label ">(ถ้ามี) เวลา : </label>
                                    <div class="col-sm-8">
                                        <input type="time" class="form-control" name="time_begin2">
                                    </div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label class="col-sm-3 control-label ">ถึง : </label>
                                    <div class="col-sm-8">
                                        <input type="time" class="form-control" name="time_end2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                               <hr> 
                            </div>
                            <div class="pull-right" style="margin-right:15px;">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล </button>
                                <button type="reset" class="btn btn-default" onclick="back_page();">ยกเลิก</button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value='<?=$id?>'>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
function back_page(){
    window.location = "index.php?mod=hr/manage_leave_person&id="+<?=$id?>;
}
</script>


