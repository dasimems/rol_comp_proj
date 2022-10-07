<?php

define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_HOST", "localhost");
define("DB_NAME", "roland_comp_db");
define("ADMIN_TABLE", "admin");

$dbarray = array(
    "DBUsername"=>DB_USERNAME,
    "DBName"=>DB_NAME,
    "DBHost"=>DB_HOST,
    "DBType"=>"mysql",
    "DBPassword"=>DB_PASSWORD
);

$dbarrayjson = json_encode($dbarray);

$dbconnect = new MYDB($dbarrayjson);