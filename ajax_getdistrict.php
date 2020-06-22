<?php

include 'inc/connect.php';
if ($_POST['ampID']) {
    $sql_select_district = "
      SELECT * FROM district
      WHERE ampID={$_POST["ampID"]}
      ORDER BY convert(distName USING tis620)  
    ";
    $data = "<option value=''>- เลือกข้อมูล -</option>";
    $query_district = mysqli_query($conn, $sql_select_district);
    if (mysqli_num_rows($query_district)) {
        while ($district = mysqli_fetch_assoc($query_district)) {
            $data .= "<option value='{$district["distID"]}'>{$district["distName"]}</option>";
        }
    }
    echo $data;
}
?>