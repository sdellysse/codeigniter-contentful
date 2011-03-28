<html>
  <head>
    <title><?php echo contents_of('title') ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js" type="text/javascript"></script>
    <?php echo contents_of('head') ?>
  </head>
  <body class="<?php echo contents_of('body-class', 'trim')?>">
    <h1>Layout</h1>
    <hr/>
    <h1>View:</h1>
    <div style="border: 3px coral solid">
      <?php echo contents_of('main_area') ?>
    </div>
  </body>
</html>
