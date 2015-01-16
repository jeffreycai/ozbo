<div class="container">
  <div class="row">
    <div class="col-sm-8">
      <?php if (!empty($message)): ?>
        <?php echo $message; ?>
      <?php endif; ?>
      
      <p><?php echo i18n(array(
          'en' => 'Your suggeustion is the motivation for our improvement. Welcome to drop a line here to let us know your thoughs in regards to the service we provide.',
          'zh' => '您的建议是我们前进的动力！欢迎您在此留言告诉我们您的建议和意见，我们会不断改善我们的服务。'
      )) ?></p>
            <form action="" method="POST" role="form" class="form-horizontal" id="contact-form">
              <div class="form-group">
                <label for="name" class="col-sm-3 col-lg-12"><?php echo i18n(array('en' => 'Name', 'zh' => '姓名')) ?> <span>*</span></label>
                <div class="col-sm-9 col-lg-12">
                  <input id="name" name="name" type="text" required="" placeholder="<?php echo i18n(array('en' => 'Your name', 'zh' => '您的姓名')) ?>" class="form-control" <?php if (isset($name) && $name): ?>value="<?php echo $name; ?>"<?php endif; ?> />
                </div>
              </div>
              <div class="form-group">
                <label for="email" class="col-sm-3 col-lg-12 "><?php echo i18n(array('en' => 'Email', 'zh' => '邮箱')) ?> <span>*</span></label>
                <div class="col-sm-9 col-lg-12">
                  <input id="email" name="email" type="email" required="" placeholder="<?php echo i18n(array('en' => 'Your email address', 'zh' => '您的邮箱地址')) ?>" class="form-control" <?php if (isset($email) && $email): ?>value="<?php echo $email; ?>"<?php endif; ?> />
                </div>
              </div>
              <div class="form-group">
                <label for="comment" class="col-sm-3 col-lg-12"><?php echo i18n(array('en' => 'Message', 'zh' => '留言')) ?> <span>*</span></label>
                <div class="col-sm-9 col-lg-12">
                  <textarea class="form-control" id="comment" name="comment" rows="7" required="" placeholder="<?php echo i18n(array('en' => 'What you want to say', 'zh' => '您想对我们说的话')) ?>"><?php if (isset($comment) && $comment): ?><?php echo $comment ?><?php endif; ?></textarea>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3 col-lg-12 col-lg-offset-0" style="text-align: right">
                  <input type="submit" value="<?php echo i18n(array('en' => 'Submit', 'zh' => '提交')) ?>" name="submit" class="btn btn-default" />
                </div>
              </div>
              <?php Form::loadSpamToken('#contact-form', UID_CONTACT_FORM) ?>
            </form>
    </div>
    <div class="col-sm-4 hidden-xs">
      <h4>Email</h4>
      <p>ozboxoffice[at]gmail[dot]com</p>
    </div>
  </div>
  
</div>




