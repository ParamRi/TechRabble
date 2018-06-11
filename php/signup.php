<html>
<body>
<?php
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  echo "Hello! Your username is: $username <br>";
  echo "Your email is: $email <br>";
  if ($password == $confirm_password) echo "passwords match <br>";
  if ($password != $confirm_password) echo "passwords don't match <br>";
  
  $mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
  $sql = "INSERT INTO usertable (username, email, passwordHash) VALUES ('$username', '$email', '$password')";
  $result = $mysqli->query($sql);
  echo $result;
  if ($result === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $mysqli->error;
  }
  /*
  while ($row = $result->fetch_assoc()) {
    echo $row['username']."<br>";
  }
  */
 ?>
</body>
</html>