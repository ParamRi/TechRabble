<!--
    Dev: Nathan Kurz, Param Ri
    File: home.html
    Description: Home page for TechRabble
     -->

<?php 
	include 'header.php';
?>
<div class="jumbotron text-center">
	<h1>TechRabble</h1>
	<p id="subheader">Feel Free to Rabble!</p>
</div>
<div class="container">
	<div class="col-sm-12 text-center" id="discussionTitle">
		<h2>Featured Discussions</h2>
	</div>
	<?php 
	  $mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
	  $sql = "SELECT * FROM discussions";
	  $result = $mysqli->query($sql);
	  if ($result->num_rows > 0) {
		echo "<div class='table'>";
		echo '<table>
				<tr>
					<th>Discussion</th>
					<th>Subject</th>
					<th>Exerpt</th>
				</tr>';
		while($row = $result->fetch_assoc())
		{
			$out = "
				<tr>
				<td><a href=\"discussion.php?id='". $row['discId'] . "'\">
				" . $row['title'] . "</h3></a></td>
				<td>" . $row['subj'] . "</td>
				<td>" . $row['body'] . "</td>
				</tr>";
			echo $out;
		}
		echo "
		</table>
		</div>";
		mysqli_close($mysqli);
	  } else {
		echo "Error: " . $sql . "<br>" . $mysqli->error;
	  }
		
	 ?>
</div>
	
	<div class="container">
		<div class="col-sm-12 text-center" id="mostRecent">
			<h2>New Discussions</h2>
		</div>
		<?php
			$sql = "SELECT * FROM discussions ORDER BY post_date LIMIT 4;";
			$mysqli = new mysqli("localhost", "root", "HelloWorld2431$$", "techrabble");
			$result = $mysqli->query($sql);
			if ($result->num_rows > 0) {
				echo "<div class=\"row\">";

				while($row = $result->fetch_assoc())
				{
					$out = "
						<div class=\"col-sm-4\">
						<a href=\"discussion.php?id='". $row['discId'] . "'\">
						<h3>" . $row['title'] . "</h3></a>
						<p>" . $row['subj'] . "</p>
						<p>" . $row['body'] . "</p>
						</div>";
					echo $out;
				}
				echo "</div>";
				mysqli_close($mysqli);
			} else {
				echo "Error: " . $sql . "<br>" . $mysqli->error;
			}
		?>
	</div>
  
</body>