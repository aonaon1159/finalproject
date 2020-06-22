<?php
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}

include("inc/topnav.php");
?>
<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">Edit Users.</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-user-circle"></i> แก้ไขข้อมูลผู้ใช้งาน.
                    <div class="pull-right">
                    </div>
                </div> 
                <div class="table-responsive">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">          
                                <form method="post">
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
                                                    <option disabled selected>กรุณาเลือกระดับผู้ใช้งาน</option>
                                                    <option value="1">user</option>
                                                    <option value="2">admin</option>
                                                    <option value="3">super admin</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">Password : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="pass"
                                                        placeholder="Password"
                                                        required>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">กลุ่มผู้ใช้ : </label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="group" required>
                                                    <option disabled selected>กรุณาเลือกกลุ่มผู้ใช้</option>
                                                    <option value="1">Prem / Avia </option>
                                                    <option value="2">Agency</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group col-sm-6">
                                            <label class="col-sm-4 control-label ">ชื่อผู้ใช้ : </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="fullname"
                                                        placeholder="Fullname"
                                                        required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div style="float:right;">
                                            <button class="btn btn-primary" type="submit" id="submit">
                                                <i class="fa fa-sm fa-plus-square"></i> | บันทึกข้อมูล
                                            </button>
                                    </div>
                                </form>
                                <?php

                                if(isset($_POST["pass"])){

                                    $addBy = $_SESSION["uName"];
                                    $uName = $_POST["name"];
                                    $uLevel = $_POST["level"];
                                    $uGroup = $_POST["group"];
                                    $fullname = $_POST["fullname"];
                                    $uPass = md5($_POST["pass"]);
                                    $sql = "INSERT INTO users
                                    SET uName = '$uName',
                                    uPass = '$uPass',
                                    fullname = '$fullname',
                                    uLevel = '$uLevel',
                                    uGroup = '$uGroup',
                                    addBy = '$addBy'

                                    ";
                                    echo $sql;
                                    mysqli_query($conn, $sql);

                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>