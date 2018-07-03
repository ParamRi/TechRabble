<?php
	session_start();
	include 'header.php';
	
	if(!isset($_SESSION['signed_in']) || $_SESSION['signed_in'] != true) {
		echo "You must be signed in to view profile.";
		ob_start();
		header('Location: home.php');
		ob_end_flush();
		die();
	}
?>

<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="well">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
					<?php
						$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
						if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
							if(!isset($_GET['id'])) {
								$sql = "SELECT * FROM `usertable` WHERE id=" . $_SESSION['id'] . ";";
								$result = $mysqli->query($sql);
								echo '<h4>'. $_SESSION['username'] . '</h4> ';
								if($user = $result->fetch_assoc()) {
									echo '<p>
									<i class="glyphicon glyphicon-penil"></i>'. $user['email'] .'
									<br />
									<i class="glyphicon glyphicon-star"></i>registered since: ' . $user['reg_date'] . '</p>';
									$_BIO = $user['bio'];
								}
							} else {
								$sql = "SELECT * FROM usertable WHERE id=" . $_GET['id'] . ";";
								$result = $mysqli->query($sql);
								if($user = $result->fetch_assoc()) {
									echo '<h4>'. $user['username'] .'</h4>';
									echo '<p>
									<i class="glyphicon glyphicon-penil"></i>'. $user['email'] .'
									<br />
									<i class="glyphicon glyphicon-star"></i>registered since: ' . $user['reg_date'] . '</p>';
									$_BIO = $user['bio'];
								}
							}
						} 
						
						if($_SERVER['REQUEST_METHOD'] == 'POST') {
							$_BIO = $_POST['bio'];
						}
					?>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="well well-lg">
			<h4>Bio</h4>
			</br>
			<?php
			if(isset($_BIO)) {
				echo '<p>' . $_BIO . '</p>';
			} else {
				echo 'No bio available';
			}
			if(!isset($_GET['id']) || ($_GET['id'] == $_SESSION['id'])){
				echo '<button onClick="location.href=\'editProfile.php?id='. $_SESSION['id'] .'\'" type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-pencil"></span> Edit
				</button>';
			}
			?>
			
		</div>
	</div>
</div>
