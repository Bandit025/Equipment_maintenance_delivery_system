<?php
session_start();
require_once 'connect.php';
if (!isset($_SESSION['admin_login'])) {
    header('Location: login.php');
    exit();
}


$id_user = $_SESSION['admin_login'];

$equipment_id = $_POST['equipment_id'];
$repair_date = $_POST['repair_date'];
$status_rs = $_POST['status'];

// Insert the repair schedule into the database
$sql = "INSERT INTO repair_schedule (equipment_id, repair_date, status_rs) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $equipment_id, $repair_date, $status_rs);

if ($stmt->execute()) {
    echo "<script>alert('เพิ่มกำหนดการซ่อมครุภัณฑ์สำเร็จ');</script>";
    header('refresh:1;url=manage_repair_schedule.php');
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();


?>
