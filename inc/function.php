<?php	
function getIP() {
	if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
		return $_SERVER['HTTP_CF_CONNECTING_IP'];
	return $_SERVER['REMOTE_ADDR'];
}

function logevent($event = "System Failure: An unidentified error has occurred.", $uID = 0) {
	include("connect.php");
	// $ip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER["REMOTE_ADDR"];
	$date = date('Y-m-d H:i:s');
	$ip = $_SERVER["REMOTE_ADDR"];
	$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$logSql = "insert into logs set logEvent = '$event', url = '$url', ip = '$ip', uID = '$uID' , logTime = '$date';";
	mysqli_query($conn, $logSql) or die("<p><b>Logs Event Error</b></p><p>" . mysqli_error($conn) . "</p><hr>");
}

function getData($conn, $table, $col, $key, $val) {
	$sql = "
	select	{$col}
	from	{$table}
	where	{$key} = '{$val}'
	";
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	if (mysqli_num_rows($rs)) {
		$ds = mysqli_fetch_assoc($rs);
		return $ds[$col];
	} else {
		return "";
	}
}


function countCol($conn, $table, $col, $cond) {
	$sql = "select {$col} from {$table} where {$col} = '{$cond}'";
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	return mysqli_num_rows($rs);
}

function countColByUser($conn, $table, $col, $cond, $uCol, $uID) {
	$sql = "select {$col} from {$table} where {$col} = '{$cond}' and {$uCol} = '{$uID}'";
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	return mysqli_num_rows($rs);
}



function levelType($typeID) {
	switch($typeID) {
		case 1: return "Users";
		case 2: return "Administrator";
		case 3: return "GM";
		default : return "";
	}
}

function genCS($length = 8) {
    // $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	// $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$characters = '0123456789';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return (date("y") + 43) . $randomString;
}

function genCode($length = 8) {
	$characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ23456789';
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randomString;
}

function getUserInfo($id, $column) {
	include("connect.php");
	$sql = "select $column from users where uID = '$id' ";
	$rsUsr = mysqli_query($conn, $sql) or die("<div class='alert alert-danger' style='position: fixed; top: 0px; z-index: 9999; width: 100%'>" . mysqli_error($conn) . "</div>");
	if (mysqli_num_rows($rsUsr)) {
		$usr = mysqli_fetch_assoc($rsUsr);
		return $usr[$column];
	} else {
		return "";
	}
}

function shortDate($lg = "th", $d = "2018-01-01 08:15:30", $isTimeStamp = 1) {
	if ($isTimeStamp) {
		$t = date("d/m/y H:i", strtotime($d));
		switch ($lg) {
			case "en"	:
			return $t;
			case "th"	:
			$datetime = explode(" ", $t);
			$d = explode("/", $datetime[0]);
			$h = $datetime[1];
			return $d[0] . "/" . $d[1] . "/" . ($d[2] + 43) . " " . $h;
			default		:
			return "";
		}
	} else {
		$t = date("d/m/y", strtotime($d));
		switch ($lg) {
			case "en"	:
			return $t;
			case "th"	:
			$d = explode("/", $t);
			return $d[0] . "/" . $d[1] . "/" . ($d[2] + 43);
			default		:
			return "";
		}
	}
}

function fullThaiDate($d = "", $isTimeStamp = 0) {
	// $d must in date form Y-m-d -> 2015-06-11
	$h = '';
	if ($isTimeStamp) {
		$datetime = explode(" ", $d);
		$d = $datetime[0];
		$h = $datetime[1];
	}
	if (strlen($d) != 10) {
		return "";
	}
	$thMonthName = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
	$dSplit = explode("-", $d);
	return "วันที่ " . $dSplit[2] . " เดือน " . $thMonthName[$dSplit[1]-0] . " พ.ศ. " . ($dSplit[0] + 543) . " " . $h;
}

function showThaiDate($d = "", $format = "T", $isTimeStamp = 0) {
	// $d must in date form Y-m-d -> 2015-06-11
	// $format default "T" = short month name, other = month no.
	$h = '';
	if ($isTimeStamp) {
		$datetime = explode(" ", $d);
		$d = $datetime[0];
		// $h = $datetime[1];
	}
	if (strlen($d) != 10 or $d == "0000-00-00") {
		return "";
	}
	$thMonthName = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
	$dSplit = explode("-", $d);
	if ($format == "T") {
		return $dSplit[2] . " " . $thMonthName[$dSplit[1]-0] . " " . ($dSplit[0] + 543) . " " . $h;
	} else {
		return $dSplit[2] . "/" . $dSplit[1] . "/" . ($dSplit[0] + 543) . " " . $h;
	}
}

function showAge($d) {
	if (strlen($d) != 10) {
		return "";
	}
	$birthday = explode("-", $d);
	$today = explode("-", date("Y-m-d"));
	$age = $today[0] - $birthday[0];
	if ("{$today[1]}-{$today[2]}" < "{$birthday[1]}-{$birthday[2]}") {
		$age -= 1;
	}
	return $age;
}

function encode($txtvalue) {
	$strvalue = base64_encode(str_rot13(base64_encode($txtvalue)));
	return str_replace("'","||||",$strvalue);
}

function decode($txtvalue) {
	$strvalue = base64_decode(str_rot13(base64_decode($txtvalue)));
	return str_replace("||||","'",$strvalue);
}
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
$thai_month_arr=array("0"=>"",
	"1"=>"มกราคม",
	"2"=>"กุมภาพันธ์",
	"3"=>"มีนาคม",
	"4"=>"เมษายน",
	"5"=>"พฤษภาคม",
	"6"=>"มิถุนายน", 
	"7"=>"กรกฎาคม",
	"8"=>"สิงหาคม",
	"9"=>"กันยายน",
	"10"=>"ตุลาคม",
	"11"=>"พฤศจิกายน",
	"12"=>"ธันวาคม");     
function thai_date($time){
	global $thai_day_arr,$thai_month_arr;
	$thai_date_return="วัน".$thai_day_arr[date("w",$time)];
	$thai_date_return.= "ที่ ".date("j",$time);
	$thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
	$thai_date_return.= " พ.ศ.".(date("Y",$time)+543);
	$thai_date_return.= "  ".date("H:i",$time)." น.";
	return $thai_date_return;
}
function day_thai($time){
	global $thai_day_arr,$thai_month_arr;
	$day_thai="วัน".$thai_day_arr[date("w",$time)];
	return $day_thai;
}

?>