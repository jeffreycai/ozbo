<?php

if (!isset($_GET['cinemaId'])) {
  die('Error: cinemaId not provided.');
}

$telstra = new Telstra();
//$telstra->login('bluestreamjc', '0172122a');
$result = $telstra->getSessions($_GET['cinemaId']);

header('Content-Type: application/json');
echo $result;
