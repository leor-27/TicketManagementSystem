<?php
session_start();
include 'backend/db.php';

$users = "SELECT Ticket.*, User.EMAIL
    FROM Ticket
    JOIN User ON Ticket.USER_ID = User.USER_ID
    ORDER BY Ticket.CREATED_AT DESC"; // joined the User and Ticket entities to retrieve simultaneously
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
                <a href="manager_request_list.php">User List</a>
            </button>
            <button>
                <a href="manager_dashboard.php">Ticket List</a>
            </button>
        </div>
    </div>

    <table class = "ticket-list">
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
            <form action="backend/ticket-handler.php" method="POST">  <!-- removed this: id="ticket-form" class="ticket-form" -->
                <td><?=htmlspecialchars($row['TICKET_ID']) ?></td> 
                <td><?=htmlspecialchars($row['EMAIL']) ?></td>
                <td><?=htmlspecialchars($row['REQUEST_TYPE']) ?></td>
                <td><?=htmlspecialchars($row['DESCRIPTION']) ?></td>
                <td><?=htmlspecialchars($row['STATUS']) ?></td>
                <td>
                    <?php
                        $created = new DateTime($row['CREATED_AT']);
                        echo $created->format("M j, Y H:i"); // formats the date
                    ?> <!-- ai -->
                </td>
                <td>
                    <?php
                        $updated = new DateTime($row['LAST_UPDATED']);
                        echo $updated->format("M j, Y H:i");
                    ?>
                </td>
                <td>
                    <select id="status" name = "status" class="filter-btn" required>
                        <option value="Pending">Pending</option>
                        <option value="Open">Open</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
                        <option value="Closed">Closed</option>
                        <option value="Completed">Completed</option>
                        <option value="Failed">Failed</option>
                    </select>
                </td>
                <td> 
                    <input type="hidden" name="ticket_id" value="<?= $row['TICKET_ID'] ?>"> <!-- ai generated -->
                    <button type="submit">Update</button> 
                </td>
            </form>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button class = "logout">
        <a href="backend/logout.php">Logout</a>
    </button>

</body>
</html>