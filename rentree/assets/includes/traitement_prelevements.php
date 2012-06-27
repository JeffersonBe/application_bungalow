<?php 
	//On ouvre le fichier dans lequel on va écrire.
  $fp = fopen("soge.txt","w");
  
   //Première ligne du fichier
    $date = date('dm').substr(date('y'),1,2);
    fputs($fp,"0308        544885       ".$date."BDE IT-SUDPARIS                                   E     0068300037275571                                               30003      \n");


                // Le reste (le code de Nono quasiment sans retouche)
                $total = 0;
				include('connect/connect_settings.php');
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);
				for($i=1;$i<=$_POST['nb_ajouts'];$i++)
				{
					if( !empty($_POST['ajoutid'.$i]))
					{
					//On récupère les infos liées à l'id
					$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE id = :r_id; AND typepaiemeentcotiz = prelevement');
					$query->execute(array('r_id' => $_POST['ajoutid'.$i]));
					
	                if( $answer = $query->fetch()){
	                    $prenom = $answer['prenom'];
	                    $nom = $answer['nom'];
	                    $destinataire_bordel = $prenom.' '.$nom;
	                    $nb_caracteres = strlen($destinataire_bordel);
	                    if($nb_caracteres > 24 ){
	                        $destinataire = substr($destinataire_bordel,'0','23');
	                    }
	                    else{
	                        while($nb_caracteres != 24){
	                            $destinataire_bordel .= ' ';
	                            $nb_caracteres = strlen($destinataire_bordel);
	                        }
	                    }
	                    $destinataire = $destinataire_bordel;
	                    $rib = $answer['numcompte'];
	                    $nbchiffre = strlen($rib);
	                    $rib = substr($rib,'0','16');
	
	                    $montant = $_POST['montant'];
	
	
	                    $motif = $_POST['motif'];
	                    $nb_caracteres = strlen($motif);
	                    if($nb_caracteres > 31 ){
	                        $motif = substr($motif,'0','30');
	                    }
	                    else{
	                        while($nb_caracteres != 31){
	                            $motif .= ' ';
	                            $nb_caracteres = strlen($motif);
	                        }
	                    }
	                    
	                    $total += intval($montant);
	                    
	
	                    fputs($fp,"0608        544885            ".$destinataire."SOCIETE GENERALE                ".$rib.$montant.$motif."30003      \n");
	                }// fin de if answer
					else
					{
						echo "Erreur: ".$_POST['info'.$i]." n'a pas autorisé le paiement par prélèvement ou bien n'a pas de numéro de compte";
					}
					}
				}// fin de for

                $nb_caracteres = strlen($total);
                    if($nb_caracteres > 16 ){
                        $total = substr($total,'0','15');
                    }
                    else{
                        while($nb_caracteres != 16){
                            $total = '0'.$total;
                            $nb_caracteres = strlen($total);
                        }
                    }

                fputs($fp,"0808        544885                                                                                    ".$total."                                          \n");
                fputs($fp,"\n");
				fclose($fp);
								
				//On propose maintenant le fichier au téléchargement.
				

$Fichier = 'soge.txt'; //Le fichier à télécharger
  header("Content-Type: octet-stream");
  header("Content-Length: ".filesize($Fichier) );
  header("Content-Disposition: attachment; filename=$Fichier"); 
  include($Fichier);
				
?>