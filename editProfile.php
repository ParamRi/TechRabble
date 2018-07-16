<?php
	$data = json_decode(file_get_contents('php://input'), true);
	if(isset($data['bio']) && isset($data['userID'])){
		$mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
		$sql = "UPDATE usertable SET bio=\"".$data['bio']."\" WHERE id=" . $data['userID'].";";
		$result = $mysqli->query($sql);
		if($result) {
			echo '
				<p> '.$data['bio'].' </p>
			';
		} else {
			echo 'something whent wrong';
		}
	}
?>