<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['login'])){
	$user=$_SESSION['login'];
}elseif(isset($_SESSION['admin_login'])){
	$user=$_SESSION['admin_login'];
}else
	header("Location: login.php");

$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
?>
<html>
<head>
	<title> Post Uploading</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
	<h1 class="title">Post Upload</h1>
	<h2 class="minititle"><a href="content.php"> Content Page </a></h2>
	<table align="center">
	<form action="upload.php" method="POST" enctype="multipart/form-data">
		<tr>
			<th>Topic : </th> <td><input type="radio" name="topic" value="free" checked>free
								  <input type="radio" name="topic" value="health">health
								  <input type="radio" name="topic" value="mind">mind<br></td></tr>
		<tr>
			<th>Title : </th> <td><input type="text" name="title"><br></td></tr>
		<tr>
			<th>Image file : </th> <td><input type="file" name="image"><br></td></tr>
		<tr>
			<th>Text : </th> <td><textarea rows=20 cols=70 name="text"></textarea><br></td></tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Upload"></td></tr>
	</form>
	</table>
	<?php
	if(isset($_POST['submit'])){
		if(empty($_FILES['image']['name'])||empty($_POST['title'])){
			echo "<h2>Please select an image !<h2/>";
		}else{
			$image_name=addslashes($_FILES['image']['name']);
			$image_data=addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_size=getimagesize($_FILES['image']['tmp_name']);
			
			$title=$_POST['title'];
			$topic=$_POST['topic'];
			if(empty($_POST['text'])){
				$text="";
			}else{
				$text=$_POST['text'];
			}
			if($image_size==FALSE){
				echo "<h2>That's not an image file. </h2>";
			}else{
				$sql="INSERT INTO posts (user,topic,title,content) VALUES ('$user','$topic','$title','$text')";
				mysqli_query($conn,$sql);
				$posts=mysqli_query($conn,"SELECT *FROM posts WHERE user='$user' AND content='$text'");
				$post=mysqli_fetch_array($posts);
				$id=$post['id'];
				$sql="INSERT INTO images VALUES (NULL,'$image_name','$image_data','$id')";
				if(!mysqli_query($conn,$sql)){
					echo "Problem in uploading image !.".mysqli_error($conn);
				}else{
					echo "<h2> You are post is Uploaded !</h2>";
					echo "<img src='get.php?id=$id' style='width:500px'>";
				}
			}
		}
	}
	mysqli_close($conn);
	?>
</body>
</html>