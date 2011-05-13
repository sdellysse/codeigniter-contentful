<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!class_exists('Contentful')) {
    class Contentful {
        function __construct($config = array()) {
            $this->CI =& get_instance();
            $this->CI->load->library('ContentfulManager');

            # Set tasty defaults
            $this->set_config('layout_enabled', TRUE);
            $this->set_config('layout', 'default');
            $this->set_config('format', 'html');

            $this->set_config($config);
            log_message('debug', 'Contentful Template class initialized');
        }

        function get_config($key) {
            if(strpos($key, '_') !== 0) {
                return $this->get_config('_' . $key);
            }
            return $this->$key;
        }

        function load($view, $vars = array(), $return = false) {
            $view_path = "{$view}.{$this->get_config('format')}.php";
            $layout_path = "layouts/{$this->get_config('layout')}.{$this->get_config('format')}.php";

            if ($this->get_config('layout_enabled')) {
                log_message('debug', "Contentful: loading view '{$view_path}'");

                $this->CI->contentfulmanager->content_for_main();
                echo $this->CI->load->view($view_path, $vars, true);
                $this->CI->contentfulmanager->end_content_for();

                log_message('debug', "Contentful: loading layout '{$layout_path}'");
                return $this->CI->load->view($layout_path, $vars, $return);
            } else {
                log_message('debug', "Contentful: loading view '{$view_path}'");
                log_message('debug', 'Contentful: layout has been disabled');

                return $this->CI->load->view($view_path, $vars, $return);
            }
        }

        function set_config(/* (array) or ($key, $value) */) {
            $arguments = func_get_args();
            if (count($arguments) === 1) {
                return $this->set_config_from_array($arguments[0]);
            } else if (count($arguments) === 2) {
                return $this->set_config_with_key_value_pair($arguments[0], $arguments[1]);
            } else {
                throw new Exception('Invalid number of arguments');
            }
        }

        function set_config_from_array($array) {
            $retval = null;
            foreach ($array as $key => $value) {
                $retval = $this->set_config_with_key_value_pair($key, $value);
            }
            return $retval;
        }

        function set_config_with_key_value_pair($key, $value) {
            if(strpos($key, '_') !== 0) {
                return $this->set_config_with_key_value_pair('_' . $key, $value);
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
