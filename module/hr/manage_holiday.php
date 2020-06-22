<?php
if (!isset($_SESSION["uID"]))
    exit("<script>window.location = './';</script>");


include("inc/topnav.php");
$this_year = date("Y");
?>

<div id="page-wrapper-hr">
    <div class="row">
        <div class="col-sm-12" style="padding-left:30px;">
            <h3 class="page-header">วันหยุดประจำปี <?=date("Y")+543?> (<span id="total_Holiday"></span> วัน)</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" style="padding:0 25px 0 30px;">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding-bottom:20px;">
                    <i class="fa fa-calendar"></i> ตารางจัดการวันหยุด
                    <div class="pull-right">
                        <div class="ibox-tools">
                            <?php if ($_SESSION["level"] ==  2) { ?>
                            <a href="index.php?mod=hr/form_add_holiday" class="btn btn-primary btn-sm"><i class="fa fa-sm fa-calendar"></i> | เพิ่มวันหยุด</a>
                        <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">ทั้งปี</a></li>
                                <?php 
                                $sql_tap_month = mysqli_query($conn ,"SELECT distinct month(holiday_date) FROM hr_year_holiday WHERE deleted = 0 AND ((year(holiday_date) = '$this_year') OR holiday_regular = 1) ORDER BY month(holiday_date) ASC");
                                while(list($tap_month) = mysqli_fetch_row($sql_tap_month)){
                                ?>
                                    <li role="presentation"><a href="#<?=$tap_month?>" aria-controls="<?=$tap_month?>" role="tab" data-toggle="tab"><?=monthThaiFull($tap_month)?></a></li>
                                <?php
                                }
                                mysqli_free_result($sql_tap_month);
                                ?>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="all">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <th style="text-align: left;">ลำดับ</th>
                                                <th style="text-align: left;">จำนวนวัน</th>
                                                <th>วันที่</th>
                                                <th>ถึง</th>
                                                <th>วันที่</th>
                                                <th>วันหยุด</th>
                                                <th style="text-align: center;">ทุกปี</th>
                                                <?php if ($_SESSION["level"] == 2) { ?>
                                                <th style="text-align: center;">จัดการ</th>
                                            <?php } ?>
                                            </thead>
                                            <?php
                                            $round=1;
                                            $amount=0;
                                            $total_holiday=0;
                                            $weekend=0;
                                            $sql_all = mysqli_query($conn ,"SELECT holiday_id, holiday_date ,holiday_end, holiday_regular, holiday_title FROM hr_year_holiday WHERE deleted = 0 AND ((year(holiday_date) = '$this_year') OR holiday_regular = 1) ORDER BY holiday_date ASC");
                                            while(list($holiday_id ,$holiday_date ,$holiday_end ,$holiday_regular ,$holiday_title) = mysqli_fetch_row($sql_all)){
                                                list($year, $month ,$day) = explode("-", $holiday_date);
                                                list($year2, $month2 ,$day2) = explode("-", $holiday_end);
                                                $numberDays=1;
                                                if(empty($day2)) $day2="-";
                                                else{
                                                    $startTimeStamp = strtotime($holiday_date);
                                                    $endTimeStam = strtotime($holiday_end);

                                                    $timeDiff = abs($endTimeStam - $startTimeStamp);

                                                    $numberDays = ($timeDiff/86400)+1; 
                                                    $numberDays = intval($numberDays);


                                                    $start = strtotime("saturday", $startTimeStamp);
                                                    while($start < $endTimeStam) {
                                                        $sat = date("l", $start);
                                                        $sun = strtotime("+1 days", $start);
                                                        $sun = date("l", $sun);
                                                        
                                                        $sat = strtolower($sat);
                                                        $sun = strtolower($sun);

                                                        if($sat == "saturday") {
                                                            $amount++;
                                                        }
                                                        if($sun == "sunday") {
                                                            $amount++;
                                                        }

                                                        $start = strtotime("+1 weeks", $start);
                                                    }
                                                }
                                                
                                            ?>
                                            
                                            <tbody>
                                                <tr>
                                                    <td style="text-align: left;"><?=$round?></td>
                                                    <td style="text-align: left;"><?=$numberDays?></td>
                                                    <td><?=$day." ".monthThaiFull($month)?></td>
                                                    <td>-</td>
                                                    <td><?=$day2." ".monthThaiFull($month2)?></td>
                                                    <td><?=$holiday_title?></td>
                                                    <td style="text-align: center;">
                                                    <?=!empty($holiday_regular)?"<i class='fa fa-check'></i>":""?>
                                                    </td><?php if ($_SESSION["level"] == 2) { ?>
                                                    <td style="text-align: center;">
                                                        <a class='btn btn-xs btn-warning' style="cursor: pointer;"  onclick="edit(<?=$holiday_id?>)"><span class="fa fa-pencil-square-o"></span> | แก้ไข</a>
                                                        <a class='btn btn-xs btn-danger' onclick="del(<?=$holiday_id?>)" style="cursor: pointer;"><span class="fa fa-minus-square"></span> | ลบ</a>

                                                    </td>
                                                <?php } ?>
                                                </tr>
                                            </tbody>
                                            <?php 
                                                $round++;
                                                $total_holiday+=$numberDays;

                                                // $weekend += isweekend($holiday_date, $holiday_end);
                                            }
                                            mysqli_free_result($sql_all);
                                            ?>
                                        </table>
                                    </div>
                                </div>
                                <?php 
                                $sql_tap_month = mysqli_query($conn ,"SELECT distinct month(holiday_date) FROM hr_year_holiday WHERE deleted = 0 AND ((year(holiday_date) = '$this_year') OR holiday_regular = 1)");
                                while(list($tap_month) = mysqli_fetch_row($sql_tap_month)){
                                ?>
                                    <div role="tabpanel" class="tab-pane fade" id="<?=$tap_month?>">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <th>วันที่</th>
                                                    <th>ถึง</th>
                                                    <th>วันที่</th>
                                                    <th>วันหยุด</th>
                                                    <th style="text-align: center;">ทุกปี</th>
                                                </thead>
                                                <?php
                                                $sql_month = mysqli_query($conn ,"SELECT holiday_date ,holiday_end ,holiday_title, holiday_regular FROM hr_year_holiday WHERE month(holiday_date) = '$tap_month' AND deleted = 0 AND ((year(holiday_date) = '$this_year') OR holiday_regular = 1) ORDER BY holiday_date ASC");
                                                while(list($holiday_date ,$holiday_end ,$holiday_title , $holiday_regular) = mysqli_fetch_row($sql_month)){
                                                    list($year, $month ,$day) = explode("-", $holiday_date);
                                                    list($year2, $month2 ,$day2) = explode("-", $holiday_end);
                                                    if(empty($day2)) $day2="-";
                                                    if($month2>$month || ($month2==12&&$month==1)) $day2.=" ".monthThaiFull($month2);
                                                ?>
                                                
                                                <tbody>
                                                    <tr>
                                                        <td><?=$day ?></td>
                                                        <td>-</td>
                                                        <td><?=$day2?></td>
                                                        <td><?=$holiday_title?></td>
                                                        <td style="text-align: center;">
                                                        <?=!empty($holiday_regular)?"<i class='fa fa-check'></i>":""?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <?php 
                                                }
                                                mysqli_free_result($sql_month);
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                <?php
                                }
                                mysqli_free_result($sql_tap_month);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="pager">
        <li><a href="?mod=main" class="btn btn-default">กลับสู่หน้าหลัก</a></li>
    </ul>
    
</div>

<script>
$('#myTabs a').click(function (e) {
    e.preventDefault()
    $(this).tab('show')
})

$("#total_Holiday").html(<?=$total_holiday-$amount?>);

function edit(id){
    window.location='index.php?mod=hr/form_edit_holiday&id='+id;
}

function del(id){
    var r = confirm("คุณต้องการลบวันหยุดนี้ใช่หรือไม่");
    if (r == true) {
        window.location='index.php?mod=hr/sm_del_holiday&id='+id;
    }
}
</script>

<?php 


function monthThaiFull($month){
    switch ($month) {
        case "01":
        $month = "มกราคม";
        break;
        case "02":
        $month = "กุมภาพันธ์";
        break;
        case "03":
        $month = "มีนาคม";
        break;
        case "04":
        $month = "เมษายน";
        break;
        case "05":
        $month = "พฤษภาคม";
        break;
        case "06":
        $month = "มิถุนายน";
        break;
        case "07":
        $month = "กรกฏาคม";
        break;
        case "08":
        $month = "สิงหาคม";
        break;
        case "09":
        $month = "กันยายน";
        break;
        case "10":
        $month = "ตุลาคม";
        break;
        case "11":
        $month = "พฤศจิกายน";
        break;
        case "12":
        $month = "ธันวาคม";
        break;
    }
  return $month;
}
?>

