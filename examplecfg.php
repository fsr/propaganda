<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); //start session
$sessionuser = $_SESSION['user'];
$sessionpw = $_SESSION['password'];
$email = 'mymail@my.de';
$page = "https://my.website.de/";

if (!isset($_SESSION['user'])) {
    redirect_user();
}

function redirect_user()
{ //redirect user to home page
    $url ='index.php'; // Define the URL.
    ob_end_clean(); // Delete the buffer.
    header("Location: $url");
    exit(); #quit
}


  $ldaphost = "ldap://ldap.myhost.my/"; //Hostname
  $ldapconn = ldap_connect($ldaphost); //establish ldap connection
  ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3); //set protocol version to allow connection
  $userdn = "ou=myou,dc=mydc,dc=mydc";

  if ($ldapconn) {
      @ldap_bind($ldapconn)
    or die('Could not bind!<meta http-equiv="refresh" content="3; URL=index.php"/>');
      $checkid = ldap_search($ldapconn, $userdn, "uid=".$sessionuser);
      $check = ldap_get_entries($ldapconn, $checkid);
      if ($check["count"]>0) {
          for ($i=0; $i<$check["count"]; $i++) {
              $usercn = $check[$i]["cn"][0];
          }
      } else {
          exit("Couldn't log you in. Please check that you used the right username and password! <br /> Please contact myhost to get access if you don't have an account!<meta http-equiv='refresh' content='5; URL=index.php'/>");
      }
  }

  $uiddn = "uid=".$sessionuser.",".$userdn;

  $user = "cn=".$usercn;
  $userlogin = $user.",".$userdn;
  $password = $sessionpw;

  if ($ldapconn) {
      @ldap_bind($ldapconn, $userlogin, $password)
  or @ldap_bind($ldapconn, $uiddn, $password)
  or exit("Couldn't log you in. Please check that you used the right username and password! <meta http-equiv='refresh' content='3; URL=index.php'/>");

      $uid = ldap_search($ldapconn, $userdn, $user);
      $info = ldap_get_entries($ldapconn, $uid);
      for ($i=0; $i<$info["count"]; $i++) {
          $username = $info[$i]["uid"][0];
      }

      $propagandadn = "ou=myou,dc=mydc,dc=mydc";
      $propagandacn = "cn=mycn";
      $propaganda = ldap_search($ldapconn, $propagandadn, $propagandacn);
      $group = ldap_get_entries($ldapconn, $propaganda);
      for ($i=0; $i<$group["count"]; $i++) {
          $memberarray = $group[$i]["memberuid"];
      }

      ldap_unbind($ldapconn);
  }
