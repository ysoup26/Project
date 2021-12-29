<?php
$id=$_GET['id'];
$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
mysqli_query($conn,"DELETE FROM posts WHERE id=$id");
mysqli_query($conn,"DELETE FROM images WHERE postId=$id");
mysqli_close($conn);
header("Location: content.php");
?>