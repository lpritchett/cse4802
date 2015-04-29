<?session_start()?>
</HEAD>
<BODY>

<a href="befriend.php">Friends Page</a>
<br>
<a href="logout.php">Logout</a>

<br>
<?

$user = $_GET["user"];
 // if page has not been submitted, we echothm
$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
$db_selected = mysql_select_db('soullie7', $connection);
$curr_user = $user;
$query = "select * from logintable where user = '$curr_user'";
$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$home_city = $row["home_city"];
$home_state = $row["home_state"];
$password = $row["password"];
$email = $row["email"];
$birthyear = $row["birthyear"];
$interests = $row["interests"];
$privacy = $row["privacy"];
if ($privacy == 'Low') {
	echo '<br>';
	echo '<h2>'.$curr_user.'\'s profile</h2>';
	echo '<div>Home City: '.$home_city.'</div>';
	echo '<div>Home State: '.$home_state.'</div>';
	echo '<div>Email: '.$email.'</div>';
	echo '<div>Birth Year: '.$birthyear.'</div>';
	echo '<div>interests: '.$interests.'</div>';
} else if ($privacy == 'Medium') {
	$user = $_SESSION['valid_user'];
	$friend_query = "select * from friend where (friend.recipient = '$user' or friend.sender='$user') and friend.is_accepted = 1
		and (friend.recipient = '$curr_user' or friend.sender = '$curr_user')";
	$result = mysql_query($friend_query) or die("Query failed: " .mysql_error());
	if($result != False and mysql_num_rows($result) > 0){
		echo '<br>';
		echo '<h2>'.$curr_user.'\'s profile</h2>';
		echo '<div>Home City: '.$home_city.'</div>';
		echo '<div>Home State: '.$home_state.'</div>';
		echo '<div>Email: '.$email.'</div>';
		echo '<div>Birth Year: '.$birthyear.'</div>';
		echo '<div>interests: '.$interests.'</div>';
	}
} else if ($privacy == 'High') {
	$user = $_SESSION['valid_user'];
	$friend_query = "select * from friend where (friend.recipient = '$user' or friend.sender='$user') and friend.is_accepted = 1
		and (friend.recipient = '$curr_user' or friend.sender = '$curr_user')";
	$result = mysql_query($friend_query) or die("Query failed: " .mysql_error());
	if($result != False and mysql_num_rows($result) > 0){
		echo '<br>';
		echo '<h2>'.$curr_user.'\'s profile</h2>';
		echo '<div>Home City: '.$home_city.'</div>';
		echo '<div>Home State: '.$home_state.'</div>';
		echo '<div>Email: '.$email.'</div>';
		echo '<div>Birth Year: '.$birthyear.'</div>';
		echo '<div>interests: '.$interests.'</div>';
	} else {
		echo '<div>This user has set their profile to High privacy, you must be friends to view this profile</div>';
	}
}

       



?>
</BODY>
</HTML>

