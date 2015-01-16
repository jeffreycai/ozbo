<?php

//-- Clear cache
if ($command == 'cc') {

  if ($arg1 == 'all') {
    echo " - Drop table 'ticket_order' ";
    echo TicketOrder::dropTable() ? "success\n" : "fail\n";
  }
}

//-- Import DB
if ($command == 'import' && $arg1 == 'db' && (is_null($arg2) || $arg2 == 'ticket_order') ) {
  //- create tables if not exits
  echo " - Create table 'ticket_order' ";
  echo TicketOrder::createTableIfNotExist() ? "success\n" : "fail\n";
}