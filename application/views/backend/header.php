<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="fr"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="fr"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  <?php
  if (isset($titre))
    echo "<title>".$titre." - Back Office du BDE Showtime 2012 TMSP</title>";
  else
    echo "<title>Back Office du BDE Showtime 2012 TMSP</title>";
  ?>
  <!-- Included CSS Files -->
  <?php echo css('foundation'); ?>
  <!--[if lt IE 9]>
    <?php echo css('ie'); ?>
  <![endif]-->
  <?php echo js('modernizr.foundation'); ?>
  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <?php echo js('html5'); ?>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <?php echo js('jquery.min'); ?>
</head>