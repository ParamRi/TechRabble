<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	include 'header.php';
?>
  
<?php
	echo isset($_SESSION['signed_in']);
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
		echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
	} else {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '
			<div class="jumbotron text-center">
				<h1>TechRabble</h1>
				<p id="subheader">Feel Free to Rabble!</p>
			</div>
			';
			include 'signin_form.html';
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
						signinError();
					}
				} else {
					signinError();
				}
			}
		}
	}
	
	function signinError() {
		echo '
		<div class="jumbotron text-center">
			<h1>Woops!</h1>
			<p id="subheader">wrong username or password</p>
		</div>
		';
		include 'signin_form.html';
	}
?>
  
