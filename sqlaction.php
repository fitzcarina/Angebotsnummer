<?php
  function OpenConnection()
  {
      $serverName = "LT-080120\SQLExpress";
      $connectionOptions = array("Database"=>"schnupp",
          "Uid"=>"", "PWD"=>"");
      $conn = sqlsrv_connect($serverName, $connectionOptions);
      if($conn == false)
          die(FormatErrors(sqlsrv_errors()));

      return $conn;
  }
?>