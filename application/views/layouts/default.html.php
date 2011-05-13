<html>
  <head>
    <title><?php echo contents_of('title') ?></title>
    <?php echo contents_of('head') ?>
  </head>
  <body class="<?php echo trim(contents_of('body-class'))?>">
    <h1>This is part of the layout</h1>
    <hr/>
    <h1>The un-contentful part of the View:</h1>
    <div style="border: 3px coral solid">
      <?php echo contents_of_main() ?>
    </div>
    <h1>This is also part of the layout</h1>
  </body>
</html>
