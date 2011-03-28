<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('content_for')) {
  function content_for($section, $closure = null) {
    return get_instance()->contentfulmanager->content_for($section, $closure);
  }
}

if(!function_exists('content_for_main_area')) {
  function content_for_main_area($closure = null) {
    return get_instance()->contentfulmanager->content_for_main_area($closure);
  }
}

if(!function_exists('contents_of')) {
  function contents_of(/*...*/) {
    return call_user_func_array(array(get_instance()->contentfulmanager, 'contents_of'), func_get_args());
  }
}

if(!function_exists('end_content_for')) {
  function end_content_for() {
    return get_instance()->contentfulmanager->end_content_for();
  }
}

if(!function_exists('has_content_for')) {
  function has_content_for($section) {
    return get_instance()->contentfulmanager->has_content_for($section);
  }
}
log_message('debug', 'contentfulmanager helpers loaded');
