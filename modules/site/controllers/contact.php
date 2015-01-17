<?php
// handle submission
// handle form submission
if (isset($_POST['submit'])) {
  // check spam
  if (!Form::checkSpamToken(UID_CONTACT_FORM)) {
    $message = new Message(Message::DANGER, i18n(array('en' => 'Form submission error.', 'zh' => '表单提交错误')));
    Message::register($message);
    HTML::forwardBackToReferer();
  }
  $name = trim(strip_tags($_POST['name']));
  $email = trim(strip_tags($_POST['email']));
  $comment = trim(strip_tags($_POST['comment']));
  // form validation
  if (empty($name)) {
    $message = new Message(Message::DANGER, i18n(array('en' => 'Please enter your name', 'zh' => '请填写您的姓名')));
    Message::register($message);
  } else if (!isset($email) || !preg_match('/^[^@]+@[^@]+$/', $email)) {
    $message = new Message(Message::DANGER, i18n(array('en' => 'Please enter a valid email address.', 'zh' => '请填写正确的电子邮箱地址')));
    Message::register($message);
  } else if (empty($comment)) {
    $message = new Message(Message::DANGER, i18n(array('en' => 'Please enter your comment.', 'zh' => '请填写留言')));
    Message::register($message);
  // validation passed, send email
  } else {
    $comment = "<p>Name: <br />$name<br /><br />" . "Email: <br />$email<br /><br />" . "Comment: <br />" . str_replace("\n", "<br />", $comment) . "</p>";

    sendemailAdmin( (ENV == 'prod' ? '' : 'Dev: ') . 'New message from ' . $settings['sitename']['plain'][get_language()], $comment);

    $message = new Message(Message::SUCCESS, i18n(array('en' => 'Thanks for your contact :) We\'ll keep in touch', 'zh' => '谢谢您的留言，我们会及时和您联系的')));
    Message::register($message);
  }
  HTML::forwardBackToReferer();
}


$message = Message::renderMessages();


$html = new HTML();

$html->renderOut('site/html_header', array(
    'body_class' => 'contact',
    'title' => i18n(array(
        'en' => 'Contact :: ',
        'zh' => '联系 :: '
    )) . $settings['sitename']['plain'][get_language()]
));
$html->renderOut('site/header', array('active_url' => array('/contact')));
$html->renderOut('site/jumbotron/general', array('title' => i18n(array(
    'en' => 'Contact',
    'zh' => '联系'
))));
$html->renderOut('site/contact', array('message' => $message));
$html->renderOut('site/footer');
$html->renderOut('site/html_footer');