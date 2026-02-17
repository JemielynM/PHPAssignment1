<?php
    require_once("database.php");

    // get data from the form  
    $contact_id = filter_input(INPUT_POST, 'contact_id', FILTER_VALIDATE_INT);
    
    $queryContacts = '
      SELECT contactID, firstName, lastName, emailAddress, phoneNumber, status, dob, typeID, imageName FROM contacts WHERE contactID = :contact_id';

    $statement = $db->prepare($queryContacts);  
    $statement->bindValue(':contact_id', $contact_id);
    $statement->execute();
    $contact = $statement->fetch();
    $statement->closeCursor();

    // Get contact types
    $query = 'SELECT typeID, contactType FROM types';
    $statement = $db->prepare($query);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();

?>

<!DOCTYPE html>
<html>

  <head>
     <title>Contact Manager - Update Contact</title>
     <link rel="stylesheet" type="text/css" href="css/contact.css" />
  </head>

  <body>
     <?php include("header.php") ?>

       <main>
           <h2>Update Contact</h2>
     
           <form action="update_contact.php" method="post" id="update_contact_form" enctype="multipart/form-data">
                <input type="hidden" name="contact_id" value="<?php echo $contact['contactID']; ?>" />
                <div id="data">

                    <label>First Name:</label>
                    <input type="text" name="firstName" value="<?php echo $contact['firstName']; ?>" /><br />

                    <label>Last Name:</label>
                    <input type="text" name="lastName" value="<?php echo $contact['lastName']; ?>" /><br />

                    <label>Email Address:</label>
                    <input type="text" name="emailAddress" value="<?php echo $contact['emailAddress']; ?>" /><br />

                    <label>Phone Number:</label>
                    <input type="text" name="phoneNumber" value="<?php echo $contact['phoneNumber']; ?>" /><br />

                    <label>Status:</label><br />
                    <input type="radio" name="status" value="member" <?php if ($contact['status'] == 'member') echo 'checked'; ?>/>Member<br />
                    <input type="radio" name="status" value="nonmember" <?php if ($contact['status'] == 'nonmember') echo 'checked'; ?>/>Non-member<br /><br />

                    <label>Date of Birth:</label>
                    <input type="date" name="dob" value="<?php echo $contact['dob']; ?>" /><br />

                    <label>Contact Type:</label>
                    <select name="type_id"
                      <?php foreach ($types as $type) : ?>
                        <option value="<?php echo $type['typeID']; ?>" <?php if ($type['typeID'] == $contact['typeID']) echo 'selected'; ?>>
                          <?php echo $type['contactType']; ?>
                        </option>
                      <?php endforeach; ?>
                   </select><br /> 

                    <?php if (!empty($contact['imageName'])): ?>
                        <label>Current Image:</label>
                        <img src="images/<?php echo htmlspecialchars($contact['imageName']); ?>" height="100"><br />  
                    <?php endif; ?>

                    <label>Upload New Image:</label>
                    <input type="file" name="file1" /><br />
                        

                </div>

                <div id="buttons">
                    <label>&nbsp;</label>
                    <input type="submit" value="Update Contact" /><br />   
                </div>
           </form>
           
           <p><a href="index.php">View Contact List</a></p>
     
        </main>

    <?php include("footer.php") ?>

  </body>
</html>
    