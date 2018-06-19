<!DOCTYPE html>
<html lang="en">
<?php
	include 'header.php';
?>
  
<?php
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
		echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
	} else {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '
			<div class="jumbotron text-center">
				<h1>TechRabble</h1>
				<p id="subheader">Feel Free to Rabble!</p>
			</div>
			<div class="login-form">
				<form action="" method="post">
				  <h2 class="text-center">Sign In</h2>
				  <div class="form-group">
					<input type="text" class="form-control" name="username" placeholder="Username" required="required">

					<input type="password" class="form-control" name="password" placeholder="Password" required="required">

					<button type="submit" class="btn btn-primary btn-block">Sign In</button>
				  </div>
				  <div class="clearfix">
					<label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
					<a href="#" class="pull-right">Forgot Password?</a>
				  </div>
				</form>
				<p class="text-center"><a href="#">Create an Account</a></p>
			  </div>
			';
		} else {
			$erros = array();
			
			if(!isset($_POST['username'])) {
				$erros[] = 'username empty';
			}
			if(!isset($_POST['password']))
			{
				$errors[] = 'password empty.';
			}
			if(!empty($errors)) {
				echo '<ul>';
				foreach($errors as $key => $value) {
					echo '<li>' . $value . '</li>';
				}
				echo '</ul>';
			} else {
				$username = $_POST['username'];
				$password = $_POST['password'];
				$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
				$passwordHash = password_hash($password, PASSWORD_BCRYPT);
				$sql = "SELECT id, username, passwordHash FROM usertable WHERE username='" . $username . "';";
				$result = $mysqli->query($sql);
				if ($result->num_rows > 0) {
					echo "User exists<br>";
					$row = $result->fetch_assoc();
				if(password_verify($password , $row['passwordHash']) && ($username == $row['username'])) {
						echo "passwords match. <br>";
						echo "username exist matches. <br>";
						$_SESSION['signed_in'] = true;
						$_SESSION['username'] = $username;
						$_SESSION['id'] = $row['id'];
						echo '<pre>';
						var_dump($_SESSION);
						echo '</pre>';
						echo '
						<div class="jumbotron text-center">
							<h1>Welcome back, '. $_SESSION['username'] . '!</h1>
							<p id="subheader">You are Signed In!</p>
						</div>
						';
						
					} else {
						echo "wrong username or password";
					}
				} else {
					echo "wrong username or password";
					echo "Error: " . $sql . "<br>" . $mysqli->error;
				}
			}
		}
	}
?>
  
