<!DOCTYPE html>
<?php
session_start();

$conn=mysqli_connect("localhost","root","","users_db") or die(mysqli_connect_error());

if(isset($_POST['submit'])){
	$name=$_POST['name'];
    $pass=$_POST['pass'];
	$result=mysqli_query($conn,"SELECT name,pass FROM admin WHERE name='$name' AND pass='$pass'");
	if(mysqli_num_rows($result) > 0){
		$_SESSION['admin_login']=$name;
		header("Location: admin_users.php");
	}else{
		echo "Wrong Login Info!";
	}
}
mysqli_close($conn);
?>

<html>
<head>
	<title>Admin Login Page</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body style="text-align: center;">
	<h1 class="title"> WE&Heal</h1><br>
	<form action="admin_login.php" method="post">
	<table align="center" style="width: 30%">
		<tr> <th colspan="2">Admin Login</th> </tr>
		<tr> <td>Admin Name</td>
			<td><input type="text" name="name"></td> </tr>
		<tr> <td>Admin Pass</td>
			<td><input type="password" name="pass"></td> </tr>
		<tr> <td colspan="2"><input type="submit" name="submit" value="Admin Login"> </td></tr>
	</table>
	</form>
	<p> <b><a href="login.php" align="right"> Go back </a></b> </p>
</body>
</html>