<?php

if (!isset($_GET['cinemaId'])) {
  die('Error: cinemaId not provided.');
}

$telstra = new Telstra();
//$telstra->login('bluestreamjc', '0172122a');
$result = $telstra->getSessions($_GET['cinemaId']);

header('Content-Type: application/json');
echo $result;


// we log the movie for later API crawl
$object = json_decode($result);
if (module_enabled('movie') && is_object($object)) {
  foreach ($object->result as $item) {
    $search_title = trim(str_ireplace('3D', '', $item->movie->name));
    Movie::logAMovieForLaterAPICrawl($search_title);
  }
}