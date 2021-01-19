<?php

  $servername = "ersmysql-dev-gc.rcs.griffith.edu.au";
  $username = "blurredmindsdb_u";
  $password = "tmRuNs6A";
  $database = "blurredmindsdb";
  $dbport = 3306;
  
  // create connection
  $db = new mysqli($servername, $username, $password, $database, $dbport);
  $test = $_POST["test"];
  
  $sql = "INSERT INTO test (test) VALUES ('$test')";
  
  $db->query($sql);

?>