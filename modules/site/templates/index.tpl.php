
<section id="steps1">
  <div class="container">
    
    
    
    <div class="panel panel-default" id="step1">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo i18n(array(
            'en' => 'Step 1: Choose cinema',
            'zh' => '第一步：选择电影院'
        )); ?></h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <select class="form-control" id="state">
            <option selected="selected" value="default"><?php echo i18n(array(
              'en' => 'Which state are you from? ...',
              'zh' => '您在哪个州？...'
          )) ?></option>
            <?php foreach ($states as $key => $value): ?>
              <option value="<?php echo $key ?>"><?php echo $key; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <select class="form-control" id="cinema"  disabled="disabled">
            <option selected="selected" value="default"> </option>
          </select>
          <div class="metainfo">
            <small id="address"></small>
            <small id="loading-cinemas"><img src="<?php echo get_sub_root(); ?>/modules/site/assets/images/ajax-loader.gif" alt="<?php echo i18n(array(
              'en' => 'loading',
              'zh' => '加载中'
            )); ?>" /> <?php echo i18n(array(
                'en' => 'Loading ...',
                'zh' => '加载中 ...'
            )) ?></small>
          </div>
        </div>
      </div>
    </div>
    
    
    
    <div class="panel panel-default" id="step2">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo i18n(array(
            'en' => 'Step 2: Choose a movie',
            'zh' => '第二步：选择电影'
        )); ?></h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <select class="form-control" id="movie" disabled="disabled">
            <option selected="selected" value="default"> </option>
          </select>
        </div>
      </div>
    </div>
    
    
    <div class="panel panel-default" id="step3">
      <div class="panel-heading">
        <h3 class="panel-title"><?php echo i18n(array(
            'en' => 'Step 3: Choose a session',
            'zh' => '第三步：选择场次'
        )); ?></h3>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <select class="form-control" id="session" disabled="disabled">
            <option selected="selected" value="default"> </option>
          </select>
        </div>
        <div class="form-group">
          <label for="ticket"><?php echo i18n(array(
              'en' => 'Number of ticket',
              'zh' => '订购票数'
          )) ?></label>
          <select class="form-control" id="ticket" disabled="disabled">
            <?php for ($i = 1; $i <= 10; $i++): ?>
            <option <?php if ($i == 1): ?>selected="selected" <?php endif; ?>value="1"><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
      </div>
    </div>
    
    <div class="row" style="text-align: center">
      <div class="col-sm-12">
        <button id="check" class="btn btn-lg btn-success" disabled="disabled"><?php echo i18n(array(
            'en' => 'Submit booking',
            'zh' => '提交订单'
        )) ?></button>
      </div>
    </div>

    
  </div>
</section>


<section id="steps2">
  <div class="container">
    
    <div class="row" id="details">
      <div class="col-xs-12">
        <h3><?php echo i18n(array(
            'en' => 'Your booking details',
            'zh' => '您的订单详情'
        )) ?></h3>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Your State',
                  'zh' => '您所在的州'
              )) ?></th>
              <td class="state"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Cinema',
                  'zh' => '电影院'
              )) ?></th>
              <td class="cinema"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Movie',
                  'zh' => '电影'
              )) ?></th>
              <td class="movie"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Session',
                  'zh' => '场次'
              )) ?></th>
              <td class="session"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Number of ticket',
                  'zh' => '票数'
              )) ?></th>
              <td class="ticket"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Price per ticket',
                  'zh' => '单价'
              )) ?></th>
              <td class="price"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Online booking fee',
                  'zh' => '网上订票费用'
              )) ?></th>
              <td class="booking_fee"></td>
            </tr>
            <tr>
              <th><?php echo i18n(array(
                  'en' => 'Total payment',
                  'zh' => '支付总金额'
              )); ?></th>
              <td class="total"></td>
            </tr>
          </tbody>
        </table>
        <p id="modify"><a href="<?php echo uri('') ?>?reload=1"><span class="glyphicon glyphicon-remove"></span> <?php echo i18n(array(
            'en' => 'Not correct. I want to change.',
            'zh' => '不正确，我要更改'
        )) ?></a></p>
      </div>
    </div>
    
    <div id="step4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo i18n(array(
              'en' => 'Step 4: Provide your email to receive e-ticket',
              'zh' => '第四步：填写您的邮箱以接收电子票'
          )); ?></h3>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12">
              <p><?php echo i18n(array(
                  'en' => 'Ticket(s) will be emailed to your mailbox. Print out the e-ticket or show your e-ticket from your phone at the cinema box office.',
                  'zh' => '电影票会发送到您的邮箱内。您可以将电子票打印出来，或者直接在电影院购票处出示手机上的电子票即可。'
              )) ?></p>
              <div class="form-group">
                <label><?php echo i18n(array(
                    'en' => 'Please provide your email address to receive e-ticket',
                    'zh' => '请填写您的邮箱地址以接收电子票'
                )) ?></label>
                <input id="email" type="email" class="form-control" required="required" placeholder="<?php echo i18n(array(
                    'en' => 'Your email',
                    'zh' => '您的邮箱地址'
                )) ?>" />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label><?php echo i18n(array(
                    'en' => 'Please confirm email address',
                    'zh' => '请确认邮箱地址'
                )) ?></label>
                <input id="email_confirm" type="email" required="required" class="form-control" placeholder="<?php echo i18n(array(
                    'en' => 'Confirm email',
                    'zh' => '确认邮箱地址'
                )) ?>" />
              </div>
            </div>
          </div>
          <div class="row" id="confirm">
            <div class="col-xs-12">
              <button type="button" class="btn btn-lg btn-success"><?php echo i18n(array(
                'en' => 'Proceed to payment',
                'zh' => '前往支付页面'
              )) ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div id="step5">
      <div class="panel panel-default">
        <div class="panel-heading" style="position: relative;">
          <h3 class="panel-title"><?php echo i18n(array(
              'en' => 'Step 5: Payment',
              'zh' => '第五步：支付'
          )); ?></h3>
          <img id="stripe-logo" src="<?php echo uri('modules/site/assets/images/stripe-logo.png', false) ?>" alt="<?php i18n(array(
                  'en' => 'Secure payment powered by Stripe',
                  'zh' => 'Stripe安全支付'
              )) ?>" />
        </div>
        <div class="panel-body" id="options">
<!--          <ul class="nav nav-tabs">
            <li class="active" role="presentation"><a class="creditcard" href="#"><?php echo i18n(array(
                'en' => 'Pay by Credit card',
                'zh' => '信用卡支付'
            )) ?></a></li>
            <li role="presentation"><a class="paypal" href="#"><?php echo i18n(array(
                'en' => 'Pay by Paypal',
                'zh' => 'Paypal支付'
            )) ?></a></li>
          </ul>-->
          
          <div class="row" id="powered-by">
            <div class="col-xs-12">
              <img id="cards" alt="<?php echo i18n(array(
                  'en' => 'Accepted cards',
                  'zh' => '接受的信用卡'
              )) ?>" src="<?php echo uri('modules/site/assets/images/cards.gif', false) ?>" width="113" height="23" border="0" />
            </div>
          </div>
            
          <form id="creditcard" method="POST" autocomplete="off" action="<?php echo uri('payment') ?>">
            <div class="row">
              <div class="col-xs-12">
                <div class="alert alert-danger payment-errors" role="alert"></div>
                <div class="form-group">
                  <label><?php echo i18n(array(
                      'en' => 'Card Number',
                      'zh' => '卡号'
                  )) ?></label>
                  <input id="card-number" class="form-control" type="text" size="20" maxlength="20" data-stripe="number" placeholder="<?php echo i18n(array(
                      'en' => 'Your credit card number',
                      'zh' => '您的信用卡卡号'
                  )) ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label>CVC</label>
                  <input id="card-cvd" class="form-control" type="text" size="4" maxlength="4" data-stripe="cvc" placeholder="<?php echo i18n(array(
                      'en' => 'CVC number',
                      'zh' => 'CVC码'
                  )) ?>" autocomplete="off" />
                </div>
                <div class="form-group">
                  <label><?php echo i18n(array(
                      'en' => 'Expiration (MM/YYYY)',
                      'zh' => '信用卡有效日期'
                  )) ?></label>
                  <div class="form-control dummy">
                  <input id="exp-month" type="text" size="2" maxlength="2" data-stripe="exp-month" placeholder="MM" autocomplete="off" /> /
                  <input id="exp-year" type="text" size="4" maxlength="4" data-stripe="exp-year" placeholder="YYYY" autocomplete="off" />
                  </div>
                </div>
                <div class="row" id="pay">
                  <div class="col-xs-12">
                    <button type="submit" class="btn btn-lg btn-primary"><?php echo i18n(array(
                        'en' => 'Pay now',
                        'zh' => '现在支付'
                    )) ?></button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          
          
<!--          <div id="paypal">
            This is paypal
          </div>-->
        </div>
      </div>
    </div>


    
  </div>
</section>





<script type="text/javascript">
  var prices;
  var our_price;
  var total;
  
  $(function(){
    <?php if (isset($_GET['reload'])): ?>
      $('html, body').animate({
          scrollTop: ($("#steps1").offset().top - 50)
      }, 400);
    <?php endif; ?>
  });

 
  // states as json
  var states = <?php echo json_encode($states); ?>;
  
  // step 1 ajax to build cinema options
  $("#state").change(function(){
    var state = $('option:selected', $(this)).val();
    
    $("#address").hide();
    
    // disable other form components
    $("#cinema").html('').attr('disabled', false);
    $("#movie").html('').attr("disabled", true);
    $("#session").html('').attr("disabled", true);
    $("#ticket").attr("disabled", true);
    $("#check").attr("disabled", true);
    
    // delete "default" option
    if (state != 'default') {
      $('option[value=default]', $(this)).remove();
    }
    
    // build cinema options
    var options = "<option value='default'><?php echo i18n(array(
              'en' => 'Which cinema are you going? ...',
              'zh' => '您去哪个电影院？...'
            )) ?></option>";
    for (idx in states[state].result) {
      var cinema = states[state].result[idx];
      options += "<option value='" + idx + "'" + ">" + cinema.name + "</option>";
    }

    $("#cinema").html(options).attr('disabled', false);
    $("#address").hide();
  });
  
  // when cinema is selected, ajax to get movie, update movie options
  $("#cinema").change(function(){
    var state = $('option:selected', $("#state")).val();
    var idx = $('option:selected', $(this)).val();
    
    // disable myself
    $(this).attr("disabled", true);
    
    // hide #address
    $("#address").hide();
    
    // disable other form components
    $("#movie").html('').attr("disabled", true);
    $("#session").html('').attr("disabled", true);
    $("#ticket").attr("disabled", true);
    $("#check").attr("disabled", true);
    

    // remove "default" option
    if (idx != "default") {
      $('option[value=default]', $(this)).remove();
    }
    
    var cinema = states[state].result[idx];

    // ajax call to get movie
    var movies;
    $('#loading-cinemas').show();
    $.ajax({
      url: '<?php echo uri("movie-sessions", false); ?>',
      type: "GET",
      data: 'cinemaId=' + cinema.cinemaId.value + '%2C' + cinema.cinemaId.cinemaGroup + '%2C' + (cinema.brand ? cinema.brand : 'null') +'%2C' + idx,
      dataType: 'json',
      success: function(data){
        $('#loading-cinemas').hide();
        $("#address").html('').show();
        $("#cinema").attr("disabled", false);
        
        // update address
        var address = "<?php echo i18n(array(
            'en' => '<strong>Address:</strong> ',
            'zh' => '<strong>地址: </strong>'
        )); ?>";
        var address = address + (cinema.address.addressLine1 ? cinema.address.addressLine1: '') + (cinema.address.addressLine2 ? ', ' + cinema.address.addressLine2 : '') + (cinema.address.addressLine3 ? ', ' + cinema.address.addressLine3 : '') + (cinema.address.suburb ? ', ' + cinema.address.suburb : '') + (cinema.address.state ? ' ' + cinema.address.state : '') + (cinema.address.postcode ? ', ' + cinema.address.postcode : '');
        $("#address").show().html(address);

        // error handling
        if (typeof data.status == 'undefined' || data.status != 'SUCCESS') {
          alert("<?php echo i18n(array(
              'en' => 'Our ticket booking system is too busy at the moment, please try again later. Thank you for your patience',
              'zh' => '我们的订票系统现在正忙，请稍后再试'
          )) ?>");
        } else {
          movies = data.result;
          
          // build movie options
          var options = "<option value='default'><?php echo i18n(array(
                    'en' => 'Which movie do you want to watch? ...',
                    'zh' => '您想去看哪部电影？...'
                  )) ?></option>";
          for (idx in movies) {
            var movie = movies[idx].movie;
            options += "<option value='" + idx + "'" + ">" + movie.name + "</option>";
          }
 
          $("#movie").html(options).attr('disabled', false);
          $('html, body').animate({
              scrollTop: ($("#step2").offset().top - 50)
          }, 400);
        }
      },
      error: function(){
        $('#loading-cinemas').hide();
        $("#address").hide();
        $("#cinema").attr("disabled", false);
        
        alert("<?php echo i18n(array(
            'en' => 'Our ticket booking system is too busy at the moment, please try again later. Thank you for your patience',
            'zh' => '我们的订票系统现在正忙，请稍后再试'
        )) ?>");
      }
    });
    
    // when movie is selected, build session options
    $("#movie").change(function(){
      
      var movie_idx = $('option:selected', $(this)).val();
      var sessions = movies[movie_idx].sessions;
      
      $("#check").attr("disabled", true);
      
      // delete "default" option
      if (movie_idx != 'default') {
        $('option[value=default]', $(this)).remove();
      }
      
      var options = "<option value='default'><?php echo i18n(array(
                'en' => 'Which session do you want to go? ...',
                'zh' => '您想去看哪一场？...'
              )) ?></option>";
      for (idx in sessions) {
        var session = sessions[idx];
        
        options += "<option value='" + idx + "'" + ">" + session.startTime + "</option>";
      }

      $("#session").html(options).attr('disabled', false);
      $("#ticket").attr('disabled', true);
          $('html, body').animate({
              scrollTop: ($("#step3").offset().top - 50)
          }, 400);
    });
    
    // when a session is selected
    $("#session").change(function(){
      
      $("#check").attr("disabled", false);
      
      // delete "default" option
      if ($("option:selected", $(this)).val() != 'default') {
        $('option[value=default]', $(this)).remove();
      }
      
      $("#ticket").attr('disabled', false);
    });
    
    // check button action
    $("#check").click(function(event){
      event.preventDefault();
      // validation
      var state = $('#state option:selected').val();
      var cinema = $('#cinema option:selected').val();
      var movie = $('#movie option:selected').val();
      var session = $('#session option:selected').val();
      var ticket = $('#ticket option:selected').val();
      
      if (state == 'default' || typeof state == 'undefined') {
        alert('<?php echo i18n(array(
            'en' => 'Please select a state',
            'zh' => '请选择您所在的州'
        )) ?>');
      } else if (cinema == 'default' || typeof cinema == 'undefined') {
        alert('<?php echo i18n(array(
            'en' => 'Please select a cinema',
            'zh' => '请选择电影院'
        )) ?>');
      } else if (movie == 'default' || typeof movie == 'undefined') {
        alert('<?php echo i18n(array(
            'en' => 'Please select a movie',
            'zh' => '请选择电影'
        )) ?>');
      } else if (session == 'default' || typeof session == 'undefined') {
        alert('<?php echo i18n(array(
            'en' => 'Please select a session',
            'zh' => '请选择要看的场次'
        )) ?>');
      } else if (!ticket.match(/^\d+$/)) {
        alert('<?php echo i18n(array(
            'en' => 'Please select number of tickets',
            'zh' => '请选择订票数'
        )) ?>');
      }
      
      else {
        // ajax to get movie details
        $("#steps1 select").attr("disabled", true);
        
        var original_text = $("#check").html();
        $("#check").attr("disabled", true).html("<?php echo i18n(array(
            'en' => 'Submitting ...',
            'zh' => '提交中 ...'
        )) ?> <img src='<?php echo get_sub_root(); ?>/modules/site/assets/images/ajax-loader.gif' alt='<?php echo i18n(array(
              'en' => 'loading',
              'zh' => '加载中'
            )); ?>' />");

        // https://www.my.telstra.com.au/myaccount/loyalty-offers-consumer/buyTicket?cinema=68%2CAHL%2Cnull%2C0&movie=1668&session=5185877&_=1420687772516
        var cinema_idx = cinema;
        var cinema = states[state].result[cinema_idx];
        var cinema = cinema.cinemaId.value + '%2C' + cinema.cinemaId.cinemaGroup + '%2C' + (cinema.brand ? cinema.brand : 'null') +'%2C' + cinema_idx;

        var movie_idx = movie;
        var movie = movies[movie_idx].movie.movieId.value;

        var session_idx = session;
        var session = movies[movie_idx].sessions[session_idx].sessionId.value;

  //      console.log(cinema);
  //      console.log(movie);
  //      console.log(session);


        $.ajax({
          url: '<?php echo uri("booking-url", false); ?>',
          type: "GET",
          data: 'cinema=' + cinema + '&movie=' + movie + '&session=' + session,
          success: function(data){
            if (typeof data != 'object') {
              alert("<?php echo i18n(array(
                      'en' => 'Sorry, the session you selected doesn\'t have any stock',
                      'zh' => '抱歉，您所选的场次没有票了'
              )); ?>");
              $("#check").attr("disabled", false).html(original_text);
              $("#steps1 select").attr("disabled", false);
            } else {
              $('.state').html($("#state option:selected").html());
              $('.cinema').html($("#cinema option:selected").html());
              $('.movie').html($("#movie option:selected").html());
              $('.session').html($("#session option:selected").html());
              $('.ticket').html($("#ticket option:selected").html());
              
              prices = data;
              
//              if (typeof console == 'object') {
//                console.log(data);
//              }

              var adult_price = typeof data.adult == 'undefined' || !data.adult.match(/\d+(\.\d+)/) ? null : parseFloat(data.adult);
              if (adult_price == null) {
                adult_price = typeof data.tff_adult == 'undefined' || !data.tff_adult.match(/\d+(\.\d+)/) ? null : parseFloat(data.tff_adult);
              }
              var child_price = typeof data.child == 'undefined' || !data.child.match(/\d+(\.\d+)/) ? null : parseFloat(data.child);
              var student_price = typeof data.student == 'undefined' || !data.student.match(/\d+(\.\d+)/) ? null : parseFloat(data.student);
              var telstra_price = typeof data.telstra_tickets == 'undefined' || !data.telstra_tickets.match(/\d+(\.\d+)/) ? null : parseFloat(data.telstra_tickets);
              our_price;
              var cheaper = true;
              var ticket_num = parseInt($("#ticket option:selected").html());
              var booking_fee = 1.10;
              
              if (telstra_price == null) {
                our_price = adult_price;
                cheaper = true;
              } else if ((telstra_price + 1) < (adult_price + booking_fee)) {
                our_price = telstra_price + 1;
                cheaper = true;
              } else {
                our_price = adult_price;
                cheaper = true;
              }
              
              if (our_price == null) {
                alert("<?php echo i18n(array(
                        'en' => 'Sorry, the session you selected doesn\'t have any stock',
                        'zh' => '抱歉，您所选的场次没有票了'
                )); ?>");
                $("#check").attr("disabled", false).html(original_text);;
                $("#steps1 select").attr("disabled", false);
              }
              
              total = our_price * ticket_num;
              var total_original = cheaper ? (adult_price + booking_fee) * ticket_num : 0;
              
              var price = cheaper ? our_price : adult_price;
              var price_string = our_price != adult_price ? "<strike>$" + adult_price.toFixed(2).toString() + "</strike>&nbsp;&nbsp;&nbsp;$" + our_price.toFixed(2).toString() : "$" + our_price.toFixed(2).toString();
              total = our_price * ticket_num;
              var total_string = cheaper ? "<strike><strong>$" + ((adult_price+booking_fee) * ticket_num).toFixed(2).toString() + "</strong></strike>&nbsp;&nbsp;&nbsp;<strong style='color:#31708F;'>$" + (our_price * ticket_num).toFixed(2).toString() + "</strong>" : "<strong style='color:#31708F;'>$" + (our_price * ticket_num).toFixed(2).toString() + "</strong>";

              $(".price").html(price_string);
              $(".total").html(total_string);
              $(".booking_fee").html("<strike>" + ticket_num.toString() + ' X $' + booking_fee.toString() + "</strike>");
              if (cheaper) {
                var difference = adult_price + booking_fee - our_price;
                $("#details table").before("<div class='alert alert-info' role='alert'><span class='glyphicon glyphicon-info-sign'></span> <?php echo i18n(array(
                    'en' => 'We have helped you save ',
                    'zh' => '本次订票我们一共帮您节省了 '
                )) ?><span style='font-weight:strong; color: #D9534F;'>$" + (difference * ticket_num).toFixed(2).toString() + "</span><?php echo i18n(array(
                    'en' => ' in this booking!',
                    'zh' => ' 元！'
                )) ?></div>");
              }

              $("#steps1").hide();
              $("#step1, #step2, #step3, #check").hide(); // this is extra for IE8
              $("#steps2").fadeIn(400, function(){
                $("#step4").show();
                $("#details").show();
                $('html, body').animate({
                    scrollTop: ($("#steps2").offset().top - 50)
                }, 400);
              });
            }
          },
          error: function() {
            alert("<?php echo i18n(array(
                    'en' => 'Sorry, the session you selected doesn\'t have any stock',
                    'zh' => '抱歉，您所选的场次没有票了'
            )); ?>");
            $("#check").attr("disabled", false).html(original_text);;
            $("#steps1 select").attr("disabled", false);
          }
        });
      }
    });
    
    // confirm, proceed to payment
    $("#email, #email_confirm").focus(function(){
      $(this).removeClass('has-error');
    });
    $("#confirm button").click(function(){
      var email = $("#email").val();
      var email_confirm = $("#email_confirm").val();
      // validation
      if (!isEmail(email)) {
        alert('<?php echo i18n(array(
            'en' => 'Please provide a valid email address',
            'zh' => '请填写合法的邮件地址'
        )) ?>');
        $("#email").addClass('has-error');
      } else if (!isEmail(email_confirm)) {
        alert('<?php echo i18n(array(
            'en' => 'Please provide a valid email address',
            'zh' => '请填写合法的邮件地址'
        )) ?>');
        $("#email_confirm").addClass('has-error');
      } else if (email != email_confirm) {
        alert('<?php echo i18n(array(
            'en' => 'Confirm email is different from email. Please make sure they are the same.',
            'zh' => '确认邮件地址和邮件地址不一致，请确保两个邮件地址相同。'
        )) ?>');
        $("#email_confirm").addClass('has-error');
        $("#email").addClass('has-error');
      } else {
        // step 5 animation
        $("#step4").hide();
        $("#step5").fadeIn(function(){
          $('html, body').animate({
              scrollTop: ($("#step5").offset().top - 50)
          }, 400);
        });
        
      }
    });
    
    
    // payment options tab action
    $("#options .nav li a").click(function(event){
      event.preventDefault();
      
      var a = $(this);
      var li = a.parent();
      var body = $("#" + a.attr('class'));
      
      $("#options .nav li").removeClass('active');
      $("#creditcard, #paypal").hide(function(){
        body.fadeIn(function(){
          $('html, body').animate({
              scrollTop: ($("#step5").offset().top - 50)
          }, 400);
        }); 
      });
      li.addClass('active');
    });

  });
</script>