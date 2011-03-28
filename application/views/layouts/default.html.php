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
