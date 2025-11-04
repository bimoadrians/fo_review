<?php
  //global var
  $GLOB_AUDIT_FLAG = "OFF";
  $GLOB_AUDIT_DATE = "('2025-01-29')";

  //server
  // $host_db    = "192.168.10.100";
  // $user_db    = "itteam";
  // $pass_db    = "itteam@5U1";
  // $nama_db    = "db_sahabat_unggul";
  // $port_db    = "3306";

  //server hr
  // $host_db_hr = "192.168.10.100";
  // $user_db_hr = "itteam";
  // $pass_db_hr = "itteam@5U1";
  // $nama_db_hr = "sui_hr_sistem";
  // $port_db_hr = "3306";
  
  // $ACCES_TOKEN = 'asd123159789asdasdqwerty';

  //server
  $host_db    = "192.168.10.105";
  //$host_db    = "103.145.177.157";
  $user_db    = "egipublic";
  $pass_db    = "Asd159789.";
  $nama_db    = "db_sahabat_unggul";
  $port_db    = "3306";

  //server hr
  $host_db_hr = "192.168.10.105";
  //$host_db_hr = "103.145.177.157";
  $user_db_hr = "egipublic";
  $pass_db_hr = "Asd159789.";
  $nama_db_hr = "sui_hr_sistem";
  $port_db_hr = "3306";

  $ACCES_TOKEN = 'asd123159789asdasdqwerty';

  $conn = mysqli_connect($host_db, $user_db, $pass_db, $nama_db, $port_db);
  $conn_hr = mysqli_connect($host_db_hr, $user_db_hr, $pass_db_hr, $nama_db_hr, $port_db_hr);
 
  
  //Change character set to utf8
  // mysqli_set_charset($conn,"utf8");