

<?php HTML::renderOutFooterUpperRegistry(); ?>
<?php Asset::printBottomAssets('frontend'); ?>
<?php HTML::renderOutFooterLowerRegistry(); ?>



<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
// This identifies your website in the createToken call below
Stripe.setPublishableKey('<?php echo ENV == 'prod' ? $settings['stripe']['live_publishable_key'] : $settings['stripe']['test_publishable_key'] ?>');
var payment_btn_text;
jQuery(function($){
  $('#creditcard').submit(function(event) {
    event.preventDefault();
    
    var $form = $(this);
    payment_btn_text = $form.find('button').html();

    // Disable the submit button to prevent repeated clicks
    $form.find('button').prop('disabled', true).html("<?php echo i18n(array(
        'en' => 'Processing ...',
        'zh' => '处理中 ...'
    )) ?>  <img src='<?php echo get_sub_root(); ?>/modules/site/assets/images/ajax-loader.gif' alt='<?php echo i18n(array(
              'en' => 'loading',
              'zh' => '加载中'
            )); ?>' />");

    Stripe.card.createToken($form, stripeResponseHandler);

    // Prevent the form from submitting with the default action
    return false;
  });
});

function stripeResponseHandler(status, response) {
  var $form = $('#creditcard');

  if (response.error) {
    // Show the errors on the form
    var message = '';
    switch (response.error.code) {
      case 'incorrect_number':
        message = '<?php echo i18n(array(
            'en' => 'Your card number is incorrect.',
            'zh' => '您的卡号不正确'
        )) ?>'; break;
      case 'invalid_number':
        message = '<?php echo i18n(array(
            'en' => 'The card number is not a valid credit card number.',
            'zh' => '您填写的卡号不是一张有效的信用卡卡号'
        )) ?>'; break;
      case 'invalid_expiry_month':
        message = '<?php echo i18n(array(
            'en' => "The card\'s expiration month is invalid.",
            'zh' => '您填写的有效期月份不合法'
        )) ?>'; break;
      case 'invalid_expiry_year':
        message = '<?php echo i18n(array(
            'en' => "The card\'s expiration year is invalid.",
            'zh' => '您填写的有效期年份不合法'
        )) ?>'; break;
      case 'invalid_cvc':
        message = '<?php echo i18n(array(
            'en' => "Your card\'s security code (cvc) is invalid",
            'zh' => '您的CVC安全码无效'
        )) ?>'; break;
      case 'expired_card':
        message = '<?php echo i18n(array(
            'en' => 'The card has expired.',
            'zh' => '您的信用卡已过期'
        )) ?>'; break;
      case 'incorrect_cvc':
        message = '<?php echo i18n(array(
            'en' => "The card\'s security code (cvc) is incorrect.",
            'zh' => '您的CVC安全码不正确'
        )) ?>'; break;
      case 'incorrect_zip':
        message = '<?php echo i18n(array(
            'en' => "The card\'s zip code failed validation.",
            'zh' => '信用卡的zip码验证失败'
        )) ?>'; break;
      case 'card_declined':
        message = '<?php echo i18n(array(
            'en' => 'The card was declined.',
            'zh' => '信用卡支付请求被拒绝了'
        )) ?>'; break;
      case 'missing':
        message = '<?php echo i18n(array(
            'en' => 'There is no card on a customer that is being charged.',
            'zh' => '支付客户无信用卡'
        )) ?>'; break;
      case 'processing_error':
        message = '<?php echo i18n(array(
            'en' => 'An error occurred while processing the card.',
            'zh' => '信用卡支付处理出错'
        )) ?>'; break;
      case 'rate_limit':
        message = '<?php echo i18n(array(
            'en' => 'An error occurred due to requests too frequent.',
            'zh' => '支付请求过频'
        )) ?>'; break;
      default:
        message = '<?php echo i18n(array(
            'en' => 'An error has occured when processing your request',
            'zh' => '处理支付请求时出现错误'
        )) ?>';
    }
    
    $form.find('.payment-errors').show().html('<span class="glyphicon glyphicon-warning-sign"></span> ' + message);
    $form.find('button').prop('disabled', false).html(payment_btn_text);
  } else {
    // response contains id and card, which contains additional card details
    var stripeToken = response.id;
    // ajax call to server end for payment
    $.ajax({
      url: '<?php echo uri("payment"); ?>',
      type: "POST",
      data: 'stripeToken=' + encodeURIComponent(stripeToken) + '&state=' + $("#state option:selected").val() + "&cinema=" + $("#cinema option:selected").html() + "&movie=" + encodeURIComponent($("#movie option:selected").html()) + "&session=" + encodeURIComponent($("#session option:selected").html()) + "&num_ticket=" + $("#ticket option:selected").html() + "&prices=" + encodeURIComponent(JSON.stringify(prices)) + "&our_price=" + encodeURIComponent(our_price) + "&total=" + total.toString() + "&email=" + encodeURIComponent($("#email").val()) + "&lang=" + "<?php echo get_language() ?>",
      success: function(data){
        if (data == 'success') {
          window.location = '<?php echo uri('payment/success') ?>';
        } else {
          window.location = '<?php echo uri('payment/failed') ?>';
        }
      },
      error: function(){
        window.location = '<?php echo uri('payment/failed') ?>';
      }
    });
  }
};
</script>


</body>

</html>
