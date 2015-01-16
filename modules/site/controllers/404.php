<?php
$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => '404',
    'title' => i18n(array(
        'en' => 'Page not found',
        'zh' => '页面没有找到'
    ))
));
$html->renderOut('site/header');
$html->renderOut('site/jumbotron/404');
$html->renderOut('site/404');
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');