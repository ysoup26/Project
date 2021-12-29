<!DOCTYPE html>
<?php
session_start();
if(isset($_SESSION['login'])){
	$user=$_SESSION['login'];
	$admin='';
}elseif(isset($_SESSION['admin_login'])){
	$admin=$_SESSION['admin_login'];
	$user='';
}else
	header("Location: login.php");

if(isset($_GET['id'])){
	$id=$_GET['id'];
}	
$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
$content=mysqli_fetch_array(mysqli_query($conn,"SELECT *FROM posts WHERE id=$id"));

if(isset($_POST['submit2'])){
	if(empty($_POST['title'])){
		echo "<h2>Please fill it title !<h2/>";		
	}else{
		$title=$_POST['title'];
		$topic=$_POST['topic'];
		$text=$_POST['text'];
		$id=$content['id'];
		
		if(!empty($_FILES['image']['name'])){
			$image_name=addslashes($_FILES['image']['name']);
			$image_data=addslashes(file_get_contents($_FILES['image']['tmp_name']));
			$image_size=getimagesize($_FILES['image']['tmp_name']);
			if($image_size==FALSE){
				echo "<h2>That's not an image file. </h2>";
			}else{
				$sql="UPDATE images SET name='$image_name',data='$image_data'WHERE postId='$id'";
				if(!mysqli_query($conn,$sql)){
					echo "Problem in uploading image !.".mysqli_error($conn);
				}
			}
		}
		$query="UPDATE posts SET topic='$topic',title='$title',content='$text' WHERE id='$id'";
		if(mysqli_query($conn,$query)){
			header("Location: post.php?id=$id");
		}else{
			echo "SQL edit Error !";
		}
	}
}
	
?>
<html>
<head>
	<title>Post Edit</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
	<h1 class="title">Post Edit</h1>
	<h2 class="minititle"><a href="content.php"> Content Page </a></h2>
	<table align="center">
	<form action="post_edit.php?id=<?=$id?>" method="POST" enctype="multipart/form-data">
		<tr>
			<th>Topic : </th> <td><input type="radio" name="topic" value="free" checked>free
								  <input type="radio" name="topic" value="health">health
								  <input type="radio" name="topic" value="mind">mind<br></td></tr>
		<tr>
			<th>Title : </th> <td><input type="text" name="title"value="<?=$content['title']?>"><br></td></tr>
		<tr>
			<td colspan="2"><?="<img src='get.php?id=$id' width='500px'>";?><br></td>	
		<tr>
			<th>Image file : </th> <td><input type="file" name="image"><br></td></tr>
		<tr>
			<th>Text : </th> <td><textarea rows=15 cols=70 name="text"><?=$content['content']?></textarea><br></td></tr>
		<tr>
			<th><a href='post.php?id=<?=$id?>' style="color:red;">Cancle</th>
			<td><input type="submit" name="submit2" value="Upload"></a></td></tr>
	</form>
	</table>
</body>
</html>