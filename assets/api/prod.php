<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

include "config.php";

$section = isset($_GET["section"]) ? $_GET["section"] : 0;
$strSql = "";

// valid user
// $useridx = $_COOKIE['useridx'];
// $userx = $_COOKIE['userx'];
// $passx = $_COOKIE['passx'];
// $pagex = $_COOKIE['pagex'];

$menu_view = 1;
$menu_mod = 1;

$rows["auth_view"] = "true";
$auth = true;

if ($menu_view == 0) {
  $rows["auth_view"] = "false";
  echo json_encode($rows);
  exit();
} 

if ($auth != false) {
  //prod list
  if ($section == 90) { // get ref style
    $strSql = "
      SELECT PART_NUM partx, PART_NAME part_namex 
      FROM toy_part ORDER BY PART_NAME ASC; 
    ";
  }
}
//echo '<pre>'. $strSql . '</pre>';

$rows = [];
if ($auth === false) {
  $rows["auth"] = "false";
} else {
  $res = mysqli_query($conn, $strSql);
  if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
      # code...
      $rows[] = $row;
    }
  }else{
    $rows["empty"] = "empty";
  }
}
echo json_encode($rows);