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
    <title>login</title>
</head>
<body>
    <?php
        include 'dbcon.php';
        if(isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $email_search = "select * from registration where email = '$email' and status ='active'";
            $query = mysqli_query($con,$email_search);

            $email_count = mysqli_num_rows($query);

            if($email_count) {
                $email_pass = mysqli_fetch_assoc($query);
                $db_pass=$email_pass['password'];
                $_SESSION['username'] = $email_pass['name'];
                $pass_decode=password_verify($password, $db_pass);
                if($pass_decode) {
                    if(isset($_POST['rememberme'])) {
                        setcookie('emailcookie',$email,time()+86400);
                        setcookie('passwordcookie',$password,time()+86400);
                        header('location:home.php');
                    } else {
                        header('location:home.php');
                    }
                    echo "login successful";
                    ?>
                        <script>
                            location.replace('home.php');
                        </script>
                    <?php
                } else {
                    echo "password Incorrect";
                }
            } else {
                echo "Invalid Email";
            }
        }
    ?>
    <div>
        <p> 
        <?php
            if(isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
            } else {
                echo $_SESSION['msg'] = "You are logged Out. Please login again !";
            }
        ?>
        </p>
    </div>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="text" name="email" placeholder="Email ID" value="<?php if(isset($_COOKIE['emailcookie'])) {
            echo $_COOKIE['emailcookie'];
        } ?>"/><br>
        <input type="password" name="password" placeholder="Password" value="<?php if(isset($_COOKIE['passwordcookie'])) {
            echo $_COOKIE['passwordcookie'];
        } ?>"/><br>
        <input type="checkbox" name="rememberme">Remember me<br>
        <input type="submit" name="login" value="Login Now"/>
    </form>
    <h1>Not Have an account ?</h1><a href="#">SignUp Here</a>
</body>
</html>