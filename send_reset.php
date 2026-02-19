<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once("database.php");
require_once("message.php"); // your mail function file

$email = filter_input(INPUT_POST, 'email_Address');

if ($email == null || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "Invalid email address. Check all fields and try again.";
    header("Location: forgot_password.php");
    exit();
}

//Check if email exists
$query = "SELECT * FROM registration WHERE emailAddress = :email";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();

if (!$user) {
    $_SESSION['message'] = "If the email exists, a reset link has been sent to it.";
    header("Location: forgot_password.php");
    exit();
}

// Generate reset token
$token = bin2hex(random_bytes(32));

// Expiry time (30 minutes from now)
$expiry = date("Y-m-d H:i:s", strtotime('+30 minutes'));

// Save token and expiry
$update = "UPDATE registration 
           SET resetToken = :token, resetExpires = :expiry 
           WHERE emailAddress = :email";

$statement = $db->prepare($update);
$statement->bindValue(':token', $token);
$statement->bindValue(':expiry', $expiry);
$statement->bindValue(':email', $email);
$statement->execute();
$statement->closeCursor();

// Create reset link
$reset_link = "http://localhost/PHPAssignment1/reset_password.php?token=$token";

// Send email
$to_address = $email;
$to_name = $user['userName'];
$from_address = "YOUR_USERNAME@gmail.com"; // Change to your email
$from_name = "PHPAssignment1";
$subject = "Password Reset Request";
$body = "<p>Click the link below to reset your password:</p>" .
        "<p><a href='$reset_link'>$reset_link</a></p>" .
        "<p>This link will expire in 30 minutes.</p>";

$is_body_html = true;

try {
    send_mail($to_address, $to_name, $from_address, $from_name, $subject, $body, $is_body_html);
} 
catch (Exception $ex) {
    $_SESSION['message'] = "Error sending email." . $ex->getMessage();
    header("Location: forgot_password.php");
    exit();
}

$_SESSION['message'] = "If the email exists, a reset link has been sent.";
header("Location: forgot_password.php");
exit();

?>
        