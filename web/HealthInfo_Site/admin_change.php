<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['admin_login']))
	header("Location: content.php");

$conn=mysqli_connect("localhost","root","","users_db") or die(mysqli_connect_error());

if(isset($_GET['id'])){
	$id=$_GET['id'];
		
	$query="SELECT *FROM users WHERE id='$id'";
	$userDB=mysqli_fetch_assoc(mysqli_query($conn,$query));
	$name=$userDB['name'];		
	$pass=$userDB['pass'];
	$email=$userDB['email'];
}

if(isset($_POST['submit'])){
    if(empty($_POST['change_pass'])){
        echo "<script>alert('Please enter pass field !')</script>";
    }else{
        $pass=$_POST['change_pass'];
        $query="UPDATE users SET pass='$pass' WHERE id='$id'";
        if(mysqli_query($conn,$query)){
            echo "<script>alert('Info Change !')</script>";
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
<body>
	<h1 class="title">User Inform Change</h1><br>
    <form action="admin_change.php?id=<?=$id?>>" method="post">
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
             <td><?=$email?></td> </tr>
        <tr> <td colspan="4"><input type="submit" name="submit" value="change"></td> </tr>
    </table>
	</form><br>
<b> <a href="admin_users.php"> Go back </a> </b>
</body>
</html>