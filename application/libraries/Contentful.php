<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!class_exists('Contentful')) {
  get_instance()->load->library('ContentfulManager');
  class Contentful {
    function __construct($config = array()) {
      $this->CI =& get_instance();
      $this->set_config('controller_name', $this->CI->router->fetch_class());
      $this->set_config('method_name', $this->CI->router->fetch_method());
      $this->set_config('layout_enabled', TRUE);
      $this->set_config('layouts_disabled_only_for_next_load', FALSE);
      $this->set_config('layout', 'default');
      $this->set_config('format', 'html');

      foreach($config as $k => $v) {
        $this->set_config($k, $v);
      }
      log_message('debug', 'Contentful Template class initialized');
    }

    function disable_layout_for_next_load() {
      $this->set_config('layout_enabled', FALSE);
      $this->set_config('layouts_disabled_only_for_next_load', TRUE);
      log_message('debug', 'Contentful: layouts disabled for first subsequent load');
    }

    function get_config($key) {
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
      $this->CI->contentfulmanager->content_for_main_area();
      echo $this->CI->load->view($view, $this->CI, true);
      $this->CI->contentfulmanager->end_content_for();

      if($this->get_config('layout_enabled')) {
        $layout = "layouts/{$this->get_config('layout')}.{$this->get_config('format')}.php";
        log_message('debug', "Contentful: loading layout '{$layout}'");
      } else {
        log_message('debug', 'Contentful: layout disabled');
        if($this->get_config('layouts_disabled_only_for_next_load')) {
          log_message('debug', 'Contentful: re-enabling layout');
          $this->set_config('layout_enabled', TRUE);
          $this->set_config('layouts_disabled_only_for_next_load', FALSE);
        }
      }
      return $this->CI->load->view($layout, $this->CI, $return);
    }

    function set_config($key, $value) {
      if(strpos($key, '_') !== 0) {
        return $this->set_config('_' . $key, $value);
      }
      return $this->$key = $value;
    }

    function set_format($format) {
      return $this->set_config('format', $format);
    }

    function set_layout($layout) {
      return $this->set_config('layout', $layout);
    }
  }
}
