<?php
session_start();

if(isset($_SESSION['valid_user'])) {
   if(!isset($_POST['btnSubmit'])){
	echo("<p>Request Friend</p>");
   echo("<FORM name=\"friendrequestForm\" method=\"POST\" action=\"befriend.php\">
           UserName: <INPUT type=\"text\" name=\"User\" required> <BR>
           <INPUT type= \"submit\" name=\"btnSubmit\" value=\"Request\" required> </FORM>");
   } else {
	$connection=mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
	mysql_select_db("soullie7");
         $userName = $_POST["User"];
	$sender = $_SESSION['valid_user'];
	if($userName == $sender){
		echo 'Cannot add self as friend<BR>';
	} else {
	$exist_check = "select * from logintable where logintable.user = '$userName'";
	$exist_result = mysql_query($exist_check);
	if(mysql_num_rows($exist_result) != 1){
		echo "<p>That user does not exist</p>";
	} else {
	$check_query = "select * from friend where friend.recipient = '$userName' and friend.sender = '$sender' or friend.sender = '$userName' and friend.recipient = '$sender'";
	$check_result = mysql_query($check_query);
	if(mysql_num_rows($check_result) > 0) {
		echo "<p>You have already sent a request to that user or have an incoming request</p>";
	} else {
         $f_query = "insert into friend(sender, recipient, is_accepted) values('$sender', '$userName', 0)";
         mysql_query($f_query) or die("Query failed: " . mysql_error());
		echo "<p>Request Sent Successfully</p>";
	}
	}
	}
	         echo("<FORM name=\"friendrequestForm\" method=\"POST\" action=\"befriend.php\">
                 UserName: <INPUT type=\"text\" name=\"User\" required> <BR>
                 <INPUT type= \"submit\" name=\"btnSubmit\" value=\"Request\" required> </FORM>");

   }
   
if(isset($_SESSION['valid_user'])) {
	echo "<h2>Search for interests</h2>";
   if(!isset($_POST['btnSearch'])){
   echo("<FORM name=\"interestSearchForm\" method=\"POST\" action=\"befriend.php\">
           Interest: <INPUT type=\"text\" name=\"Interest\" required> <BR>
           <INPUT type= \"submit\" name=\"btnSearch\" value=\"Search\" required> </FORM>");
   } else {
	$connection=mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
	mysql_select_db("soullie7");
         $interest = $_POST["Interest"];

	$search = "select * from logintable where interests like '%$interest%'";
	$search_result = mysql_query($search);
	if(mysql_num_rows($search_result) == 0){
		echo "<p>No user's found here</p>";
	} else {
		while ($row = mysql_fetch_assoc($search_result)) {
			echo "<div>".$row['user']."</div>";
			echo '<div><a href=profile.php?user='.$row['user'].'>Profile'.'</a></div>';
			
		}
	}
	
	         echo("<FORM name=\"interestSearchForm\" method=\"POST\" action=\"befriend.php\">
                 Interest: <INPUT type=\"text\" name=\"Interest\" required> <BR>
                 <INPUT type= \"submit\" name=\"btnSearch\" value=\"Request\" required> </FORM>");
	}
   }
mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
mysql_select_db("soullie7");

    echo '<a href="logout.php">Log out</a><br />';
    echo '<a href="edit.php">Edit Profile</a><br>';
	echo '<a href="project.php">Projects</a><br>';
    echo "<h2>Member List:</h2>";
    echo '<p>You are logged in as: '.$_SESSION['valid_user'].'</p>';
    $user = $_SESSION['valid_user'];
    $query = "SELECT * FROM logintable where user != '$user'";
    $result = mysql_query($query) or die("Query failed: " . mysql_error());
    while ($row = mysql_fetch_assoc($result)) {
    //echo '<p>.$row['user']</p>';
		echo '<div><a href=profile.php?user='.$row['user'].'>'.$row['user'].'</a></div>';
}
	echo "<h2>Incoming Friend Requests:</h2>";
	$incoming_query = "select friend.sender from logintable, friend where logintable.user = '$user' and friend.recipient = '$user' and friend.is_accepted = 0";
	$result = mysql_query($incoming_query) or die("Query failed: " .mysql_error());
	while ($row = mysql_fetch_assoc($result)) {
	echo '<div>'.$row['sender'].'<div>';
	echo '<a href=friended.php?sender='.$row['sender'].'>Accept'.'</a>';
	echo ' ';
	echo '<a href=unfriended.php?sender='.$row['sender'].'>Deny'.'</a>';

	}
	echo "<h2>Friends:</h2>";
        $friend_query = "select * from friend where (friend.recipient = '$user' or friend.sender='$user') and friend.is_accepted = 1";
        $result = mysql_query($friend_query) or die("Query failed: " .mysql_error());
        while ($row = mysql_fetch_assoc($result)) {
	if($row['sender'] == $user)
	{
		echo '<div>'.$row['recipient'].'</div>';
                echo '<a href=unfriended.php?toRemove='.$row['recipient'].'>Remove'.'</a>';
	} else {

        	echo '<div>'.$row['sender'].'</div>';
        	echo '<a href=unfriended.php?toRemove='.$row['sender'].'>Remove'.'</a>';
	}
	}
	
	echo "<h2>Collaboration Requests</h2>";
	$collabQuery = "select * from Invitation where collaboratorId = '$user'";
	
	$collabResult = mysql_query($collabQuery);
	while ($row = mysql_fetch_assoc($collabResult)) {
		$projId = $row['ProjId'];
		$projectNameQuery = "select * from Project where Id = $projId";
		$projectName = mysql_fetch_assoc(mysql_query($projectNameQuery))['Title'];
		echo '<div>'.$projectName.'&nbsp';
		echo '<a href=collab.php?projId='.$row['ProjId'].'&accept=1>Accept</a>&nbsp';
		echo '<a href=collab.php?projId='.$row['ProjId'].'&accept=0>Deny</a></div>&nbsp';
	}

mysql_free_result($result);

}

?>

