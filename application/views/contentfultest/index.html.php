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
