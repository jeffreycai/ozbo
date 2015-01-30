<?php

$states;
if ($states = Vars::findByName('states')) {
  $states = unserialize($states->getValue());
} else {
  require_once(WEBROOT . DS . 'modules' . DS . 'site' . DS . 'cron' . DS . 'telstra_cinema.php');
}

$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => 'booking',
    'title' => i18n(array(
        'en' => 'Book a movie ticket :: ',
        'zh' => '预订一张电影票 :: '
    )) . $settings['sitename']['plain'][get_language()]
));
$html->renderOut('site/header', array('active_url' => array('/booking')));
$html->renderOut('site/jumbotron/general', array('title' => i18n(array(
    'en' => 'Book your ticket',
    'zh' => '预订电影票'
))));
$html->renderOut('site/components/breadcrumbs', array(
    'items' => array(
        i18n(array(
            'en' => 'Home',
            'zh' => '首页'
        )) => uri(''),
        i18n(array(
            'en' => 'Booking',
            'zh' => '订票'
        )) => uri('booking')
    )
));
if (is_maintenance()) {
  $html->renderOut('site/maintenance');
} else {
  $html->renderOut('site/booking', array('states' => $states));
}
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');