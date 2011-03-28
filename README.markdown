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

### In your view:

Configuration
-------------

Edit `application/config/contentful.php` and
`application/config/contentfulmanager.php`.


[1]: https://github.com/sdellysse/codeigniter-contentful/tarball/master
[2]: https://github.com/sdellysse/codeigniter-contentful/zipball/master
[3]: http://localhost/ci
[4]: http://localhost/ci/index.php/contentfultest
