<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['login']))
	header("Location: content.php");

	$conn=mysqli_connect("localhost","root","","users_db") or die(mysqli_connect_error());
	$name=$_SESSION['login'];
	$query="SELECT *FROM users WHERE name='$name'";
	$userDB=mysqli_fetch_assoc(mysqli_query($conn,$query));
	$pass=$userDB['pass'];
	$email=$userDB['email'];

if(isset($_POST['submit'])){
    $pass=$_POST['change_pass'];
    $email=$_POST['change_email'];
    if(empty($_POST['change_pass'])||empty($_POST['change_email'])){
        echo "<script>alert('Please enter all required field !')</script>";
    }else{
        $query="UPDATE users SET pass='$pass',email='$email' WHERE name='$name'";
        if(mysqli_query($conn,$query)){
            echo "<script>alert('Changed !')</script>";
        }else{
          	echo "SQL Error !";
        }
    }
}
mysqli_close($conn);

?>
<html>
<head>
	<title>User Inform Change</title>
    <link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body style="text-align: center">
    <h1 class="title">My Inform Change</h1><br>
    <form action="user_change.php" method="post">
    <table align="center">
        <tr> <th colspan="2">Current info</th> 
             <th colspan="2">Change info </th></tr>
        <tr> <td>Username</td>
             <td><?=$name?></td>
             <td>Username</td>
             <td><?=$name?></td></tr>
        <tr> <td>Password</td>
             <td><?=$pass?></td> 
             <td>Password</td>
             <td><input type="password" name="change_pass"></td></tr>
        <tr> <td>E-mail</td>
             <td><?=$email?></td>
             <td>E-mail</td>
             <td><input type="text" name="change_email"></td></tr>
        <tr> <td colspan="4"><input type="submit" name="submit" value="change"></td> </tr>
    </table>
    </form><br>
<b> <a href="content.php"> Go back </a> </b>
</body>

</html>