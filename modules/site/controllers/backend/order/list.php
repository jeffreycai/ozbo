<?php
$page = isset($_GET['page']) ? $_GET['page'] : 1;
if (!preg_match('/^\d+$/', $page)) {
  dispatch('core/backend/404');
  exit;
}
$settings = Vars::getSettings();

$html = new HTML();

$html->renderOut('core/backend/html_header', array(
  'title' => i18n(array('en' => 'Order list', 'zh' => '订单列表')),
), true);
$html->output('<div id="wrapper">');
$html->renderOut('core/backend/header');

$total = TicketOrder::countAll();
$total_page = ceil($total / $settings['backend_per_page']);
$html->renderOut('site/backend/order/list', array(
    'orders' => TicketOrder::findAllWithPage($page, $settings['backend_per_page']),
    'current_page' => $page,
    'total_page' => $total_page,
    'total' => $total,
    'pager' => $html->render('core/components/pagination', array('total' => $total_page, 'page' => $page))
), true);


$html->output('</div>');

$html->renderOut('core/backend/html_footer');

exit;