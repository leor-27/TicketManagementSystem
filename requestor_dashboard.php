<?php
session_start();
include 'backend/db.php';

$users = "SELECT Ticket.*, User.EMAIL
    FROM Ticket
    JOIN User ON Ticket.USER_ID = User.USER_ID
    ORDER BY Ticket.USER_ID DESC"; // ai generated
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
    <title>Requests</title>
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

    <div class = "ticket-inputs">
        <div class = "tickets">
            <form id="ticket-form" class="ticket-form" action="backend/ticket-handler.php" method="POST">
                <input type="hidden" name="step" id="step" value="createTicket">

                <div class = "fields">
                    <label for="request-types">Request Type: </label>

                    <select id="request-types" name = "request-types" class="filter-btn" required>
                        <option value="General Inquiry">General Inquiry</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Complaint">Complaint</option>
                        <option value="Feature Request">Feature Request</option>
                        <option value="Technical">Technical</option>
                    </select>
                </div>

                <div class = "fields">
                    <label id="description-label">Description: </label>
                    <textarea rows="3" id="description" name="description" required> </textarea>
                </div>

                <button type="submit" class="submitTicket" id="submitTicket">Submit Ticket</button>

            </form>
        </div>
    
        <div class = "dashboard">
            <table>
                <colgroup>
                    <col class="requestor-id"> <col class="requestor"> 
                    <col class="request-type"> <col class="request-status"> 
                    <col class="request-date"> <col class="request-last-updated">
                </colgroup>          
                <tr>
                    <th>ID</th>
                    <th>Requestor</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Requested Date</th>
                    <th>Last Updated</th>
                </tr>  
                <tbody>
                    <?php
                        while ($row = $userList->fetch_assoc()): ?>
                    <tr>
                        <td><?=htmlspecialchars($row['TICKET_ID']) ?></td>
                        <td><?=htmlspecialchars($row['EMAIL']) ?></td>
                        <td><?=htmlspecialchars($row['REQUEST_TYPE']) ?></td>
                        <td><?=htmlspecialchars($row['STATUS']) ?></td>
                        <td><?=htmlspecialchars($row['CREATED_AT']) ?></td>
                        <td><?=htmlspecialchars($row['LAST_UPDATED']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <button class = "logout">
        <a href="backend/logout.php">Logout</a>
    </button>

</body>
</html>