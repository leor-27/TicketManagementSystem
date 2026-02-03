<?php
session_start();
include 'db.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id'])) { // redirects if no user logged in
    header("Location: ../index.php");
    exit();
}

// this if block only executes if the user's role is requestor
if ($_SESSION['role'] === 'Requestor') {

    // declarations of various sessions to be used
    $userId = $_SESSION['user_id'];
    $description = trim($_POST['description']);
    $requestType = $_POST['request-types'];
    $status = 'Pending';

    $stmt = $conn->prepare("
        INSERT INTO Ticket
        (USER_ID, DESCRIPTION, REQUEST_TYPE, STATUS, CREATED_AT, LAST_UPDATED)
        VALUES (?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->bind_param(
        "isss",
        $userId,
        $description,
        $requestType,
        $status
    );
        $stmt->execute();
        $newsId = $conn->insert_id;
        $stmt->close();

    header("Location: ../requestor_dashboard.php");
    exit();
}

// this if block only executes if the user's role is manager
if ($_SESSION['role'] === 'Manager') {

    $status = $_POST['status'];
    $ticketId = $_POST['ticket_id'];

    $stmt = $conn->prepare("
        UPDATE Ticket 
        SET STATUS = ?,
            LAST_UPDATED = NOW()
        WHERE TICKET_ID = ?
    ");

    $stmt->bind_param(
        "si",
        $status,
        $ticketId
    );
    $stmt->execute();
    $stmt->close();

    header("Location: ../manager_dashboard.php");
    exit();
}

?>