<?php
session_start();
$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
//mysql_select_db("soullie7");
$db_selected = mysql_select_db('soullie7', $connection);
$projectId = $_GET['projectName'];
$project_query = "select * from Project where Id = $projectId";
$result = mysql_query($project_query);
$row = mysql_fetch_assoc($result);
echo '<h2>Project Details: '.$row['Title'].'</h2>';
$projId = $_GET['projectName'];
    echo '<a href="logout.php">Log out</a><br />';
    echo '<a href="edit.php">Edit Profile</a><br>';
	echo '<a href="project.php">Projects</a><br><br>';

    $user = $_SESSION['valid_user'];
    $owner_query = "select OwnerName from Project where Id = $projectId";
    $owner = mysql_query($owner_query);
    $owner_name = mysql_fetch_assoc($owner);
    if($user == $owner_name['OwnerName']) {
        echo("<div><FORM name=\"deleteProjecttForm\" method=\"POST\" action=\"projectDetails.php?projectName=$projId\">
                            <INPUT type= \"submit\" name=\"deleteProjSubmit\" value=\"Delete Project\" required>
                                    <INPUT type=\"hidden\" value=\"$projId\" name=\"projId\">      
                                            </FORM></div>");
    }
echo '<h4>Request Collaborators</h4>';
echo("<div><FORM name=\"collabRequestForm\" method=\"POST\" action=\"projectDetails.php?projectName=$projId\">
		UserName: <INPUT type=\"text\" name=\"user\" required> <BR>
		<INPUT type= \"submit\" name=\"btnCollabSubmit\" value=\"Request\" required>
		<INPUT type=\"hidden\" value=\"$projId\" name=\"projId\">	   
		</FORM></div>");
	   
if (isset($_SESSION['valid_user'])) {
echo '<h4>Create New Document</h4>';
echo("<FORM name=\"createDocument\" method=\"POST\" action=\"projectDetails.php?projectName=$projId\">
Filename: <INPUT type=\"text\" name=\"filename\"> <BR>
<div><textarea type=\"text\" name=\"docText\" cols =\"40\" rows=\"5\">Input Text Here</textarea></div>
<INPUT type=\"hidden\" value=\"$projId\" name=\"projId\">
<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Create Document\" > </FORM>"
);

	



	if (isset($_POST['btnSubmit'])){
		$user = $_SESSION['valid_user'];

		$filename = $_POST['filename'];
		$projectId = $_POST['projId'];
		$docText = $_POST['docText'];
		
		$project_query = "select * from Project where Id = $projectId";
		$result = mysql_query($project_query);
		$row = mysql_fetch_assoc($result);

		$projOwner = $row['OwnerName'];

		$query = "insert into Document (ProjId, creatorId, Filename, versionNo, ProjOwnerId, Text)
			values($projectId, '$user', '$filename', 1, '$projOwner', '$docText')";

		$result = mysql_query($query) or die("Query failed: " . mysql_error());
	}
	if(isset($_POST['btnCollabSubmit'])){
		$user = $_SESSION['valid_user'];
		$collabRequestUser = $_POST['user'];
		$projectId = $projectId = $_POST['projId'];
		$collabExistCheckQuery = "select * from Invitation where collaboratorId = '$collabRequestUser'";
		$collabResult = mysql_query($collabExistCheckQuery);
		if($collabResult != False and mysql_num_rows($collabResult)==0) {
		$projectId = $_POST['projId'];
			$createCollabQuery = "insert into Invitation (ProjId, OwnerName, collaboratorId, status)
				values ($projectId, '$user', '$collabRequestUser', 0)";
			mysql_query($createCollabQuery);
			echo "<div>Request Sent Successfully</div>";
		} else {
			echo "<div>You have already requested that user to work on this project</div>";
		}
	}
	   

	
		$user = $_SESSION['valid_user'];
		$project_query = "select * from Document where ProjId = $projId";
		$project_result = mysql_query($project_query);
		echo '<h4>All Documents and Versions</h4>';
		while ($row = mysql_fetch_assoc($project_result)){
			echo '<div><a href=documentDetails.php?docId='.$row['DocId'].'>'.$row['Filename'].' Version: '.$row['versionNo'].'</a>';
		}

		
		mysql_close($connection);
}
