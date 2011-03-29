<?php defined('BASEPATH') or exit('No direct script access allowed');

if(!function_exists('content_for')) {
  function content_for($section, $closure = null) {
    return get_instance()->contentfulmanager->content_for($section, $closure);
  }
  if(class_exists('SafePhp')) {
    get_instance()->safephp->add(
      'control',
      '/OPENTAG\s*content\s+for\s+([\w-\.]+)\s*CLOSETAG/',
      'OPENTAG content_for(\'$1\') CLOSETAG'
    );
    get_instance()->safephp->add(
      'control',
      '/\<[Cc][Oo][Nn][Tt][Ee][Nn][Tt]\s+[Ff][Oo][Rr]=([\'"])([^\1]*)\1\s*\>/',
      'OPENTAG content_for($1$2$1) CLOSETAG'
    );
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
  if(class_exists('SafePhp')) {
    get_instance()->safephp->add(
      'escaped_output',
      '/OPENTAG\s*contents\s+of\s+([\w-\.]+)\s*CLOSETAG/',
      'OPENTAG htmlspecialchars(contents_of(\'$1\'), ENT_QUOTES) CLOSETAG'
    );
    get_instance()->safephp->add(
      'unescaped_output',
      '/OPENTAG\s*contents\s+of\s+([\w-\.]+)\s*CLOSETAG/',
      'OPENTAG contents_of(\'$1\') CLOSETAG'
    );
  }
}

if(!function_exists('end_content_for')) {
  function end_content_for() {
    return get_instance()->contentfulmanager->end_content_for();
  }
  if(class_exists('SafePhp')) {
    get_instance()->safephp->add(
      'control',
      '/OPENTAG\s*end\s+content\s+for\s*CLOSETAG/',
      'OPENTAG end_content_for() CLOSETAG'
    );
    get_instance()->safephp->add(
      'control',
      '/\<\/[Cc][Oo][Nn][Tt][Ee][Nn][Tt]\s*\>/',
      'OPENTAG end_content_for() CLOSETAG'
    );
  }
}

if(!function_exists('has_content_for')) {
  function has_content_for($section) {
    return get_instance()->contentfulmanager->has_content_for($section);
  }
}
log_message('debug', 'contentfulmanager helpers loaded');
