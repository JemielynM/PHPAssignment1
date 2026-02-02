<?php
  session_start();
?>
<!DOCTYPE html>
<html>

  <head>
     <title>PHPAssignment1 - Error</title>
     <link rel="stylesheet" type="text/css" href="css/contact.css" />
  </head>

  <body>
     <?php include("header.php") ?>

    <main>
     <h2>Error</h2>
     
      
      <p>Error message: <?php echo $_SESSION["add_error"]; ?></p>

      <p><a href="add_contact_form.php">Add Contact List</a></p>
      <p><a href="index.php">View Contact List</a></p>
    </main>

    <?php include("footer.php") ?>

  </body>
</html>
  