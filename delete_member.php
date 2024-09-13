<?php
session_start();
require_once 'connect.php';

// Check if user is logged in as admin
if (!isset($_SESSION['admin_login'])) {
    header('Location: index.php');
    exit();
}

// Get user ID from query parameter
$id_user = $_GET['id_user'];

// Prepare SQL query to delete user
$sql = "DELETE FROM users WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);

// Execute the query
if ($stmt->execute()) {
    echo "<script>alert('ลบข้อมูลผู้ใช้สำเร็จ');</script>";
    header('refresh:1;url=manage_users.php');
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>