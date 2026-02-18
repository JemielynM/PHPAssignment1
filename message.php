<?php
    require './PHPmailer/PHPMailerAutoload.php';

    function send_mail($to_address, $to_name, $from_address, $from_name, $from_name,
        $subject, $body, $is_body_html = false) 
    {
        if (!valid_mail($to_address)) {
            throw new Exception('This To address is Invalid: ' . htmlspecialchars($to_address));
        }

        if (!valid_mail($from_address)) {
            throw new Exception('This From address is Invalid: ' . htmlspecialchars($from_address));
        }

        $mail = new PHPMailer;

        //  ***** You must change the following to match your SMTP server and account information.*****
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username = 'Your_USERNAME@GMAIL.com';
        $mail->Password = 'Your_PASSWORD';

        //Set From address, To address, subject and body
        $mail->setFrom($from_address, $from_name);
        $mail->addAddress($to_address, $to_name);
      
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = strip_tags($body);
       
        if ($is_body_html) {
            $mail->isHTML(true);
        }
        if (!$mail->send()) {
            throw new Exception('Error sending email: ' . htmlspecialchars($mail->ErrorInfo));
        }

    }

    function valid_mail($email) {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            return false;
        }
        else {
            return true;
       }   
    }

?>   
        