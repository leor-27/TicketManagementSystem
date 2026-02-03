<?php
session_start();
include 'db.php';
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

    $userId = $_SESSION['user_id'];
    $requestType = $_POST['request-types'];
    $status = 'Open';

if ($_SESSION['role'] === 'Requestor') {

    $stmt = $conn->prepare("
        INSERT INTO Ticket
        (USER_ID, REQUEST_TYPE, STATUS, CREATED_AT, LAST_UPDATED)
        VALUES (?, ?, ?, NOW(), NOW())
    ");

    $stmt->bind_param(
        "isss",
        $userId,
        $requestType,
        $status
    );
        $stmt->execute();
        $newsId = $conn->insert_id;
        $stmt->close();
}


?>