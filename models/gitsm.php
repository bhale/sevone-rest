<?php

class GitsmDB {
  function __construct() {
    // Connect to GITSM DB
    $host = getenv('GITSM_DB_HOST');
    $user = getenv('GITSM_DB_USER');
    $password = getenv('GITSM_DB_PASSWORD');
    $database = getenv('GITSM_DB_DATABASE');

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
