<?php
define('MYSQL_HOST', 'localhost');
define('MYSQL_USER', 'dev-ozboxoffice');
define('MYSQL_PASS', 'q6p8XWjWVR2SDZWM');
define('MYSQL_DB', 'dev-ozboxoffice');

//-- initialize MySQL
global $mysqli;
$mysqli = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
if ($mysqli->connect_errno) {
  printf("Connect failed: %s", $mysqli->connect_error);
  exit;
}
