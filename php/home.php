<!DOCTYPE html>
<html>
<body>
<?php 
  $mysqli = new mysqli("localhost", "root", "HelloWorld2431@$", "techrabble");
  $sql = "SELECT * FROM discussions";
  $result = $mysqli->query($sql);
  if (mysql_num_rows($result)==0) {
    echo "Retrived";
	echo "<table border='1'>
	<tr>
	<th>Title</th>
	<th>Subject</th>
	<th>Body</th>
	</tr>";

	while($row = $result->fetch_assoc())
	{
		echo "<tr>";
		echo "<td>" . $row['title'] . "</td>";
		echo "<td>" . $row['subj'] . "</td>";
		echo "<td>" . $row['body'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";

	mysqli_close($mysqli);
  } else {
	echo "Error: " . $sql . "<br>" . $mysqli->error;
  }
	
  /*
  while ($row = $result->fetch_assoc()) {
    echo $row['username']."<br>";
  }
  */
 ?>
</body>
</html>