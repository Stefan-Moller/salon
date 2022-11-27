  <?php foreach( $view->scripts as $scriptInfo ): ?>
  <script src="js/<?=$scriptInfo[0]?>"<?=$scriptInfo[1]?' type="module"':''?>></script>
  <?php endforeach; ?>

  <script type="module">
    <?php include $view->getScriptFile(); ?>
  </script>

  <script src="js/main.js"></script>

</body>

</html>