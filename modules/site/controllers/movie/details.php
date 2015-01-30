<?php

$id = isset($vars[1]) ? $vars[1] : null;

if ($id && $movie = Movie::findByIMDBId($id)) {

  $html = new HTML();

  $html->renderOut('site/html_header', array(
      'body_class' => 'movie-details',
      'title' => i18n(array(
          'en' => 'Movie details :: ' . $movie->getSearchTitle(),
          'zh' => '电影详情 :: ' . $movie->getSearchTitle()
      )) . " :: " . $settings['sitename']['plain'][get_language()]
  ));
  $html->renderOut('site/header');
  $html->renderOut('site/jumbotron/general', array('title' => i18n(array(
      'en' => $movie->getSearchTitle(),
      'zh' => $movie->getSearchTitle()
  ))));
  $html->renderOut('site/components/breadcrumbs', array(
    'items' => array(
        i18n(array(
            'en' => 'Home',
            'zh' => '首页'
        )) => uri(''),
        i18n(array(
            'en' => 'Movie details',
            'zh' => '电影详情'
        )) . ' / ' . $movie->getSearchTitle() => uri('')
    )
  ));
  $html->renderOut('site/movie/details', array('movie' => $movie));
  $html->renderOut('site/footer');
  $html->renderOut('site/html_footer');
  
} else {
  dispatch('site/404');
  exit;
}