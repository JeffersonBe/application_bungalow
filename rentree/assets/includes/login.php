<!-- Page de login -->
<?php include('assets/includes/head.php') ?>
<title>Vous essayez d'accéder à une zone réservée aux membres du BDE Showtime, veuillez vous logger!</title>
</head>
<body>
	<div id='login'>
		<img src='assets/img/logo_st_secure.png'/>
		<form method="post" action="index.php" id='form_log'>
				<p>
					<label for="login">Login : </label>
						<input type="text" name="login" />
				</p>
				<p>
					<label for="password">Mot de passe : </label>
						<input type="password" name="password" />
				</p>
				<p>
					<input type="submit" class="submit" value="Log Me Now" />
				</p>
		</form>
	</div><!-- fin de logger-->