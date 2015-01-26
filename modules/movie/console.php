<?php

//-- Clear cache
if ($command == 'cc') {
  if ($arg1 == 'all') {
    echo " - Drop table 'movie' ";
    echo Movie::dropTable() ? "success\n" : "fail\n";
  }
}

//-- Import DB
if ($command == 'import' && $arg1 == 'db' && (is_null($arg2) || $arg2 == 'movie') ) {
  //- create tables if not exits
  echo " - Create table 'movie' ";
  echo Movie::createTableIfNotExist() ? "success\n" : "fail\n";
}
