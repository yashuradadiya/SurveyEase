<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

require 'config.php';

/**
 * [php mailer object]
 * @param [string] $email,[email address]
 * @param [string] $subject,[email's subject]
 * @param [string] $message,[email's message]
 * @return [string] [Error message, or success]
 */
function sendMail($email, $subject, $message) {
    $msg = '';
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = MAILHOST;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom(SEND_FROM, SEND_FROM_NAME);
        $mail->addAddress($email);
        $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;

        // Send email
        if ($mail->send()) {
            return 'true';
        } else {
            @$msg = "Something went wrong while sending the email.";
            return $msg;
        }
    } catch (Exception $e) {
        // Catch PHPMailer exceptions and handle the error
        @$msg = "Something went wrong: " . $e->getMessage();
        return $msg;
    }
}
?>
