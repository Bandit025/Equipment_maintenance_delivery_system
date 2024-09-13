<?php
session_start();
require_once('connect.php');

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert data into the database
$sql = "INSERT INTO users (username, password, email, fname, lname, urole) VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$urole = 1; // Default user role, change as needed
$stmt->bind_param("sssssi", $username, $hashed_password, $email, $firstname, $lastname, $urole);

if ($stmt->execute()) {
    echo "<script>alert('สมัครสมาชิกสำเร็จ')</script>";
    if (isset($_SESSION['admin_login'])) {
        header('refresh:1;url=manage_users.php');
        exit(); 
    } else {
        header('refresh:1;url=index.php');
        exit(); 
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();

?>