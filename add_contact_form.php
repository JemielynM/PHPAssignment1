<?php
  session_start();

 require("database.php");

 ?>

<!DOCTYPE html>
<html>

  <head>
     <title>Contact Manager - Add Contact</title>
     <link rel="stylesheet" type="text/css" href="css/contact.css" />
  </head>

  <body>
     <?php include("header.php") ?>

       <main>
           <h2>Add Contact</h2>
     
           <form action="add_contact.php" method="post" id="add_contact_form" enctype="multipart/form-data">
            
                <div id="data">

                    <label>First Name:</label>
                    <input type="text" name="firstname" /><br />

                    <label>Last Name:</label>
                    <input type="text" name="lastname" /><br />

                    <label>Email Address:</label>
                    <input type="text" name="emailAddress" /><br />

                    <label>Phone Number:</label>
                    <input type="text" name="phoneNumber" /><br />

                    <label>Status:</label><br />
                    <input type="radio" name="status" value="member" />Member<br />
                    <input type="radio" name="status" value="non-member" />Non-member<br />

                    <label>Date of Birth:</label>
                    <input type="date" name="dob" /><br />

                </div>

                <div id="buttons">
                    <label>&nbsp;</label>
                    <input type="submit" value="Add Contact" /><br />   
                </div>
           </form>
           
           <p><a href="index.php">View Contact List</a></p>
     
        </main>

    <?php include("footer.php") ?>

  </body>
</html>
    