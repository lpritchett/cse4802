<?php
session_start();
echo '<h2>Project Details</h2>';
$projId = $_GET['projectName'];
    echo '<a href="logout.php">Log out</a><br />';
    echo '<a href="edit.php">Edit Profile</a><br>';
	echo '<a href="project.php">Projects</a><br><br>';
	
if (isset($_SESSION['valid_user'])) {
echo("<FORM name=\"createDocument\" method=\"POST\" action=\"projectDetails.php?projectName=$projId\">
Filename: <INPUT type=\"text\" name=\"filename\"> <BR>
<INPUT type=\"hidden\" value=\"$projId\" name=\"projId\">
<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Create Document\" > </FORM>"
);
	$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
	//mysql_select_db("soullie7");
	$db_selected = mysql_select_db('soullie7', $connection);
	



	if (isset($_POST['btnSubmit'])){
		$user = $_SESSION['valid_user'];

		$filename = $_POST['filename'];
		$projectId = $_POST['projId'];
		
		$project_query = "select * from Project where Id = $projectId";
		$result = mysql_query($project_query);
		$row = mysql_fetch_assoc($result);

		$projOwner = $row['OwnerName'];

		$query = "insert into Document (ProjId, creatorId, Filename, versionNo, ProjOwnerId)
			values($projectId, '$user', '$filename', 1, '$projOwner')";

		$result = mysql_query($query) or die("Query failed: " . mysql_error());
	}
	   

		


		$user = $_SESSION['valid_user'];
		$project_query = "select * from Document where ProjId = $projId";
		$project_result = mysql_query($project_query);

		while ($row = mysql_fetch_assoc($project_result)){
			echo '<div><a href=documentDetails.php?projId='.$row['DocId'].'>'.$row['Filename'].''.'</a>';
			
		}

		
		mysql_close($connection);
}