<?php
if (!isset($_SESSION["uID"])) {
	exit("<script>window.location = './';</script>");
}
include("inc/topnav.php");
include("inc/leftbar.php");
?> 
<style>

    .panel-heading h1 {
    font-size: 1.5em;
}
    #page-wrapper {
        background-color: #f2f2f2;
    }
</style>

<?php 
    $m = strtotime(date("Y-m-d"));
    $m_la = strtotime("-2 month" ,$m);
    $m_sql = date("m" ,$m);
    $m_la_sql = date("m" ,$m_la);


    $sql_confirm = "SELECT * FROM hr_person_leave WHERE deleted = 0 AND person_leave_status = 1 AND confirm = 1 AND (month(person_leave_begin) = '$m_sql' OR month(person_leave_begin) = '$m_la_sql') GROUP BY person_id";
    $query_sql_confirm = mysqli_query($conn, $sql_confirm);
    $amount_confirm = mysqli_num_rows($query_sql_confirm);
    $sql_leave = "SELECT * FROM hr_person_leave WHERE deleted = 0 AND person_leave_status = 2 AND confirm = 1 AND (month(person_leave_begin) = '$m_sql' OR month(person_leave_begin) = '$m_la_sql') GROUP BY person_id";
    $query_sql_leave = mysqli_query($conn, $sql_leave);
    $amount_leave = mysqli_num_rows($query_sql_leave);
    $sql_user_status = "SELECT * FROM hr_person_leave WHERE confirm = 1 AND person_id = $_SESSION[uID] AND gotit = 0";
    $query_user_status = mysqli_query($conn, $sql_user_status);
    $amount_user_status = mysqli_num_rows($query_user_status);
    $sql_user_sent_status = "SELECT * FROM hr_person_leave WHERE confirm = 0 AND person_id = $_SESSION[uID] AND deleted = 0 AND gotit = 0";
    $query_user_sent_status = mysqli_query($conn, $sql_user_sent_status);
    $amount_user_sent_status = mysqli_num_rows($query_user_sent_status);
    $sql_user_dis_status = "SELECT * FROM hr_person_leave WHERE  person_id = $_SESSION[uID] AND deleted = 1 AND gotit = 0";
    $query_user_dis_status = mysqli_query($conn, $sql_user_dis_status);
    $amount_user_dis_status = mysqli_num_rows($query_user_dis_status);
    $sql_user_got_status = "SELECT * FROM hr_person_leave WHERE  person_id = $_SESSION[uID] AND gotit = 0";
    $query_user_got_status = mysqli_query($conn, $sql_user_got_status);
    $amount_user_got_status = mysqli_num_rows($query_user_got_status);
?>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin: 30px;">การแจ้งเตือน ประจำเดือน  <?php $month_name = strtolower(date("M")); // name of each month
                                            switch ($month_name) {
                                                case "jan" : echo "มกราคม";break; 
                                                case "feb" : echo "กุมภาพันธ์";break; 
                                                case "mar" : echo "มีนาคม";break; 
                                                case "apr" : echo "เมษายน";break; 
                                                case "may" : echo "พฤษภาคม";break; 
                                                case "jun" : echo "มิถุนายน";break; 
                                                case "jul" : echo "กรกฏาคม";break; 
                                                case "aug" : echo "สิงหาคม";break; 
                                                case "sep" : echo "กันยายน";break; 
                                                case "oct" : echo "ตุลาคม";break; 
                                                case "nov" : echo "พฤศจิกายน";break; 
                                                case "dec" : echo "ธันวาคม";break;
                                            }?>
                <!-- ID:<?=$_SESSION['uID']?><br>
                                                                        IP:<?=include("ip.php")?><br> 
                                                                        วันที่:<?=$current_dated?>
                                                                        เวลา : <?=$time?>
                                                                        <?php include("inc/displaydatetime.php") ?>--> 
                </h1>
            </div>
<?php if ($_SESSION["level"] > 1) { ?>
                <div id="page-wrapper-hr">
            <a class="report-navi" href="?mod=hr/show_leave&id=1">
                <div class="col-md-4 ">
                    <div class="panel " style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-check-circle fa-5x" style="color:#72ffe5;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>ลาป่วย <?=number_format($amount_confirm)?> คน</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>อณุมัติการลาเรียบร้อยแล้ว</p>
                        </div>
                    </div>
                </div>
            </a>
            <a class="report-navi" href="?mod=hr/show_leave&id=2">
                <div class="col-md-4 ">
                    <div class="panel " style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-check-circle fa-5x" style="color:#72ffe5;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>ลากิจ <?=number_format($amount_leave)?> คน</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>อณุมัติการลาเรียบร้อยแล้ว</p>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
            <?php if ($_SESSION["level"] == 3) { ?>
            <a href="./?mod=hr/confirm" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-exclamation-circle fa-5x" style="color:#ff8c8c;">
                                    </i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <?php  
                                     $sql_request = "
                                            SELECT hr_person.person_id FROM `hr_person` INNER JOIN hr_person_leave ON hr_person.person_id = hr_person_leave.person_id WHERE hr_person_leave.confirm = 0 AND hr_person_leave.deleted = 0 GROUP BY person_id";
                                        $query_sql_request = mysqli_query($conn, $sql_request);
                                        $amount_request = mysqli_num_rows($query_sql_request);
                                    ?>
                                    <h1><?=number_format($amount_request)?> คน</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>รอการอณุมัติการลา </p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="./?mod=hr/manage_leave" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-archive fa-5x" style="color:#01c4ff;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>ประวัติ</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>ประวัติการลา</p>
                        </div>
                    </div>
                </div>
            </a>
             <a href="./?mod=fn/form_view_summarize_m&month=<?=date('m')?>" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-calendar-alt fa-5x" style="color:#8aff90;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>ข้อมูลสรุปเงินเดือน </h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>ข้อมูลสรุปการลาเดือนปัจจุบัน</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
<?php } ?>
<?php if ($_SESSION["level"] == 2) { ?>

            <a href="./?mod=hr/confirm" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-exclamation-circle fa-5x" style="color:#ff8c8c;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <?php  
                                     $sql_request = "
                                            SELECT hr_person.person_id FROM `hr_person` INNER JOIN hr_person_leave ON hr_person.person_id = hr_person_leave.person_id WHERE hr_person_leave.confirm = 0 AND hr_person_leave.deleted = 0 GROUP BY person_id";
                                        $query_sql_request = mysqli_query($conn, $sql_request);
                                        $amount_request = mysqli_num_rows($query_sql_request);
                                    ?>
                                    <h1><?=number_format($amount_request)?> คน</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>รอการอณุมัติ</p>
                        </div>
                    </div>
                </div>
            </a>
            <a href="./?mod=hr/manage_leave" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-archive fa-5x" style="color:#01c4ff;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>ประวัติ</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>ประวัติการลา</p>
                        </div>
                    </div>
                </div>
            </a>
        <?php } ?>
        <?php if ($_SESSION['level'] == 1) {?>
        <?php if (number_format($amount_user_got_status) !=0){ ?>
        <?php if(number_format($amount_user_status) != 0){?>
             <a class="report-navi" href="?mod=hr/check_leave&id=<?=$_SESSION['uID']?>">
                <div class="col-md-4 ">
                    <div class="panel " style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-check-circle fa-5x" style="color:#72ffe5;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>อณุมัติการลาเรียบร้อยแล้ว</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>อณุมัติการลาเรียบร้อยแล้ว</p>
                        </div>
                    </div>
                </div>
            </a><?php }?>
            <?php if (number_format($amount_user_sent_status) != 0){  ?>
                    <a  href="?mod=hr/manage_leave_person_request&id=<?=$_SESSION['uID']?>" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-exclamation-circle fa-5x" style="color:#ff8c8c;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>รอการยืนยัน</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>รอการยืนยัน</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
<?php }?>
<?php if (number_format($amount_user_dis_status) !=0){ ?>
     <a href="?mod=hr/check_leave&id=<?=$_SESSION['uID']?>" class="report-navi" >
                <div class="col-md-4">
                    <div class="panel" style="color:black;">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <i class="fas fa-times-circle fa-5x" style="color:#ff8c8c;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                    <h1>ปฏิเสธการร้องขอ</h1>
                                </div>
                            </div>
                        </div>
                        <hr class="panel-spilt">
                        <div class="panel-body">
                            <p>ปฏิเสธการร้องขอการลา</p>
                        </div>
                    </div>
                </div>
            </a>
<?php }}}?>

</div>
