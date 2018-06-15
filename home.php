<!--
    Dev: Nathan Kurz
    File: home.html
    Description: Home page for TechRabble
     -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>TechRabble</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/home.css" . <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="navBar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="home.html">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signin.html">sign-in</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signup.html">sign-up</a>
      </li>
    </ul>
  </nav>

  <div class="jumbotron text-center">
    <h1>TechRabble</h1>
    <p id="subheader">Feel Free to Rabble!</p>
  </div>

  <div class="container">
    <div class="col-sm-12 text-center" id="discussionTitle">
      <h2>Featured Discussions</h2>
    </div>
	<?php 
	  $mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
	  $sql = "SELECT * FROM discussions";
	  $result = $mysqli->query($sql);
	  if ($result->num_rows > 0) {
		echo "<div class=\"row\">";

		while($row = $result->fetch_assoc())
		{
			$out = "
				<div class=\"col-sm-4\">
				<a href=\"discussion.php?id='". $row['discId'] . "'\">
				<h3>" .$row['title'] . "</h3></a>
				<p>" . $row['subj'] . "</p>
				<p>" . $row['body'] . "</p>
				</div>";
			echo $out;
		}
		echo "</div>";
		mysqli_close($mysqli);
	  } else {
		echo "Error: " . $sql . "<br>" . $mysqli->error;
	  }
		
	 ?>
  </div>
