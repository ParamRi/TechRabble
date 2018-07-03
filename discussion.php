<!--
    Dev: Param Ri
    File: discussion.php
    Description: Description page for TechRabble
     -->
<?php 
	session_start();
	include 'header.php';

	echo "<div class=\"container\">";
	echo "<div class=\"jumbotron text-center\">";

	$disc_id = $_GET['id']; 
	$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
	$sql = "SELECT title, subj, body FROM discussions WHERE discId = " . $disc_id;
	$result = $mysqli->query($sql);
	$row = $result->fetch_assoc();
	echo "<h1>" . $row['title'] . "</h1></div>";
	echo "<div class=\"jumbotron text-center\">";
	echo "<h2>" . $row['subj'] . "</h2>";
	echo "<p>" . $row['body'] . "</p></div>";
		
	if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
		if($_SERVER['REQUEST_METHOD'] != 'POST') {
			echo '<div class="container">
			<form action="" method="post">
				<textarea placeholder="Write your comment here" name="comment"></textarea>
				<div>
					<button type="submit">Submit</button>
				</div>
			</form>
			</div> ';
		} else {
			$comment = $_POST['comment'];
			$sql4 = "INSERT INTO comments (body, userID, discID) VALUES (\"" . $comment . "\", '" . $_SESSION['id'] . "', " . $disc_id . ");";
			echo $sql4;
			$result4 = $mysqli->query($sql4);
			if($result4 === True) {
				echo 'Comment added successfully';
			} else {
				echo 'Couldn\'t add comment.';
				echo $mysqli->error;
			}
		}
	} else {
		echo 'You must be signed in to make a comment.';
	}
	$sql2 = "SELECT * FROM `comments` WHERE discID=" . $disc_id . " AND commentID NOT IN (SELECT replyPost FROM replys); ";
	$result2 = $mysqli->query($sql2);
	echo ' <div class="container">
		  <div class="row">
			<div class="col-md-8">
			  <h2 class="page-header">Comments</h2>';
	while($comment = $result2->fetch_assoc()){
		$sql3 = "SELECT username, id FROM usertable WHERE id=". $comment['userID']. ";";
		$result3 = $mysqli->query($sql3) or die($mysqli->error);
		$user = $result3->fetch_assoc();
		echo '<section class="comment-list">
			  <!-- First Comment -->
			  <article class="row">
				<div class="col-md-2 col-sm-2 hidden-xs">
				  <figure class="thumbnail">
					<img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
					<figcaption class="text-center">username</figcaption>
				  </figure>
				</div>
				<div class="col-md-10 col-sm-10">
				  <div class="panel panel-default arrow left">
					<div class="panel-body">
					  <header class="text-left">
						<a href="profile.php?id='. $user['id'] . '">
						<i class="fa fa-user"></i> ' . $user['username'] . '</div></a>
						<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> '. $comment['post_date'] .' </time>
					  </header>
					  <div class="comment-post">
						<p> '. 
						  $comment['body']
						. ' </p>
		';
		$commentID = $comment['commentID'];
		echo '
			<div id="'.$commentID.'" style="display:none">
				<form action="" method="post">
					<textarea placeholder="Write your comment here" name="comment"></textarea>
					<div>
						<button type="submit">Submit</button>
					</div>
				</form>
			</div>
		';
		postReplies($mysqli, $comment);
		echo '</div>
					  <button onclick="openText('.$commentID.')">Reply</button>
					</div>
				  </div>
				</div>
			  </article>
			  </section>
		';
	}
	echo '</div>
			</div>
		</div>';
		
	function postReplies($mysqli, $comment) {
		$sqlReplies = "SELECT replyPost FROM replys WHERE originalPost=". $comment['commentID'] . ";";
		$resultReplies = $mysqli->query($sqlReplies);
		$hasReplies = False;
		if($resultReplies->num_rows > 0) {
			echo '<section class="comment-list">
			  <article class="row">
				<div class="col-md-2 col-sm-2 hidden-xs">
				  <figure class="thumbnail">
					<img class="img-responsive" src="http://www.keita-gaming.com/assets/profile/default-avatar-c5d8ec086224cb6fc4e395f4ba3018c2.jpg" />
					<figcaption class="text-center">username</figcaption>
				  </figure>
				</div>
				<div class="col-md-10 col-sm-10">
				  ';
			$hasReplies = True;
		}
		while($reply = $resultReplies->fetch_assoc()) {
			$sqlReplies2 = "SELECT * FROM comments WHERE commentID='" . $reply['replyPost'] . "';";
			$resultReplies2 = $mysqli->query($sqlReplies2)->fetch_assoc();
			$sql3 = "SELECT username, id FROM usertable WHERE id=". $resultReplies2['userID']. ";";
			$result3 = $mysqli->query($sql3) or die($mysqli->error);
			$user = $result3->fetch_assoc();
			echo ' 
				<div class="panel panel-default arrow left">
					<div class="panel-body">
					  <header class="text-left">
						<div class="comment-user">
						<a href="profile.php?id='. $user['id'] . '">
						<i class="fa fa-user"></i> ' . $user['username'] . '</div></a>
						<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> '. $resultReplies2['post_date'] .' </time>
			';
			echo '<p> '. $resultReplies2['body'].'</p>';
			if ($resultReplies2 == True) {
				postReplies($mysqli, $resultReplies2);
			}
			$commentID = $resultReplies2['commentID'];
			echo '
				</div>
				<div id="'.$commentID.'" style="display:none">
				<form action="" method="post">
					<textarea placeholder="Write your comment here" name="comment"></textarea>
					<div>
						<button type="submit">Submit</button>
					</div>
				</form>
				</div>
				<button onclick="openText('.$commentID.')">Reply</button>
			</div>
			';
		}
		if($hasReplies) {
			echo '</div>
			</div>
		</div>';
		}
	}
	?> 
  </div>
</body>
<script>
	function openText(commentID) {
		var textBox = document.getElementById(commentID);
		if(textBox.style.display === "none") {
			textBox.style.display = "block";	
		} else {
			textBox.style.display = "none";
		}
	}
</script>