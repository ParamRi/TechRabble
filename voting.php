<?php

	$commentID = $_GET['commentID'];
	$userID = $_GET['userID'];
	if(isset($_GET['vote'])){
		$vote = $_GET['vote'];
		$mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
		$sql = "SELECT * FROM votes WHERE onComment=" . $commentID ." AND byUser=" . $userID.";";
		$result = $mysqli->query($sql);
		if($result) {
			if($result->num_rows > 0){
				$row = $result->fetch_assoc();
				if($vote == 'up') {
					$removeVote = "DELETE FROM votes WHERE onComment=" . $commentID ." AND byUser=" . $userID.";";
					$result2 = $mysqli->query($removeVote);
					if($result2) {
						$numVotes = getVoteCount($commentID);
						echo "votes:" . $numVotes;
					}
					if($row['voteValue'] == '-1') {
						$addVote = "INSERT INTO votes (voteValue, onComment, byUser) VALUES ('1', ".$commentID.", ".$userID.");";
						$result2 = $mysqli->query($addVote);
						if($result2) {
							$numVotes = getVoteCount($commentID);
							echo "votes:" . $numVotes;
						}
					}
				} else if($vote == 'down') {
					$removeVote = "DELETE FROM votes WHERE onComment=" . $commentID ." AND byUser=" . $userID.";";
					$result2 = $mysqli->query($removeVote);
					if($result2) {
						if($row['voteValue'] == '1') {
						} else if($row['voteValue'] == '-1') {
							echo "down-vote removed";
						}
					}
					if($row['voteValue'] == '1') {
						$addVote = "INSERT INTO votes (voteValue, onComment, byUser) VALUES ('-1', ".$commentID.", ".$userID.");";
						$result2 = $mysqli->query($addVote);
						if($result2) {
							$numVotes = getVoteCount($commentID);
							echo "votes:" . $numVotes;
						}
					}
				}
			} else {
				if($vote == "up") {
					$addVote = "INSERT INTO votes (voteValue, onComment, byUser) VALUES ('1', ".$commentID.", ".$userID.");";
					$result2 = $mysqli->query($addVote);
					if($result2) {
						$numVotes = getVoteCount($commentID);
						echo "votes:" . $numVotes;
					}
				} else if ($vote == "down") {
					$addVote = "INSERT INTO votes (voteValue, onComment, byUser) VALUES ('-1', ".$commentID.", ".$userID.");";
					$result2 = $mysqli->query($addVote);
					if($result2) {
						$numVotes = getVoteCount($commentID);
						echo "votes:" . $numVotes;
					}
				}
			}
		}
	} 
	
	function getVoteCount($commentID) {
		$mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
		$sql = "SELECT SUM(voteValue) FROM votes WHERE onComment=" . $commentID .";";
		$result = $mysqli->query($sql);
		$numVotes = 0;
		if($result) {
			$numVotes = $result->fetch_assoc()['SUM(voteValue)'];
		}
		return $numVotes;
	}

?>