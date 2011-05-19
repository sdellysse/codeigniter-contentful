<?php defined('BASEPATH') or exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Default format type
|--------------------------------------------------------------------------
|
| Default is 'html'. Contentful can return an arbitrary number of
| different formats. When you tell Contenful to load a view named
| 'somefile', it looks for the file "somefile.$format.php'
|
*/
$config['format'] = 'html';

/*
|--------------------------------------------------------------------------
| Filename for default layout
|--------------------------------------------------------------------------
|
| Default is TRUE. Determines whether or not a layout file should be used.
|
*/
$config['layout_enabled'] = TRUE;

/*
|--------------------------------------------------------------------------
| Filename for default layout
|--------------------------------------------------------------------------
|
| Default is 'default'. Determines where it looks for a layout file if one
| is not specified. This expands out to
| application/views/layouts/$layout.$format.php
|
*/
$config['layout'] = 'default';
