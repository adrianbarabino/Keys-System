<?php
require("connection.php");

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Key Control</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require("navigation.php");

$do = $_GET['do'];
if($do){
	if($do == "generatekey"){
		function randomAlphaNum($length){ 

    $rangeMin = pow(36, $length-1); //smallest number to give length digits in base 36 
    $rangeMax = pow(36, $length)-1; //largest number to give length digits in base 36 
    $base10Rand = mt_rand($rangeMin, $rangeMax); //get the random number 
    $newRand = base_convert($base10Rand, 10, 36); //convert it 
    
    return $newRand; //spit it out 

} 


$random1 = randomAlphaNum(3);
$random2 = randomAlphaNum(3);
$random3 = randomAlphaNum(3);
$random4 = randomAlphaNum(3);

$random_final = strtoupper($random1."-".$random2."-".$random3."-".$random4);

$f_start = date("Y-m-d H:i:s");

$mysqli->query("INSERT INTO  `keys` (`id`, `key`, `f_start`, `f_used`, `active`) VALUES(
	NULL, 
	'".$random_final."',
	'".$f_start."',
	 '',
	  '1');");

echo "<h2>The key: ";
echo $random_final;
echo " is now active! </h2>";

}elseif($do == "newkey"){
	?>


<form action="generatekey.php" method="post">

<input type="hidden" name="create" value="create" />
	<button value="Generate Key">Generate Key</button>

</form>
	<?php
}elseif($do == "disallow"){


if($_GET['id']){

$id = $_GET['id'];

$query = "SELECT * FROM `keys` where id = ".$id;

if($result = $mysqli->query($query)){
	while ($row = $result->fetch_array()) {
$key = $row['key'];
echo "<h2>The key ".$key." was used now.</h2>";
$f_used = date("Y-m-d H:i:s");



	$mysqli->query("UPDATE `keys` SET  `f_used` =  '".$f_used."', `active` =  '0' WHERE  `id` = ".$id." LIMIT 1");
}
}
}else{
	echo "<h2>The key doesn't exist!</h2>";
}
}elseif($do == "renew"){


if($_GET['id']){

$id = $_GET['id'];

$query = "SELECT * FROM `keys` where id = ".$id;

if($result = $mysqli->query($query)){
	while ($row = $result->fetch_array()) {
$key = $row['key'];
echo "<h2>The key ".$key." was active now.</h2>";
$f_used = date("Y-m-d H:i:s");



	$mysqli->query("UPDATE `keys` SET  `f_used` =  '', `active` =  '1' WHERE  `id` = ".$id." LIMIT 1");
}
}
}else{
	echo "<h2>The key doesn't exist!</h2>";
}

}elseif($do == "delete"){

if($_GET['id']){

$id = $_GET['id'];

$query = "SELECT * FROM `keys` where id = ".$id;

if($result = $mysqli->query($query)){
	while ($row = $result->fetch_array()) {
$key = $row['key'];
echo "<h2>The key ".$key." was deleted now.</h2>";


}
}
	$mysqli->query("DELETE from `keys` where `id` = ".$id);



}else{
	echo "<h2>The key doesn't exist!</h2>";
}
}

}else{







if($_GET['order'] OR $_GET['where']){
	$query = "SELECT * FROM `keys` ";

if($_GET['where']){
	$where = $_GET['where'];
	$where2 = $_GET['where2'];
	$query = $query."WHERE `".$where."` =".$where2." ";
	

}
if($_GET['order']){
	$order = $_GET['order'];

	if($_GET['order2']){
	$order2 = $_GET['order2'];
}else{
	$order2 = "asc";
}

	$query = $query."ORDER BY  `keys`.`".$order."` ".$order2." ";
}
}else{
	$_GET['order'] = "id";
$query = $query."SELECT * FROM `keys` ORDER BY  `keys`.`key` ASC ";
}

?>

<ul class="sub-menu">
<li><a href="
<?php
echo "index.php?";

	if($_GET['order']){
		echo "order=".$_GET['order']."&";
	}
	if($_GET['order2']){
		echo "order2=".$_GET['order2']."&";
	}
	
		echo "where=active&";
	
		echo "where2=1";
	

?>
">Show only actives </a> </li><li><a href="
<?php
echo "index.php?";

	if($_GET['order']){
		echo "order=".$_GET['order']."&";
	}
	if($_GET['order2']){
		echo "order2=".$_GET['order2']."&";
	}
		echo "where=active&";
	
		echo "where2=0";
	

?>
"> Show only used keys</a> </li><li><a href="
<?php
echo "index.php?";

		echo "order=f_used&";
	
	if($_GET['order2']){
		echo "order2=".$_GET['order2']."&";
	}
	if($_GET['where']){
		echo "where=".$_GET['where']."&";
	}
	if($_GET['where2'] == '0' OR $_GET['where2'] == '1'){
		echo "where2=".$_GET['where2']."&";
	}

?>"> Order by Used Date </a> </li><li><a href="
<?php
echo "index.php?";

		echo "order=f_start&";
	
	if($_GET['order2']){
		echo "order2=".$_GET['order2']."&";
	}
	if($_GET['where']){
		echo "where=".$_GET['where']."&";
	}
	if($_GET['where2'] == '0' OR $_GET['where2'] == '1'){
		echo "where2=".$_GET['where2']."&";
	}

?>"> Order by Created Date </a> </li><li><a href="
<?php
echo "index.php?";

	if($_GET['order']){
		echo "order=".$_GET['order']."&";
	}
	
	if($_GET['order2']){
		if($_GET['order2'] == "asc"){
		echo "order2=desc&";
	}elseif($_GET['order2'] == "desc"){
		echo"order2=asc&";
	}
	}else{
		echo "order2=desc&";
	}
	if($_GET['where']){
		echo "where=".$_GET['where']."&where2=".$_GET['where2'];
	}
	

?>"> Toggle ASC / DESC </a></li> </ul>
<table>
<tr>
<td>ID </td>
<td>Key</td>
<td>Created at</td>
<td>Used at</td>
<td>is active?</td>
<td>actions</td>


</tr>

<?php
if($result = $mysqli->query($query)){
    /* fetch associative array */
    while ($row = $result->fetch_array()) {
    	echo "<tr>";
    	        echo "<td>";
        echo $row['id'];
                echo "</td>";
    	echo "<td><b>";
        echo $row['key'];
        echo "</b></td>";

        echo "<td>";
        echo date("d/m/Y H:i:s", strtotime($row['f_start']));
                echo "</td>";
                if($row['f_used'] == "0000-00-00 00:00:00"){
                echo "<td>No used yet</td>";
            }else{
               echo "<td>";
        echo date("d/m/Y H:i:s", strtotime($row['f_used']));
                echo "</td>";
                };

                if($row['active'] == 1){

                echo "<td>Active</td>";
                } else {
                echo "<td>Used</td>";
                }
echo "<td>";
if($row['active'] == 1){
		echo "<a href='index.php?do=disallow&id=".$row['id']."'> disallow for use</a> - ";

}else{
	echo "<a href='index.php?do=renew&id=".$row['id']."'> renew for use</a> - ";
}

                echo "<a href='index.php?do=delete&id=".$row['id']."'>delete key</a></tr>";

    }

}
?>
</table>
<?php
    /* free result set */


/* close connection */
$mysqli->close();
}
?>

	
</body>
</html>