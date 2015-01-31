<?php

/**
 * Cron job to go through movies that haven't been update (no details) and call OMDB API
 * to get the details
 */



require_once __DIR__ . '/../../../bootstrap.php';

foreach (Movie::findAllToPopulate() as $movie) {
  $movie->setUpdatedAt(time());
  $movie->save();
  
  $crawler = new Crawler();
  $result = $crawler->read('http://www.omdbapi.com/?t=' . urlencode($movie->getSearchTitle()) . '&y=&plot=full&r=json');
  $result = json_decode($result);
  
  if (is_object($result)) {
    if ($result->Response == 'False') {
      $message = 'Failed to get details for movie #' . $movie->getId() . ' - ' . $movie->getSearchTitle();
      $log = new Log('movie', Log::NOTICE, $message);
      $log->save();
      
      sendemailAdmin('Movie module notice for #' . $movie->getId(), $message);
      
      continue;
    }
    
    foreach (get_object_vars($result) as $key => $val) {
      $method = "set" . $key;
      if (method_exists($movie, $method)) {
        // special case for "released" field
        if (strtolower($method) == 'setreleased') {
          if (empty($val) || $val < (time() - (60 * 60 * 24 * $settings['movie']['back_track_how_long']))) {
            
          }
          
          $movie->setReleased(strtotime($val));
        // for other occations
        } else {
          $movie->{$method}($val);
        }
      }
    }

    if ($result = $movie->save()) {
      // copy remote image to local
      if ($movie->isPopulated()) {
        $tokens = explode('.', $movie->getPoster());
        $extension = array_pop($tokens);
        $local_post_path = MOVIE_POST_PATH . DS . $movie->getId() . '.' . $extension;
        if (copy($movie->getPoster(), $local_post_path)) {
          $movie->setPoster($movie->getId() . '.' . $extension);
          
          // resize / crop
          load_library_wide_image();
          WideImage::load($local_post_path)->resize(300, 460, 'outside')->crop('center', 'center', 300, 460)->saveToFile($local_post_path);
          
        } else {
          $movie->setPoster(null);
        }
        $movie->save();
      }
    } else {
      $message = 'Failed to store details to db for movie #' . $movie->getId() . ' - ' . $movie->getSearchTitle();
      $log = new Log('movie', Log::ERROR, $message);
      $log->save();
      
      sendemailAdmin('Movie moduel error for #' . $movie->getId(), $message);
    }
  }
  
}