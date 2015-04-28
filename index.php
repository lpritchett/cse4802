<?php
session_start();
if(isset($_SESSION['valid_user'])){
	echo '<p>You are logged in as ' .$_SESSION['valid_user'].'</p>';
} else {
	echo '<p> failed</p>';
}
?>



