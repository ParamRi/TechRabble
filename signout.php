<html>
<body>
<?php
	include 'header.php';
	
	session_unset();
	
	session_destroy();
	
	echo '
	<div class="jumbotron text-center">
		<h1>GOOD BYE!</h1>
		<p id="subheader">You have sucessfully signed out!</p>
	</div>
	';
	
	var_dump($_SESSION);
?>