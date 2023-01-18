<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$app->title?> - <?=$view->title?></title>
  <base href="<?=$app->baseUri?>">
  <?php foreach( $view->styles as $styleFileRef ): ?>
  <link rel="stylesheet" type="text/css" href="<?=$styleFileRef?>">
  <?php endforeach; ?>
  <style><?php include $view->getInlineStylesFile(); ?></style>
  <script src="js/vendors/f1js/f1-global.js"></script>
</head>

<body class="height-fixed-100">
  <script>F1.DEBUG = <?=__DEBUG_ON__?>; F1.page = '<?=$view->name?>'; F1.pageHref = '<?=$view->href?>';</script>