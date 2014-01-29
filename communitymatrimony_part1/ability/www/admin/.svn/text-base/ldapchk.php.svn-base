<?php

$username = 'ashokumar';
$password = 'cbspro09';
$domainname = 'bharatmatrimony.com';

echo authenticate_ldap($username,$password,$domainname);

function authenticate_ldap($username,$password,$domainname) {

     global $ds;

     $ds = ldap_connect("172.20.0.253");

    //Can't connect to LDAP.
    if( !$ds ) {
        //"Error in contacting the LDAP server -- contact ";
        //"technical services!  (Debug 1)";
        return 0;
    }

    //Connection made -- bind anonymously and get dn for username.
    $bind = @ldap_bind($ds);

    //Check to make sure we're bound.
    if( !$bind ) {
        //echo "Anonymous bind to LDAP FAILED.  Contact Tech Services! (Debug 2)";
        return 0;
    }

    $search = ldap_search($ds, "ou=$domainname,dc=consimgroup", "uid=$username");

    //Make sure only ONE result was returned -- if not, they might've thrown a * into the username.  Bad user!
    if( ldap_count_entries($ds,$search) != 1 ) {
        //echo "Error processing username -- please try to login again. (Debug 3)";
        return 0;
    }

   $info = ldap_get_entries($ds, $search);

    //Now, try to rebind with their full dn and password.
    $bind = @ldap_bind($ds, $info[0][dn], $password);
    if( !$bind || !isset($bind)) {
        //echo "Login failed -- please try again. (Debug 4)";
        return 0;
    }
    //Now verify the previous search using their credentials.
    $search = ldap_search($ds, "ou=$domainname,dc=consimgroup", "uid=$username");

    $info = ldap_get_entries($ds, $search);
    if( $username == $info[0][uid][0] ) {
        return 1;
    } else {
        return 0;
    }
}


ldap_close($ds); //comment it for local uncomment for live/**/

?>