<?session_start()?>
</HEAD>
<BODY>
<h2>Register</h2>
<?


if (!isset($_POST['btnSubmit'])&&!isset($_SESSION['valid_user'])) { // if page has not been submitted, we echothm
	echo("<FORM name=\"registerForm\" method=\"POST\" action=\"register.php\">
	UserName: <INPUT type=\"text\" name=\"userName\" required> <BR>
	Password: <INPUT pattern=\".{8,}\" title=\"8 char minimum\" type=\"password\" name=\"password\" required> <BR>
	Hometown City: <INPUT type=\"text\" name=\"city\" required><BR>
	Hometown State: <INPUT type=\"text\" name=\"state\" required><BR>
	Interest: <INPUT type=\"text\" name=\"interests\" required><BR>
	<select name=\"privacy\">
		<option value=\"High\">High Privacy</option>
		<option value=\"Medium\">Medium Privacy</option>
		<option value=\"Low\">Low Privacy</option>
	</select><BR>
	Email: <INPUT type=\"email\" name=\"email\" required><BR>
	Birthyear: <INPUT type=\"number\" size=\"4\" min=\"1800\" name=\"birthyear\" required><BR>
	<INPUT type= \"submit\" name=\"btnSubmit\" value=\"Register\" required> </FORM>"
);
} elseif(!isset($_SESSION['valid_user'])) {//else we echo the userName and password

	if(!isset($_SESSION['valid_user'])){
		$userName = $_POST["userName"];
		$password = $_POST["password"];
		$city = $_POST["city"];
		$state = $_POST["state"];
		$interests = $_POST["interests"];
		$privacy = $_POST["privacy"];
		$birthyear = $_POST["birthyear"];
		$email = $_POST["email"];


		// Connecting and selecting database
		$connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
		//mysql_select_db("soullie7");
		$db_selected = mysql_select_db('soullie7', $connection);
		if (!$db_selected) {
		    die ('Can\'t use soullie7 : ' . mysql_error());
		}
			echo ("Connected successfully <BR>");

			// Performing SQL query
			$check_query = "select count(*) from logintable where user ='$userName'";
			$check_result = mysql_query($check_query) or die("Check query failed: " . mysql_error());
			$check_row = mysql_fetch_row($check_result);
		if($check_row[0] == 1){
		echo("User with that name already exists");
		mysql_close($connection);
		} else {
			$query = "insert into logintable(user, password, email, birthyear, home_city, home_state, privacy, interests) 
				values('$userName','$password','$email','$birthyear','$city','$state','$privacy', '$interests')";
			mysql_query($query) or die("Query failed: " . mysql_error());
			$_SESSION['valid_user'] = $userName;
			echo ("Registration Successful");
			mysql_close($connection);
		}
	}
}


?>
<a href="login.php">Back to login</a>
</BODY>
</HTML>

