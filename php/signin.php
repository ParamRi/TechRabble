<html>
<body>
<?php
  include '../header.php';
  $username = $_POST['username'];
  $password = $_POST['password'];
  $mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
  $passwordHash = password_hash($password, PASSWORD_BCRYPT);
  $sql = "SELECT passwordHash FROM usertable WHERE username='" . $username . "';";
  $result = $mysqli->query($sql);
  if ($result->num_rows > 0) {
	echo "User exists<br>";
	$row = $result->fetch_assoc();
	if(password_verify($password , $row['passwordHash'])) {
		echo "passwords match.";
	} else {
		echo "wrong username or password";
	}
  } else {
	echo "wrong username or password";
	echo "Error: " . $sql . "<br>" . $mysqli->error;
  }

 ?>
</body>
</html>