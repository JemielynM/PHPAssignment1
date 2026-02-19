<?php
    require './PHPMailer/PHPMailerAutoload.php';

    
    function send_mail($to_address, $to_name, $from_address, $from_name, 
        $subject, $body, $is_body_html = false) {  

        if (!valid_email($to_address)) {
            throw new Exception('This To address is invalid: ' . htmlspecialchars($to_address));
        }

        if (!valid_email($from_address)) {
            throw new Exception('This From address is Invalid: ' . htmlspecialchars($from_address));
        }

        $mail = new PHPMailer;

        

        //  ***** You must change the following to match your SMTP server and account information.*****
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->SMTPAuth = true;


        $mail->Username = 'YOUR_USERNAME@gmail.com';
        $mail->Password = 'YOUR_APP_PASSWORD';

        //Set From address, To Address, subject and body
        $mail->setFrom($from_address, $from_name);
        $mail->addAddress($to_address, $to_name);
      
        $mail->Subject = $subject;
        
       
        if ($is_body_html) {
            $mail->isHTML(true);
            $mail->Body = $body;
            $mail->AltBody = strip_tags($body);
        }
        else {
            $mail->Body = $body;
            $mail->AltBody = $body;
        }
        if (!$mail->send()) {
            throw new Exception('Error sending email: ' . htmlspecialchars($mail->ErrorInfo));
        }

    }

    function valid_email($email) {
         return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        }
    
?>   
        