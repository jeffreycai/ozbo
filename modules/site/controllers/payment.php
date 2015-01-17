<?php

// we clear session info for previous booking
unset($_SESSION['order_id']);

// get params from POST
$token = isset($_POST['stripeToken']) ? $_POST['stripeToken'] : null;
$state = isset($_POST['state']) ? $_POST['state'] : null;
$cinema = isset($_POST['cinema']) ? $_POST['cinema'] : null;
$movie = isset($_POST['movie']) ? $_POST['movie'] : null;
$session = isset($_POST['session']) ? $_POST['session'] : null;
$num_ticket = isset($_POST['num_ticket']) ? $_POST['num_ticket'] : null;
$prices = isset($_POST['prices']) ? $_POST['prices'] : null;
$our_price = isset($_POST['our_price']) ? $_POST['our_price'] : null;
$total = isset($_POST['total']) ? $_POST['total'] : null;
$email = isset($_POST['email']) ? $_POST['email'] : null;
$lang = isset($_POST['lang']) ? $_POST['lang'] : null;

$title;
$content;


$response = 'failed';

// check if we have a stripe token
if (is_null($token)) {
  $response = "failed";

  $log = new Log('stripe', Log::ERROR, 'Stripe token missing');
  $log->save();
// if yes, call stripe API for peyment
} else {
  require_once MODULESROOT . DS . 'site' . DS . 'includes' . DS . 'libraries' . DS . 'stripe-php' . DS . 'lib' . DS . 'Stripe.php';
  
  // Set your secret key: remember to change this to your live secret key in production
  // See your keys here https://dashboard.stripe.com/account
  Stripe::setApiKey(ENV == 'prod' ? $settings['stripe']['live_secret_key'] : $settings['stripe']['test_secret_key']);

  // Get the credit card details submitted by the form
  // $token = $_POST['stripeToken'];

  // make description
  $fields = array(
      "State" => $state, 
      "Cinema" => $cinema, 
      "Movie" => $movie,
      "Session" => $session,
      "Num Tickets" => $num_ticket,
      "Prices" => $prices,
      "Our price" => $our_price,
      "Total" => $total,
      "Email" => $email,
      "lang" => $lang);
  $description = "";
  foreach ($fields as $key => $val) {
    $description .= "[$key] => $val\n";
  }
  
  // Create the charge on Stripe's servers - this will charge the user's card
  try {
    $log = new Log('stripe', Log::NOTICE, 'Strip: 1. Calling Stripe API with fields - ' . serialize($description), $_SERVER['REMOTE_ADDR']);
    $log->save();

    // call Stripe API to charge
    $charge = Stripe_Charge::create(array(
      "amount" => round($total * 100), // amount in cents, again
      "currency" => "aud",
      "card" => $token,
      "description" => $description)
    );
    $log = new Log('stripe', Log::SUCCESS, 'Strip: 2. API call successful. Credit card charged.', $_SERVER['REMOTE_ADDR']);
    $log->save();
    
    
    
    
    // store the order in db
    $order = new TicketOrder();
    $order->setToken($token);
    $order->setState($state);
    $order->setCinema($cinema);
    $order->setMovie($movie);
    $order->setSession($session);
    $order->setNumTicket($num_ticket);
    $order->setPrices($prices);
    $order->setOurPrice($our_price);
    $order->setTotal($total);
    $order->setCreatedAt(time());
    $order->setEmail($email);
    $order->setIp($_SERVER['REMOTE_ADDR']);
    $order->setLanguage($lang);
    $order->save();
    
    sendemailAdmin(
            ENV == 'prod' ? 'New transaction' : 'DEV: New transaction',
            str_replace("\n", '<br />', "<p>$description</p><p><strong>ID: </strong>" . $order->getId() . "</p>")
    );
    
    if ($order && $order->getId()) {
      // store in session so that the payment_success page knows
      $_SESSION['order_id'] = $order->getId();
      $response = "success";
      
      $log = new Log('stripe', Log::SUCCESS, 'Strip: 3. Order stored in local db.', $_SERVER['REMOTE_ADDR']);
      $log->save();
    } else {
      $response = "failed";
      
      $log = new Log('stripe', Log::ERROR, 'Strip: 3. Order failed to store in local db.', $_SERVER['REMOTE_ADDR']);
      $log->save();
    }
  } catch(Stripe_CardError $e) {
    // The card has been declined
    $response = "failed";
    
    // Since it's a decline, Stripe_CardError will be caught 
    $body = $e->getJsonBody();
    $err = $body['error'];
    
    $log = new Log('stripe', Log::ERROR, 'Strip: 2. API call failed. Credit card not charged. Details: Status is: "' . $e->getHttpStatus() . '" Type is: "' . $err['type'] . '" Code is: "' . $err['code'] . '" Param is: "' . $err['param'] . '" Message is: "' . '" ' . $err['message'], $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_InvalidRequestError $e) {
    // Invalid parameters were supplied to Stripe's API
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe Invalid Request Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_AuthenticationError $e) {
    // Authentication with Stripe's API failed 
    // (maybe you changed API keys recently)
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe Authentication Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_ApiConnectionError $e) {
    // Network communication with Stripe failed 
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe API Connection Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Stripe_Error $e) {
    // Display a very generic error to the user, and maybe send
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Stripe Error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  } catch (Exception $e) {
    // Something else happened, completely unrelated to Stripe
    $response = "failed";
    $log = new Log('stripe', Log::ERROR, 'Unknown error', $_SERVER['REMOTE_ADDR']);
    $log->save();
  }
  
}

echo $response;