<!-- login.php -->
<?php
session_start();
if($_POST['username'] && $_POST['password']) {
  $_SESSION['username'] = $_POST['username'];
}
header("Location: index.php");
?>
