<?php
    session_start();
    date_default_timezone_set("America/Toronto");

    require_once('database.php');
    

    $user_name = filter_input(INPUT_POST, 'user_name');
    $user_password = filter_input(INPUT_POST, 'password');
    
    

    // Check for duplicate userName
    $queryUsers = '
        SELECT userID, userName, password, emailAddress, failed_attempts, last_failed_login FROM registration WHERE userName = :userName';

    $statement = $db->prepare($queryUsers);  
    $statement->bindValue(':userName', $user_name);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    //echo $use_rname;
    // echo $user_password;
    

    if ($user) {

        //echo "Inside first if block";
        //echo $user_password;
        //echo $user['password'];   
        //die();

        $now = new DateTime(); // gets system current date and time
        $last_failed = new DateTime($user['last_failed_login']);

        $interval = $now->getTimestamp() - $last_failed->getTimestamp();

        if ($user['failed_login_attempts'] >= 3 && $interval < 300) {
            $remaining = 300 - $interval;

            $_SESSION['login_error'] = "Accountlocked. Try again in " . ceil($remaining) . " seconds.";
            header("Location: login_form.php");
            exit;
        }


        if (password_verify($user_password, $user['password'])) {
            //echo "Inside second if block";
            //die();

            $_SESSION['isLoggedIn'] = TRUE;
            $_SESSION['userName'] = $user['userName'];

            $_SESSION['user_id'] = $user['userID'];
            header("Location: login_confirmation.php");
            exit;
        } 
        else {
            //echo "Inside else block";
            //die();
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: login_form.php");
            exit;

        }
    }
    else {
        $_SESSION['login_error'] = "User not found.";
        header("Location: login_form.php");
        exit;
    }

?>