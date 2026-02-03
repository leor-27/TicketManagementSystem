<?php
session_start();
include 'backend/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Sign Up</h1>

    <form id="admin-form" action="backend/login-handler.php" method="POST">
        <input type="hidden" name="step" value="signup">

        <div class = "fields">
            <label id="">Last Name: </label>
            <input type="text" id="lastName" name="lastName" required>
        </div>

        <div class = "fields">
        <label id="input-label">First Name: </label>
        <input type="text" id="firstName" name="firstName" required>
        </div>

        <div class = "fields">
        <label id="input-label">Middle Name: </label>
        <input type="text" id="middleName" name="middleName" required>
        </div>

        <div class = "fields">
        <label id="input-label">Birthdate: </label>
        <input type="date" id="birthdate" name="birthdate" required>
        </div>

        <div class = "fields">
        <label for="gender">Gender: </label>
        <select id="gender" name="gender">
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select> 
        </div>

        <div class = "fields">
        <label for="phone">Mobile Number: </label>
        <input 
            type="tel" id="phone" name="phone"
            placeholder="63XXXXXXXXXX" pattern="63[0-9]{10}" required>
        </div>

        <div class = "fields">
            <label id="input-label">Email: </label>
            <input type="text" id="email" name="email" required>
        </div>

        <button type="submit" class="registerButton" id="registerButton">Register</button> 

    </form>
    
</body>
</html>
