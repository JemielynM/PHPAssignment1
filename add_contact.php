<?php
    session_start();

    $first_name = filter_input(INPUT_POST, 'firstName');
    $last_name = filter_input(INPUT_POST, 'lastName');
    $email_address = filter_input(INPUT_POST, 'emailAddress');
    $phone_number = filter_input(INPUT_POST, 'phoneNumber');
    $status = filter_input(INPUT_POST, 'status');
    $dob = filter_input(INPUT_POST, 'dob');
    $image = $_FILES['image'];
   

    require_once("database.php");
    require_once("image_util.php");

    $base_dir = 'images/';

    // Check for duplicate email
    $queryContacts = '
        SELECT firstname, lastname, emailAddress, phoneNumber, status, dob, imageName FROM contacts';

    $statement = $db->prepare($queryContacts);  
    $statement->execute();
    $contacts = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($contacts as $contact) {
        if ($email_address === $contact["emailAddress"]) {
            $_SESSION["add_error"] = "Invalid data, Duplicate email address. Try again.";
            $url = "error.php";
            header("Location: " . $url);
            die();
        }
    }   

    if ($first_name === null || $last_name === null || $email_address === null || $phone_number === null || $dob === null) {
           $_SESSION["add_error"] = "Invalid contact data. Check all fields and try again.";
           $url = "error.php";
           header("Location: " . $url);
           die();
        }

    // Add the contact

    $query = 'INSERT INTO contacts (firstName, lastName, emailAddress, phoneNumber, status, dob)
        VALUES (:firstName, :lastName, :emailAddress, :phoneNumber, :status, :dob)';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $first_name);
    $statement->bindValue(':lastName', $last_name);
    $statement->bindValue(':emailAddress', $email_address);
    $statement->bindValue(':phoneNumber', $phone_number);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':dob', $dob);
    $statement->execute();
    $statement->closeCursor();


    $_SESSION["fullName"] = $first_name . " " . $last_name;
    $url = "add_confirmation.php";
    header("Location: $url");
    die();
?>