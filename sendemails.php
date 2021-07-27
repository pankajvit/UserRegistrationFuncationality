<?php
$to_email = "pankajvitmca@gmail.com";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is test email send by PHP Script in 2020 from Youtube";
$headers = "From: pankaj.kumar18@vit.edu";

if(mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully send to $to_email....";
} else {
    echo "Email sending failed...";
}
?>