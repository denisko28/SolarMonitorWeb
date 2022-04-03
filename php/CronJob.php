<?php
  require 'Connection.php';
  require 'CRUDFunctions.php';

  date_default_timezone_set('Europe/Bucharest');

  $timNow = date("H");
  //$timNow = "23";
  $timNow = $timNow . ":00";
  echo $timNow;

  $dayNow = date("l");
  //$dayNow = "Sunday";
  echo $dayNow;

  $dateNow = date("j");
  //$dateNow = "31";
  echo $dateNow;

  $monthNow = date("F");
  //$monthNow = "August";
  echo $monthNow;

  $yearNow = date("Y");
  echo $yearNow;

  $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date("n"), date("Y"));
  //$daysInMonth = 31;
  echo $daysInMonth;

  if($timNow == "23:00")
  {
    // Create connection
    $conn = MysqlConnect();

    //End of the day
    $sql = "SELECT ROUND(SUM(Data), 1) FROM Day";
    $daySum = sqlSelectOne($sql, $conn);

    $sql = "UPDATE Day SET Data = 0  WHERE 1";
    sqlInsertUpdate($sql, $conn);
    
    $sql = "UPDATE Week SET Data = $daySum WHERE Day = '$dayNow'";
    sqlInsertUpdate($sql, $conn);

    $sql = "UPDATE Month SET Data = $daySum WHERE Date = '$dateNow'";
    sqlInsertUpdate($sql, $conn);

    //End of the week
    if($dayNow == "Sunday")
    {
      $sql = "UPDATE Week SET Data = 0  WHERE 1";
    }

    //End of the month
    if($dateNow == $daysInMonth)
    {
      $sql = "SELECT ROUND(SUM(Data), 1) FROM Month";
      $monthSum = sqlSelectOne($sql, $conn);

      $sql = "UPDATE Month SET Data = 0 WHERE 1";
      sqlInsertUpdate($sql, $conn);

      $sql = "UPDATE Year SET Data = $monthSum WHERE Month = '$monthNow'";
      sqlInsertUpdate($sql, $conn);

      //End of the Year
      if($monthNow == "December")
      {
        $sql = "SELECT ROUND(SUM(Data), 1) FROM Year";
        $yearSum = sqlSelectOne($sql, $conn);

        $sql = "UPDATE Year SET Data = 0 WHERE 1";
        sqlInsertUpdate($sql, $conn);

        $sql = "UPDATE AllTime SET Data = $yearSum WHERE Year = '$yearNow'";
        sqlInsertUpdate($sql, $conn);
      }
    }

    $conn->close();
  }
?>