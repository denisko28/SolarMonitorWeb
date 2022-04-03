<?php
  require 'Connection.php';
  require 'CRUDFunctions.php';

  try{
    $lastID = $_GET['lastID'];
  }catch(Exception $e){
    echo $e->getMessage();
  }
  
  $conn = MysqlConnect();

  $sql = "SELECT `LastValue` FROM `LastRevision` WHERE ID = ". $lastID;
  $lastValue = sqlSelectOne($sql, $conn);
  echo $lastValue;

  $conn->close();
?>