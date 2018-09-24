<html>
<body>
<?php
	include 'header2.php';
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
		echo '<div class="jumbotron text-center">
		<p>You are already signed in, you can <a href="signout.php">sign out</a> if you want.</p>
		</div>';
	} else {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '
			<div class="jumbotron text-center">
				<h1>Join!</h1>
				<p id="subheader">Be a part of the noise!</p>
			</div>
			';
			include '../signup.html';
		} else {
			$username = $_POST['username'];
			$email = $_POST['email'];
			if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
				echo '
				<div class="jumbotron text-center">
					<p id="subheader">Invalid email!</p>
				</div>';
				die();
			}
			$password = $_POST['password'];
			$confirm_password = $_POST['confirm_password'];
			if ($password == $confirm_password){
				echo '<p>Hello! Your username is: $username <br>
					Your email is: $email <br>
					</p>
					passwords match <br>';
				$mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
				$passwordHash = password_hash($password, PASSWORD_BCRYPT);
				$sql = "INSERT INTO usertable (username, email, passwordHash) VALUES ('$username', '$email', '" . $passwordHash . "')";
				$result = $mysqli->query($sql);
				echo $result;
				if ($result === TRUE) {
					echo "New record created successfully";
				} else {
					echo "Error: " . $sql . "<br>" . $mysqli->error;
				}
			} else if ($password != $confirm_password) {
				echo '
				<div class="jumbotron text-center">
					<p id="subheader">passwords don\'t match!</p>
				</div>
				';
			}
		}
	}
  /*
  while ($row = $result->fetch_assoc()) {
    echo $row['username']."<br>";
  }
  */
 ?>
</body>
</html>