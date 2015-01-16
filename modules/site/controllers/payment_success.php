<?php
$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => 'payment-result',
    'title' => i18n(array(
        'en' => 'Your payment is successful',
        'zh' => '您的支付成功了！'
    )) . $settings['sitename']['plain'][get_language()]
));
$html->renderOut('site/header');
$html->renderOut('site/jumbotron/general', array('title' => i18n(array(
    'en' => 'Payment successful',
    'zh' => '支付成功'
))));
$html->renderOut('site/payment_success');
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');


