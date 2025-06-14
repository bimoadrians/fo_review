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
  if ($section == 1){ //view list

    $date = $_GET['date'];
    $unit = $_GET['unit'];
    $line = $_GET['line'];

    $strSql = "
    SELECT sa.*, sc.PART_NAME partdx, sb.LINE_DESC linedx, sb.LINE_PREF unitx
    FROM (
      SELECT sa.idx, sa.partx, sa.linex, sa.groupx, sa.fchx, sa.byx, SUM(timex) timex
      FROM (        
        SELECT a.anali_id idx, a.anali_part partx, a.anali_line linex, a.anali_group groupx, a.anali_fch fchx, IFNULL(a.anali_by, '') byx, 
        IFNULL(ROUND((((IFNULL(3600/b.anali_act_ct1, 0) + IFNULL(3600/b.anali_act_ct2, 0)) - ((ROUND((((a.anali_hc * a.anali_wh)/a.anali_fch)*1000),0) * a.anali_eff)/a.anali_wh)) * b.anali_act_ct1)/60, 0), '') timex
        FROM ie_capacity_analih a 
        LEFT JOIN ie_capacity_analid b ON a.anali_id = b.anali_id
        WHERE a.anali_date ='$date' UNION ALL
        SELECT a.anali_id idx, a.anali_part partx, a.anali_line linex, a.anali_group groupx, a.anali_fch fchx, IFNULL(a.anali_by, '') byx, 
        IFNULL(ROUND((((IFNULL(3600/b.anali_act_ct1, 0) + IFNULL(3600/b.anali_act_ct2, 0)) - ((ROUND((((a.anali_hc * a.anali_wh)/a.anali_fch)*1000),0) * a.anali_eff)/a.anali_wh)) * b.anali_act_ct1)/60, 0), '') timex
        FROM ie_capacity_analih a 
        RIGHT JOIN ie_capacity_analidc b ON a.anali_id = b.anali_id
        WHERE a.anali_date ='$date'
      ) sa GROUP BY sa.idx, sa.partx, sa.linex, sa.groupx, sa.fchx, sa.byx
    ) sa 
    LEFT JOIN line sb ON sa.linex = sb.LINE_CODE
    LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM 
    WHERE 1=1 "
    .(($unit !="" && $unit != "ALL") ? " AND sb.LINE_PREF ='$unit' " : "").""
    .(($line !="" && $line != "ALL") ? " AND sb.LINE_CODE ='$line' " : "")."
    ";  

    //echo '<pre>'. $strSql . '</pre>';

  } else if ($section == 2){ //view list detail

    $id = $_GET['id'];
    $strSql = "
      SELECT idx, datex, linex, c.LINE_DESC linedx, leadx, groupx, partx, b.PART_NAME partdx, a.pfchx, a.pflagx, a.procx, a.procdx, a.mcx, a.fchx, a.effx, a.hcx, a.whx, a.tqtyx, 
      ROUND(3600 * (a.whx/a.tqtyx), 0) ttx, ROUND(a.tqtyx/a.whx, 0) thx, IFNULL(ROUND(a.cbstx, 0), 0) cbstx, 
      IFNULL(ROUND(3600/a.cbstx, 0), 0) cbsctx, IFNULL(ROUND(3600/(a.cbstx*effx), 1), 0) effctx, IFNULL(ROUND(3600/(3600/(a.cbstx*effx)), 0), 0) efftjx,
      a.oprx, IFNULL(a.oprct1x, '') oprct1x, IFNULL(a.oprct2x, '') oprct2x, IFNULL(3600/a.oprct1x, '') poprct1x, IFNULL(3600/a.oprct2x, '') poprct2x, (IFNULL(3600/a.oprct1x, 0) + IFNULL(3600/a.oprct2x, 0)) tpoprct,
      (IFNULL(3600/a.oprct1x, 0) + IFNULL(3600/a.oprct2x, 0)) - ROUND(a.tqtyx/a.whx,0) oprblx, 
      IFNULL(ROUND(oprct1x/(3600 * (a.whx/a.tqtyx)), 2), '') oprnedx,
      IFNULL(ROUND((((IFNULL(3600/a.oprct1x, 0) + IFNULL(3600/a.oprct2x, 0)) - (a.tqtyx/a.whx)) * a.oprct1x)/60, 0), '') bltmx
      FROM (
        SELECT
          c.anali_id idx, c.anali_date datex, c.anali_line linex, c.anali_lead leadx, c.anali_part partx, c.anali_fch pfchx, c.anali_group groupx, 
          'CBS' pflagx, a.anali_proc_id procx, b.CBSD_PROC_DESC procdx, b.CBSD_PROC_MC_TOOL mcx, a.anali_fch fchx, IFNULL(a.anali_opr, '') oprx, c.anali_eff effx,
          a.anali_act_ct1 oprct1x, a.anali_act_ct2 oprct2x, 
          (1000/a.anali_fch) cbstx,
          ROUND((((c.anali_hc * c.anali_wh)/c.anali_fch)*1000),0) * c.anali_eff tqtyx,
          c.anali_hc hcx, c.anali_wh whx
        FROM ie_capacity_analid a 
        LEFT JOIN toy_part_cbsd b ON a.anali_proc_id = b.CBSD_ID
        LEFT JOIN ie_capacity_analih c ON a.anali_id = c.anali_id
        WHERE a.anali_id = '$id' AND IFNULL(b.CBSD_PROC_FCH, 0) <> 0
        UNION ALL
        SELECT
          c.anali_id idx, c.anali_date datex, c.anali_line linex, c.anali_lead leadx, c.anali_part partx, c.anali_fch pfchx, c.anali_group groupx, 
          'CUS' pflagx, a.anali_proc_id procx, a.anali_proc procdx, a.anali_mc mcx, a.anali_fch fchx, IFNULL(a.anali_opr, '') oprx, c.anali_eff effx,
          a.anali_act_ct1 oprct1x, a.anali_act_ct2 oprct2x, 
          (1000/a.anali_fch) cbstx,
          ROUND((((c.anali_hc * c.anali_wh)/c.anali_fch)*1000),0) * c.anali_eff tqtyx,
          c.anali_hc hcx, c.anali_wh whx
        FROM ie_capacity_analidc a
        LEFT JOIN ie_capacity_analih c ON a.anali_id = c.anali_id
        WHERE a.anali_id = '$id'
      ) a 
      LEFT JOIN toy_part b on a.partx = b.PART_NUM
      LEFT JOIN line c on a.linex = c.LINE_CODE
    ";  

  } else if ($section == 3){ //add list detail
    
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    } 

    $req_date = $_POST['req_date'];
    $req_line = $_POST['req_line'];
    $req_group = $_POST['req_group'];
    $req_part = $_POST['req_part'];
    $req_lead = $_POST['req_lead'];
    $req_by = $_POST['req_by'];

    $msgx = '';

    $strSql = "
      SELECT IFNULL(COUNT(*),0) rec_count 
      FROM ie_capacity_analih 
      WHERE anali_date='$req_date' 
      AND anali_line='$req_line'
      AND anali_group='$req_group'
      AND anali_part='$req_part';
    ";

    $res = mysqli_query($conn, $strSql);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $rec_count = $row['rec_count'];

    if ($rec_count == 0) {
      
      //get style data
      $strSql = "SELECT * FROM toy_part_cbsh WHERE CBSH_PART_NUM='$req_part' LIMIT 1;";
      $res = mysqli_query($conn, $strSql);
      $row = mysqli_fetch_array($res, MYSQLI_ASSOC);

      $fchx = $row['CBSH_FCH'];
      $effx = floatval($row['CBSH_EFF'])/100;
      $hcx = $row['CBSH_OPT'];
      $whx = $row['CBSH_WORK_HOUR'];
      
      $strSql = "
      INSERT INTO `ie_capacity_analih` (
        `anali_date`, `anali_line`, `anali_group`, 
        `anali_lead`, `anali_part`, `anali_fch`, `anali_eff`, `anali_hc`, `anali_wh`, `anali_by`, 
        `add_date`, `add_id`
      ) VALUES (
        '$req_date', '$req_line', '$req_group', 
        '', '$req_part', '$fchx', '$effx', $hcx, $whx, '$req_by',
        NOW(), $useridx
      );";

      if (mysqli_query($conn, $strSql)) {
       
        $strSql = "
        SELECT anali_id FROM ie_capacity_analih 
        WHERE `anali_date`='$req_date' AND `anali_line`='$req_line' AND  
         `anali_group`='$req_group' AND `anali_part`='$req_part';
        ";

        $res = mysqli_query($conn, $strSql);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $idx = $row['anali_id'];

        // INSERT CBS
        $strSql = "
        INSERT INTO `ie_capacity_analid` (`anali_id`, `anali_proc_id`, `anali_fch`, `anali_opr`, `anali_act_ct1`, `anali_act_ct2`, `add_date`, `add_id`) 
        SELECT '$idx' aidx, a.CBSD_ID procx, a.CBSD_PROC_FCH fchx, '' anali_opr, NULL act1, NULL act2, NOW() addx, '$useridx' adux   
        FROM toy_part_cbsd a 
        LEFT JOIN toy_part_cbsh b ON a.CBSD_PART_NUM = b.CBSH_PART_NUM
        WHERE a.CBSD_PART_NUM = '$req_part';
        ";

        if (mysqli_query($conn, $strSql)) {
          $action = 'TRUE';
        } else {
          $action = 'FALSE';
        }

        // INSERT CUSTOME
        $strSql = "
        INSERT INTO `ie_capacity_analidc` (`anali_id`, `anali_proc_id`, `anali_proc`, `anali_fch`, `anali_opr`, `anali_act_ct1`, `anali_act_ct2`, `add_date`, `add_id`) 
        SELECT '$idx' aidx, 'A1' procx, '' procdx, 0 fchx, '' anali_opr, NULL act1, NULL act2, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'A2' procx, '' procdx, 0 fchx, '' anali_opr, NULL act1, NULL act2, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'A3' procx, '' procdx, 0 fchx, '' anali_opr, NULL act1, NULL act2, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'A4' procx, '' procdx, 0 fchx, '' anali_opr, NULL act1, NULL act2, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'A5' procx, '' procdx, 0 fchx, '' anali_opr, NULL act1, NULL act2, NOW() addx, '$useridx' adux   
        ";
        
        if (mysqli_query($conn, $strSql)) {
          $action = 'TRUE';
        } else {
          $action = 'FALSE';
        }

      } else {
        $action = 'FALSE';
      }
    } else {
      $action = 'FALSE';
      $msgx = "DUPLIKAT";
    }
    
    $strSql = "
      SELECT '$action' actx, '$msgx' msgx;
    ";
  
  } else if ($section == 4){ //update list detail
    
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }
    
    $rflag = $_POST['rflag'];
    $rId = $_POST['rId'];
    $rIdProc = $_POST['rIdProc'];

    $rEff = floatval($_POST['rEff'])/100;
    $rHc = $_POST['rHc']; 
    $rWh = $_POST['rWh'];

    $rProc = $_POST['rProc'];
    $rProcOpn = $_POST['rProcOpn'];
    $rProcOp1 = (int)$_POST['rProcOp1'];
    $rProcOp2 = (int)$_POST['rProcOp2'];

    if ($rflag == 'H') {
      $strSql ="
      UPDATE ie_capacity_analih 
      SET anali_eff='$rEff', anali_hc='$rHc', anali_wh='$rWh', mod_date=NOW(), mod_id='$useridx'
      WHERE anali_id='$rId';
      ";
    } else if ($rflag == 'D') {
      $strSql ="
      UPDATE ie_capacity_analid 
      SET anali_opr='$rProcOpn', anali_act_ct1='$rProcOp1', anali_act_ct2='$rProcOp2', mod_date=NOW(), mod_id='$useridx' 
      WHERE anali_id='$rId' AND anali_proc_id='$rIdProc';
      ";
    } else if ($rflag == 'E') {
      $strSql ="
      UPDATE ie_capacity_analidc
      SET anali_proc='$rProc', anali_opr='$rProcOpn', anali_act_ct1='$rProcOp1', anali_act_ct2='$rProcOp2', mod_date=NOW(), mod_id='$useridx' 
      WHERE anali_id='$rId' AND anali_proc_id='$rIdProc';
      ";
    }

    $action ="";
    if (mysqli_query($conn, $strSql)) {
      $action = 'TRUE';
    } else {
      $action = 'FALSE';
    }

    $strSql = "
      SELECT '$action' actionx, '$msgx' msgx;
    ";
  } else if ($section == 5) {

    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }
  
    $data_id = $_POST['data_id'];

    $strSql = "DELETE FROM ie_capacity_analidc WHERE anali_id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }

    $strSql = "DELETE FROM ie_capacity_analid WHERE anali_id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }

    $strSql = "DELETE FROM ie_capacity_analih WHERE anali_id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }
    
  } else if ($section == 90){ //view all list lead    
    $strSql = "
    SELECT DISTINCT lead_name leadx FROM (
      SELECT lead_name FROM line_leader a UNION ALL
      SELECT DISTINCT a.LINE_NAME_SPV FROM line a
    ) a ORDER BY lead_name;
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