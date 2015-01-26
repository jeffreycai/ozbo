<?php

/**
 * Cron job to go through movies that haven't been update (no details) and call OMDB API
 * to get the details
 */



require_once __DIR__ . '/../../../bootstrap.php';

foreach (Movie::findAllToPopulate() as $movie) {
  $crawler = new Crawler();
  $result = $crawler->read('http://www.omdbapi.com/?t=' . urlencode($movie->getSearchTitle()) . '&y=&plot=short&r=json');
  $result = json_decode($result);
  
  if (is_object($result)) {
    if ($result->Response == 'False') {
      $movie->setUpdatedAt(time());
      $movie->save();
      
      $message = 'Failed to get details for movie #' . $movie->getId() . ' - ' . $movie->getSearchTitle();
      $log = new Log('movie', Log::NOTICE, $message);
      $log->save();
      
      sendemailAdmin('Movie module notice for #' . $movie->getId(), $message);
      
      continue;
    }
    
    foreach (get_object_vars($result) as $key => $val) {
      $method = "set" . $key;
      if (method_exists($movie, $method)) {
        $movie->{$method}($val);
      }
    }

    if ($result = $movie->save()) {
      $movie->setUpdatedAt(time());
      $movie->save();
    } else {
      $message = 'Failed to store details to db for movie #' . $movie->getId() . ' - ' . $movie->getSearchTitle();
      $log = new Log('movie', Log::ERROR, $message);
      $log->save();
      
      sendemailAdmin('Movie moduel error for #' . $movie->getId(), $message);
    }
  }
  
}