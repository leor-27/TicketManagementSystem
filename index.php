<?php
session_start();
include 'backend/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Management System</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Ticket Management System</h1>
    <h2>Login</h2>

    <?php 
    if (isset($_GET['status']) && $_GET['status'] === 'loggedOut') {
        echo "<script> 
                alert('You have been logged out successfully.');
            </script>";
        } // displays the message when the user clicks the logout button and was redirected from logout.php
    ?>

    <?php 
    if (isset($_GET['newUser'])) {
        $name = htmlspecialchars($_GET['newUser']);
        echo "<script> 
            alert('Welcome, $name! Please login with your generated password.');
        </script>";
    } // displays the message after the user signed up for the first time and showed the generated password
    ?>

    <form id="admin-form" class="admin-form" action="backend/login-handler.php" method="POST"> <!-- calls the login-handler in the backend -->
        <input type="hidden" name="step" id="step" value="login">

        <div class = "fields">
            <label id="input-label">Email: </label>
            <input type="text" id="email" name="email"> 
        </div>

        <div class = "fields">
            <label id="password-label">Password: </label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit" class="loginButton" id="loginButton">Login</button>

    </form>

    <p>Don't have an account?
        <a href="sign-up.php" id="signUp"><u class = "signUpText">Sign up here.</u></a>
    </p>    
    
</body>
</html>
