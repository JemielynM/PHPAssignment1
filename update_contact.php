<?php
    session_start();

    require_once("database.php");
    require_once('image_util.php');

    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);

    $first_name = filter_input(INPUT_POST, 'firstName');
    $last_name = filter_input(INPUT_POST, 'lastName');
    $email_address = filter_input(INPUT_POST, 'emailAddress');
    $phone_number = filter_input(INPUT_POST, 'phoneNumber');
    $status = filter_input(INPUT_POST, 'status');
    $dob = filter_input(INPUT_POST, 'dob');
   

    //Get the uploaded image
    $image = $_FILES['file1'];

    //Get current contact record to check existing image
    $queryContacts = '
      SELECT contactID, firstName, lastName, emailAddress, phoneNumber, status, dob, imageName FROM contacts WHERE contactID = :contact_id';

    $statement = $db->prepare($queryContacts);  
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $contact = $statement->fetch();
    $statement->closeCursor();

    $old_image_name = $contact['imageName']; 
    $base_dir = 'images/';
    $image_name = $old_image_name; 

    
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
    // Validate input

    if ($first_name === null || $last_name === null || $email_address === null || 
        $phone_number === null || $dob === null) {
           $_SESSION["add_error"] = "Invalid contact data. Check all fields and try again.";
           $url = "error.php";
           header("Location: " . $url);
           die();
        }
    // If a new image is uploaded   
    
    if ($image && $image['error'] == UPLOAD_ERR_OK) {

        
        
        // process new image
        $original_filename = basename($image['name']);
        $upload_path = $base_dir . $original_filename;
        move_uploaded_file($image['tmp_name'], $upload_path);


        process_image($base_dir, $original_filename);

        // save _100 versoin in DB
        $dot_pos = strrpos($original_filename, '.');
        $new_image_name = substr($original_filename, 0, $dot_pos) . '_100' . substr($original_filename, $dot_pos);
        $image_name = $new_image_name;


        if ($old_image_name != 'placeholder_100.jpg') {
            $old_base = substr($old_image_name, 0, strrpos($old_image_name, '_100'));
            $old_ext = substr($old_image_name, strrpos($old_image_name, '.'));
            $original = $old_base . $old_ext;
            $image_100 = $old_base . '_100' . $old_ext;
            $image_400 = $old_base . '_400' . $old_ext;

            foreach ([$original, $image_100, $image_400] as $file) {
                    $path = $base_dir . $file;
                    if (file_exists($path)) {
                       unlink($path);
                    }
            }
        }
    }


    // Update contact

    $query = '
        UPDATE contacts
        SET firstName = :firstName,
            lastName = :lastName,
            emailAddress = :emailAddress,
            phoneNumber = :phoneNumber,
            status = :status,
            dob = :dob,
            imageName = :imageName
        WHERE contactID = :contact_id
    ';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $first_name);
    $statement->bindValue(':lastName', $last_name);
    $statement->bindValue(':emailAddress', $email_address);
    $statement->bindValue(':phoneNumber', $phone_number);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':dob', $dob);
    $statement->bindValue(':imageName', $image_name);
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $statement->closeCursor();


    $_SESSION["fullName"] = $first_name . " " . $last_name;
    $url = "update_confirmation.php";
    header("Location: $url");
    die();
?>