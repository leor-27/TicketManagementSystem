<?php
session_start();
include 'backend/db.php';

$users = "SELECT * FROM Ticket ORDER BY USER_ID DESC";
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
                <input type="hidden" name="step" id="step" value="login">

                <div class = "fields">
                    <label id="request-types">Request Type: </label>

                    <select id="request-types" name = "request-types" class="filter-btn" required>
                        <option value="general">General Inquiry</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="complaint">Complaint</option>
                        <option value="feature">Feature Request</option>
                        <option value="technical">Technical</option>
                    </select>
                </div>

                <div class = "fields">
                    <label id="description-label">Description: </label>
                    <textarea rows="3" id="descripton" name="description" required> </textarea>
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
                        <td><?=htmlspecialchars($row['USER_ID']) ?></td>
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