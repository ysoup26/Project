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
	<title>Content Page</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
	<style>
		a {color: black}
	</style>
</head>
<body>
<h1 class='title'><a href="content.php"> WE&Heal </a></h1>
<ul class="menus">
	<li class="menu" ><a href="search_post.php">Search Post</a></li><br>
	<li class="menu"><a href="content.php?topic=health">Health</a></li><br>
	<li class="menu"><a href="content.php?topic=mind">Mind</a></li><br>
	<li class="menu"><a href="upload.php">Upload Post</a></li><br>
	<li class="menu"><a href="content.php?self=<?=$user?>">My Post</a></li>
</ul>
<div class="pop">
<h2> Welcome <?=$user?>!</h2>
<div class='link'>
<?php
	if(isset($_SESSION['admin_login'])){
		echo "<a href='admin_users.php'>";
	}else{
		echo "<a href='user_change.php'>";
	}
?>[Inform change]</a></div><br>
   <div class="link"><a href="logout.php">[Logout]</a></div></div>
<div class="pop" style="margin-top: 350px;">
<h2> -Notification- </h2>
<p>You can freely share health information.<br>
   Please respect the users and use it.</p>
</div>


<?php
if(isset($_GET['topic'])||isset($_GET['self'])){ //주제 or 개인글 보기
	if(isset($_GET['topic'])){
		$topic=$_GET['topic'];
		$contents=mysqli_query($conn,"SELECT *FROM posts WHERE topic='$topic'");
	}
	if(isset($_GET['self'])){
		$topic=$_GET['self'];
		$contents=mysqli_query($conn,"SELECT *FROM posts WHERE user='$topic'");
	}
	echo "<div class='posts'>";
	echo "<h2 class='subtitle'>".$topic." post</h2><hr>";
	while($content=mysqli_fetch_array($contents)){
		if($content){
			echo "<div class='post'><a href='post.php?id=".$content['id']."'>";
			echo "<img src='get.php?id=".$content['id']."'><br>";
			echo $content['title'];
			echo "</a></div>";
		}
	}
	echo "</div>";
}else{
	echo "<div class='posts'>";
	echo "<h2 class='subtitle'>All post</h2><hr>";
	$contents=mysqli_query($conn,"SELECT *FROM posts");
	while($content=mysqli_fetch_array($contents)){
		if($content){
			echo "<div class='post'><a href='post.php?id=".$content['id']."'>";
			echo "<img src='get.php?id=".$content['id']."'><br>";
			echo $content['title'];
			echo "</a></div>";
		}
	}
	echo "</div>";
}
?>
</body>
</html>