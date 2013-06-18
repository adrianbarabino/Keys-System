<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Key System - Example</title>
	<link href='http://fonts.googleapis.com/css?family=Arvo:400,700|Lobster' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="./keycontrol/style.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script language="javascript">
	$(document).ready(function() {
	   // Esta primera parte crea un loader no es necesaria
	    $().ajaxStart(function() {
	        $('#loading').show();
	        $('#result').hide();
	    }).ajaxStop(function() {
	        $('#loading').hide();
	        $('#result').fadeIn('slow');
	    });
	   // Interceptamos el evento submit
	    $('#form, #fat, #fo3').submit(function() {
	  // Enviamos el formulario usando AJAX
	        $.ajax({
	            type: 'POST',
	            url: $(this).attr('action'),
	            data: $(this).serialize(),
	            // Mostramos un mensaje con la respuesta de PHP
	            success: function(data) {
	                $('#result').html(data);
	            }
	        })        
	        return false;
	    }); 
	})  
	</script>
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
	<h2>Please, enter your code for access to premium content</h2>
	<form method="post" action="ajax.php" id="fo3" name="fo3" >
      <fieldset>
        <legend>Enter key</legend>
        <ol>
            <li><label>Key:</label><input type="text" size="30" name="key" /></li>
        </ol>
        <input type="submit"   name="mysubmit" value="Send key" />
      </fieldset>
</div>
</form>
<div id="result"></div>

<footer>
<span>
	Keys System by <a href="http://adrianbarabino.github.io/" target="_blank">Adrian Barabino</a> - <a href="https://github.com/adrianbarabino/Keys-System" target="_blank">hosted in Github</a>
</span>

</footer>
</body>
</html>