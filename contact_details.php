<?php
    session_start();
    require_once("database.php");

    // get contact id
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
    
    //Fetch contact info

?>

<!DOCTYPE html>
<html>

  <head>
     <title>Contact Manager - Contact Details</title>
     <link rel="stylesheet" type="text/css" href="css/contact.css" />
  </head>

  <body>
     <?php include("header.php") ?>

       <main>
           <h2>Contact Details</h2>

           <p>Under Construction</p>
     
           
           
           <p><a href="index.php">Back to Contact List</a></p>
     
        </main>

    <?php include("footer.php") ?>

  </body>
</html>
    