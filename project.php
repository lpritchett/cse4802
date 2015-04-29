<?php
session_start();
echo '<h2>Projects</h2>';
    echo '<a href="logout.php">Log out</a><br />';
    echo '<a href="edit.php">Edit Profile</a><br><br>';
	
if (isset($_SESSION['valid_user'])) {
echo("<FORM name=\"createProject\" method=\"POST\" action=\"project.php\">
Project Title: <INPUT type=\"text\" name=\"projectName\"> <BR>
<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Create Project\" > </FORM>"


);
	$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
	//mysql_select_db("soullie7");
	$db_selected = mysql_select_db('soullie7', $connection);
	
	


	if (isset($_POST['btnSubmit'])){
		$user = $_SESSION['valid_user'];

		$projectName = $_POST['projectName'];
		$query = "insert into Project (OwnerName,Title) values('$user', '$projectName')";
		$result = mysql_query($query) or die("Query failed: " . mysql_error());
		}
	   



		echo "<h4>Owned Projects";
		$user = $_SESSION['valid_user'];
		$project_query = "select * from Project where OwnerName = '$user'";
		
		$project_result = mysql_query($project_query);
		while ($row = mysql_fetch_assoc($project_result)){
			
			echo '<div><a href=projectDetails.php?projectName='.$row['Id'].'>'.$row['Title'].''.'</a></div>';
			
		}
		
		echo "<h4>Collaborative Projects";
		$user = $_SESSION['valid_user'];
		$project_query = "select * from Invitation where collaboratorId = '$user' and status = 1";
		$project_result = mysql_query($project_query);
		$row = mysql_fetch_assoc($project_result);
		$projId = $row['ProjId'];
		$project_query = "select * from Project where Id = $projId";
		$project_result = mysql_query($project_query);
		while ($project_result != 0 and $row = mysql_fetch_assoc($project_result)){
			
			echo '<div><a href=projectDetails.php?projectName='.$row['Id'].'>'.$row['Title'].''.'</a></div>';
			
		}

		
		mysql_close($connection);
}
