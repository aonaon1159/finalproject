<?php	
function getIP() {
    if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    return $_SERVER['REMOTE_ADDR'];
}

function logevent($event = "System Failure: An unidentified error has occurred.", $uID = 0) {
	include("connect.php");
	// $ip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER["REMOTE_ADDR"];
	$ip = $_SERVER["REMOTE_ADDR"];
	$url = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$logSql = "insert into logs set logEvent = '$event', url = '$url', ip = '$ip', uID = '$uID';";
	mysqli_query($conn, $logSql) or die("<p><b>Logs Event Error</b></p><p>" . mysqli_error($conn) . "</p><hr>");
}

function getLabel($conn, $mod = "", $label = "", $lang = "th") {
	$sql = "
			select	* 
			from	labels 
			where	module = '{$mod}'
				and labelName = '{$label}'
	";
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	if (mysqli_num_rows($rs)) {
		$ds = mysqli_fetch_assoc($rs);
		return $ds[$lang];
	} else {
		return "";
	}
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

function routeConnectCount($conn, $routeID = 0) {
	$sql = "
			select	*
			from	stoproute
			where	onService and not deleted and routeID = '{$routeID}'
			order	by seq
	";
	$rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$hasRows = mysqli_num_rows($rs);
	if ($hasRows) {
		$pathCount = 0;
		for ($i = 1; $i <= $hasRows; $i++) {
			for ($j = $i; $j <= $hasRows; $j++) {
				if ($i != $j) $pathCount++;
			}
		}
		return $pathCount;
	} else {
		return 0;
	}
}

function dispApproved($appr) {
	if ($appr) {
		return "<b class='bg-success'>&nbsp;Y&nbsp;</b>";
	} else {
		return "<b class='bg-danger'>&nbsp;N&nbsp;</b>";
	}
}

function levelType($typeID) {
	switch($typeID) {
		case 5: return "พนักงานทั่วไป";
		case 6: return "ธุรการ";
		case 7: return "รองหัวหน้า";
		case 8: return "หัวหน้างาน";
		case 9: return "ผู้ดูแลระบบ";
		default : return "";
	}
}

function listLevelOption($lv = 0) {
	$lvOpt = "";
	for ($i = 5; $i < 10; $i++) {
		$sel = $i == $lv ? "selected" : "";
		$lvOpt .= "<option value='$i' $sel>" . levelType($i) . "</option>";
	}
	return $lvOpt;
}

function getDepartmentName($id) {
	include("connect.php");
	$sql = "select * from department where department_id = '$id' ";
	$rsDep = mysqli_query($conn, $sql) or die("<div class='alert alert-danger' style='position: fixed; top: 0px; z-index: 9999; width: 100%'>" . mysqli_error($conn) . "</div>");
	if (mysqli_num_rows($rsDep)) {
		$dep = mysqli_fetch_assoc($rsDep);
		return $dep["department_name"];
	} else {
		return "";
	}
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

function listDepartmentOption($id = 0) {
	include("connect.php");
	$sql = "select * from department where not deleted";
	$rsDep = mysqli_query($conn, $sql) or die("<div class='alert alert-danger' style='position: fixed; top: 0px; z-index: 9999; width: 100%'>" . mysqli_error($conn) . "</div>");
	if (mysqli_num_rows($rsDep)) {
		$depOption = "";
		while ($dep = mysqli_fetch_assoc($rsDep)) {
			$sel = $dep["department_id"] == $id ? "selected" : "";
			$depOption .= "<option value='{$dep["department_id"]}' $sel>{$dep["department_name"]}</option>";
		}
		return $depOption;
	} else {
		return "";
	}
}

function listRoomOption($id = 0) {
	include("connect.php");
	$sql = "select * from meeting_room where not deleted";
	$rsRm = mysqli_query($conn, $sql) or die("<div class='alert alert-danger' style='position: fixed; top: 0px; z-index: 9999; width: 100%'>" . mysqli_error($conn) . "</div>");
	if (mysqli_num_rows($rsRm)) {
		$sel = $id == 0 ? "selected" : "";
		$rmOption = "<option value='' $sel>- เลือก -</option>";
		while ($rm = mysqli_fetch_assoc($rsRm)) {
			$sel = $rm["room_id"] == $id ? "selected" : "";
			$rmOption .= "<option value='{$rm["room_id"]}' $sel>{$rm["room_name"]}</option>";
		}
		return $rmOption;
	} else {
		return "";
	}
}

function listLeaveOption($id = 0) {
	include("connect.php");
	$sql = "select * from leave_type where not deleted";
	$rsLv = mysqli_query($conn, $sql) or die("<div class='alert alert-danger' style='position: fixed; top: 0px; z-index: 9999; width: 100%'>" . mysqli_error($conn) . "</div>");
	if (mysqli_num_rows($rsLv)) {
		$lvOption = "";
		while ($lv = mysqli_fetch_assoc($rsLv)) {
			$sel = $lv["type_id"] == $id ? "selected" : "";
			$lvOption .= "<option value='{$lv["type_id"]}' $sel>{$lv["type_name"]}</option>";
		}
		return $lvOption;
	} else {
		return "";
	}
}

function enDate($d = "", $isTimeStamp = 0) {
	$h = '';
	if ($isTimeStamp) {
		$datetime = explode(" ", $d);
		$d = $datetime[0];
		$h = $datetime[1];
	}
	if (strlen($d) != 10) {
		return "";
	}
	$dSplit = explode("-", $d);
	return $dSplit[2] . "/" . $dSplit[1] . "/" . $dSplit[0] . " " . $h;
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
		$h = $datetime[1];
	}
	if (strlen($d) != 10) {
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
?>
