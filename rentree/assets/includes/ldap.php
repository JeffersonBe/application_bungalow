<?php

$ldaphost = "157.159.10.119";

/*for a SSL secured ldap_connect()

$ldaphost = "ldap.yourdomain.com"; */

$ldapport = 636;

$ds = ldap_connect($ldaphost, $ldapport)
or die("Could not connect to $ldaphost");

if ($ds) {

$username = "bonnaire";
$upasswd = "972dwayneblasian972";
$binddn = "uid=$username,ou=people,o=it-sudparis,c=eu";

$ldapbind = ldap_bind($ds, $binddn, $upasswd);
                           
if ($ldapbind) {

print "Congratulations! $some_user is authenticated.";}

else {

print "Nice try, kid. Better luck next time!";}}

?>
