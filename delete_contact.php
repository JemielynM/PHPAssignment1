<?php
    require_once("database.php");

    // get data from the form  
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
    

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

    if ($contact_id != false) {
            // delete the contact from the database
        $query = 'DELETE FROM contacts WHERE contactID = :contact_id';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':contact_id', $contact_id);

        $statement->execute();
        $statement->closeCursor();
    }

    // reload the index page
    $url = "index.php";
    header("Location: " . $url);
    die();
?>      