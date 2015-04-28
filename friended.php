<? session_start();
$sender = $_GET["sender"];
 $connection=mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
        mysql_select_db("soullie7");
        $user = $_SESSION['valid_user'];
        $query = "update friend set is_accepted=1 where sender='$sender' and recipient='$user'";
	mysql_query($query) or die("Query failed: ".mysql_error());
	echo '<H2>Added Friend</H2>';
echo '<a href="befriend.php">Friends Page</a>';
?>
