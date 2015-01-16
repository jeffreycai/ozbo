<?php 
$start_entry = ($current_page - 1)*$settings['backend_per_page'] + 1;
$end_entry = min(array($total, $current_page*$settings['backend_per_page']));
?>

<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><?php i18n_echo(array('en' => 'Order', 'zh' => '订单')); ?></h1>
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        <div class="panel-heading"><?php i18n_echo(array('en' => 'Order list', 'zh' => '订单列表')) ?></div>
        <div class="panel-body">
          
        <?php echo Message::renderMessages(); ?>
          
<table class="table table-striped table-bordered table-hover dataTable no-footer">
  <thead>
      <tr role="row">
        <th>ID</th>
        <th><?php i18n_echo(array('en' => 'State', 'zh' => '州')) ?></th>
        <th><?php i18n_echo(array('en' => 'Cinema', 'zh' => '电影院')) ?></th>
        <th><?php i18n_echo(array('en' => 'Movie', 'zh' => '电影')) ?></th>
        <th><?php i18n_echo(array('en' => 'Session', 'zh' => '场次')) ?></th>
        <th><?php i18n_echo(array('en' => '# Ticket', 'zh' => '票数')) ?></th>
        <!--<th><?php i18n_echo(array('en' => 'Prices', 'zh' => '所有价格')) ?></th>-->
        <th><?php i18n_echo(array('en' => 'Our price', 'zh' => '我们的价格')) ?></th>
        <th><?php i18n_echo(array('en' => 'Total', 'zh' => '总金额')) ?></th>
        <!--<th><?php i18n_echo(array('en' => 'Email', 'zh' => '电子邮箱')) ?></th>-->
        <th><?php i18n_echo(array('en' => 'Created', 'zh' => '订票时间')) ?></th>
      </tr>
  </thead>
  <tbody>
    <?php foreach ($orders as $order): ?>
    <tr>
      <td><?php echo $order->getId(); ?></td>
      <td><?php echo $order->getState(); ?></td>
      <td><?php echo $order->getCinema(); ?></td>
      <td><?php echo $order->getMovie(); ?></td>
      <td><?php echo $order->getSession(); ?></td>
      <td><?php echo $order->getNumTicket(); ?></td>
      <!--<td><?php echo $order->getPrices(); ?></td>-->
      <td><?php echo $order->getOurPrice(); ?></td>
      <td><?php echo $order->getTotal(); ?></td>
      <!--<td><?php echo $order->getEmail(); ?></td>-->
      <td><?php echo $order->getCreatedAt(true); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row">
  <div class="col-sm-12" style="text-align: right;">
  <?php i18n_echo(array(
      'en' => 'Showing ' . $start_entry . ' to ' . $end_entry . ' of ' . $total . ' entries', 
      'zh' => '显示' . $start_entry . '到' . $end_entry . '条记录，共' . $total . '条记录',
  )); ?>
  </div>
  <div class="col-sm-12" style="text-align: right;">
  <?php echo $pager; ?>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
</div>