<?php

$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => 'home',
    'title' => $settings['sitename']['plain'][get_language()]
));
$html->renderOut('site/header', array('active_url' => array('/')));
$html->renderOut('site/jumbotron/index');
if (is_maintenance()) {
  $html->renderOut('site/maintenance');
} else {
  $html->renderOut('site/index', array(
      'movies' => Movie::findAllValid(time() - (60 * 60 * 24 * $settings['movie']['back_track_how_long']))
  ));
}
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');