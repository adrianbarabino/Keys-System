<?php
session_start();


require("./keycontrol/connection.php");
$key = $_POST['key'];



$query = "SELECT * FROM  `keys` WHERE  `key` =  '".$key."'";
if($result = $mysqli->query($query)){
	while ($row = $result->fetch_array()) {
$id = $row['id'];
$active = $row['active'];

}
}

if($id){

if($active == "1"){

$_SESSION['views']=uniqid('php_');


echo "<h2><a href='premium.php'>access to content</a></h2>";






$f_used = date("Y-m-d H:i:s");



	$mysqli->query("UPDATE `keys` SET  `f_used` =  '".$f_used."',`active` =  '0'  where id = ".$id);

}else{
	echo "<h2>This key is already used!</h2>";
}
} else {

	echo "<h2>Wrong Key!</h2>";
}


?>