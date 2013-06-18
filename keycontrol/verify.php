<?php

 
      $loginOK = false; 
      $UserIDL; 
      $UserNameL; 
      $UserEmailL; 



if($_COOKIE["usEmail"] && $_COOKIE["usPass"]){


$result = $mysqli->query("SELECT * FROM users WHERE email='".$_COOKIE["usEmail"]."' AND password='".$_COOKIE["usPass"]."'");

if($row = $result->fetch_assoc())
{

setcookie("usEmail",$_COOKIE["usEmail"],time()+7776000);
setcookie("usPass",$_COOKIE["usPass"],time()+7776000);

$loginOK = true;
$UserIDL = $row["id"];
$UserNameL = $row["name"];
$UserEmailL = $row["email"];
}
else
{
setcookie("usEmail","x",time()-3600);
setcookie("usPass","x",time()-3600);

}
$result->free();
}
?>