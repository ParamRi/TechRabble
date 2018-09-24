<!--
    Dev: Param Ri
    File: new_discussion_form.php
    Description: Page that allows users to create new discussions
     -->
<?php
	include 'header.php';
	
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '
			<div class="jumbotron text-center">
				<h2>Start New Discussion</h2>
			</div>
			';
			include 'new_discussion_form.html';
		} else {
			$errors = array();
			
			if(!isset($_POST['title'])) {
				$errors[] = 'You need a Title';
				include 'new_discussion_form.html';
			}
			if(!isset($_POST['body']))
			{
				$errors[] = 'body of discussion is empty.';
				include 'new_discussion_form.html';
			}
			if(!empty($errors)) {
				echo '<ul>';
				foreach($errors as $key => $value) {
					echo '<li>' . $value . '</li>';
				}
				echo '</ul>';
			} else {
				$title = $_POST['title'];
				$subject = ' ';
				if(isset($_POST['subject'])) { 
					$subject = $_POST['subject'];
				}
				$body = $_POST['body'];
				var_dump($_POST);
				$mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
				$sql = "INSERT INTO discussions (title, subj, body, userID) VALUES ('$title', '$subject', 'body', '" . $_SESSION['id'] . "');";
				$result = $mysqli->query($sql);
				if ($result === TRUE) {
					$_SESSION['discussion_created'] = true;
					echo '<div class="jumbotron text-center">
						<h1>Discussion created by '. $_SESSION['username'] . '!</h1>
						<p id="subheader">type something here!</p>
					</div>
					';
						
				} else {
					echo $mysqli->error;
					echo '<div class="jumbotron text-center">
							<h1>Woops!</h1>
							<p id="subheader">Something whent wrong while trying to create your discussion!</p>
						</div>
						';
					include 'new_discussion_form.html';
				}
			}
		}
	} else {
		echo 'You must be signed in to post a new discussion';
	}
	
?>