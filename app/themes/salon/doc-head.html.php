<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$app->title?> - <?=$view->title?></title>
  <base href="<?=$app->baseUri?>">
  <?php foreach( $view->styles as $styleFile ): ?>
  <link rel="stylesheet" type="text/css" href="css/<?=$styleFile?>">
  <?php endforeach; ?>
  <link rel="stylesheet" type="text/css" href="css/salon-theme.css">
  <style><?php include $view->getStylesFile(); ?></style>
  <script src="js/vendors/f1js/f1.js"></script>
  <script>F1.DEBUG = <?=__DEBUG_ON__?>; F1.page = '<?=$view->name?>';</script>
  <script>document.documentElement.style.setProperty('--scrollbar-width', (window.innerWidth - document.documentElement.offsetWidth) + 'px');</script>
</head>

<body>