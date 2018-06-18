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
		$row = $result->fetch_assoc();
		echo "<h1>" . $row['title'] . "</h1></div>";
		echo "<div class=\"jumbotron text-center\">";
		echo "<h2>" . $row['subj'] . "</h2>";
		echo "<p>" . $row['body'] . "</p></div>";
	?> 
  </div>
</body>