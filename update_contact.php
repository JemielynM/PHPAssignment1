<?php
    session_start();

    require("database.php");

    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    $first_name = filter_input(INPUT_POST, 'firstName');
    $last_name = filter_input(INPUT_POST, 'lastName');
    $email_address = filter_input(INPUT_POST, 'emailAddress');
    $phone_number = filter_input(INPUT_POST, 'phoneNumber');
    $status = filter_input(INPUT_POST, 'status');
    $dob = filter_input(INPUT_POST, 'dob');
   

    
    // Check for duplicate email
    $queryContacts = '
        SELECT contactID, firstName, lastName, emailAddress, phoneNumber, status, dob FROM contacts';

    $statement = $db->prepare($queryContacts);  
    $statement->execute();
    $contacts = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($contacts as $contact) {
        if ($email_address === $contact["emailAddress"] && $contact_id != $contact["contactID"]) {
            $_SESSION["add_error"] = "Invalid data, Duplicate Email address. Try again.";
            $url = "error.php";
            header("Location: " . $url);
            die();
        }
    }   

    if ($first_name === null || $last_name === null || $email_address === null || 
        $phone_number === null || $dob === null) {
           $_SESSION["add_error"] = "Invalid contact data. Check all fields and try again.";
           $url = "error.php";
           header("Location: " . $url);
           die();
        }

    // Update contact

    $query = '
        UPDATE contacts
        SET firstName = :firstName,
            lastName = :lastName,
            emailAddress = :emailAddress,
            phoneNumber = :phoneNumber,
            status = :status,
            dob = :dob
        WHERE contactID = :contact_id
    ';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $first_name);
    $statement->bindValue(':lastName', $last_name);
    $statement->bindValue(':emailAddress', $email_address);
    $statement->bindValue(':phoneNumber', $phone_number);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':dob', $dob);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $statement->closeCursor();


    $_SESSION["fullName"] = $first_name . " " . $last_name;
    $url = "update_confirmation.php";
    header("Location: $url");
    die();
?>