<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!class_exists('ContentfulManager')) {
    class ContentfulManager {
        public function __construct($config = array()) {
            $this->CI =& get_instance();
            $this->CI->load->helper('contentfulmanager');

            $this->blocks = array();
            $this->section_name_stack = array();
            $this->main_area_name = 'contentful_manager_main_area';

            log_message('debug', 'Contentful Manager class initialized');
        }

        public function content_for($section, $closure = null) {
            if(is_callable($closure)) {
                $this->content_for($section);
                $closure();
                return $this->end_content_for();
            }

            array_push($this->section_name_stack, $section);
            ob_start();
        }

        public function content_for_main () {
            $arguments = func_get_args();
            array_unshift($arguments, $this->main_area_name);
            return call_user_func_array(array($this, 'content_for'), $arguments);
        }

        public function contents_of($section) {
            if(array_key_exists($section, $this->blocks)) {
                return $this->blocks[$section];
            } else {
                return '';
            }
        }

        public function contents_of_main () {
            $arguments = func_get_args();
            array_unshift($arguments, $this->main_area_name);
            return call_user_func_array(array($this, 'contents_of'), $arguments);
        }

        public function end_content_for() {
            $section = array_pop($this->section_name_stack);
            $this->blocks[$section] = ob_get_clean();
        }

        public function has_content_for($section) {
            return isset($this->blocks[$section]);
        }
    }
}

