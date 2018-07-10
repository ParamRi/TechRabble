<?php

	$commentID = $_GET['commentID'];
	$userID = $_GET['userID'];
	$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
	$sql = "SELECT * FROM votes WHERE onComment=" . $commentID ." AND byUser=" . $userID.";";
	$result = $mysqli->query($sql);
	if($result) {
		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			echo "test positive";
			$removeVote = "DELETE FROM votes WHERE onComment=" . $commentID ." AND byUser=" . $userID.";";
			$result2 = $mysqli->query($removeVote);
			if($result2) {
				echo "vote removed";
			}
		} else {
			echo "test negative";
			$addVote = "INSERT INTO votes (voteValue, onComment, byUser) VALUES ('1', ".$commentID.", ".$userID.");";
			$result2 = $mysqli->query($addVote);
			if($result2) {
				echo "vote added";
			}
		}
	}

?>