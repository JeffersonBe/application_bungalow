<?php

session_start() ; 
session_unset() ;

// On ecrase le tableau de session
$_SESSION = array();

// on ecrase aussi le cookie de session
if (isset($_COOKIE[session_name()])) {
setcookie(session_name(), '', time()-86500, '/');
}
// et finalement, la session
session_destroy();

//On ecrase AUSSI le cookie plop et logsecure
setcookie('plop','',time()-86500);
//setcookie('logsecure','',time()-86500);

header('Refresh: 0; url=index.php');

?>