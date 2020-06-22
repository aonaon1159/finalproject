<?php 
if (!isset($_SESSION["uID"])) {
    exit("<script>window.location = './';</script>");
}
include("inc/topnav.php");
include("inc/leftbar.php");
$sql_select_person = "SELECT * FROM hr_person WHERE person_id='{$_GET["id"]}' ";
$query_person = mysqli_query($conn, $sql_select_person);
$person = mysqli_fetch_array($query_person);
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" style="margin: 30px;">เปลี่ยนรหัสผ่าน</h1>
        </div>
        <div id="page-wrapper-hr">
            <div class="form-group col-sm-4" style="text-align:center;">
                <a href="././<?= $person[10] ?>" data-lightbox="image-1"
                    data-title="<?= $person[2] . " " . $person[3] ?>">
                    <img src="././<?= $person[10] ?>"
                    style="max-width: 250px; max-height: 200px; border: solid 1px#1b2426;">
                </a>
            </div>
            <form action="./?mod=hr/sm_update_password" method="post">
                <label class="col-sm-4 control-label">รหัสเดิม : </label>
              <div class="form-group col-sm-6">
                  <input type="password" class="form-control" name="oldpass" required>
              </div>
              <label class="col-sm-4 control-label">รหัสใหม่ : </label>
              <div class="form-group col-sm-6">
                  <input type="password" class="form-control" name="newpass" required>
              </div>
              <label class="col-sm-4 control-label">ยืนยันรหัสใหม่   : </label>
              <div class="form-group col-sm-6">
                  <input type="password" class="form-control" name="newpass2" required>
              </div>
              <label class="col-sm-4 control-label"></label>
              <div class="col-sm-6">
                  <button type="submit" class="btn btn-success" onclick="return confirm('คุณต้องเปลี่ยนรหัสผ่านจริงหรือไม่')">ยืนยัน</button>
              </div>
              
            </form>
