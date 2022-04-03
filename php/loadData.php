<?php
    require 'Connection.php';
    require 'CRUDFunctions.php';

    try{
      $newRevVal = $_GET['data'];
    }catch(Exception $e){
      echo $e->getMessage();
    }
    
    date_default_timezone_set('Europe/Bucharest');
    
    $timNow = date("H");
    $timNow = $timNow . ":00";
    echo $timNow;
    
    $dayNow = date("l");
    echo $dayNow;
    
    $dateNow = date("j");
    echo $dateNow;

    $monthNow = date("F");
    echo $monthNow;

    $yearNow = date("Y");
    echo $yearNow;
    
    // Create connection
    $conn = MysqlConnect();
    
    //Check if new revision value is not smaller then previous revision
    $sql = "SELECT LastValue FROM LastRevision WHERE ID = '0'";
    $previousRevVal = sqlSelectOne($sql, $conn);
    if($newRevVal >= $previousRevVal)
        $dataVal = $newRevVal - $previousRevVal;
    else
        $dataVal = 0; 

    //Update Last Revision
    $sql = "UPDATE LastRevision SET LastValue = $newRevVal WHERE ID = '0'";
    sqlInsertUpdate($sql, $conn);
    
    $sql = "UPDATE LastRevision SET LastValue = $dataVal WHERE ID = '1'";
    sqlInsertUpdate($sql, $conn);

    // Insert to Journal
    $journalTime = date("H:i");
    $journalDate = date("Y-m-d");
    $sql = "INSERT INTO Journal (Date, Time, Data, RevisionVal) VALUES ('$journalDate', '$journalTime', $dataVal, $newRevVal)";
    sqlInsertUpdate($sql, $conn);
    
    //Update day value
    $sql = "SELECT Data FROM Day WHERE Time = '$timNow' LIMIT 1";
    $hourSum = sqlSelectOne($sql, $conn);
    $dataVal = $dataVal + $hourSum;
    
    $sql = "UPDATE Day SET Data = $dataVal  WHERE Time = '$timNow'";
    sqlInsertUpdate($sql, $conn);
    
    //Update week and month values
    $sql = "SELECT ROUND(SUM(Data), 1) FROM Day";
    $daySum = sqlSelectOne($sql, $conn);

    $sql = "UPDATE Week SET Data = $daySum WHERE Day = '$dayNow'";
    sqlInsertUpdate($sql, $conn);

    $sql = "UPDATE Month SET Data = $daySum WHERE Date = '$dateNow'";
    sqlInsertUpdate($sql, $conn);

    //Update year value
    $sql = "SELECT ROUND(SUM(Data), 1) FROM Month";
    $monthSum = sqlSelectOne($sql, $conn);

    $sql = "UPDATE Year SET Data = $monthSum WHERE Month = '$monthNow'";
    sqlInsertUpdate($sql, $conn);

    //Update allTime value
    $sql = "SELECT ROUND(SUM(Data), 1) FROM Year";
    $yearSum = sqlSelectOne($sql, $conn);

    $sql = "UPDATE AllTime SET Data = $yearSum WHERE Year = '$yearNow'";
    sqlInsertUpdate($sql, $conn);
    
    $conn->close();
?>