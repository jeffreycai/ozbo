<?php
/**
 * Auto-load register
 * 
 * @param type $class
 */
function custom_loader($class) {
  global $enabled_modules;
  
  foreach ($enabled_modules as $module) {
    // loop over the module folder
    $module_dir = MODULESROOT . DS . $module;
    if (is_dir($module_dir)) {
      $class_dir = $module_dir . DS . 'includes' . DS . 'classes';
      include_class_file($class_dir, $class);
    }
  }
}
function include_class_file($dir, $class) {
  if (is_dir($dir) && $handle = opendir($dir)) {
    while (false !== ($entry = readdir($handle))) {
      // skip any file starting with "."
      if (preg_match('/^\./', $entry)) {
        continue;
      }
      // loop over
      $target = $dir . DS . $entry;
      if (is_file($target) && $entry == $class . '.class.php') {
        include_once($target);
      } else if (is_dir($target)) {
        include_class_file($target, $class);
      }
    }
  }
}

/**
 * Dispatch to a controller
 * 
 * @param type $controller
 */
function dispatch($controller, $vars = array()) {
  $tokens = explode('/', $controller);
  $module = array_shift($tokens);
  $path = implode('/', $tokens);
  
  $controller_file = MODULESROOT . DS . $module . DS . 'controllers' . DS . $path . ".php";
  if (is_file($controller_file)) {
    foreach ($vars as $key => $val) {
      $$key = $val;
    }
    $settings = Vars::getSettings();
    require_once $controller_file;
  } else {
    die("Controller '$controller' does not exist.");
  }
}


/**
 * Print out a var
 * 
 * @param type $var
 * @param type $html
 */
function _debug($var, $html = true) {
  if ($html) {
    echo "<pre>";
  }
  var_dump($var);
  if ($html) {
    echo "</pre>";
  }
  die();
}

/**
* Build GET query string 
*/
function build_query_string($params) {
  $rtn = array();
  foreach ($params as $key => $val) {
    if (empty($val)) {
      continue;
    }
    
    $key = urlencode(strip_tags($key));
    $val = urlencode(strip_tags($val));
    $rtn[] = $key.'='.$val;
  }
  return '?'.implode('&', $rtn);
}

/**
* Update a $_REQUEST parameter value and output the query string
*/
function update_query_string($input) {
  $url = explode('?', get_cur_page_url()); 
  $url = $url[0];
  $params = $_GET;
  foreach ($input as $key => $val) {
    $params[$key] = $val;
  }
  return $url . build_query_string($params);
}

/**
* Get current page url
*/
function get_cur_page_url($with_domain = false) {
  global $cur_page_url;
  if (isset($cur_page_url)) {
    return $cur_page_url;
  }
  
 $pageURL = 'http';
 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 if (!$with_domain) {
   return preg_replace('/^https?:\/\/[^\/]+/', '', $pageURL);
 }
 $cur_page_url = $pageURL;
 return $cur_page_url;
}

/**
 * echo "active" class for a link according to the current page url
 * 
 * @param type $active_url
 * @param type $current_url
 * @param type $class
 */
function echo_link_active_class($active_url, $current_url, $class='active') {
  global $conf;

  if ("$active_url" == $current_url) {
    echo " class='$class' ";
  }
}

/**
 * convert a time stamp to time ago
 * @return string
 */
function time_ago($start_point, $end_point = null) {
  if ($end_point == null) {
    $end_point = time();
  }
  
  $etime = $end_point - $start_point;
  if ($etime < 1) {
    return '0 seconds';
  }
  $a = array( 12 * 30 * 24 * 60 * 60  =>  '年',
              30 * 24 * 60 * 60       =>  '月',
              24 * 60 * 60            =>  '日',
              60 * 60                 =>  '小时',
              60                      =>  '分钟',
              1                       =>  '秒'
  );

  foreach ($a as $secs => $str) {
    $d = $etime / $secs;
    if ($d >= 1)
    {
      $r = round($d);
//      return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
      return $r . ' ' . $str . '之前';
    }
  }
}

function load_library_wide_image() {
  require_once  WEBROOT . DS . 'modules' . DS . 'core' . DS . 'includes' . DS . 'libraries' . DS . 'wideimage' . DS . 'lib' . DS . 'WideImage.php';
}

function resetSpamTokens() {
  $_SESSION['spam_key'] = generateRandomChars();
  $_SESSION['spam_val'] = generateRandomChars();
}
function getSpamKey() {
  return $_SESSION['spam_key'];
}
function getSpamVal() {
  return $_SESSION['spam_val'];
}

function html_to_text($html) {
  $rtn = preg_replace('/<\/?p([^>]+)?>/', '', $html);
  $rtn = preg_replace('/<\/?a([^>]+)?>/', '', $rtn);
  $rtn = preg_replace('/<img[^>]+\/?>/', '', $rtn);
  $rtn = preg_replace('/<br ?\/?>/', "\n", $rtn);
  $rtn = preg_replace('/<\/?strong>/', '', $rtn);
  $rtn = preg_replace('/<\/?blockquote>/', '', $rtn);

  
  $rtn = preg_replace('/<\/?[u|o]l>/', '', $rtn);
  $rtn = preg_replace('/<li>/', '- ', $rtn);
  $rtn = preg_replace('/<\/li>/', '', $rtn);
  return $rtn;
}

/**
 * return subroot
 * 
 * @global type $sub_root
 * @return string
 */
function get_sub_root() {
  // don't calculate if already done
  if (isset($_SESSION['sub_root'])) {
    return $_SESSION['sub_root'];
  }
  
  $uri = get_request_uri();
  
  $uri_tokens = explode('/', trim($uri, '/'));
  $path_tokens = explode(DS, trim(WEBROOT, DS));

  $sub_root = "";
  $pointer = null;
  while ($token = array_shift($uri_tokens)) {
    for ($i = 0; $i < sizeof($path_tokens); $i++) {
      $p_token = $path_tokens[$i];
      // when it hits the first occurance
      if (is_null($pointer) && $p_token == $token) {
        $pointer = $i;
        $sub_root = $p_token;
      } else if (!is_null($pointer) && $i > 0 && $token == $path_tokens[$i - 1]) {
        $pointer = $i - 1;
        $sub_root = $path_tokens[$pointer] . '/' . $sub_root;
      }
    }
  }
  if ($sub_root != '') {
    $sub_root .= '/';
  }
  $_SESSION['sub_root'] = $sub_root;
  return $sub_root;
}

/**
 * Get query string
 * 
 * @return type
 */
function get_query_string() {
  return isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;
}

/**
 * Get Request uri
 * 
 * @param type $no_query_string
 * @return type
 */
function get_request_uri($no_query_string = true) {
  $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
  if ($no_query_string) {
    $request_uri = str_replace('?' . get_query_string(), '', $request_uri);
  }
  return $request_uri;
}

/**
 * Get Request uri without subroot and lang code
 * 
 * @return type
 */
function get_request_uri_relative($no_query_string = true) {
  $request_uri = get_request_uri($no_query_string);
  return preg_replace('/^\/' . str_replace('/', '\/', get_sub_root()) . '(' . get_language() . '(\/|$))?/', '/', $request_uri);
}

/**
 * Return the user preferred language
 */
function get_language() {
  $settings = Vars::getSettings();
  
  // when i18n is off, we take the default language
  if (isset($settings['i18n_lang_default'])) {
    $_SESSION['lang'] = $settings['i18n_lang_default'];
    return $_SESSION['lang'];
  }
  
  // first we check if the lang is in url
  $request_uri = get_request_uri();
  $uri_without_subroot = str_replace(get_sub_root(), '', $request_uri);
  $tokens = explode('/', trim($uri_without_subroot, '/'));
  $lang = array_shift($tokens);
  if (isset($settings['i18n_lang']) && in_array($lang, array_keys($settings['i18n_lang']))) {
    $_SESSION['lang'] = $lang;
    return $lang;
  }
  // if not, we check if it is in session
  if (isset($_SESSION['lang'])) {
    $lang = $_SESSION['lang'];
    return $_SESSION['lang'];
  }
  // if not either, we get it from $_SERVER['HTTP_ACCEPT_LANGUAGE']
  $lang = substr(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '', 0, 2);
  if (isset($settings['i18n_lang']) && in_array($lang, array_keys($settings['i18n_lang']))) {
    $_SESSION['lang'] = $lang;
    return $lang;
  }
  // finaly, just return 'en'
  $_SESSION['lang'] = 'en';
  $lang = 'en';
  return $lang;
}

/**
 * return the lang code from url, if none exist, return false
 */
function get_language_from_url() {
  $request_uri = get_request_uri();
  $string = str_replace(get_sub_root(), '', $request_uri);
}

function i18n(Array $lang) {
  return $lang[get_language()];
}

function i18n_echo(Array $lang) {
  echo i18n($lang);
}

/**
 * print out an uri
 */
function uri($uri, $i18n = true) {
  $settings = Vars::getSettings();
  $rtn = "/" . get_sub_root();
  if (isset($settings['i18n']) && $settings['i18n'] && $i18n) {
    $rtn .= get_language() . '/';
  }
  $rtn .= $uri;
  
  return $rtn;
}

function print_uri($uri, $i18n = true) {
  echo uri($uri, $i18n);
}

/**
 * get a random string
 * 
 * @param type $length
 * @return type
 */
function get_random_string($length) {
  return substr(md5(rand(99, 9999)), 0, $length);
}

/**
 * custom sort function for "usort()"
 * 
 * @param type $key, the sort key
 * @return type
 */
function build_int_sorter($key) {
  return function ($a, $b) use ($key) {
    if (is_array($a) && is_array($b)) {
      // if key is not defined, we just return 999999
      if (!isset($a[$key]) || !isset($b[$key])) {
        return 0;
      }
      return $a[$key] - $b[$key];
    } else if (is_object($a) && is_object($b)) {
      // if key is not defined, we just return 0
      if (!isset($a->$key) || !isset($b->$key)) {
        return 0;
      }
      return $a->$key - $b->$key;
    }
  };
}

/**
 * Check if a controller exists or not
 * 
 * @param type $controller
 * @return type
 */
function controllerExists($controller) {
  $tokens = explode('/', $controller);
  $module = array_shift($tokens);
  $controller = implode('/', $tokens);
  return is_file(MODULESROOT . DS . $module . DS . 'controllers' . DS . $controller . '.php');
}

/**
 * Load a module .yml fixture file
 * 
 * @param type $module
 * @param type $fixture_file
 * @return type
 */
function load_fixture($module, $fixture_file = 'fixture.yml') {
  require_once(MODULESROOT . DS . 'core' . DS . 'includes' . DS . 'libraries' . DS . 'spyc' . DS . 'spyc.php');
  
  $file = MODULESROOT . DS . $module . DS . $fixture_file;
  if (is_file($file)) {
    return Spyc::YAMLLoad($file);
  }
}

/**
 * Import a fixture array into database
 * 
 * @global type $mysqli
 * @param type $fixtures
 */
function import_fixture($fixtures) {
  global $mysqli;
  
  foreach ($fixtures as $table => $records) {
    foreach ($records as $record) {
      $columns = array();
      $vars = array();
      foreach ($record as $col => $val) {
        $columns[] = "`$col`";
        if (is_array($val)) {
          $val = serialize($val);
        }
        $vars[] = DBObject::prepare_val_for_sql($val);
      }
      $query = "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $vars) . ");";
//_debug($query);
      if ($mysqli->query($query)) {
        echo " -- Insert record for table $table success! \n";
      } else {
        echo " -- Insert record for table $table failed! \n";
      }
    }
  }
}

/**
 * check if a module is enabled
 * 
 * @param type $module
 */
function module_enabled($module) {
  global $enabled_modules;
  return in_array($module, $enabled_modules);
}

/**
 * check if a module exist or not
 * 
 * @param type $module
 * @return type
 */
function module_exists($module) {
  return is_dir(WEBROOT . DS . 'modules' . DS . $module);
}


function js_library_exist($name) {
  $result = shell_exec('find ' . WEBROOT . DS . 'libraries' . DS . $name . '*');
  return !is_null($result);
}

/**
 * If we are in command line or not
 */
function is_cli() {
  return PHP_SAPI == 'cli';
}

/**
 * If we are not at backend of not
 * 
 * @return type
 */
function is_backend() {
  return (preg_match('/^\/admin/', get_request_uri_relative()) && !is_cli());
}

/**
 * check if maintenance mode is on
 */
function is_maintenance() {
  $var = Vars::findByName('maintenance');
  if ($var && $var->getValue() == 1) {
    return true;
  }
  return false;
}