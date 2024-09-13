<?php
session_start();
require_once 'connect.php';

// Check if user is logged in as admin
if (!isset($_SESSION['admin_login'])) {
    header('Location: index.php');
    exit();
}

// Retrieve form data
$id_user = $_POST['id_user'];
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

// Prepare SQL query
if (!empty($password)) {
    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET username = ?, password = ?, email = ?, fname = ?, lname = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $hashed_password, $email, $firstname, $lastname, $id_user);
} else {
    $sql = "UPDATE users SET username = ?, email = ?, fname = ?, lname = ? WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $username, $email, $firstname, $lastname, $id_user);
}

// Execute the query
if ($stmt->execute()) {
    echo "<script>alert('แก้ไขข้อมูลสำเร็จ');</script>";
    header('refresh:1;url=manage_users.php');
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>