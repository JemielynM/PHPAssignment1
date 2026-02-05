<?php
  session_start();
?>

<!DOCTYPE html>
<html>

  <head>
     <title>Contact Manager - Update Contact Confirmation</title>
     <link rel="stylesheet" type="text/css" href="css/contact.css" />
  </head>

  <body>
     <?php include("header.php") ?>

       <main>
           <h2>Update Contact Confirmation</h2>
           <p>
                Thank you, <?php echo $_SESSION["fullName"]; ?>, for 
                updating contact information.
                We look forward to assisting you again.
           </p>
     
            <p><a href="index.php">Back to Home</a></p>
     
        </main>

    <?php include("footer.php") ?>

  </body>
</html>
    

