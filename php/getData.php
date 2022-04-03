<?php
    require 'Connection.php';

    try{
        $tableName = $_GET['tabName'];
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
    $conn = MysqlConnect();
    
    if($tableName == "Day")
    {
        $sql = "SELECT * FROM ". $tableName . " WHERE ID > 3 AND ID < 23 ORDER BY ID ASC";
    }
    else if($tableName == "Week" || $tableName == "Year")
    {
        $sql = "SELECT * FROM ". $tableName . " ORDER BY ID ASC";
    }else if($tableName == "Month")
    {
        $sql = "SELECT * FROM ". $tableName . " ORDER BY Date ASC";
    }else if($tableName == "AllTime")
    {
        $sql = "SELECT * FROM ". $tableName . " ORDER BY Year ASC";
    }
    $result = $conn->query($sql);
    $rows = array();
    while($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
    
    echo json_encode($rows) . " ";
    
    $conn->close();
?>