<?php

class GitsmDB {
  function __construct() {
    // Connect to GITSM DB
    $host = $_ENV["GITSM_DB_HOST"];
    $user = $_ENV["GITSM_DB_USER"];
    $password = $_ENV["GITSM_DB_PASSWORD"];
    $database = $_ENV["GITSM_DB_DATABASE"];

    mssql_connect($host, $user, $password) or die ("Could not connect to MSSQL");
    mssql_select_db($database);

    $pdo = new PDO("dblib:host=$host;dbname=$database", $user, $password);
    $this->db = new NotORM($pdo);
  }

  function findOne($query) {
    $result = mssql_query($query);
    $data = mssql_fetch_array($result);
    return $data;
  }
}

?>
