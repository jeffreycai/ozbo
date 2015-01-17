<?php
$order_id = isset($_SESSION['order_id']) ? $_SESSION['order_id'] : false;
$order;
        
if ($order_id && $order = TicketOrder::findById($order_id)) {
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
      'en' => 'Payment successful!',
      'zh' => '支付成功！'
  ))));
  $html->renderOut('site/payment_success', array('order' => $order));
  $html->renderOut('site/footer');
  $html->renderOut('site/html_footer');
} else {
  HTML::forward('payment/failed');
}




