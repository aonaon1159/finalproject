<!-- MetisMenu CSS -->
<link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="dist/css/sb-admin-2.css" rel="stylesheet">
<!-- Morris Charts CSS -->
<link href="vendor/morrisjs/morris.css" rel="stylesheet">

<!-- Main Body -->

<div id="wrapper">
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                       <img src="images/logo-h.png" class="img-responsive">
                   </li>
                   <li>
                    <a href="./?mod=main"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <?php if ($_SESSION["level"] >= 2) { ?>
                  <li>
                    <a href="./?mod=hr/user"><i class="fa fa-user-circle fa-fw"></i> ผู้ใช้งาน</a>
             </li>
         <?php } ?>
         <?php if ($_SESSION["level"] > 1) { ?>
            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> งานบุคคล 
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down fa-fw"></i></a>
                <ul class="nav nav-second-level">
                    <li>
                     <a href="./?mod=hr/manage_person"><i class="fas fa-id-card fa-fw"></i> ทะเบียนพนักงาน</a>
                 </li>
                 <li>
                     <a href="./?mod=hr/manage_leave"><i class="fas fa-id-card fa-fw"></i> การลาพนักงาน</a>
                 </li>
                 <li>
                     <a href="./?mod=hr/manage_holiday"><i class="fa fa-calendar fa-fw"></i> กำหนดวันหยุดประจำปี</a>
                 </li>
                 <li>
                     <a href="./?mod=fn/form_view_time"><i class="fa fa-clock-o fa-fw"></i> เวลาทำงาน</a>
                 </li>
                 <li>
                     <a href="./?mod=fn/manage_salary"><i class="fa fa-money fa-fw"></i> เงินเดือน</a>
                 </li>
                 <?php if ($_SESSION["level"] == 2) { ?>
                 <li>
                     <a href="./?mod=hr/manage_users"><i class="fas fa-key fa-fw"></i> สร้างบัญชีผู้ใช้งาน</a>
                 </li>
             <?php } ?>
             </ul>
         </li>
     <?php } ?>
     <?php if ($_SESSION["level"] < 3) { ?>
        <li>
            <a href="#"><i class="fa fa-users fa-fw"></i> ตรวจสอบข้อมูล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down fa-fw"></i></a>
            <ul class="nav nav-second-level">
                <li>
                    <a href="./?mod=fn/time_check"><i class="fa fa-id-card fa-fw"></i> เวลาการเข้างาน</a>
                </li>
                <li>
                    <a href="./?mod=fn/salary_check"><i class="fa fa-id-card fa-fw"></i> เงินเดือนที่ได้รับ</a>
                </li>
            </ul>
        </li>
    <?php } ?>
         <?php if ($_SESSION["level"] > 1) { ?>
        <li>
            <a href="./?mod=check_logs"><i class="fa fa-search fa-fw"></i> ตรวจสอบข้อมูลการใช้งาน</a>
        </li>
    <?php } ?>
             <?php if ($_SESSION["level"] < 2) { ?>
        <li>
            <a href="./?mod=send_leave&id=<?=$_SESSION["uID"]?>"><i class="fa fa-paper-plane fa-fw"></i> ส่งใบลา</a>
        </li>
    <?php } ?>
</ul>
</div>
<!-- /.sidebar-collapse -->
</div>
<script src="vendor/metisMenu/metisMenu.min.js"></script>
<script src="vendor/raphael/raphael.min.js"></script>
<script src="vendor/morrisjs/morris.min.js"></script>
<script src="dist/js/sb-admin-2.js"></script>