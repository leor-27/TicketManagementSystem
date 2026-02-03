<?php
session_start();
include 'backend/db.php';

$stmt = $conn->prepare("
    SELECT EMAIL, NAME, BIRTHDATE, MOBILE_NUMBER, GENDER
    FROM User
    WHERE USER_ID = ?
    LIMIT 1
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>
        alert('User not found.');
        window.history.back();
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requestor Profile</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Requestor Dashboard</h1>

    <div class="dropdown-menu">
        <div class="menu-header">
            <button>
                <a href="user-profile.php">Requestor Profile</a>
            </button>
            <button>
                <a href="requestor_dashboard.php">Requests</a>
            </button>
        </div>
    </div>

    <div class = "profile-info">
        <p>Full Name: <?=htmlspecialchars($user['NAME']) ?></p>

        <?php
            $birthdate = new DateTime($user['BIRTHDATE']);
            $today = new DateTime();
            $age = $today->diff($birthdate)->y;
        ?>

        <p>Age: <?= $age ?></p>
        <p>Gender: <?=htmlspecialchars($user['GENDER']) ?></p>
        <p>Contact Info: <?=htmlspecialchars($user['MOBILE_NUMBER']) ?> </p>
        <p class = "email"> <?=htmlspecialchars($user['EMAIL']) ?> </p>
        </div>

    <button class = "logout">
        <a href="backend/logout.php">Logout</a>
    </button>
    
</body>
</html>
