<?php

session_start();
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Premium Content - Keys System</title>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700|Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="./keycontrol/style.css">
</head>
<body class="index">
	<header>
		<nav>
			<ul>
				<li>
					<h1><a href="index.php">Keys System</a></h1>
				</li>
			</ul>
		</nav>
	</header>
<?php
if($_SESSION['views']){
?>
<!doctype html>
<?php
echo "<h2>Welcome to this content!!</h2>";
echo "<h2>You are premium!</h2>";
 //you can remove a single variable in the session 
 unset($_SESSION['views']); 
 
 // or this would remove all the variables in the session, but not the session itself 
 session_unset(); 
 
 // this would destroy the session variables 
 session_destroy();

}else{
	echo "<h2>You don't have permission for access to this page</h2>";
}
?>

<footer>
<span>
	Keys System by <a href="http://adrianbarabino.github.io/" target="_blank">Adrian Barabino</a> - <a href="https://github.com/adrianbarabino/Keys-System" target="_blank">hosted in Github</a>
</span>

</footer>
</body>
</html>