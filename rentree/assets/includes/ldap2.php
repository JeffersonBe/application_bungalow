
<?php
$ldapconfig['host'] = 'annuaire.it-sudparis.eu';
$ldapconfig['port'] = 636;
$ldapconfig['basedn'] = 'o=it-sudparis,c=eu ';
$username='bonnaire';
$password='972dwayneblasian972';
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

$dn="uid=".$username.",ou=people,".$ldapconfig['basedn'];

if ($bind=ldap_bind($ds, $dn, $password)) {
  echo("Login correct");
} else {

  echo("Unable to bind to server.</br>");

  echo("msg:'".ldap_error($ds)."'</br>");#check if the message isn't: Can't contact LDAP server :)
  #if it say something about a cn or user then you are trying with the wrong $dn pattern i found this by looking at OpenLDAP source code :)
  #we can figure out the right pattern by searching the user tree
  #remember to turn on the anonymous search on the ldap server
  if ($bind=ldap_bind($ds)) {

    $filter = "(cn=*)";

    if (!($search=@ldap_search($ds, $ldapconfig['basedn'], $filter))) {
      echo("Unable to search ldap server<br>");
      echo("msg:'".ldap_error($ds)."'</br>");#check the message again
    } else {
      $number_returned = ldap_count_entries($ds,$search);
      $info = ldap_get_entries($ds, $search);
      echo "The number of entries returned is ". $number_returned."<p>";
      for ($i=0; $i<$info["count"]; $i++) {

        var_dump($info[$i]);#look for your user account in this pile of junk and apply the whole pattern where you build $dn to match exactly the ldap tree entry
      }
    }
  } else {
    echo("Unable to bind anonymously<br>");
    echo("msg:".ldap_error($ds)."<br>");
  }
}
?>
