<nav role="navigation" class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
        <span class="sr-only"><?php echo i18n(array(
                'en' => 'Toggle navbar',
                'zh' => '折叠导航栏'
        )); ?></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="/" class="navbar-brand blue"><span class=" glyphicon glyphicon-film"></span> <?php echo $settings['sitename']['plain'][get_language()] ?></a>
    </div>
    <nav id="navbar" class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
      <ul class="nav navbar-nav">
        <li <?php if (isset($active_url) && in_array('/', $active_url)): ?>class="active"<?php endif; ?>><a href="/"><?php echo i18n(array(
            'en' => 'Home',
            'zh' => '首页'
        )) ?></a></li>
        <li <?php if (isset($active_url) && in_array('/contact', $active_url)): ?>class="active"<?php endif; ?>><a href="/contact"><?php echo i18n(array(
            'en' => 'Contact',
            'zh' => '联系'
        )) ?></a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <?php $current_lang; $others = array(); ?>
          <?php foreach ($settings['i18n_lang'] as $code => $lang) {
            if ($code == get_language()) {
              $current_lang = $code;
            } else {
              $others[$code] = $lang;
            }
          }
          ?>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $settings['i18n_lang'][$current_lang] ?> <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <?php foreach ($others as $code => $lang): ?>
            <li><a href="/<?php echo get_sub_root(); echo get_language(); ?>/switch/<?php echo $code ?>"><?php echo $lang; ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</nav>