

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Identifier-URL" content=""/>
<meta name="language" content="fr"/>
<meta name="location" content="France"/>
<meta name="Author" content="Pierre-Edouard MONTABRUN"/>
<meta name="Description" content="Réservation des Bugalows WEI 2011"/>
<meta name="keywords" content="Réservation Bugalows 2011 Télécom SudParis Télécom Ecole de Management"/>
<meta name="htdig-keywords" content=""/>
<meta name="subject" content=""/>
<meta name="Date-Creation-yyyymmdd" content="20110805"/>
<meta name="Audience" content="all"/>
<link rel="stylesheet" media="screen" type="text/css" href="style.css" />
<title>Réservation des Bugalows - WEI 2011 by Hypnoz</title>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.qtip-1.0.0.min.js"></script> 
<script type="text/javascript">
chosen=0;
function choose(x)
{
	if(chosen!=0){document.getElementById('cell_'+chosen).style.backgroundColor = '#FFF';}
	document.getElementById('bungalow').value=x;
	document.getElementById('cell_'+x).style.backgroundColor= "#fd8b8b";
	chosen=x;
}



// Create the tooltips only on document load
$(document).ready(function() 
{
   // By suppling no content attribute, the library uses each elements title attribute by default
   $('a[href][title]').qtip({

      content: {
         text:false// Use each elements title attribute
      },
      style:
	  {
	        border: {
         width: 10,
         radius: 8
		 },
	  name:'blue', // Give it some style
	        tip: { // Now an object instead of a string
         corner: 'topLeft', // We declare our corner within the object using the corner sub-option
         color: '#6699CC',
         size: {
            x: 10, // Be careful that the x and y values refer to coordinates on screen, not height or width.
            y : 10 // Depending on which corner your tooltip is at, x and y could mean either height or width!
         }
		 }
	  }
   });
   
   // NOTE: You can even omit all options and simply replace the regular title tooltips like so:
   // $('#content a[href]').qtip();
});
</script>


</head>
<body>








<?php 


//Nombre de colonnes pour l'affichages du contenun des Bungalows
$nb_colonnes=3;

//Traitement des noms et prénoms

$nom_raw = addslashes($_POST['nom']);
//Parsing du nom
$find = array('à','â','ä','é','è','ê','ë','î','ï','ç','ù','ü','ô','ö');
$replace = array('a','a','a','e','e','e','e','i','i','c','u','u','o','o');
$nom = strtoupper(str_replace($find,$replace,strtolower($nom_raw)));
$prenom_raw = addslashes($_POST['prenom']);
//parsing du prenom
$prenom = strtolower(str_replace($find,$replace,$prenom_raw));

//Informations de connexion
include('../rentree/connect_settings.php');
include('../rentree/bungalows.php');

$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);

//Vérification que l'utilisateur est bien inscrit au WEI

$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE nom=:r_nom AND prenom=:r_prenom;');
if($answer=$query->execute(array('r_nom'=>$nom,'r_prenom'=>$prenom)))
{
	if($answer=$query->fetch())
	{
		//Si Oui
		
		$msg=0;
		?>
		Bonjour <?php echo $prenom.' '.$nom;?>, Vous pouvez désormais choisir votre Bungalow. Si vous choisissez un Bungalow vide, n'hésitez pas à lui donner un nom!
		<form method="post" action="register.php" id="bungalows_form">
		<input type="hidden" name="id_eleve" value="<?php echo $answer['id'];?>"/>
		<input type="hidden" name="nom" value="<?php echo $nom;?>"/>
		<input type="hidden" name="prenom" value="<?php echo $prenom;?>"/>
		<input type="hidden" name="bungalow" id="bungalow" value=""/>
		<table id='bugalows_table'>
		<?php
		$query=$bdd->prepare('SELECT * FROM '.$bung_table.';');
		if($answer=$query->execute())
		{
			$i=0;
			?>
			<tr>
			<?php
			while($answer=$query->fetch())
			{
				$i=$i+1;
				if($i%$nb_colonnes==1)
				{
					echo '<tr>';
				}
				?>
				
				<?php
				if($answer['nb_nainsa']<$answer['contenance'])
				{
					?>
					
					
					<td class='cell_libre' id='cell_<?php echo $answer['id'];?>'>
					
					<?php
				}
				else
				{
					?>
					<td class='cell_utilisee' id='cell_<?php echo $answer['id'];?>'>
					
					<?php
				}
				$titre="";
				for($j=1;$j<=$answer['nb_nainsa'];$j++)
				{
					$query2=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id=:r_id;');
					$answer2=$query2->execute(array('r_id'=>$answer['nainsa'.$j]));
					$answer2=$query2->fetch();
					$titre=$titre."<li>".$answer2['prenom']." ".$answer2['nom']."</li>";
				}
				if(empty($titre)){$titre="vide";}else{$titre="<ul class='liste_bung'>".$titre."</ul>";}
				?>
				<a href="#" title="<?php echo $titre;?>" onClick=<?php echo 'choose('.$answer['id'].')';?>>
				<div class='nb_nainsa'><?php echo $answer['nb_nainsa'];?></div>
				<div class='contenance'><?php echo $answer['contenance'];?></div>
				<img class='img_bung' src='img/bungalow_<?php echo $equipe_officiel[$answer['equipe']]['couleur'];?>.jpg'/></a><br/>

				
				
				
				<?php if($answer['nom']=='')
					{
						?>
						<input type='text' class='nom_bungalow' size='10' name='<?php echo $answer['id'];?>' value=''/>
						<?php
					}
					else
					{
						?>
						<h3 class='nom_bungalow'><?php echo $answer['nom'];?></h3>
						<?php		
					}
				?>
				</a>
				</td>
				
				<?php
				if($i%$nb_colonnes==0)
				{
					echo '</tr>';
				}

			
			
			}
			if($i%$nb_colonnes!=0)
			{
				for($j=1+($i%$nb_colonnes);$j<=$nb_colonnes;$j++)
				{
					echo '<td></td>';
				}
				echo '</tr>';
			}
		?>
		
		
		</table>
		<input type="submit" class="submit" value="Enregistrer!" />
		</form>
		<?php
		
	}
	}
	else
	{	
		//Il n'est pas inscrit
		?>
		Vous n'êtes pas inscrit(e) au WEI 2011 by Hypnoz.<br/>Pour vous inscrire, Contacter un membre du bde <a href="mailto:contact@hypnoz2011.com">par email</a> ou bien rendez-vous au local BDE situé au Foyer.
		<?php
	}
}
else
{
	//Impossible de se connecter à la base de donnée
	echo 'Impossible de se connecter à la base de donnée';
}

?>

</body>
</html>