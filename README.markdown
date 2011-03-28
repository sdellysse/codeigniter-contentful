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
2. Copy the contents of the extracted directory to your CodeIgniter project
   root.
3. That's it. It comes with an example controller/layout/view combination for
   testing purposes. Assuming your project url is [http://localhost/ci][3],
   point your web browser to [http://localhost/ci/index.php/contentfultest][4].

Usage
-----

### In your controller:

    class ContentfulTest extends CI_Controller {
      public function index() {
        $this->load->library('contentful');
        $this->name = 'Shawn Dellysse';
        $this->contentful->load();
      }
    }

  This will load the library, set a variable in the view, and then load your
  layouts and views. Since you didn't specify otherwise, it will look for your
  layout in `application/views/layout/default.html.php` and will look for your
  view in `application/views/contentfultest/index.html.php`.

### In your layout:

    <html>
      <head>
        <title><?php echo yield('title') ?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js" type="text/javascript"></script>
        <?php echo yield('head') ?>
      </head>
      <body class="<?php echo yield('body-class', 'trim')?>">
        <h1>Layout</h1>
        <hr/>
        <h1>View:</h1>
        <div style="border: 3px coral solid">
          <?php echo yield() ?>
        </div>
      </body>
    </html>

### In your view:

    <?php content_for('title') ?>
      Greetings <?php echo $name ?>!
    <?php end_content_for() ?>

    <?php content_for('body-class') ?>
      greetings-page
    <?php end_content_for() ?>

    <?php content_for('head') ?>
      <script type="text/javascript">
        $(document).ready(function() {
          //...
        });
      </script>
    <?php end_content_for() ?>

    Hello, <?php echo $name ?>!

Configuration
-------------

Edit `application/config/contentful.php` and
`application/config/contentfulmanager.php`.


[1]: https://github.com/sdellysse/codeigniter-contentful/tarball/master
[2]: https://github.com/sdellysse/codeigniter-contentful/zipball/master
[3]: http://localhost/ci
[4]: http://localhost/ci/index.php/contentfultest
