<? session_start();
$sender = $_GET["toRemove"];
 $connection=mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
        mysql_select_db("soullie7");
        $user = $_SESSION['valid_user'];
        $query = "delete from friend where (sender='$sender' and recipient='$user') or (sender='$user' and recipient='$sender')";
        mysql_query($query) or die("Query failed: ".mysql_error());
        echo '<H2>Friend Removed</H2>';
echo '<a href="befriend.php">Friends Page</a>';
?>
