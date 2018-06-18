<html>
<body>
<?php
  include '../header.php';
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  echo "<p>";
  echo "Hello! Your username is: $username <br>";
  echo "Your email is: $email <br>";
  echo "</p>";
  if ($password == $confirm_password){
	  echo "passwords match <br>";
	  $mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
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
	  echo "passwords don't match <br>";
  }
  /*
  while ($row = $result->fetch_assoc()) {
    echo $row['username']."<br>";
  }
  */
 ?>
</body>
</html>