<? session_start();
$user = $_GET["valid_user"];
$projId = $_GET["projId"];
$connection=mysql_connect("mysql-user.cse.msu.edu", "soullie7", "Jeff74094");
        mysql_select_db("soullie7");
	if($projId == 1){
		$query = "update Invitation set status = 1, where ProjId = $projId and 
	} else {
	
	}
	echo '<H2>Accepted Project</H2>';
echo '<a href="befriend.php">Friends Page</a>';
?>
