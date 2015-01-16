<?php

$cinema = $_GET['cinema'];
$movie = $_GET['movie'];
$session = $_GET['session'];

if (!isset($cinema) || !isset($movie) || !isset($session)) {
  die('Parameters illegal');
}


$telstra = new Telstra();
//$telstra->login('bluestreamjc', '0172122a');
$result = $telstra->getBookingUrl($cinema, $movie, $session);

header('Content-Type: application/json');

// https://bookings.eventcinemas.com.au/tickets/order/step2?sessionId=5186734&bookingsource=TelstraMyAccount&requestId=538b4b1a-73e8-4b95-8a52-24c9705d66fc&token=KNT-d447b4f89ac4f6881379a1ca45494a3115611672

if (!preg_match('/^https:\/\/bookings\.eventcinemas/', $result) &&
    !preg_match('/^https:\/\/villagecinemas\.com\.au/', $result)) {
  die('error: ' . $result);
}

$booking_url = $result;

// fetch movie details from booking url
$result = $telstra->readUrl($booking_url);

// find the first price available
$tokens = explode("<span class=\"price\">", $result);
if (sizeof($tokens) > 1) {
  $tickets = array();
  for ($i = 0; $i < sizeof($tokens) - 1; $i++) {
    $matches = array();
    
    preg_match('/<a href="#[a-z0-9]+" ?>([^<]+)<\/a>/i', $tokens[$i], $matches);
    if (isset($matches[1])) {
      $ticket_type = $matches[1];
    } else continue;
    
    
    preg_match('/^\$(\d+\.\d+)/', $tokens[$i+1], $matches);
    if (isset($matches[1])) {
      $price = $matches[1];
    } else continue;
    
    $tickets[str_replace(' ', '_', trim(strtolower($ticket_type)))] = $price;
  }
  header('Content-Type: application/json');
  echo json_encode($tickets);
} else {
  die('error: ' . $result);
}

