<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);

include "config.php";

$section = isset($_GET["section"]) ? $_GET["section"] : 0;
$strSql = "";

// valid user
$useridx = $_COOKIE['useridx'];
$userx = $_COOKIE['userx'];
$passx = $_COOKIE['passx'];
$pagex = $_COOKIE['pagex'];

$auth = true;

$menu_view = 1;
$menu_mod = 1;

if ($menu_view == 0) {
  $rows["auth_view"] = "false";
  echo json_encode($rows);
  exit();
} 

if ($auth != false) {
 if ($section == 1){ //view doc
    $dep = $_GET['dep'] == 'ALL' ? '' : $_GET['dep'];
    $cat = $_GET['cat'] == 'ALL' ? '' : $_GET['cat'] ;
    $nam = $_GET['nam'] == 'ALL' ? '' : $_GET['nam'] ;
    
    $strSql = "
      SELECT a.*, b.USER_INISIAL usern 
      FROM `share_doc` a 
      LEFT JOIN `xref_user_web` b ON a.add_id = b.USER_ID 
      WHERE UCASE(`name`) LIKE UCASE('%$nam%') 
      ". ($dep == "" ? "" : " AND UCASE(`dep`) = UCASE('$dep')") ."
      ". ($cat == "" ? "" : " AND UCASE(`cat`) = UCASE('$cat')") ."
      ORDER BY a.add_date DESC LIMIT 100;
    ";
  } else if ($section == 2){ //add-doc
    
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }

    $tardir = $_SERVER['DOCUMENT_ROOT']."/uploads/";

    $errors = "";
    $maxsize = 2097152*5;
    $accepted = array(
      'application/pdf',
      'image/jpeg',
      'image/jpg',
      'image/gif',
      'image/png'
    );

    $dep = $_POST['dep'];
    $cat = $_POST['cat'];
    $doc = $_POST['doc'];

    //var_dump($_POST, $_FILES);
    if(isset($_FILES['docfile'])){
      if (($_FILES['docfile']['size'] >= $maxsize) || ($_FILES['docfile']['size'] == 0)) {
        $errors = 'File too large. File must be less than 10 megabytes.';
      }
      if((!in_array($_FILES['docfile']['type'], $accepted)) && (!empty($_FILES['docfile']['type']))){
        $errors = 'Invalid file type. Only PDF, JPG, GIF and PNG types are accepted.';
      }
    }

    if (strlen($errors) == 0){
      $temp = explode(".", $_FILES['docfile']['name']);
      $newname = round(microtime(true)) . '.' . end($temp);      
      if (move_uploaded_file($_FILES['docfile']['tmp_name'], $tardir . $newname)) {
        $strSql = "
        INSERT INTO `share_doc` (`dep`, `cat`, `name`, `path`, `add_id`, `add_date`) VALUES (
          '$dep', '$cat', '$doc', '$newname', 
          $useridx, NOW()
        );";

        if (mysqli_query($conn, $strSql)) {
          $strSql = "SELECT 'TRUE' actx, 'Success upload file to server' msgx";
        } else {
          $strSql = "SELECT 'FALSE' actx, 'Error upload file to server' msgx";
        }

      } else {
        $strSql = "SELECT 'FALSE' actx, 'Error upload file to server' msgx";
      }
    } else {
      $strSql = "SELECT 'FALSE' actx, '$errors' msgx";
    }

  } else if ($section == 3){ //del-doc

    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }

    $tardir = $_SERVER['DOCUMENT_ROOT']."/uploads/";
    $data_id = $_POST['data_id'];
    $data_path = $_POST['data_path'];

    $strSql = "DELETE FROM share_doc WHERE id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      unlink($tardir.$data_path);
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete file from server' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete file from server' msgx";
    }
  } else if ($section == 4){ //view hw
    $dep = $_GET['dep'] == 'ALL' ? '' : $_GET['dep'];
    $cat = $_GET['cat'] == 'ALL' ? '' : $_GET['cat'] ;
    $nam = $_GET['nam'] == 'ALL' ? '' : $_GET['nam'] ;
    
    $strSql = "
      SELECT a.*, b.USER_INISIAL usern 
      FROM `hardware_users` a 
      LEFT JOIN `xref_user_web` b ON a.add_id = b.USER_ID 
      WHERE UCASE(`merk`) LIKE UCASE('%$nam%') 
      ". ($dep == "" ? "" : " AND UCASE(`dep`) = UCASE('$dep')") ."
      ". ($cat == "" ? "" : " AND UCASE(`cat`) = UCASE('$cat')") ."
      ORDER BY a.dep, a.user, a.merk  LIMIT 100;
    ";
  } else if ($section == 5){ //add-hw
    
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }

    $dep = $_POST['dep'];
    $cat = $_POST['cat'];
    $merk = $_POST['merk'];
    $user = $_POST['user'];
   
    $strSql = "
    INSERT INTO `hardware_users` (`dep`, `cat`, `merk`, `user`, `add_id`, `add_date`) VALUES (
      '$dep', '$cat', '$merk', '$user', $useridx, NOW()
    );";

    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT 'TRUE' actx, 'Success add hardware user' msgx";
    } else {
      $strSql = "SELECT 'FALSE' actx, 'Error add hardware user' msgx";
    }

  } else if ($section == 6){ //del-hw

    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }
  
    $data_id = $_POST['data_id'];

    $strSql = "DELETE FROM hardware_users WHERE id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete file from server' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete file from server' msgx";
    }
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