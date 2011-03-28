<?php defined('BASEPATH') or exit('No direct script access allowed');
if(!class_exists('ContentfulManager')) {
  class ContentfulManager {
    private $blocks;
    private $call_stack;

    public function __construct() {
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
}

