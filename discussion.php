<!--
    Dev: Param Ri
    File: discussion.php
    Description: Description page for TechRabble
     -->
<?php 
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
			if(isset($_POST['comment'])) {
				var_dump($_POST);
				$comment = $_POST['comment'];
				if(!empty($comment)) {
					$sql4 = "INSERT INTO comments (body, userID, discID) VALUES (\"" . $comment . "\", '" . $_SESSION['id'] . "', " . $disc_id . ");";
					echo $sql4;
					$result4 = $mysqli->query($sql4);
					if($result4 === True) {
						echo 'Comment added successfully';
					} else {
						echo 'Couldn\'t add comment.';
						echo $mysqli->error;
					}
				} else {
					echo 'Comment empty';
				}
			} else if (isset($_POST['reply'])) {
				var_dump($_POST);
				$reply = $_POST['reply'];
				if(!empty($reply)) {
					$sql5 = "INSERT INTO comments (body, userID, discID) VALUES (\"" . $reply . "\", '" . $_SESSION['id'] . "', " . $disc_id . ");";
					$result5 = $mysqli->query($sql5);
					if($result5 === True) {
						$last_reply = $mysqli->insert_id;
						echo "New comment added";
						$sql6 = "INSERT INTO replys (originalPost, replyPost) VALUES ('". $_POST['original'] ."', '" . $last_reply . "');";
						$result6 = $mysqli->query($sql6);
						if($result6 === True) {
							echo "reply made";
						} else {
							echo "reply failed";
						}
					} else {
						echo "Failed to add comment";
					}
				} else {
					echo 'Reply empty';
				}
			}
		}
	} else {
		echo 'You must be signed in to make a comment.';
	}
	$sql2 = "SELECT * FROM `comments` WHERE discID=" . $disc_id . " AND commentID NOT IN (SELECT replyPost FROM replys); ";
	$result2 = $mysqli->query($sql2);
	echo ' 
	<div class="container">
		<div class="row">
			<div class="col-md-8">
			  <h2 class="page-header">Comments</h2>
			  <section class="comment-list">
			  ';
	while($comment = $result2->fetch_assoc()){
		$sql3 = "SELECT username, id FROM usertable WHERE id=". $comment['userID']. ";";
		$result3 = $mysqli->query($sql3) or die($mysqli->error);
		$user = $result3->fetch_assoc();
		echo '<div id="comment">';
		postComment($user, $comment);
		
		postReplies($mysqli, $comment);
		echo '</div>';
	}
	echo '	  
			  </section>
			</div>
		</div>
	</div>';
		
	function postReplies($mysqli, $comment) {
		$sqlReplies = "SELECT replyPost FROM replys WHERE originalPost=". $comment['commentID'] . ";";
		$resultReplies = $mysqli->query($sqlReplies);
		$hasReplies = False;
		if($resultReplies->num_rows > 0) {
			echo '<div id="reply">';
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
						<i class="fa fa-user"></i> ' . $user['username'] . '</a>
						</div>
					<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> '. $resultReplies2['post_date'] .' </time>
			';
			$commentID = $resultReplies2['commentID'];
			echo '		<p> '. $resultReplies2['body'].'</p>';
			if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
				echo '
						<button onclick="voteUp('.$commentID.', '.$_SESSION['id'].')" id="voteUp'.$commentID.'">
							<span class="glyphicon glyphicon-circle-arrow-up"></span>
						</button>
						<button onclick="voteDown('.$commentID.', '.$_SESSION['id'].')" id="voteDown'.$commentID.'">
							<span class="glyphicon glyphicon-circle-arrow-down"></span>
						</button>
						<button onclick="openText('.$commentID.')">Reply</button>
				';
			}
			$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
			$sql = "SELECT SUM(voteValue) FROM votes WHERE onComment=" . $commentID .";";
			$result = $mysqli->query($sql);
			$numVotes = 0;
			if($result) {
				$numVotes = $result->fetch_assoc()['SUM(voteValue)'];
			}
			echo '<div id="votes'.$commentID.'"> <p>'.$numVotes.' </p> </div>
					</div>
				<div id="'.$commentID.'" style="display:none">
					<form action="" method="post">
						<textarea placeholder="Make a reply commet here" name="reply" original="' . $commentID .'"></textarea>
						<div>
							<button type="submit">Submit</button>
						</div>
					</form>
				</div>
				</div>
			';
			if ($resultReplies2 == True) {
				postReplies($mysqli, $resultReplies2);
			}
			
		}
		if($hasReplies) {
			echo '</div>';
		}
	}
	
	function postComment($user, $comment) {
		$commentID = $comment['commentID'];
		echo '
		<div class="col-md-10 col-sm-10">
			<div class="panel panel-default arrow left">
				<div class="panel-body">
				  <header class="text-left">
					<a href="profile.php?id='. $user['id'] . '">
					<i class="fa fa-user"></i> ' . $user['username'] . '
				</div></a>
					<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> '. $comment['post_date'] .' </time>
				  
					<div class="comment-post">
						<p> '. 
						  $comment['body']
						. ' </p>
						';
		if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
			
			echo '
						<button onclick="voteUp('.$commentID.', '.$_SESSION['id'].')" id="voteUp'.$commentID.'">
							<span class="glyphicon glyphicon-circle-arrow-up"></span>
						</button>
						<button onclick="voteDown('.$commentID.', '.$_SESSION['id'].')" id="voteDown'.$commentID.'">
							<span class="glyphicon glyphicon-circle-arrow-down"></span>
						</button>
						<button onclick="openText('.$commentID.')">Reply</button>
			';
		}
		$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
		$sql = "SELECT SUM(voteValue) FROM votes WHERE onComment=" . $commentID .";";
		$result = $mysqli->query($sql);
		$numVotes = 0;
		if($result) {
			$numVotes = $result->fetch_assoc()['SUM(voteValue)'];
		}
		echo '<div id="votes'.$commentID.'"> <p>'.$numVotes.' </p> </div>
					</div>
		';
		
		echo '
				<div id="'.$commentID.'" style="display:none">
					<form action="" method="post">
						<textarea placeholder="Make a reply comment here" name="reply"></textarea>
						<input name="original" value="'. $commentID . '" />
						<div>
							<button type="submit">Submit</button>
						</div>
					</form>
				</div>
		';
		echo '
		</div>
		';
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
	
	function voteUp(commentID, userID) {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("votes"+commentID).innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","voting.php?commentID="+commentID+"&userID="+userID+"&vote=up",true);
		xmlhttp.send();
		setColor("voteUp", commentID);
	}
	
	function voteDown(commentID, userID) {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("votes"+commentID).innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","voting.php?commentID="+commentID+"&userID="+userID+"&vote=down",true);
		xmlhttp.send();
		setColor("voteDown", commentID);
	}
	
	function getVoteCount(commentID) {
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
			  document.getElementById("votes"+commentID).innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","voting.php?commentID="+commentID+"&userID="+userID+"&getVotes=\"True\"",true);
		xmlhttp.send();
	}
	
	var colorUp = "#FFFFFF";
	var colorDown = "#FFFFFF";
    function setColor(btn, commentID) {
		if(btn == "voteUp") {
			var upBtn = document.getElementById(btn+commentID);
			if (colorUp == "#7bd671") {
				colorUp = "#FFFFFF";
				upBtn.style.backgroundColor = colorUp;
			}
			else {
				colorUp = "#7bd671";
				upBtn.style.backgroundColor = colorUp;
				if(colorDown == "#ef675f") {
					var dwnBtn = document.getElementById("voteDown"+commentID);
					colorDown = "#FFFFFF";
					dwnBtn.style.backgroundColor = colorDown;
				}
			}
		} else if (btn == "voteDown") {
			var dwnBtn = document.getElementById(btn+commentID);
			if (colorDown == "#ef675f") {
				colorDown = "#FFFFFF";
				dwnBtn.style.backgroundColor = colorDown;
			}
			else {
				colorDown = "#ef675f";
				dwnBtn.style.backgroundColor = colorDown;
				if(colorUp == "#7bd671") {
					var upBtn = document.getElementById("voteUp"+commentID);
					colorUp = "#FFFFFF";
					upBtn.style.backgroundColor = colorUp;
				}
			}
		}
    }
</script>