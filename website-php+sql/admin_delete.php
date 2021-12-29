<?php
session_start();
if(isset($_SESSION['admin_login'])){
	$id=$_GET['id'];
	$conn=mysqli_connect('localhost','root','','users_db');
	if(mysqli_query($conn,"DELETE FROM users WHERE id='$id'")){
		header("Location:admin_users.php");
	}else{
		header("Location:admin_login.php");
	}
}else{
	header("Location:admin_login.php");
}

?>