<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

$config = array();

# This is the searchbase where account entries exist in LDAP.
# You shouldn't need to change this for development.
$config['ACM_LDAP_USERS_OU'] = "ou=users,dc=dev,dc=acm,dc=umn,dc=edu";

# GETTINGSTARTED: Password secret
# This is the secret used to hash the user's password before it goes into LDAP.
# You don't _need_ to change this value, but it doesn't hurt to change it.
$config['ACM_REGISTRATION_KEY'] = 'supersecretpassword';

# This is the address of the LDAP server.
$config['ACM_LDAP_SERVER_URL'] = 'ldap://hippogriff.acm.umn.edu';

?>
