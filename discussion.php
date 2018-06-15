<!--
    Dev: Param Ri
    File: discussion.php
    Description: Description page for TechRabble
     -->
<?php 
	include 'header.php';

	echo "<div class=\"container\">";
	echo "<div class=\"jumbotron text-center\">";

		$disc_id = $_GET['id']; 
		$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
		$sql = "SELECT title, subj, body FROM discussions WHERE discId = " . $disc_id;
		$result = $mysqli->query($sql);
		echo "<h1>" . $result->fetch_assoc()['title'] . "</h1></div>";
	?> 
  </div>
</body>