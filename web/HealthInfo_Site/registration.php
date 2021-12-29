<!DOCTYPE html>
<?php
session_start();

$conn=mysqli_connect("localhost","root","","users_db") or die(mysqli_connect_error());

if(isset($_POST['submit'])){
    if(empty($_POST['name'])||empty($_POST['pass'])||empty($_POST['email'])){
        echo "<script>alert('Please enter all required field !')</script>";
    }else{
        $user=$_POST['name'];
        $pass=$_POST['pass'];
        $email=$_POST['email'];
        $query="SELECT * FROM users WHERE name='$user' OR email='$email'";
        $result=mysqli_query($conn,$query); 

        if (mysqli_num_rows($result) > 0) {
            header("Location: registration.php?MSG=Username:$user or E-mail:$email is already exist, Please use another one!");
        }else{
            $query="INSERT INTO users (name,pass,email) VALUES ('$user','$pass','$email')";
            if(mysqli_query($conn,$query)){
                $_SESSION['login']=$user;
                header("Location: content.php");
            }else{
                echo "SQL insert error !";
            }
        }
    }

}
mysqli_close($conn);

?>
<html>
<head>
    <title>Registration Page</title>
    <link href="site_style.css" type="text/css" rel="stylesheet">
</head>
<body>
    <h1 class="title"> WE&Heal</h1><br>
    <?php
        if(isset($_GET['MSG'])){
            echo "<b>".$_GET['MSG']."</b>";
        }
    ?>
    <form action="registration.php" method="post">
    <table align="center" style="width: 30%">
        <tr> <th colspan="2">Registration</th> </tr>
        <tr> <td>Username</td>
             <td><input type="text" name="name"></td> </tr>
        <tr> <td>Password</td>
             <td><input type="password" name="pass"></td> </tr>
        <tr> <td>E-mail</td>
             <td><input type="text" name="email"></td> </tr>
        <tr> <td colspan="2"><input type="submit" name="submit" value="registration"> </td></tr>
    </table>
    <p>Go back login page? <b><a href="login.php">Back To Login</a></b>
    </form>
</body>
</html>