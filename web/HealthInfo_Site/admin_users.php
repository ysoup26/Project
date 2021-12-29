<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['admin_login'])){
	header("Location:admin_login.php");
}
$conn=mysqli_connect('localhost','root','','users_db');
$users=mysqli_query($conn,"SELECT *FROM users");

mysqli_close($conn);
?>
<html>
<head>
	<title>Admin User Page</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
	<h1 class="title"> Admin Panel for Users Management</h1><br>
	<table align="center">
		<tr><th>id</th><th>name</th><th>password</th><th>E-mail</th><th>Change</th><th>Delete?</th>
		<?php
		while($user=mysqli_fetch_array($users)){
			echo "<tr>";
			echo "<td>".$user['id']."</td>";
			echo "<td>".$user['name']."</td>";
			echo "<td>".$user['pass']."</td>";
			echo "<td>".$user['email']."</td>";
			echo "<td><a href='admin_change.php?id=".$user['id']."'>[Change]</a></td>";
			echo "<td><a href='admin_delete.php?id=".$user['id']."'>[Delete]</a></td>";
			echo "</tr>";
		}
		?>	
	</table>
	<br>
	<a href="content.php"><b>Go site</b></a>&nbsp&nbsp
	<a href="admin_logout.php"><b>Logout</b></a>
</body>
</html>