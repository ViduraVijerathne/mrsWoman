<?php


use PHPMailer\PHPMailer\PHPMailer;

require_once "SMTP.php";
require_once "Exception.php";
require_once "PHPMailer.php";
function sendEmail($body,$title ,$email)
{
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'bimalsha0dinuwan@gmail.com';
    $mail->Password = 'pldphsujrbzeyeml';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('MsWoman', $title);
    $mail->addReplyTo('MsWoman', $title);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Your Order is Being Shipped!(Test)';

    $bodyContent = $body;

    $mail->Body = $bodyContent;

    $mail->send();


}
sendEmail("helloword","viduranox@gmail.com");
?>