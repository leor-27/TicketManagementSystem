<?php
session_start();
include 'backend/db.php';

$users = "SELECT * FROM User ORDER BY USER_ID DESC";
$userList = $conn->query($users);

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Manager Dashboard</h1>
    <p>Last logged in at: <?php echo date("m-d-Y H:i", $_SESSION['latestLoginTime']);
 ?></p>

    <div class="dropdown-menu">
        <div class="menu-header">
            <button>
                <a href="manager-user-list.php">User List</a>
            </button>
            <button>
                <a href="manager-dashboard.php">Ticket List</a>
            </button>
        </div>
    </div>

    <table>
        <colgroup>
            <col class="col-email"> <col class="col-password">
        </colgroup>          
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
        </tr>  
        <tbody>
            <?php
                while ($row = $userList->fetch_assoc()): ?>
            <tr>
                <td><?=htmlspecialchars($row['NAME']) ?></td>
                <td><?=htmlspecialchars($row['EMAIL']) ?></td>
                <td><?=htmlspecialchars($row['PASSWORD']) ?></td>
                <!-- <td><?=htmlspecialchars($row['BIRTHDATE']) ?></td>
                <td><?=htmlspecialchars($row['GENDER']) ?></td>
                <td><?=htmlspecialchars($row['MOBILE_NUMBER']) ?></td> -->
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button class = "logout">
        <a href="backend/logout.php">Logout</a>
    </button>
</body>
</html>