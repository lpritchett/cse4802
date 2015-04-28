<?php
$Name = $_POST["name"];
if (!isset($_POST['submit'])) { 
?>
<html>
<body>
<form method="post" action="<?php echo $PHP_SELF;?>">
Enter your name: <input type="text" name="name"><br />
<input type="submit" value="submit" name="submit">
</form>
<?php
} else {
echo "Hello, ".$Name.". Welcome to CSE 491/891<br />";
}
?>
