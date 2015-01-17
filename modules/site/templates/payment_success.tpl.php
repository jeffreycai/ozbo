<section>
  <div class="container">
    <h2><?php echo i18n(array(
        'en' => 'Thanks you for buying tickets from us',
        'zh' => '感谢您购买我们的电影票'
    )) ?></h2>
    <br />
    <p><?php echo i18n(array(
          'en' => 'We are processing your booking right now. You\'ll receive your ticket in your mailbox: ' . $order->getEmail() . ' soon.',
          'zh' => '我们正在处理您的订票业务，电影票会在处理完毕后发送到您的邮箱：' . $order->getEmail()
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