<?php
	require("keycontrol/connection.php");
error_reporting("ALL");

?>

<!doctype html>
<html>
<head>
<title>Key Control Installation</title>
<style>
body {
    background: #e31;
    margin: 0;
}
h1 {
    background: rgb(34, 34, 34);
    padding: 0.3em 1em;
    color: #eee;
    margin:0;
}

form input {
    padding: 0.5em;
    font-size: 1.1em;
}
form button {
    width: 99%;
}
form {
    display: inline-block;
    margin-left:2em;
}
p {
    margin-left: 2em;
    color: white;
}
a {
    margin-left: 3em;
    color: white;
    text-decoration: none;
    background: #333;
    border-radius: 0.3em;
    padding: 1em;
}
h3 {
    margin-left: 1.2em;  color: #222;  font-size: 1.6em;
}
</style>
</head>
<body>
<?php
if($_GET['step'] > 0){

if($_GET['step'] == 2){
if($_POST['mail']){

function run_query_batch($handle, $filename="")
{

global $mysqli;
// --------------
// Open SQL file.
// --------------
if (! ($fd = fopen($filename, "r")) ) {
die("Failed to open $filename: " . $mysqli->error() . "<br>");
}

// --------------------------------------
// Iterate through each line in the file.
// --------------------------------------
while (!feof($fd)) {

// -------------------------
// Read next line from file.
// -------------------------
$line = fgets($fd, 32768);
$stmt = "$stmt$line";

// -------------------------------------------------------------------
// Semicolon indicates end of statement, keep adding to the statement.
// until one is reached.
// -------------------------------------------------------------------
if (!preg_match("/;/", $stmt)) {
continue;
}

// ----------------------------------------------
// Remove semicolon and execute entire statement.
// ----------------------------------------------
$stmt = preg_replace("/;/", "", $stmt);

// ----------------------
// Execute the statement.
// ----------------------
if(!$result = $mysqli->query($stmt, $handle)){
	die("Error in the query to the DB");
}

$stmt = "";
}

// ---------------
// Close SQL file.
// ---------------
fclose($fd);
}

run_query_batch($dbhandle, "keys.sql");
$sql = "INSERT INTO users (name,password,email) VALUES (";
			$sql .= "'".remove_tags($_POST["name"])."'";
			$sql .= ",'".md5(md5(remove_tags($_POST["pass"])))."'";
			$sql .= ",'".remove_tags($_POST["mail"])."'";
			$sql .= ")";
			if(!$register_result = $mysqli->query($sql)){
				die("Error in the query to DB ". $mysqli->error);
				
			}
	?>
	
		<h1>Sucefully installed</h1>

		<p>Now you NEED delete this file (install.php) and you can now <a href="keycontrol/">log-in in the panel (/keycontrol/)</a>.
		</p>
	<?php
}else{
echo "<h1>Error</h1><h3>You don't have ingresed an email</h3>";
}
}

if($_GET['step'] == 1){
	?>
	<h1>Installation step 1</h1>
	<p>For continue you need provide an username and password for the Administrador/Operator</p>

	<form action="install.php?step=2" method="POST">
	
		<input type="text" id="name" name="name" placeholder="Name of the user" />
		<br>
		<input type="text" id="mail" name="mail" placeholder="Mail of the user" />
		<br>
		<input type="password" id="pass" name="pass" placeholder="Password" />
		<br>
		<button type="submit" value="install!">install</button>


	</form>
	<?php
}
}else{

	?>
	
	<h1>Welcome to the Key System installation</h1>
	<p>
		All work is maked by Adrian Barabino for learning and personal/comercial uses.
		<br>The code has been released with the Apache License 2.0, PLEASE read it.
		<br>Before to do click on "Lets go to install" you first need rename the <b>connection.php.sample</b> to <b>connection.php</b> and edit the file!!
	</p>

	<h3>Installing</h3>
	<a href="install.php?step=1">Lets go to install</a>

 	<?php

}

?>
</body>
</html>