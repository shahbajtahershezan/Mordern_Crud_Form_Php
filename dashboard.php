<?php 
// Include database connection at the very top
include 'db.php';

// Check if connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: #f4f7f9;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #007bff;
        }
        .btn {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-warning {
            background: #ffc107;
            color: black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .actions {
            display: flex;
            gap: 5px;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>User Management Dashboard</h1>
            <a href="index.html" class="btn">Add New User</a>
        </div>

        <?php
        // Display messages
        if (isset($_GET['message'])) {
            $message = htmlspecialchars($_GET['message']);
            $type = isset($_GET['type']) ? $_GET['type'] : 'success';
            echo "<div class='message $type'>$message</div>";
        }
        ?>

        <?php
        // Database query to get users
        $sql = "SELECT * FROM users ORDER BY reg_date DESC";
        $result = $conn->query($sql);

        if ($result) {
            if ($result->num_rows > 0) {
                echo "<table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>District</th>
                            <th>Education</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['phone']}</td>
                        <td>{$row['district']}</td>
                        <td>{$row['education']}</td>
                        <td>{$row['reg_date']}</td>
                        <td class='actions'>
                            <a href='view.php?id={$row['id']}' class='btn'>View</a>
                            <a href='edit.php?id={$row['id']}' class='btn btn-warning'>Edit</a>
                            <a href='delete.php?id={$row['id']}' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
                        </td>
                    </tr>";
                }
                
                echo "</tbody></table>";
            } else {
                echo "<div class='message warning'>No users found in the database. <a href='index.html' class='btn' style='margin-left: 10px;'>Add First User</a></div>";
            }
        } else {
            echo "<div class='message error'>Error executing query: " . $conn->error . "</div>";
        }
        ?>
    </div>
</body>
</html>
<?php
// Close connection
$conn->close();
?>