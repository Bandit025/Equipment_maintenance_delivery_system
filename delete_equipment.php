<?php
session_start();
require_once 'connect.php';

// Check if user is logged in as admin
if (!isset($_SESSION['admin_login'])) {
    header('Location: index.php');
    exit();
}

// Get user ID from query parameter
$id = $_GET['id'];

// Prepare SQL query to delete user
$sql = "DELETE FROM equipment WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

// Execute the query
if ($stmt->execute()) {
    echo "<script>alert('ลบข้อมูลครุภัณฑ์สำเร็จ');</script>";
    header('refresh:1;url=manage_equipment.php');
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>