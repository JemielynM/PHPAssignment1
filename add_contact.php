<?php
    session_start();

    $first_name = filter_input(INPUT_POST, 'firstName');
    $last_name = filter_input(INPUT_POST, 'lastName');
    $email_address = filter_input(INPUT_POST, 'emailAddress');
    $phone_number = filter_input(INPUT_POST, 'phoneNumber');
    $status = filter_input(INPUT_POST, 'status');
    $dob = filter_input(INPUT_POST, 'dob');
    $notes = filter_input(INPUT_POST, 'notes');

    require_once("database.php");

    // Add the contact

    $query = 'INSERT INTO contacts (firstName, lastName, emailAddress, phoneNumber, status, dob, notes)
        VALUES (:firstName, :lastName, :emailAddress, :phoneNumber, :status, :dob, :notes)';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $first_name);
    $statement->bindValue(':lastName', $last_name);
    $statement->bindValue(':emailAddress', $email_address);
    $statement->bindValue(':phoneNumber', $phone_number);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':dob', $dob);
    $statement->bindValue(':notes', $notes);
    $statement->execute();
    $statement->closeCursor();



?>