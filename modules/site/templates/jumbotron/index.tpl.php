
  <div class="jumbotron">
    <div class="container">
      <h1><span class=" glyphicon glyphicon-film"></span><br /><?php echo $settings['sitename']['plain'][get_language()] ?></h1>
      <p><?php echo $settings['sitename']['slogon'][get_language()] ?></p>
      
      <?php if (!is_maintenance()): ?>
      <p><a class="btn btn-primary btn-lg" href="#" role="button"><?php echo i18n(array(
          'en' => 'I want it!',
          'zh' => '我要我要!'
      )); ?></a></p>
      <?php endif; ?>
      
    </div>
  </div>