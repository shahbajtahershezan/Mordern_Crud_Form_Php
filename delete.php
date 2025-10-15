<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Delete user from database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php?message=User deleted successfully&type=success");
    } else {
        header("Location: dashboard.php?message=Error deleting user&type=error");
    }
} else {
    header("Location: dashboard.php");
}
exit();
?>