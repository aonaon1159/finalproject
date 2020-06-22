<?php

if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");

    $sql_user = "SELECT person_firstname_thai FROM hr_person WHERE person_id =$_GET[id]";
    $query_user = mysqli_query($conn, $sql_user);  
    $rows_person = mysqli_fetch_array($query_user);
?>
<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Add Users. </h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-user-circle"></i> สร้างบัญชีพนักงาน.
                    <div class="pull-right">
                    </div>
                </div> 
                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">          
                                <form method="post" action="?mod=hr/sm_insert_user&id=<?=$_GET['id']?>">
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">Username : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="name"
                                                       placeholder="Username"
                                                       autofocus="autofocus" required>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ระดับผู้ใช้งาน : </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="level" required>
                                                    <option disabled selected value="0">กรุณาเลือกระดับผู้ใช้งาน</option>
                                                    <option value="1">user</option>
                                                    <option value="2">admin</option>
                                                    <option value="3">super admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" value="1234" name="pass">
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ชื่อผู้ใช้ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" 
                                                value="<?=$rows_person[0]; ?>" name="fullname" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <div class="col-sm-12">
                                        <div style="float:right;">
                                            <button class="btn btn-primary" type="submit" id="submit" 
                                            onclick="return confirm('คุณต้องการยืนยันการสร้างบัญชีหรือไม่')">
                                                <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                            </button>
                                    </div>
                                    <input type="hidden" name="pass" value="1234">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>