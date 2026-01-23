<?php

 require("database.php");

 $queryContacts = '
    SELECT firstname, lastname, emailAddress, phoneNumber, status, dob FROM contacts';

  $statement = $db->prepare($queryContacts);  
  $statement->execute();
  $contacts = $statement->fetchAll();
  $statement->closeCursor();

?>

<!DOCTYPE html>
<html>

  <head>
     <title>Contact Manager</title>
     <link rel="stylesheet" type="text/css" href="css/contact.css" />
  </head>

  <body>
     <?php include("header.php") ?>

    <main>
     <h2>Contact List</h2>
     <table>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Status</th>
          <th>Date of Birth</th>
        </tr>
        <?php foreach ($contacts as $contact) : ?>
        <tr>
          <td><?php echo htmlspecialchars($contact['firstname']); ?></td>
          <td><?php echo htmlspecialchars($contact['lastname']); ?></td>
          <td><?php echo htmlspecialchars($contact['emailAddress']); ?></td>
          <td><?php echo htmlspecialchars($contact['phoneNumber']); ?></td>
          <td><?php echo htmlspecialchars($contact['status']); ?></td>
          <td><?php echo htmlspecialchars($contact['dob']); ?></td>
        </tr>
        <?php endforeach; ?>  

     </table>
    </main>

    <?php include("footer.php") ?>

  </body>
</html>
    