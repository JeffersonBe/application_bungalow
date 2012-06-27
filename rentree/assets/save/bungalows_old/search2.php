<?php
include('../rentree/connect_settings.php');

$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
$bdd = new PDO('mysql:host='.$hostdb.';dbname='.$namedb, $logindb, $passworddb, $pdo_options);

if(!$bdd)
{
    // Show error if we cannot connect.
    echo 'ERROR: Could not connect to the database.';
}
else 
{
    // Is there a posted query string?
    if(isset($_POST['search2']))
	{
        $search = addslashes($_POST['search2']);
        // Is the string length greater than 0?
        if(strlen($search) >0) 
		{
			// Run the query: We use LIKE '$queryString%'
			// The percentage sign is a wild-card, in my example of countries it works like this...
			// $queryString = 'Uni';
			// Returned data = 'United States, United Kindom';
		
		
			$query=$bdd->prepare('SELECT * FROM '.$nainsa_table.' WHERE prenom LIKE :r_search LIMIT 10;');
		
			$query->execute(array('r_search' => $search.'%'));
			while($answer=$query->fetch())
			{
				// While there are results loop through them - fetching an Object (i like PHP5 btw!).
                // Format the results, im using <li> for the list, you can change it.
                // The onClick function fills the textbox with the result.
                echo '</li><li onclick="fill(\''.$answer['nom'].'\',\''.$answer['prenom'].'\',2);">'.$answer['prenom'].' '.$answer['nom'].'</li>';
            }
        }
		else 
		{
            echo 'Oops: p�pin!.';
        }
    } 
	else 
	{
        // Dont do anything.
    } // There is a queryString.
}
 
?>