<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8" />
  <!-- Set the viewport width to device width for mobile -->
  <meta name="viewport" content="width=device-width" />
  <title>Showtime BDE | Bienvenue sur le site SEI/WEI</title>
  <!-- Included CSS Files -->
  <?php echo css('foundation'); ?>
  <link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>

  <!--[if lt IE 9]>
    <link rel="stylesheet" href="stylesheets/ie.css">
  <![endif]-->

  <?php echo js('modernizr.foundation'); ?>

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body class="row">
<div id="main" class="six columns centered">
	<?php echo validation_errors(); ?> 
    <div id="inscription" class="row">
        <div class="twelve columns">
            <?php echo form_open(); ?>
            <h3 class="text-center">Formulaire d'inscription</h3>
                <div class="row">
                    <div class="six columns">
                        <label>Email</label>
                        <input type="text" name='email'>
                    </div>
                    <div class="six columns">
                        <label>Mot de passe</label>
                        <input type="password" name='pass'>
                    </div>
                </div>
                <p class="text-center">
                    <input type="submit" class="button large radius" value="Let's GO!"/>
                </p>
            </form>
        </div>
    </div><!-- fin de inscription -->
</div><!-- fin de main -->
  <!-- Included JS Files -->
  <?php echo js('jquery.min'); ?>
<?php echo js('foundation'); ?>
<?php echo js('app'); ?>
</body>
</html>