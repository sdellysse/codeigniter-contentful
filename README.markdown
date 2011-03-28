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
   testing purposes. Assuming your project url is http://localhost/ci,
   point your web browser to http://localhost/ci/index.php/contentfultest.

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

  The `yield($section)` will return the content inside the `content_for` block
  written in the view. The first argument to `yield` is always the name of the
  section; it can also take an arbitrary number of strings after the section
  that are the names of functions that will format the output. In this case,
  for the `body-class` section, that yield call is equivalent to
  `<?php echo trim(yield('body-class')) ?>`. In general,
  `yield('some-section', 'a', 'b', 'c')` will be equivalent to
  `a(b(c(yield('some-section'))))`.

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

  Each `content_for($section)` should map to a `yield($section)` in your
  layout. Please note that, although they are style and indented as such,
  `content_for` blocks are *not* control structures. All code inside a
  block will always be evaluated.

### When run with the above layout, view, and controller (with a little bit of tidying):
    <html>
      <head>
        <title>  Greetings Shawn Dellysse!  </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js" type="text/javascript"></script>
          <script type="text/javascript">
            $(document).ready(function() {
              //...
            });
          </script>
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

Edit `application/config/contentful.php` and
`application/config/contentfulmanager.php`.


[1]: https://github.com/sdellysse/codeigniter-contentful/tarball/master
[2]: https://github.com/sdellysse/codeigniter-contentful/zipball/master
