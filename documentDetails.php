<?php
session_start();
$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
//mysql_select_db("soullie7");
$db_selected = mysql_select_db('soullie7', $connection);

$docId = $_GET['docId'];
$user = $_SESSION['valid_user'];
$document_query = "select * from Document where docId = $docId";
$documents = mysql_query($document_query);
$doc = mysql_fetch_assoc($documents);
$projectId = $doc['ProjId'];
echo '<h2>Document Details: '.$doc['Filename'].'<br> Version: '.$doc['versionNo'].'</h2>';
echo '<a href="logout.php">Log out</a><br />';
echo '<a href="edit.php">Edit Profile</a><br>';
echo '<a href="project.php">Projects</a><br>';
echo '<a href="projectDetails.php?projectName='.$projectId.'">Back to Project Documents</a><br><br>';

if (isset($_SESSION['valid_user'])) {

	$docId = $_GET['docId'];	
	$document_query = "select * from Document where docId = $docId";
	$documents = mysql_query($document_query);
	$doc = mysql_fetch_assoc($documents);
	$docText = $doc['Text'];
	echo("<FORM name=\"edit document\" method=\"POST\" action=\"documentDetails.php?docId=$docId\">
	Text: <textarea type=\"text\" name=\"docText\" cols =\"40\" rows=\"5\">$docText</textarea><BR>
	<INPUT type=\"hidden\" value=\"$docId\" name=\"docId\">
	<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Edit Document\" > </FORM>"
);

	



	if (isset($_POST['btnSubmit'])){
		$user = $_SESSION['valid_user'];

		$docId = $_POST['docId'];
		
		$document_query = "select * from Document where docId = $docId";

		$documents = mysql_query($document_query);
		$doc = mysql_fetch_assoc($documents);
		$projectId = $doc['ProjId'];
		$filename = $doc['Filename'];
		$version_no = $doc['versionNo'];
		
		$version_no = $version_no + 1;

		$projOwner = $doc['ProjOwnerId'];
		$parentDocId = $doc['DocId'];
		$check_for_same_parent = "select max(versionNo) from Document where parentDocId = $docId";

		$version_check = mysql_query($check_for_same_parent);
		
		if($version_check != False and mysql_num_rows($version_check) > 0){

			
			$row = mysql_fetch_assoc($version_check);
			if( $row['max(versionNo)'] !=0){
				$version_no = $row['max(versionNo)'] + 1;
			}

		}
		$docText = $_POST['docText'];
		$query = "insert into Document (ProjId, creatorId, Filename, versionNo, ProjOwnerId, parentDocId, Text)
			values($projectId, '$user', '$filename', $version_no, '$projOwner', $parentDocId, '$docText')";
		$result = mysql_query($query) or die("Query failed: " . mysql_error());
	}
	   
		$document_query = "select * from Document where docId = $docId";

		$documents = mysql_query($document_query);
		$doc = mysql_fetch_assoc($documents);
		$parentDocId = $doc['parentDocId'];
		echo '<h4>Parent</h4>';
		$parent_doc_query = "select * from Document where DocId = $parentDocId";
		$parent_doc = mysql_query($parent_doc_query);
		if($parent_doc != False and mysql_num_rows($parent_doc) > 0){
			$row = mysql_fetch_assoc($parent_doc);
			echo '<div><a href=documentDetails.php?docId='.$row['DocId'].'>Version: '.$row['versionNo'].''.'</a>';
		}

		$user = $_SESSION['valid_user'];
		$project_query = "select * from Document where parentDocId = $docId";
		$project_result = mysql_query($project_query);
		echo '<h4>Children</h4>';
		while ($row = mysql_fetch_assoc($project_result)){
			echo '<div><a href=documentDetails.php?docId='.$row['DocId'].'>Version: '.$row['versionNo'].''.'</a>';
		}

		
		mysql_close($connection);
}