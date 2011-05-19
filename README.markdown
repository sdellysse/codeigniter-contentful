Contentful Templates for CodeIgniter
====================================
What is Contentful?
-------------------

Heavily inspired by Rails 3's template system, Contentful is a templating
library for CodeIgniter (tested on 2.0.1 Reactor) and PHP 5. It allows you
to easily keep your layouts and views compeletely separate from your
controllers. It also lets the individual view apply changes to your layouts.

Installation
------------

1. Download either the [tarball][1] or the [zipball][2],
   depending upon your poison of choice, and extract it.
2. Copy the following files into your application directory:
   * config/contentful.php
   * helpers/contentfulmanager\_helper.php
   * libraries/contentful.php
   * libraries/contentfulmanager.php

Usage
-----

### In your controller: `application/controllers/contentfultest.php`:

    class ContentfulTest extends CI_Controller {
      public function index() {
        $this->load->library('contentful');

        $data['name'] = 'Shawn Dellysse';
        $this->contentful->load('contentful_test/index', $data);
      }
    }

  This will load the library, set a variable in the view, and then load your
  layouts and views. Since you didn't specify otherwise, it will look for your
  layout in `application/views/layouts/default.html.php`. Your per-page view
  will be loaded from `application/views/contentful_test/index.html.php`.

### In your layout `application/views/_layouts/default.html.php`:

    <html>
      <head>
        <title><?php echo contents_of('title') ?></title>
        <?php echo contents_of('head') ?>
      </head>
      <body class="<?php echo trim(contents_of('body-class'))?>">
        <h1>Layout</h1>
        <hr/>
        <h1>View:</h1>
        <div style="border: 3px coral solid">
          <?php echo contents_of_main() ?>
        </div>
      </body>
    </html>

  The `contents_of('some section')` will return the content inside the `content_for('some section')` block
  written in the view.

### In your view `application/views/contentful_test/index.html.php`:

    <?php content_for('title') ?>
      Greetings <?php echo $name ?>!
    <?php end_content_for() ?>

    <?php content_for('body-class') ?>
      greetings-page
    <?php end_content_for() ?>

    <?php content_for('head') ?>
      <script type="text/javascript">
        // We got scripts
      </script>
      <style type="text/css">
        /* and we got css too */
      </style>
    <?php end_content_for() ?>

    Hello, <?php echo $name ?>!

  Each `content_for($section)` should map to a `contents_of($section)` in your
  layout. Please note that, although they are style and indented as such,
  `content_for` blocks are *not* control structures. All code inside a
  block will always be evaluated.

### When run with the above layout, view, and controller (with a little bit of tidying):
    <html>
      <head>
        <title>  Greetings Shawn Dellysse!  </title>
        <script type="text/javascript">
          // We got scripts
        </script>
        <style type="text/css">
          /* and we got css too */
        </style>
      </head>
      <body class="greetings-page">
        <h1>Layout</h1>
        <hr/>
        <h1>View:</h1>
        <div style="border: 3px coral solid">
          Hello, Shawn Dellysse!
        </div>
      </body>
    </html>

Configuration
-------------

No initial configuration is necessary; however, all options are in `config/contentful.php` and
are documented there.


[1]: https://github.com/shawndellysse/codeigniter-contentful/tarball/master
[2]: https://github.com/shawndellysse/codeigniter-contentful/zipball/master
