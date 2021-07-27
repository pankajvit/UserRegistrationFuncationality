<?php 
    session_start();
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
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $cpassword = mysqli_real_escape_string($con, $_POST['re-password']);

        $pass = password_hash($password, PASSWORD_BCRYPT);
        $cpass = password_hash($cpassword, PASSWORD_BCRYPT);

        $token = bin2hex(random_bytes(15));


        $emailquery = "select * from registration where email = '$email'";
        $query = mysqli_query($con, $emailquery);
        $emailcount = mysqli_num_rows($query);

        if($emailcount > 0) {
            echo "email already exists";
        } else {
            if($password === $cpassword) {
                $insertquery = "insert into registration(name, email, mobile, password, cpassword, token, status) values ('$username', '$email','$mobile','$pass','$cpass', '$token', 'inactive')";
                $iquery = mysqli_query($con,$insertquery);
                if($iquery) {
                    $subject = "Email Activation";
                    $body = "Hi, $username. Click here to activate your account
                    http://localhost/email_validation/activate.php?token=$token";
                    $sender_email = "From: pankaj.kumar18@vit.edu";
                    if(mail($email, $subject, $body, $sender_email)) {
                        $_SESSION['msg']="check your mail to activate your account $email";
                        header('location:login.php');
                    } else {
                            echo "Email sending failed...";
                        }
                    } else {
                    ?>
                        <script>
                            alert("No insertion of data");
                        </script>
                    <?php
                    }
            }else {
                ?>
                    <script>
                        alert("Password are not matching");
                    </script>
                <?php
            }
        }
    }
    ?>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="text" name="username" placeholder="Full name" required/><br>
        <input type="email" name="email" placeholder="Email address" required/><br>
        <input type="text" name="mobile" placeholder="Phone number" required/><br>
        <input type="password" name="password" placeholder="Create password" required/><br>
        <input type="password" name="re-password" placeholder="Repeat password" required/><br>
        <input type="submit" name="submit" value="Create Account"/>
    </form>
    <p> Have an account ? </p> <a href="login.php">Log in</a>
</body>
</html>