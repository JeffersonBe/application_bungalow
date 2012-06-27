<?php
//Cette fonction renvoie le niveau d'authentification
function hothentic() {
	//Cas général: personne ne passe!
	$bool=0;
	//Si l'on vient de completer le formulaire
	if(isset($_POST['login']) && isset($_POST['password']))
	{
		//On vérifie si c'est un utilisateur autorisé
		if($_POST['login']=='hypnoz2011' && $_POST['password']=='vivelesprezpedants')
		{
			$_SESSION['plop']=1;
			$expire = time() + 86500;
			setcookie('plop', '1',$expire );
			$bool=1;	
		}
		else
		{
			//On vérifie si c'est un super-utilisateur
			if($_POST['login']=='boss' && $_POST['password']=='gethypemakemoney')
			{
				$_SESSION['plop']=2;
				$expire = time() + 86500;
				setcookie('plop', '2',$expire );
				$bool=2;
			}
		}
	}
	else // On vérifie s'il s'est déjà authentifié
	{
		if(isset($_SESSION['plop']))
		{
			$bool=$_SESSION['plop'];
		}
		else
		{
			if(isset($_COOKIE['plop']))
			{
				$bool=$_COOKIE['plop'];
			}
		}
	}
	return $bool;
}
?>