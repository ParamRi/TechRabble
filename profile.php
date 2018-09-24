<?php
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
							if(isset($_POST['bio'])) {
								$_BIO = $_POST['bio'];
							}
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
				echo '<div id="bioText">
					<p>' . $_BIO . '</p>
				</div>';
			} else {
				echo 'No bio available';
			}
			if(!isset($_GET['id']) || ($_GET['id'] == $_SESSION['id'])){
				echo '<div id="editBioButton">
					<button onClick="openBioBox()" type="button" class="btn btn-default btn-sm">
				  <span class="glyphicon glyphicon-pencil"></span> Edit
				</button> 
				</div>';
				echo '<div class="form-group" id="editBioTextBox" style="display:none">
				  <label for="bio">Enter Bio:</label>
				  <textarea class="form-control" rows="5" id="bio"></textarea>
				  <button onClick="editBio('.$_SESSION['id'].')"> Edit </button>
				</div> ';
			}
			?>
			
		</div>
	</div>
	<div class="row">
		<div class="well well-lg">
			<h4> Recent Comments</h4>
			</br>
			<?php
				$userID = '';
				if(isset($_GET['id'])) {
					$userID = $_GET['id'];
				} else {
					$userID = $_SESSION['id'];
				}
				echo '<table>
				<tr>
					<th>Discussion</th>
					<th>Comment</th>
					<th>Post Date</th>
				</tr>';
				//$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
				$sql = "SELECT * FROM `comments` WHERE userID=" . $userID . ";";
				$result = $mysqli->query($sql);
				while($comment = $result->fetch_assoc()) {
					$discTitle = getDiscTitle($comment['discID'], $mysqli);
					echo '<tr>
					<td>'. $discTitle .'</td>
					<td> <a href="discussion.php?id=\''.$comment['discID'].'\'" >' . $comment['body'] . '</td>
					<td> ' . $comment['post_date'] . '</td>
					</tr>';
				}
				echo '</table>';
				
				function getDiscTitle($discID, $mysqli) {
					$sql = "SELECT title FROM discussions WHERE discId=". $discID .";";
					$result = $mysqli->query($sql);
					if($title = $result->fetch_assoc()['title']) {
						return $title;
					} else {
						return $discID;
					}
				}
			?>
		</div>
	</div>
</div>
<script>
	function openBioBox() {
		var textBox = document.getElementById('editBioTextBox');
		if(textBox.style.display === "none") {
			textBox.style.display = "block";
			hideButton();
		} else {
			textBox.style.display = "none";
		}
	}
	
	function editBio(userID) {
		var bio = document.getElementById("bio").value;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.open("POST","editProfile.php");
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("bioText").innerHTML=this.responseText;
			}
		}
		xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
		xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xmlhttp.send(JSON.stringify({bio:bio, userID:userID}));
	}
	
	function hideButton() {
		var button = document.getElementByID('editBioButton');
		button.style.display = "none";
	}
</script>