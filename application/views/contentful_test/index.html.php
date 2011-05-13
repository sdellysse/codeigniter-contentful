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
    /* and we have css */
  </style>
<?php end_content_for() ?>

Hello, <?php echo $name ?>!
