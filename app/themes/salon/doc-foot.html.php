  <?php foreach( $view->scripts as $scriptFile ): ?>
  <script src="js/<?=$scriptFile?>"></script>
  <?php endforeach; ?>

  <script>
    <?php include $view->getScriptFile(); ?>
  </script>

  <script src="js/main.js"></script>

</body>

</html>