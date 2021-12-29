<?php
$id=$_REQUEST['id'];
$conn=mysqli_connect("localhost","root","","my_db") or die(mysqli_connect_error());
$image=mysqli_query($conn,"SELECT *FROM images WHERE postId='$id'");
$image=mysqli_fetch_assoc($image);
$image=$image['data'];
echo $image;
?>