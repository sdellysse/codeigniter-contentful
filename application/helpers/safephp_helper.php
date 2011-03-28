<?php defined('BASEPATH') or exit('No direct script access allowed');

get_instance()->load->library('ContentfulManager');

if(!function_exists('content_for')) {
  function content_for($section, $closure = null) {
    return get_instance()->contentfulmanager->content_for($section, $closure);
  }
  if(class_exists('SafePhp')) {
    get_instance()->safephp->add(
      'control',
      '/OPENTAG(\s*)content_for (\w+)(\s*)CLOSETAG/',
      '<?php content_for(\'$2\') ?>'
    );
  }
}

if(!function_exists('content_for_main_area')) {
  function content_for_main_area($closure = null) {
    return get_instance()->contentfulmanager->content_for_main_area($closure);
  }
}

if(!function_exists('end_content_for')) {
  function end_content_for() {
    return get_instance()->contentfulmanager->end_content_for();
  }
  if(class_exists('SafePhp')) {
    get_instance()->safephp->add(
      'control',
      '/OPENTAG(\s*)end_content_for(\s*)CLOSETAG/',
      '<?php end_content_for() ?>'
    );
  }
}

if(!function_exists('has_content_for')) {
  function has_content_for($section) {
    return get_instance()->contentfulmanager->has_content_for($section);
  }
}

if(!function_exists('yield')) {
  function yield(/*...*/) {
    return call_user_func_array(array(get_instance()->contentfulmanager, 'yield'), func_get_args());
  }
  if(class_exists('SafePhp')) {
    get_instance()->safephp->add(
      'unescaped_output',
      '/OPENTAG(\s*)yield(\s*)CLOSETAG/',
      '<?php echo yield() ?>'
    );
    get_instance()->safephp->add(
      'unescaped_output',
      '/OPENTAG(\s*)yield (\w+)(\s*)CLOSETAG/',
      '<?php echo yield(\'$2\') ?>'
    );
    get_instance()->safephp->add(
      'escaped_output',
      '/OPENTAG(\s*)yield (\w+)(\s*)CLOSETAG/',
      '<?php echo htmlspecialchars(yield(\'$2\'), ENT_QUOTES) ?>'
    );
  }
}
