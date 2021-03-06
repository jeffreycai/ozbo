<?php
$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => 'payment-result',
    'title' => i18n(array(
        'en' => 'Your payment failed',
        'zh' => '您的支付失败了'
    )) . $settings['sitename']['plain'][get_language()]
));
$html->renderOut('site/header');
$html->renderOut('site/jumbotron/general', array('title' => i18n(array(
    'en' => 'Payment failed',
    'zh' => '支付失败'
))));
$html->renderOut('site/payment_failed');
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');