<?php
class Telstra {

  private $cookie_path;
  private $user_agent;
  
  function __construct() {
    $this->cookie_path = WEBROOT . '/modules/site/cron/cookie.txt';
    $this->user_agent = "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)";
  }
  
  /**
   * Login to Telstra
   * 
   * @param type $username
   * @param type $password
   */
  function login($username, $password, $cookie_path = null) {
    
    $cookie_path = $this->make_cookie_path($cookie_path);
    
    // login
    $ch = curl_init("https://signon.telstra.com.au/login");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // whether to print out or not when curl_exec();
    curl_setopt($ch, CURLOPT_HEADER, 0); // whether to include HEADER in output
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); // where to put cookie after curl_close()
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "goto=https%3A%2F%2Fwww.my.telstra.com.au%2Fmyaccount%2Floyalty-offers-consumer&gotoOnFail=https%3A%2F%2Fwww.my.telstra.com.au%2Fmyaccount%2Fhome%2Ferror%3Fflag%3D&encoded=false&gx_charset=UTF-8&username=$username&password=$password&_58_rememberMeCheckbox=on");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Follow redirect or not
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10); // Max redirects to follow. Use it along with CURLOPT_FOLLOWLOCATION

    $result = curl_exec($ch);
    curl_close($ch);
  }
  
  /**
   * Log out current Telstra user
   * 
   * @param type $cookie_path
   */
  function logout($cookie_path = null) {
    
    $cookie_path = $this->make_cookie_path($cookie_path);
    
    // logout
    $ch = curl_init("https://www.my.telstra.com.au/myaccount/log-out");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // whether to print out or not when curl_exec();
    curl_setopt($ch, CURLOPT_HEADER, 0); // whether to include HEADER in output
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); // where to put cookie after curl_close()
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);
  }
  
  /**
   * Get Cinema info with different States
   */
  function getCinemas($cookie_path = null) {
    
    $cookie_path = $this->make_cookie_path($cookie_path);
    
    $settings = Vars::getSettings();
    $states = array();
    $error_flag = false;
    foreach ($settings['states'] as $state) {
      $ch = curl_init("https://www.my.telstra.com.au/myaccount/loyalty-offers-consumer/loadCinemas.json?state=" . $state . "&_=" . time() . rand(100, 999));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // whether to print out or not when curl_exec();
      curl_setopt($ch, CURLOPT_HEADER, 0); // whether to include HEADER in output
      curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
      curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); // where to put cookie after curl_close()
      curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      $result = curl_exec($ch);
      curl_close($ch);
      $states[$state] = json_decode($result);
      if (!is_object($states[$state]) || $states[$state]->status != 'SUCCESS') {
        $log = new Log('cron', Log::ERROR, 'Curl went wrong when getting state cinemas for "' . $state .'"');
        $log->save();
        $error_flag = true;
      }
    }
//_debug($states);
    // store in db
    $states = serialize($states);
    if ($error_flag == false) {
      $var = new Vars();
      $var->setName('states');
      $var->setValue($states);
      if ($var->save()) {
        $log = new Log('cron', Log::SUCCESS, 'Telstra Cinema cron finishes.');
        $log->save();
      } else {
        $log = new Log('cron', Log::ERROR, 'Telstra Cinema cron fails');
        $log->save();
      }
    }

    return $error_flag == false ? $states : false;
  }
  
  /**
   * get all sessions for a particular cinema
   * 
   * @param type $cinemaId
   */
  function getSessions($cinemaId, $cookie_path = null) {
    
    $cookie_path = $this->make_cookie_path($cookie_path);
    
    $ch = curl_init("https://www.my.telstra.com.au/myaccount/loyalty-offers-consumer/loadMovies.json?cinemaId=" . $cinemaId ."&_=" . time() . rand(100, 999));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // whether to print out or not when curl_exec();
    curl_setopt($ch, CURLOPT_HEADER, 0); // whether to include HEADER in output
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); // where to put cookie after curl_close()
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
  }
  
  /**
   * curl to get booking url
   * 
   * @param type $cinema
   * @param type $movie
   * @param type $session
   */
  function getBookingUrl($cinema, $movie, $session, $cookie_path = null) {
    
    $cookie_path = $this->make_cookie_path($cookie_path);
    
    //               https://www.my.telstra.com.au/myaccount/loyalty-offers-consumer/buyTicket?cinema=68%2CAHL%2Cnull%2C0&movie=1668&session=5185877&_=1420687772516
    $ch = curl_init("https://www.my.telstra.com.au/myaccount/loyalty-offers-consumer/buyTicket?cinema=$cinema&movie=$movie&session=$session" . "&_=" . time() . rand(100, 999));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // whether to print out or not when curl_exec();
    curl_setopt($ch, CURLOPT_HEADER, 0); // whether to include HEADER in output
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); // where to put cookie after curl_close()
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
  }
  
  /**
   * Read page content from booking url
   * 
   * @param type $booking_url
   * @param type $cookie_path
   */
  public function readUrl($url, $cookie_path = null) {
    $cookie_path = $this->make_cookie_path($cookie_path);
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // whether to print out or not when curl_exec();
    curl_setopt($ch, CURLOPT_HEADER, 0); // whether to include HEADER in output
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_path);
//    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_path); // where to put cookie after curl_close()
    curl_setopt($ch, CURLOPT_USERAGENT, $this->user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
  }
  
  /**
   * Create cookie file if not exist
   * 
   * @param type $cookie_path
   * @return type
   */
  public function make_cookie_path($cookie_path) {
    // set cookie file
    if (is_null($cookie_path)) {
      $cookie_path = $this->cookie_path;
    }
    
    // create cookie file if not exist
    if (!is_file($cookie_path)) {
      $f = fopen($cookie_path, 'w');
      fclose($f);
    }
    
    return $cookie_path;
  }
}