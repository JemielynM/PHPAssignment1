<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password</title>
        <link rel="stylesheet" type="text/css" href="css/contact.css" />
    </head>

    <body>
        <?php include("header.php") ?>

        <main>
            <h2>Forgot Password</h2>


            <?php
                if (isset($_SESSION['message'])) {
                    echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
                    unset($_SESSION['message']);
                }
            ?>

            <form action="send_reset.php" method="post">
                <label>Email Address:</label><br>
                <input type="email" name="email_Address" required><br><br>
                <input type="submit" value="Send Reset Link">
            </form>

            <p><a href="login.php">Back to Login</a></p>
        </main>

        <?php include("footer.php") ?>
    </body>
</html>