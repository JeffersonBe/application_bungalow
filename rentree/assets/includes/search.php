<?php
include('assets/connect/connect_settings.php');
$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
if($_GET["q"]=="_all")
{
$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.';');
			$query->execute();
			}
			else
			{

$search=addslashes($_GET["q"]).'%';

$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE nom LIKE :r_search;');
			$query->execute(array('r_search' => $search));

			}

echo "<table id='table_recherche' width='280'>";
$i=0;
while($answer=$query->fetch())
  {
  $i=$i+1;
  echo "<tr class='element_recherche'>";
  echo "<th scope='col'><input type='checkbox' value='".$answer['id']."' name='recherche[".$i."]' id='recherche[".$i."]'/></th>";
  echo "<th scope='col'><label ' for='recherche[".$i."]'>".$answer['nom']." ".$answer['prenom']."</label></th>";
  echo "<input type='hidden' name='nom[".$i."]' id='nom[".$i."]' value='".$answer['nom']."'/>";
  echo "<input type='hidden' name='prenom[".$i."]' id='prenom[".$i."]' value='".$answer['prenom']."'/>";
  echo '</tr>';

  }
 echo '</table>';
 echo "<input type='hidden' name='nb_recherches' id='nb_recherches' value='".$i."'/>";

$query->closeCursor();
?>