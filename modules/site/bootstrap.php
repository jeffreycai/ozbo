<?php
define('UID_CONTACT_FORM', 'dskljII87)fds');
define('CACHE_FOLDER', WEBROOT . DS . 'cache');

$user = User::getInstance();

if (is_backend() && $user->isLogin()) {
  Backend::registerSideNav(
  '
  <li>
    <a href="' . uri('admin/order/list') . '"><i class="fa fa-list-alt"></i> '.i18n(array('en' => 'Order', 'zh' => '订单')).'</a>
  </li>
  '        
  );
}