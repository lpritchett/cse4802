<?php
session_start();
echo '<h2>Login</h2>';

if (!isset($_POST['name'])&&!isset($_POST['password'])&&!isset($_SESSION['valid_user'])) { // if page has not been submitted, we echothm
echo("<FORM name=\"loginForm\" method=\"POST\" action=\"login.php\">
UserName: <INPUT type=\"text\" name=\"userName\"> <BR>
Password: <INPUT type=\"password\" name=\"password\"> <BR>
<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Login\" > </FORM>"
);
echo 'Not yet registered? ';
echo '<a href="register.php">Register</a><br><br>';
} else {//else we echo the userName and password
$userName = $_POST["userName"];
$password = $_POST["password"];
echo ("You have entered the user name $userName <BR>");

    
// Connecting and selecting database
$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
//mysql_select_db("soullie7");
$db_selected = mysql_select_db('soullie7', $connection);
if (!$db_selected) {
    die ('Can\'t use soullie7 : ' . mysql_error());
}

// Performing SQL query
$query = "select password from logintable where user = '$userName'";
$result = mysql_query($query) or die("Query failed: " . mysql_error());
$resultRow = mysql_fetch_row($result);
$actualPassword = $resultRow[0]; // Retrieve the first result tuple

if ($actualPassword == '') { // Empty tuple
echo ("Invalid username <BR>");
} else {
if ($actualPassword != $password) {
echo ("Incorrect password. Please try again <BR><BR>");
} else {
echo ("Login successful, congratulations! ");
$_SESSION['valid_user'] = $userName;
}
}
if(isset($_SESSION['valid_user'])){
echo '<br><a href="befriend.php">Friend\'s Page</a>';
echo '<br><a href="edit.php">Edit Profile</a>';
} else {
echo("<FORM name=\"loginForm\" method=\"POST\" action=\"login.php\">
UserName: <INPUT type=\"text\" name=\"userName\"> <BR>
Password: <INPUT type=\"password\" name=\"password\"> <BR>
<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Login\" > </FORM>");
echo 'Not yet registered? ';
echo '<a href="register.php">Register</a><br><br>';
}
mysql_free_result($result);
mysql_close($connection);
}

?>
