<?php 
    session_start();
    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input form</title>
</head>
<body>
    <?php
    include 'dbcon.php';
    if(isset($_POST['submit'])) {
        if(isset($_GET['token'])) {
        $token=$_GET['token'];

        $newpassword = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['re-password']);

        $pass = password_hash($newpassword, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);
        
        if($newpassword === $cpassword) {
            $updatequery = "update registration set password='$pass' where token='$token' ";
            $iquery = mysqli_query($con,$updatequery);
                if($iquery) {
                    $_SESSION['msg'] = "Your Password has been updated";
                    header('location:login.php');
                } else {
                    $_SESSION['passmsg'] = "Your password is not updated";
                    header('location:reset_password.php');
                }
        } else {
            $_SESSION['passmsg'] = "Password is not matching";
            // echo "Password are not matching";
        }
    } else {
        echo "No token found";
    }
    }
    ?>
    <p> <?php
        if(isset($_SESSION['passmsg'])) {
            echo $_SESSION['passmsg'];
        } else {
            echo $_SESSION['passmsg'] = "";
        }
        ?> 
    </p>
    <form action="" method="POST">
        <input type="password" name="password" placeholder="New password" required/><br>
        <input type="password" name="re-password" placeholder="confirm password" required/><br>
        <input type="submit" name="submit" value="Update Password"/>
    </form>
    <p> Have an account ? <a href="login.php">Log in</a></p> 
</body>
</html>