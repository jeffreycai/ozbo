<section>
  <div class="container">
    <h2><?php echo i18n(array(
        'en' => 'Thanks you for buying tickets from us. <br />Your ticket will be mailed to you in next ' . $settings['process_time'] . ' hours',
        'zh' => '感谢您购买我们的电影票。<br />您的电子票会在' . $settings['process_time'] . '小时内邮寄到您的电子邮箱'
    )) ?></h2>
    <br />
    <p><?php echo i18n(array(
          'en' => 'Please check your junk mail box if not received. <strong>All e-tickets are not refoundable.</strong>',
          'zh' => '如果您没有收到电子票，请查看是否被过滤进垃圾邮件。 <strong>所有的电子票恕不退款</strong>。'
      )) ?>
    </p>
    <p><?php echo i18n(array(
          'en' => 'Please don\'t hesitate to <a href="' . uri('contact') . '"><strong>contact us</strong></a> if you\'ve got any issue.',
          'zh' => '如您有任何疑问，欢迎及时<a href="' . uri('contact') . '"><strong>联系我们</strong></a>'
      )) ?>
    </p>
    <br />
    <h3><?php echo i18n(array(
        'en' => 'Your booking details',
        'zh' => '您的订票详情'
    )) ?></h3>
    <table class="table table-bordered">
       <tbody>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Your State',
               'zh' => '您所在的州'
           )) ?></th>
           <td class="state"><?php echo $order->getState() ?></td>
         </tr>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Cinema',
               'zh' => '电影院'
           )) ?></th>
           <td class="cinema"><?php echo $order->getCinema() ?></td>
         </tr>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Movie',
               'zh' => '电影'
           )) ?></th>
           <td class="movie"><?php echo $order->getMovie() ?></td>
         </tr>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Session',
               'zh' => '场次'
           )) ?></th>
           <td class="session"><?php echo $order->getSession() ?></td>
         </tr>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Number of ticket',
               'zh' => '票数'
           )) ?></th>
           <td class="ticket"><?php echo $order->getNumTicket() ?></td>
         </tr>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Price per ticket',
               'zh' => '单价'
           )) ?></th>
           <td class="price"><?php echo $order->getOurPrice() ?></td>
         </tr>
         <tr>
           <th><?php echo i18n(array(
               'en' => 'Total payment',
               'zh' => '支付总金额'
           )); ?></th>
           <td class="total">$<?php echo $order->getTotal(); ?></td>
         </tr>
       </tbody>
     </table>

  </div>
</section>