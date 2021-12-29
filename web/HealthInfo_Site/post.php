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

if(isset($_GET['id'])){ //글 클릭시 id도 전달
	$id=$_GET['id'];
}

$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
$content=mysqli_fetch_array(mysqli_query($conn,"SELECT *FROM posts WHERE id=$id"));

if(isset($_POST['submit'])){ //댓글 구현
	if(empty($_POST['text'])){
			echo "<script>alert('Please fill it comment !')</script>";
	}else{
		$text=$_POST['text'];
		if($user){
			$userN=$user;
		}
		if($admin){
			$userN=$admin;
		}
		$comment="INSERT INTO comments VALUES (NULL,'$userN','$text','$id')";
		if(!mysqli_query($conn,$comment)){
				echo "Problem in uploading comment !.".mysqli_error($conn);
		}
	}
}
$comments=mysqli_query($conn,"SELECT *FROM comments WHERE postId=$id");
?>

<html>
<head>
	<title>Post view</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
<h1 class="title"> View Post </h1>
<h2 class="minititle"><a href="content.php"> Content Page </a></h2>
<div class='posts' style="width:40%;text-align: left; padding: 20px;">
<?php
	echo "<h2>[".$content['title']."]<br></h2><hr>";
	echo "Uploader: ".$content['user']."&nbsp&nbsp&nbsp";
	if($user==$content['user']||$admin){
		echo "<div class='link'><a href='post_edit.php?id=".$id."'>[Edit]</a></div>";
		echo "&nbsp&nbsp<div class='link'><a href='delete.php?id=".$id."'>[Delete]</a></div>";
	}
	echo "<br><img src='get.php?id=$id' width='500px'><br>";
	echo "<pre>".$content['content']."</pre><br>";
?>
<hr>
<div class='comments'><b>[Comment]</b>
<?php 
	while($comment=mysqli_fetch_array($comments)){
		echo "<div class='comment'>".$comment['user'];
		if($user==$comment['user']||$admin){
			echo "&nbsp&nbsp&nbsp";
			echo "<a href='delete_comment.php?id=".$comment["id"]."&pid=".$id."'>[Delete]</a>";
		}
		echo "<br>".$comment['content']."</div><br>";
	}
?>
<form action="post.php?id=<?=$id?>" method="post">
	<div class="comment"><input type="text" name="text" style="width:95%;margin:5px;height:30px;"><br>
	<label style="margin-left: 70%;">
		<input type="submit" name="submit"value="Comment Upload" style="padding:5px;margin:5px;">
	</label>
	</div>
</form>
</div>
</body>
</html>