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
    ";//Untuk daily history

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
    ";//check data duplikat atau tidak

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
  } else if ($section == 5) { //delete list

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
    
  } else if ($section == 6){ //view list

    $date = $_GET['date'];
    $unit = $_GET['unit'];
    $line = $_GET['line'];

    // $strSql = "
    // SELECT sa.*, sc.PART_NAME partdx, sb.LINE_DESC linedx, sb.LINE_PREF unitx
    // FROM (
    //   SELECT sa.idx, sa.partx, sa.linex, sa.groupx, sa.byx, sa.avgppm
    //   FROM (        
    //     SELECT a.rev_id idx, a.rev_part partx, a.rev_line linex, a.rev_group groupx, IFNULL(a.rev_by, '') byx, (ROUND(((a.rev_rej/a.rev_ss)*1000),0)) avgppm
    //     FROM fo_review_h a
    //     LEFT JOIN fo_review_d b ON a.rev_id = b.rev_id
    //     WHERE a.rev_date ='$date'
    //   ) sa GROUP BY sa.idx, sa.partx, sa.linex, sa.groupx
    // ) sa 
    // LEFT JOIN line sb ON sa.linex = sb.LINE_CODE
    // LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM
    // WHERE 1=1
    // ".(($unit !="" && $unit != "ALL") ? " AND sb.LINE_PREF ='$unit' " : "").""
    //  .(($line !="" && $line != "ALL") ? " AND sb.LINE_CODE ='$line' " : "")."";//Untuk daily history

    $strSql = "
    	SELECT sa.*, sc.PART_NAME partdx, sb.LINE_DESC linedx, sb.LINE_PREF unitx
      FROM (
        SELECT sa.idx, sa.partx, sa.linex, sa.groupx, sa.byx, sa.avgppm
        FROM (        
          SELECT a.rev_id idx, a.rev_part partx, a.rev_line linex, a.rev_group groupx, IFNULL(a.rev_by, '') byx, ROUND((a.rev_avgppm),0) avgppm
          FROM fo_review_h a
            LEFT JOIN fo_review_d b ON a.rev_id = b.rev_id
            WHERE a.rev_date ='$date'
        ) sa GROUP BY sa.idx, sa.partx, sa.linex, sa.groupx
      ) sa 
      LEFT JOIN line sb ON sa.linex = sb.LINE_CODE
      LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM
      WHERE 1=1
    ".(($unit !="" && $unit != "ALL") ? " AND sb.LINE_PREF ='$unit' " : "").""
     .(($line !="" && $line != "ALL") ? " AND sb.LINE_CODE ='$line' " : "").";
     ";//Untuk daily history

    //echo '<pre>'. $strSql . '</pre>';

  } else if ($section == 7){ //view list detail

    $id = $_GET['id'];
    // $strSql = "
    //   SELECT idx, datex, linex, c.LINE_DESC linedx, groupx, partx, byx, stg, ss, rej, seam, spi, dim, oth, act, a.c_aes, a.c_func, a.c_dim, a.c_stat, avgppm, b.PART_NAME partdx, a.pflagx, a.procx, a.procdx, a.mcx
    //   FROM (
    //     SELECT
    //       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej, c.rev_seam seam, c.rev_spi spi, c.rev_dim dim, c.rev_oth oth, c.rev_act act, (ROUND(((c.rev_rej/c.rev_ss)*1000),0)) avgppm,
    //       'CBS' pflagx, a.rev_proc_id procx, b.CBSD_PROC_DESC procdx,  b.CBSD_PROC_MC_TOOL mcx, d.rev_c_aes c_aes, d.rev_c_func c_func, d.rev_c_dim c_dim, d.rev_c_stat c_stat
    //     FROM fo_review_d a 
    //     LEFT JOIN toy_part_cbsd b ON a.rev_proc_id = b.CBSD_ID
    //     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
    //     LEFT JOIN fo_review_dc d ON a.rev_id = d.rev_id
    //     WHERE a.rev_id = '$id' AND IFNULL(b.CBSD_PROC_FCH, 0) <> 0
    //     UNION ALL
    //     SELECT
    //       c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej, c.rev_seam seam, c.rev_spi spi, c.rev_dim dim, c.rev_oth oth, c.rev_act act, (ROUND(((c.rev_rej/c.rev_ss)*1000),0)) avgppm,
    //       'CUS' pflagx, a.rev_proc_id procx, a.rev_proc procdx, a.rev_mc mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat
    //     FROM fo_review_dc a
    //     LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
    //     WHERE a.rev_id = '$id'
    //   ) a 
    //   LEFT JOIN toy_part b on a.partx = b.PART_NUM
    //   LEFT JOIN line c on a.linex = c.LINE_CODE;
    // ";
    $strSql = "
      SELECT idx, datex, linex, b.PART_NAME partdx, c.LINE_DESC linedx, groupx, partx, byx, stg, a.ss, a.rej, avgppm, totavgppm, a.pflagx, a.seam, a.spi, a.dim, a.oth, a.act, a.c_aes, a.c_func, a.c_dim, a.c_stat, a.procx, a.procdx, a.mcx
      FROM (
        SELECT
          c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, a.rev_ss ss, a.rev_rej rej, ROUND(((a.rev_rej/a.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm,
          'CBS' pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth, a.rev_act act, a.rev_proc_id procx, b.CBSD_PROC_DESC procdx,  b.CBSD_PROC_MC_TOOL mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat
        FROM fo_review_d a
        LEFT JOIN toy_part_cbsd b ON a.rev_proc_id = b.CBSD_ID
        LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
        WHERE a.rev_id = '$id' AND IFNULL(b.CBSD_PROC_FCH, 0) <> 0
        UNION ALL
        SELECT
          c.rev_id idx, c.rev_date datex, c.rev_line linex, c.rev_part partx, c.rev_group groupx, c.rev_by byx, c.rev_stage stg, c.rev_ss ss, c.rev_rej rej, ROUND(((c.rev_rej/c.rev_ss)*1000),0) avgppm, c.rev_avgppm totavgppm,
          'CUS' pflagx, a.rev_seam seam, a.rev_spi spi, a.rev_dim dim, a.rev_oth oth, a.rev_act act, a.rev_proc_id procx, a.rev_proc procdx, a.rev_mc mcx, a.rev_c_aes c_aes, a.rev_c_func c_func, a.rev_c_dim c_dim, a.rev_c_stat c_stat
        FROM fo_review_dc a
        LEFT JOIN fo_review_h c ON a.rev_id = c.rev_id
        WHERE a.rev_id = '$id'
        ) a
      LEFT JOIN toy_part b on a.partx = b.PART_NUM
      LEFT JOIN line c on a.linex = c.LINE_CODE;
    ";

  } else if ($section == 8){ //add list detail  
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }

    $rev_date = $_POST['rev_date'];
    $rev_line = $_POST['rev_line'];
    $rev_group = $_POST['rev_group'];
    $rev_part = $_POST['rev_part'];
    $rev_stage = $_POST['rev_stage'];
    $rev_by = $_POST['rev_by'];

    $msgx = '';

    $strSql = "
      SELECT IFNULL(COUNT(*),0) rec_count 
      FROM fo_review_h
      WHERE rev_date='$rev_date' 
      AND rev_line='$rev_line'
      AND rev_group='$rev_group'
      AND rev_part='$rev_part'
      AND rev_stage='$rev_stage'
      AND rev_by='$rev_by';
    ";//check data duplikat atau tidak

    $res = mysqli_query($conn, $strSql);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $rec_count = $row['rec_count'];

    if ($rec_count == 0) {
      
      //get style data
      $strSql = "SELECT * FROM toy_part_cbsh WHERE CBSH_PART_NUM='$rev_part' LIMIT 1;";
      $res = mysqli_query($conn, $strSql);
      $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
      
      $strSql = "
      INSERT INTO `fo_review_h` (
        `rev_avgppm`, `rev_date`, `rev_line`, `rev_group`, 
        `rev_part`, `rev_by`, `rev_stage`, 
        `add_date`, `add_id`
      ) VALUES (
        '0', '$rev_date', '$rev_line', '$rev_group',
        '$rev_part', '$rev_by', '$rev_stage',
        NOW(), $useridx
      );";

      if (mysqli_query($conn, $strSql)) {
       
        $strSql = "
        SELECT rev_id FROM fo_review_h 
        WHERE `rev_date`='$rev_date' AND `rev_line`='$rev_line' AND  
         `rev_group`='$rev_group' AND `rev_part`='$rev_part';
        ";

        $res = mysqli_query($conn, $strSql);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $idx = $row['rev_id'];

        // INSERT CBS
        $strSql = "
        INSERT INTO `fo_review_d` (`rev_id`, `rev_proc_id`, `rev_ss`, `rev_rej`, `rev_avgppm`, `rev_seam`, `rev_spi`, `rev_dim`, `rev_oth`, `rev_act`, `add_date`, `add_id`) 
        SELECT '$idx' aidx, a.CBSD_ID procx, '0' ss, '0' rej, '0' avgppm, '' seam, '' spi, '' dim, '' oth, '' act, NOW() addx, '$useridx' adux   
        FROM toy_part_cbsd a 
        LEFT JOIN toy_part_cbsh b ON a.CBSD_PART_NUM = b.CBSH_PART_NUM
        WHERE a.CBSD_PART_NUM = '$rev_part';
        ";

        if (mysqli_query($conn, $strSql)) {
          $action = 'TRUE';
        } else {
          $action = 'FALSE';
        }

        // INSERT CUSTOME
        $strSql = "
        INSERT INTO `fo_review_dc` (`rev_id`, `rev_proc_id`, `rev_proc`, `rev_c_aes`, `rev_c_func`, `rev_c_dim`, `rev_c_stat`, `add_date`, `add_id`) 
        SELECT '$idx' aidx, 'DC1' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'DC2' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'DC3' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'DC4' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, NOW() addx, '$useridx' adux UNION ALL
        SELECT '$idx' aidx, 'DC5' procx, '' procdx, '' c_aes, '' c_func, '' c_dim, '0' c_stat, NOW() addx, '$useridx' adux;
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
  
  } else if ($section == 9){ //update list detail
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }
    
    $rflag = $_POST['rflag'];
    $rId = $_POST['rId'];
    $rIdProc = $_POST['rIdProc'];

    $rSs = $_POST['rSs'];
    $rRej = $_POST['rRej'];
    if ($rRej == null || $rRej == 0 || $rSs == null || $rSs == 0) {
      $rAvg = 0;
      $rTotavg = 0;
    } else {
      $rAvg = round((($rRej/$rSs)*1000),0);
    }

    $rSeam = $_POST['rSeam'];
    $rSpi = $_POST['rSpi'];
    $rDim = $_POST['rDim'];
    $rOth = $_POST['rOth'];
    $rAct = $_POST['rAct'];

    $rAes = $_POST['rAes'];
    $rFunc = $_POST['rFunc'];
    $rC_dim = $_POST['rC_dim'];
    $rStat = $_POST['rStat'];

    if ($rflag == 'D') {
      // $strSql ="
      // UPDATE fo_review_d a INNER JOIN fo_review_h b ON (a.rev_id = b.rev_id)
      // SET
      //   a.rev_ss='$rSs', a.rev_rej='$rRej', a.rev_avgppm='$rAvg', a.rev_seam='$rSeam', a.rev_spi='$rSpi', a.rev_dim='$rDim', a.rev_oth='$rOth', a.rev_act='$rAct', a.mod_date=NOW(), a.mod_id='$useridx',
      //   b.rev_avgppm='$rTotavg'
      // WHERE a.rev_id = '$rId' AND a.rev_proc_id = '$rIdProc' AND b.rev_id = '$rId';
      // ";
      $strSql ="
      UPDATE fo_review_d
      SET rev_ss='$rSs', rev_rej='$rRej', rev_avgppm='$rAvg', rev_seam='$rSeam', rev_spi='$rSpi', rev_dim='$rDim', rev_oth='$rOth', rev_act='$rAct', mod_date=NOW(), mod_id='$useridx' 
      WHERE rev_id='$rId' AND rev_proc_id='$rIdProc';
      ";

      if (mysqli_query($conn, $strSql)) {
        $strSql = "
          SELECT (IFNULL(SUM(ROUND((rev_avgppm),0)),0) / IFNULL(COUNT(*),0)) avgppm
	        FROM fo_review_d
          WHERE rev_id='$rId';
        ";

        $res = mysqli_query($conn, $strSql);
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $rTotavg = round(($row['avgppm']),0);

        $strSql ="
        UPDATE fo_review_h
        SET rev_avgppm='$rTotavg'
        WHERE rev_id='$rId';
        ";
      } else {
        $action = 'FALSE';
      }
    } else if ($rflag == 'DC') {
      $strSql ="
      UPDATE fo_review_dc
      SET rev_c_aes='$rAes', rev_c_func='$rFunc', rev_c_dim='$rC_dim', rev_c_stat='$rStat', mod_date=NOW(), mod_id='$useridx' 
      WHERE rev_id='$rId' AND rev_proc_id='$rIdProc';
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
  } else if ($section == 10) { //delete list

    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }
  
    $data_id = $_POST['data_id'];

    $strSql = "DELETE FROM fo_review_dc WHERE rev_id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }

    $strSql = "DELETE FROM fo_review_d WHERE rev_id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }

    $strSql = "DELETE FROM fo_review_h WHERE rev_id='$data_id';";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }
    
    $strSql = "ALTER TABLE fo_review_h AUTO_INCREMENT = 1;";
    if (mysqli_query($conn, $strSql)) {
      $strSql = "SELECT '$data_id' idx, 'TRUE' actx, 'Success delete' msgx";
    } else {
      $strSql = "SELECT '$data_id' idx, 'FALSE' actx, 'Error delete' msgx";
    }
    
  } else if ($section == 11){ //view list pis

    $style = strtoupper($_GET['style']);

    $strSql = "
    SELECT sc.PART_NAME partdx, sa.*
    FROM (
      SELECT a.toy_part_id idx, a.part_num partx, a.note_desc ndesc, a.note_dim ndim, a.note_stre nstre, a.fc_poi fcpoi, a.fc_desc fcdesc, a.fc_size fcsize,
      a.fc_allow fcallow, a.fc_stre fcstre
      FROM toy_part_pis a
      ) sa
    LEFT JOIN toy_part sc ON sa.partx = sc.PART_NUM
    WHERE 1=1
    ".(($style !="" && $style != "ALL") ? " AND UCASE(sc.PART_NAME) like '%$style%'" : "")."
    ORDER BY partdx ASC;
    ";

    //echo '<pre>'. $strSql . '</pre>';

  } else if ($section == 12){ //add pis  
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }

    $part_num = $_POST['add_part'];
    $note_desc = $_POST['note_desc'];
    $note_dim = $_POST['note_dim'];
    $note_stre = $_POST['note_stre'];
    $fc_poi = $_POST['fc_poi'];
    $fc_desc = $_POST['fc_desc'];
    $fc_size = $_POST['fc_size'];
    $fc_allow = $_POST['fc_allow'];
    $fc_stre = $_POST['fc_stre'];

    $msgx = '';

    $strSql = "
      SELECT IFNULL(COUNT(*),0) rec_count 
      FROM toy_part_pis
      WHERE part_num='$part_num' 
      AND note_desc='$note_desc'
      AND note_dim='$note_dim'
      AND note_stre='$note_stre'
      AND fc_poi='$fc_poi'
      AND fc_desc='$fc_desc'
      AND fc_size='$fc_size'
      AND fc_allow='$fc_allow'
      AND fc_stre='$fc_stre';
    ";//check data duplikat atau tidak

    $res = mysqli_query($conn, $strSql);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $rec_count = $row['rec_count'];

    if ($rec_count == 0) {
      
      //get style data
      $strSql = "
      INSERT INTO `toy_part_pis` (
        `part_num`, `note_desc`, `note_dim`, `note_stre`, 
        `fc_poi`, `fc_desc`, `fc_size`, `fc_allow`, `fc_stre`,
        `add_date`, `add_id`
      ) VALUES (
        '$part_num', '$note_desc', '$note_dim', '$note_stre',
        '$fc_poi', '$fc_desc', '$fc_size', '$fc_allow', '$fc_stre',
        NOW(), $useridx
      );";

      if (mysqli_query($conn, $strSql)) {
        $action = 'TRUE';
      } else {
        $action = 'FALSE';
      }
    } else {
      $action = 'FALSE';
      $msgx = "DUPLIKAT";
    }
    
    $strSql = "
      SELECT '$action' actx, '$msgx' msgx, $part_num;
    ";  
  } else if ($section == 13){ //update list detail
    if ($menu_mod == 0) {
      $rows["auth_mod"] = "false";
      echo json_encode($rows);
      exit();
    }
    
    $rId = $_POST['rId'];
    $rPart = $_POST['rPart'];

    $uNdesc = $_POST['rNdesc'];
    $uNdim = $_POST['rNdim'];
    $uNstre = $_POST['rNstre'];
    $uFcpoi = $_POST['rFcpoi'];
    $uFcdesc = $_POST['rFcdesc'];
    $uFcsize = $_POST['rFcsize'];
    $uFcallow = $_POST['rFcallow'];
    $uFcstre = $_POST['rFcstre'];

    $strSql ="
    UPDATE toy_part_pis
    SET note_desc='$uNdesc', note_dim='$uNdim', note_stre='$uNstre', fc_poi='$uFcpoi', fc_desc='$uFcdesc', fc_size='$uFcsize', fc_allow='$uFcallow', fc_stre='$uFcstre', mod_date=NOW(), mod_id='$useridx' 
    WHERE toy_part_id='$rId' AND part_num='$rPart';
    ";

    $action ="";
    if (mysqli_query($conn, $strSql)) {
      $action = 'TRUE';
    } else {
      $action = 'FALSE';
    }
    
    $strSql = "
      SELECT '$action' actionx, '$msgx' msgx;
    ";
  } else if ($section == 90){ //view all list lead    
    $strSql = "
    SELECT DISTINCT lead_name leadx FROM (
      SELECT lead_name FROM line_leader a UNION ALL
      SELECT DISTINCT a.LINE_NAME_SPV FROM line a
    ) a ORDER BY lead_name;
    ";
  } else if ($section == 91) { // get ref style
    $strSql = "
      SELECT PART_NUM partx, PART_NAME part_namex 
      FROM toy_part ORDER BY PART_NAME ASC; 
    ";
  }
}

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