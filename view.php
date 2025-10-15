<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User</title>
    <style>
        body { font-family: Arial; background: #f4f7f9; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; }
        .user-info { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-group { margin-bottom: 15px; }
        .label { font-weight: bold; color: #333; }
        .value { color: #666; }
        .full-width { grid-column: 1 / -1; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Details</h2>
        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                echo "<div class='user-info'>
                    <div class='info-group'><span class='label'>Full Name:</span><br><span class='value'>{$user['full_name']}</span></div>
                    <div class='info-group'><span class='label'>Father's Name:</span><br><span class='value'>{$user['father_name']}</span></div>
                    <div class='info-group'><span class='label'>Mother's Name:</span><br><span class='value'>{$user['mother_name']}</span></div>
                    <div class='info-group'><span class='label'>NID/Birth Certificate:</span><br><span class='value'>{$user['nid_birth']}</span></div>
                    <div class='info-group'><span class='label'>Date of Birth:</span><br><span class='value'>{$user['dob']}</span></div>
                    <div class='info-group'><span class='label'>Age:</span><br><span class='value'>{$user['age']}</span></div>
                    <div class='info-group'><span class='label'>Gender:</span><br><span class='value'>{$user['gender']}</span></div>
                    <div class='info-group'><span class='label'>Marital Status:</span><br><span class='value'>{$user['marital_status']}</span></div>
                    <div class='info-group'><span class='label'>Blood Group:</span><br><span class='value'>{$user['blood_group']}</span></div>
                    <div class='info-group'><span class='label'>Religion:</span><br><span class='value'>{$user['religion']}</span></div>
                    <div class='info-group'><span class='label'>Email:</span><br><span class='value'>{$user['email']}</span></div>
                    <div class='info-group'><span class='label'>Phone:</span><br><span class='value'>{$user['phone']}</span></div>
                    <div class='info-group'><span class='label'>District:</span><br><span class='value'>{$user['district']}</span></div>
                    <div class='info-group'><span class='label'>Upazila:</span><br><span class='value'>{$user['upazila']}</span></div>
                    <div class='info-group full-width'><span class='label'>Address:</span><br><span class='value'>{$user['address']}</span></div>
                    <div class='info-group'><span class='label'>Education:</span><br><span class='value'>{$user['education']}</span></div>
                    <div class='info-group'><span class='label'>Profession:</span><br><span class='value'>{$user['profession']}</span></div>
                </div>";
            } else {
                echo "<p>User not found</p>";
            }
        }
        ?>
        <a href="dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>