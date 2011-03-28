<?php defined('BASEPATH') or exit('No direct script access allowed');
if(!class_exists('ContentfulManager')) {
  class ContentfulManager {
    private $blocks;
    private $call_stack;

    public function __construct($config = array()) {
      $this->CI =& get_instance();

      $this->blocks = array();
      $this->call_stack = array();

      $this->set_config('helpers_enabled', true);

      foreach($config as $k => $v) {
        $this->set_config($k, $v);
      }
      log_message('debug', 'Contentful Manager class initialized');

      if($this->get_config('helpers_enabled')) {
        $this->CI->load->helper('contentfulmanager');
      }
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

    public function get_config($key) {
      if(strpos($key, '_') !== 0) {
        return $this->get_config('_' . $key);
      }
      return $this->$key;
    }

    public function has_content_for($section) {
      return isset($this->blocks[$section]);
    }

    public function set_config($key, $value) {
      if(strpos($key, '_') !== 0) {
        return $this->set_config('_' . $key, $value);
      }
      return $this->$key = $value;
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
        if(array_key_exists($section, $this->blocks)) {
          return $this->blocks[$section];
        } else {
          return '';
        }
      }
    }
  }
}

