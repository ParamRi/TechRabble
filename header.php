<!--
    Dev: Nathan Kurz, Param Ri
    File: home.html
    Description: Home page for TechRabble
     -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>TechRabble</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/home.css" . <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <style>
	#comment {
		margin 0 auto;
		background-color: Lavender;
	}
	
	#reply {
		margin-left: 100px;
	}
  </style>
  
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" id="navBar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="home.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signin.php">sign-in</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="signup.html">sign-up</a>
      </li>
	  <li class="nav-item">
		<a class="nav-link" href="create_new_discussion.php">New Discussion</a>
	  </li>
	  
	  <?php
		session_start();
		if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
			echo '
		<li class="nav-item">
			
			<a class="nav-link" href="profile.php">
			<span class="glyphicon glyphicon-user"></span>
			'.$_SESSION['username'].'
			</a>
		</li>
			';
		} 
	  ?>
    </ul>
  </nav>