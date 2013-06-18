<?php 
function insert_header(){
	?>

	<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login - Keys System</title>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700|Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<nav>
		<ul>
			<li>
				<h1>Key System</h1>
			</li>

		</ul>
	</nav>

	<?php
};
// Here we require the config and database connection.
require("connection.php");

$action = $_GET['action'];





if($action == "logout"){

	setcookie("usEmail","x",time()-3600);
	setcookie("usPass","x",time()-3600);
	insert_header();
	?>
	<h2>Sucefully log-out, now you are redirected to the home.</h2>
	<SCRIPT LANGUAGE="javascript">
	location.href = "index.php";
	</SCRIPT>
	<?

}elseif($action == "login"){

	if(trim($_POST["email"]) != "" && trim($_POST["password"]) != "")
	{
		$emailN = remove_tags($_POST["email"]);
		$passN = md5(md5(remove_tags($_POST["password"])));


		$sql = "SELECT password FROM users WHERE email='$emailN'";
		$result = $mysqli->query($sql); // We reeplace the old mysql php system for MySQLi
		if($row = $result->fetch_assoc())
		{
			if($row["password"] == $passN)
			{
				//90 dias dura la cookie
				setcookie("usEmail",$emailN,time()+7776000);
				setcookie("usPass",$passN,time()+7776000);
				insert_header();
				?>
				<h2>ucefully login, now you are redirected to the home!</h2>
				<SCRIPT LANGUAGE="javascript">
				location.href = "index.php";
				</SCRIPT>
				<?
			}
			else
			{	insert_header();
				echo "<h2>Wrong password</h2>";
			}
		}
		else
		{	insert_header();
			echo "<h2>User doesn't exist!!!</h2>";
		}
		// mysql_free_result($result);
	}
	else
	{	insert_header();
	echo "<h2>You need to insert an email and password!</h2>";
	}
	$mysqli->close();


}else{
	insert_header();
	die("<h2>Wrong parameters</h2>");
}


?>

	
</body>
</html>