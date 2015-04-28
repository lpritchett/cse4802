<?session_start()?>
</HEAD>
<BODY>
<H2>Edit Profile</H2>
<a href="befriend.php">Friends Page</a>
<br>
<a href="logout.php">Logout</a>

<br>
<?


if (!isset($_POST['btnSubmit'])&&isset($_SESSION['valid_user'])) { // if page has not been submitted, we echothm
         $connection = mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094") or die("Could not connect: " . mysql_error());
         $db_selected = mysql_select_db('soullie7', $connection);
        $curr_user = $_SESSION['valid_user'];
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
        );
        if($privacy = "High")
        {
            echo("<option selected=\"selected\" value=\"High\">High Privacy</option>
             <option value=\"Medium\">Medium Privacy</option>
             <option value=\"Low\">Low Privacy</option>");
        }
       if($privacy = "Medium")
        {
            echo("<option value=\"High\">High Privacy</option>
             <option selected=\"selected\" value=\"Medium\">Medium Privacy</option>
             <option value=\"Low\">Low Privacy</option>");
        }
       if($privacy = "Low")
        {
            echo("<option  value=\"High\">High Privacy</option>
             <option value=\"Medium\">Medium Privacy</option>
             <option selected=\"selected\" value=\"Low\">Low Privacy</option>");
        }

        echo("</select><BR>
        Email: <INPUT value=\"$email\" type=\"email\" name=\"email\" required><BR>
        Birthyear: <INPUT value=\"$birthyear\" type=\"number\" size=\"4\" min=\"1800\" name=\"birthyear\" required><BR>
        <INPUT type= \"submit\" name=\"btnSubmit\" value=\"Edit\" required> </FORM>"
);
} else {//else we echo the userName and password

        
                $userName = $_SESSION['valid_user']; 
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
		
$query = "update logintable set password='$password', interests='$interests', email='$email', birthyear='$birthyear', home_city='$city', home_state='$state', privacy='$privacy' where user='$userName'";
                        mysql_query($query) or die("Query failed: " . mysql_error());
                        mysql_close($connection);
		echo '<h2>Successfully Updated</h2>';
		

	

}

?>
</BODY>
</HTML>

