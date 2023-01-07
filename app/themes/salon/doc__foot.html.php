  <?php foreach( $view->scripts as $scriptFileRef ): ?>
  <script src="<?=$scriptFileRef?>"></script>
  <?php endforeach; ?>

  <script type="module"><?php include $view->getInlineScriptFile(); ?></script>

  <script src="js/main.js" type="module"></script>

</body>

</html>