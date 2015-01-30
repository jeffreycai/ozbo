<?php
define('MOVIE_POST_PATH', MODULESROOT . DS . 'movie' . DS . 'posters');

if (!is_writable(MOVIE_POST_PATH)) {
  die('Movie poster dir needs to be writable.');
}


$user = User::getInstance();
if (!is_cli() && $user->isLogin() && is_backend()) {
  
  // register admin
  Backend::registerSideNav(
  '
  <li>
    <a href="'.uri('admin/movie/list').'"><i class="fa fa-film"></i> '.i18n(array('en' => 'Movie list', 'zh' => '电影列表')) . '</a>
  </li>
  '        
  );

}