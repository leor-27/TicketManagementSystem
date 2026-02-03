<?php
session_start();
include 'backend/db.php';

$users = "SELECT Ticket.*, User.EMAIL
    FROM Ticket
    JOIN User ON Ticket.USER_ID = User.USER_ID
    ORDER BY Ticket.USER_ID DESC";
$userList = $conn->query($users);

if (!isset($_SESSION['role'])) { // redirects if user is not logged in
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket List</title>
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <h1>Manager Dashboard</h1>

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
            <col class="requestor-id"> <col class="requestor"> 
            <col class="request-type"> <col class = "request-description"> 
            <col class="request-status"> <col class="request-date"> 
            <col class="request-last-updated"> <col class ="request-actions">
            <col class="request-update">
        </colgroup>          
        <tr>
            <th>ID</th>
            <th>Requestor</th>
            <th>Type</th>
            <th>Description</th>
            <th>Status</th>
            <th>Requested Date</th>
            <th>Last Updated</th>
            <th>Actions</th>
            <th></th>
        </tr>  
        <tbody>
            <?php
                while ($row = $userList->fetch_assoc()): ?>
            <tr>
                <td><?=htmlspecialchars($row['TICKET_ID']) ?></td>
                <td><?=htmlspecialchars($row['EMAIL']) ?></td>
                <td><?=htmlspecialchars($row['REQUEST_TYPE']) ?></td>
                <td><?=htmlspecialchars($row['DESCRIPTION']) ?></td>
                <td><?=htmlspecialchars($row['STATUS']) ?></td>
                <td><?=htmlspecialchars($row['CREATED_AT']) ?></td>
                <td><?=htmlspecialchars($row['LAST_UPDATED']) ?></td>
                <td>
                    <select id="request-types" name = "request-types" class="filter-btn" required>
                        <option value="open">Open</option>
                        <option value="pending">Pending</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                        <option value="closed">Closed</option>
                        <option value="completed">Completed</option>
                        <option value="failed">Failed</option>
                    </select>
                </td>
                <td> <button type="submit">Update</button> </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button class = "logout">
        <a href="backend/logout.php">Logout</a>
    </button>

</body>
</html>