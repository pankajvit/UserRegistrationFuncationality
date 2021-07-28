<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover your mail</title>
</head>
<body>
    <?php
    include 'dbcon.php';
    if(isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $emailquery = "select * from registration where email = '$email'";
        $query = mysqli_query($con, $emailquery);

        $emailcount = mysqli_num_rows($query);
        if($emailcount) {
            $userdata = mysqli_fetch_array($query);
            $username = $userdata['name'];
            $token = $userdata['token'];
            $subject = "Password Reset";
            $body = "Hi, $username. Click here to reset your password
                    http://localhost/email_validation/reset_password.php?token=$token";
            $sender_email = "From: pankaj.kumar18@vit.edu";
            if(mail($email, $subject, $body, $sender_email)) {
                $_SESSION['msg']="check your mail to reset your password $email";
                    header('location:login.php');
            } else {
                            echo "Email sending failed...";
                    }
        }else {
            echo "No email found";
        }
    }
    ?>
    <h1>Recover Your Account</h1>
    <p>Please fill email id properly</p>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="email" name="email" placeholder="Email address" required/><br>
        <input type="submit" name="submit" value="Sent email"/>
    </form>
    <h6>Have an account? <a href="login.php">Login here</a></h6>
</body>
</html>
