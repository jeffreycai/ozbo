<?php
class HTML {
  static $footer_upper;
  static $footer_lower;
  static $header_upper;
  static $header_lower;
  static $settings_in_js;
  
  public function render($tpl, $param = array(), $cache = false) {
    $settings = Vars::getSettings();
    $user = User::getInstance();
    
    if (!is_array($param)) {
      return;
    }
    
    $tokens = explode('/', $tpl);
    $module = array_shift($tokens);
    $path = implode('/', $tokens);

    // assign template vars
    $data = new PARAM();
    foreach ($param as $key => $val) {
      $$key = $val;
    }
    ob_start();
    include(MODULESROOT . DS . $module . DS . 'templates' . DS . $path . '.tpl.php');
    $content = ob_get_clean();
    return $content;
  }
  
  public function renderOut($tpl, $param = array(), $cache = false) {
    echo $this->render($tpl, $param, $cache);
  }

  public function output($str) {
    echo "\n" . $str;
  }
  
  /**
   * redirect to $_SERVER['HTTP_REFERER']
   * 
   * @param type $no_cache
   */
  static function forwardBackToReferer($no_cache = false) {
    self::forward($_SERVER['HTTP_REFERER']);
    exit;
  }
  
  /**
   * Forward page
   * 
   * @param type $no_cache
   */
  static function forward($destination, $no_cache = false) {
    if ($no_cache) {
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
    }

    if (preg_match('/^http/', $destination)) {
      header('Location: ' . $destination);
    } else {
      header('Location: /' . get_sub_root() . $destination);
    }
    exit;
  }
  
  static function redirectToI18nUrl() {
    $uri = get_request_uri();
    $pos = strpos($uri, "/" . get_sub_root() . get_language());
    if ($pos === false || ($pos !== false && $pos != 0)) {
      $uri = get_request_uri(false);
      $uri = preg_replace('/\/' . str_replace('/', '\/', get_sub_root()) . '/', get_language() . '/', $uri, 1);
      HTML::forward($uri);
    }
  }


  /**
   * send back a json response
   * 
   * @param type $content
   */
  static function sendJSONresponse($content) {
    header('Content-type: application/json');
    echo $content;
    exit;
  }
  
  /**
   * Footer / Header registry
   */
  static function registerFooterUpper($content) {
    self::$footer_upper .= $content;
  }
  static function renderFooterUpperRegistry() {
    return self::$footer_upper;
  }
  static function renderOutFooterUpperRegistry() {
    echo self::renderFooterUpperRegistry();
  }
  
  static function registerFooterLower($content) {
    self::$footer_lower .= $content;
  }
  static function renderFooterLowerRegistry() {
    return self::$footer_lower;
  }
  static function renderOutFooterLowerRegistry() {
    echo self::renderFooterLowerRegistry();
  }
  
  static function registerHeaderUpper($content) {
    self::$header_upper .= $content;
  }
  static function renderHeaderUpperRegistry() {
    return self::$header_upper;
  }
  static function renderOutHeaderUpperRegistry() {
    echo self::renderHeaderUpperRegistry();
  }
  
  static function registerHeaderLower($content) {
    self::$header_lower .= $content;
  }
  static function renderHeaderLowerRegistry() {
    return self::$header_lower;
  }
  static function renderOutHeaderLowerRegistry() {
    echo self::renderHeaderLowerRegistry();
  }
  
  static function registerSettingsInJs(Array $keys) {
    self::$settings_in_js = array_merge($keys, is_array(self::$settings_in_js) ? self::$settings_in_js : array());
  }
  static function renderSettingsInJson() {
    if (!self::$settings_in_js) {
      self::$settings_in_js = array();
    }
    return Vars::renderSettingsInJson(self::$settings_in_js);
  }
  
  /**
   * Escape HTML entities
   * 
   * @param type $content
   */
  static function escape($content) {
    return htmlentities($content, (ENT_COMPAT), 'UTF-8');
  }
}

class PARAM {
  function __get($name) {
    // this is to prevent php notice message
    return isset($this->$name) ? $this->$name : null;
  }
}
