<?php
session_start();
include 'db.php';
date_default_timezone_set('Asia/Manila');

$step = $_POST['step'] ?? 'login';

if ($step === 'login') { // runs if the user logged in with credentials already set
    $email = trim($_POST['email'] ?? '');  // to remove potential whitespace
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo "<script>
            alert('Missing credentials.'); 
            window.history.back();
        </script>";
        exit;
    }

    // checks the users from database
    $userRow = $conn->prepare("SELECT USER_ID, PASSWORD, ROLE FROM User WHERE EMAIL = ? LIMIT 1");
    $userRow->bind_param("s", $email);
    $userRow->execute();
    $result = $userRow->get_result();

    if ($user = $result->fetch_assoc()) {

        if (password_verify($password, $user['PASSWORD'])) { // checks if the password inputted matches the hashed one in the database
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['USER_ID'];
            $_SESSION['role'] = $user['ROLE'];
            $_SESSION['latestLoginTime'] = time();

            if ($user['ROLE'] === 'Requestor') {
                header("Location: ../user-profile.php");
                exit;
            }

            if ($user['ROLE'] === 'Manager') {
                header("Location: ../manager-user-list.php");
                exit;
            }
        }
    }

    echo "<script>
        alert('Invalid email or password.'); 
        window.history.back();
    </script>";
    exit;
}

if ($step === 'signup') { // if the user is signing up for the first time with no credentials yet
    $first = trim($_POST['firstName'] ?? '');
    $middle = trim($_POST['middleName'] ?? '');
    $last = trim($_POST['lastName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $gender = $_POST['gender'] ?? '';

    if (!$first || !$last || !$email || !$birthdate || !$phone || !$gender) {
        echo "<script>
            alert('All fields are required.');
            window.history.back();
        </script>";
        exit;
    }

    $gender = strtolower($gender) === 'male' ? 'M' : 'F';
    $fullName = trim("$first $middle $last"); // concatenates the separate names into one

    // for the hashing
    $plainPassword = bin2hex(random_bytes(4));
    $passwordHash = password_hash($plainPassword, PASSWORD_DEFAULT); 

    $check = $conn->prepare("
        SELECT USER_ID 
        FROM User 
        WHERE EMAIL = ? OR MOBILE_NUMBER = ?
    ");
    $check->bind_param("ss", $email, $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>
            alert('Email or mobile number already registered.');
            window.history.back();
        </script>";
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO User 
        (EMAIL, PASSWORD, NAME, BIRTHDATE, MOBILE_NUMBER, GENDER)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "ssssss",
        $email,
        $passwordHash,
        $fullName,
        $birthdate,
        $phone,
        $gender
    );
    $stmt->execute();

    // the generated password that is alerted to the user after the signing up
    echo "<script>
        alert('Account created! Your password is: {$plainPassword}');
        window.location.href = '../index.php?newUser=' + encodeURIComponent('{$first}'); // references the newUser status declared in index.php
    </script>";
    exit;

}
