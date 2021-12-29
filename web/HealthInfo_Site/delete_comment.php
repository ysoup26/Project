<?php
$id=$_GET['id'];
$pid=$_GET['pid'];
$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
mysqli_query($conn,"DELETE FROM comments WHERE id=$id");
mysqli_close($conn);
header("Location: post.php?id=$pid");
?>