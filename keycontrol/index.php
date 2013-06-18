<?php
require("connection.php");
require("verify.php");

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Key Control</title>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700|Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="style.css">
</head>
<body <?php if(!$do){ echo "class='index'"; }?>>



<?php

if($loginOK){


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
</header>
<table>
	<thead>
<tr>
<td>ID </td>
<td class="key">Key</td>
<td class="date_start">Created at</td>
<td class="date_used">Used at</td>
<td class="status">Is active?</td>
<td class="actions">Actions</td>



</tr>
</thead><tbody>
<?php
if($result = $mysqli->query($query)){
    /* fetch associative array */
    while ($row = $result->fetch_array()) {
    	if($row['active'] == 1){
    	echo "<tr class='active'>";
    }else{
    	echo "<tr class='used'>";
    	
    }
    	        echo "<td class='id'>";
        echo $row['id'];
                echo "</td>";
    	echo "<td class='key'><b>";
        echo $row['key'];
        echo "</b></td>";

        echo "<td class='date_start'>";
        echo date("d/m/Y H:i:s", strtotime($row['f_start']));
                echo "</td>";
                if($row['f_used'] == "0000-00-00 00:00:00"){
                echo "<td class='date_used'>No used yet</td>";
            }else{
               echo "<td class='date_used'>";
        echo date("d/m/Y H:i:s", strtotime($row['f_used']));
                echo "</td>";
                };

                if($row['active'] == 1){

                echo "<td class='status'>Active</td>";
                } else {
                echo "<td class='status'>Used</td>";
                }
echo "<td>";
if($row['active'] == 1){
		echo "<a href='index.php?do=disallow&id=".$row['id']."'> disallow for use</a> ";

}else{
	echo "<a href='index.php?do=renew&id=".$row['id']."'> renew for use</a>";
}

                echo "<a href='index.php?do=delete&id=".$row['id']."'>delete key</a></tr>";

    }

}
?>
</tbody>
</table>
<?php
    /* free result set */


/* close connection */
$mysqli->close();
}
}else{
	?>
<header>
	<nav>
		<ul>
			<li>
				<h1>Key System</h1>
			</li>

		</ul>
	</nav>
</header>
<h2>Restringed Access</h2>
<h2>Please log-in or exit from here!!</h2>
	<form action="process.php?action=login" method="post"> 
      <input type ="text" placeholder="email" name="email" size=28 maxlength=100>
      <br> 
      <input type ="password" placeholder="password" name="password" size=28 maxlength=20>
      <br>
      <input type="submit" class="button" value="Log in">
      </form>
	<?php
}
?>



<footer>
<span>
	Keys System by <a href="http://adrianbarabino.github.io/" target="_blank">Adrian Barabino</a> - <a href="https://github.com/adrianbarabino/Keys-System" target="_blank">hosted in Github</a> <?php if($loginOK){ ?>- <a href="process.php?action=logout" class="exit">Exit<a><?php }; ?>
</span>

</footer>
</body>
</html>