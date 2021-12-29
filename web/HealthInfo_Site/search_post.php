<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['login'])&& !isset($_SESSION['admin_login'])){
	header("Location: content.php");
}
if(isset($_GET['text'])){
	if(empty($_GET['text'])){
		header("Location: search_post.php");
	}else{
		$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
		$text=$_GET['text'];//user이름, topic, content 선택 가능
	}
}
?>
<html>
<head>
	<title>Search Post</title>
	<link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
<h1 class="title"> Search Post </h2>
<h2 class="minititle"><a href="content.php"> Content Page </a></h2>
<ul class="menus">
	<li class="menu" ><a href="search_post.php?text=<?=$text?>">All</a></li><br>
	<li class="menu"><a href="search_post.php?text=<?=$text?>&view=user">User</a></li><br>
	<li class="menu"><a href="search_post.php?text=<?=$text?>&view=ticont">Title&content</a></li>
</ul>
<div class='posts'>
<h3><form action="search_post.php?view=all&" method="get">
	검색 : <input type="text" name="text">
	<input type="submit" name="submit" value="search">
</form></h3><hr>
<?php //항목별로 분류해서 보는기능
if(isset($_GET['text'])){
	$posts=mysqli_query($conn,"SELECT *FROM posts"); 
	$find=0;
	if(!isset($_GET['view'])){
		while($post=mysqli_fetch_array($posts)){
				$post_user=$post['user'];
				$post_title=$post['title'];
				$post_text=$post['content'];
				if(strpos($post_user,$text)!==false||strpos($post_title,$text)!==false||strpos($post_text,$text)!==false){
					$id=$post['id'];
					echo "<div class='post'><a href='post.php?id=$id'>";
					echo "<img src='get.php?id=$id'><br>";
					echo $post['title']."</a></div>";
					$find++;
				}
		}
	}else{
		if($_GET['view']=="user"){
			while($post=mysqli_fetch_array($posts)){
				$post_user=$post['user'];
				$post_title=$post['title'];
				$post_text=$post['content'];
				if(strpos($post_user,$text)!==false){
					$id=$post['id'];
					echo "<div class='post'><a href='post.php?id=$id'>";
					echo "<img src='get.php?id=$id'><br>";
					echo $post['title']."</a></div>";
					$find++;
				}
			}
		}
		if($_GET['view']=="ticont"){
			while($post=mysqli_fetch_array($posts)){
				$post_user=$post['user'];
				$post_title=$post['title'];
				$post_text=$post['content'];
				if(strpos($post_title,$text)!==false||strpos($post_text,$text)!==false){
					$id=$post['id'];
					echo "<div class='post'><a href='post.php?id=$id'>";
					echo "<img src='get.php?id=$id'><br>";
					echo $post['title']."</a></div>";
					$find++;
				}			
			}
		}
	}
	if($find==0){
			echo "'".$text."'에 대한 내용을 찾을 수 없습니다.";
	}
}
?>
</div>
</body>
</html>