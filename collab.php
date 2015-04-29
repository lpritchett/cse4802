<? session_start();
$user = $_SESSION["valid_user"];
$projId = $_GET["projId"];
$accept = $_GET["accept"];
$connection=mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
        mysql_select_db("soullie7");
	if($accept == 1){
		$query = "update Invitation set status = 1 where ProjId = $projId and collaboratorId = '$user'";
		mysql_query($query);
		echo '<H2>Accepted Project</H2>';
	} else {
		$query = "delete from Invitation where ProjId = $projId and collaboratorId = '$user'";
		mysql_query($query);
		echo '<H2>Denied Project</H2>';
	}
	
	
echo '<a href="befriend.php">Friends Page</a>';
?>
