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
  
  //$mysqli = new mysqli("localhost", "$username", "$password", "techrabble");
  //$result = $mysqli->query("SELECT username FROM usertable");
  /*
  while ($row = $result->fetch_assoc()) {
    echo $row['username']."<br>";
  }
  */
 ?>
</body>
</html>