<!DOCTYPE html>
<?php
session_start();

$conn=mysqli_connect("localhost","root","","users_db") or die(mysqli_connect_error());

if(isset($_POST['submit'])){
	if(empty($_POST['name']))
		echo "<script>alert('Please enter your name !')</script>";
	if(empty($_POST['pass']))
		echo "<script>alert('Please enter password !')</script>";
	$user=$_POST['name'];
	$pass=$_POST['pass'];
	$query = "SELECT name, pass FROM users WHERE name='$user' AND pass='$pass' ";
	$result = mysqli_query($conn,$query);
    if ( mysqli_num_rows($result) > 0 ) {
       $_SESSION['login']=$user;
       header("Location: content.php");
    }else {
       echo "Wrong username or password !";
    }
}
mysqli_close($conn);

?>
<html>
<head>
	<title>Login Page</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
<h1 class="title"> WE&Heal </h1><br>
	<form action="login.php" method="post">
	<table align="center" style="width: 30%">
		<tr> <th colspan="2">Login</th> </tr>
		<tr> <td>Username</td>
			 <td><input type="text" name="name"></td> </tr>
		<tr> <td>Password</td>
			 <td><input type="password" name="pass"></td> </tr>
		<tr> <td colspan="2"><input type="submit" name="submit" value="Login"> </td></tr>
	</table>
	</form>
	<p>Not registered yet? <b><a href="registration.php">Registration</a></b></p> 
	<p>You are Admin? <b><a href="admin_login.php">Admin Login</a></b></p>
</body>
</html>