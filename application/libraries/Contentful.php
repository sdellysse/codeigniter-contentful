<?php defined('BASEPATH') or exit('No direct script access allowed');

class Contentful {
  function __construct($config = array()) {
    $this->CI =& get_instance();
    $this->set_config('controller_name', $this->CI->router->fetch_class());
    $this->set_config('method_name', $this->CI->router->fetch_method());
    $this->set_config('layout', 'default');
    $this->set_config('format', 'html');

    foreach($config as $k => $v) {
      $this->set_config($k, $v);
    }
    log_message('debug', 'Contentful Template class initialized');
  }

  public function get_config($key) {
    if(strpos($key, '_') !== 0) {
      return $this->get_config('_' . $key);
    }
    return $this->$key;
  }

  function load($view = false, $data = false, $return = false) {
    if(!$view) {
      return $this->load("{$this->get_config('controller_name')}/{$this->get_config('method_name')}.{$this->get_config('format')}.php", $data, $return);
    }
    if(!$data) {
      return $this->load($view, $this->CI, $return);
    }
    log_message('debug', "Contentful: loading view '{$view}'");
    ContentfulManager::instance()->content_for_main_area();
    echo $this->CI->load->view($view, $this->CI, true);
    ContentfulManager::instance()->end_content_for();

    $layout = "layouts/{$this->get_config('layout')}.{$this->get_config('format')}.php";
    log_message('debug', "Contentful: loading layout '{$layout}'");
    return $this->CI->load->view($layout, $this->CI, $return);
  }

  public function set_config($key, $value) {
    if(strpos($key, '_') !== 0) {
      return $this->set_config('_' . $key, $value);
    }
    return $this->$key = $value;
  }

  public function set_format($format) {
    return $this->set_config('format', $format);
  }

  public function set_layout($layout) {
    return $this->set_config('layout', $layout);
  }
}

class ContentfulManager {
  private $blocks;
  private $call_stack;

  public static function instance() {
    static $instance;
    if(is_null($instance)) {
      $instance = new ContentfulManager;
      log_message('debug', 'ContentfulManager class initialized');
    }
    return $instance;
  }

  private function __construct() {
    $this->blocks = array();
    $this->call_stack = array();
  }

  public function content_for($section, $closure = null) {
    if(is_callable($closure)) {
      $this->content_for($section);
      $closure();
      return $this->end_content_for();
    }

    array_push($this->call_stack, $section);
    ob_start();
  }

  public function content_for_main_area($closure = null) {
    return $this->content_for('', $closure);
  }

  public function end_content_for() {
    $section = array_pop($this->call_stack);
    $this->blocks[$section] = ob_get_clean();
  }

  public function has_content_for($section) {
    return isset($this->blocks[$section]);
  }

  public function yield(/*...*/) {
    $args = func_get_args();

    $section = array_shift($args);
    $format_functions = $args;

    if($format_functions) {
      $func = array_pop($format_functions);
      array_unshift($format_functions, $section);
      return $func(call_user_func_array('yield', $format_functions));
    } else {
      if(is_null($section)) {
        return $this->yield('');
      }
      return $this->blocks[$section];
    }
  }
}

if(!defined('CONTENT_FOR_MANAGER_SHORTCUT_FUNCTIONS_DISABLE')) {

  $GLOBALS['safephp_pairs']['/<%(\s*)content_for (\w+)(\s*)%>/']  = '<?php content_for(\'$2\') ?>';
  $GLOBALS['safephp_pairs']['/<%(\s*)end_content_for(\s*)%>/']    = '<?php end_content_for() ?>';
  $GLOBALS['safephp_pairs']['/<%==(\s*)yield(\s*)%>/']            = '<?php echo yield() ?>';
  $GLOBALS['safephp_pairs']['/<%==(\s*)yield (\w+)(\s*)%>/']      = '<?php echo yield(\'$2\') ?>';
  $GLOBALS['safephp_pairs']['/<%=(\s*)yield (\w+)(\s*)%>/']       = '<?php echo htmlspecialchars(yield(\'$2\'), ENT_QUOTES) ?>';

  function content_for($section, $closure = null) {
    return ContentfulManager::instance()->content_for($section, $closure);
  }

  function content_for_main_area($closure = null) {
    return ContentfulManager::instance()->content_for_main_area($closure);
  }

  function end_content_for() {
    return ContentfulManager::instance()->end_content_for();
  }

  function has_content_for($section) {
    return ContentfulManager::instance()->has_content_for($section);
  }

  function yield(/*...*/) {
    return call_user_func_array(array(ContentfulManager::instance(), 'yield'), func_get_args());
  }
}
