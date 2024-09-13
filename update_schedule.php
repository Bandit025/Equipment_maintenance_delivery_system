<?php
// เริ่มต้นการใช้งาน session
session_start();
require_once 'connect.php';

if (!isset($_SESSION['admin_login'])) {
    header('Location: login.php');
    exit();
}



    $id = $_POST['id'];
    $equipment_id = $_POST['equipment_id'];
    $repair_date = $_POST['repair_date'];
    $status_rs = $_POST['status'];

    // อัปเดตข้อมูลกำหนดการซ่อม
    $sql_update = "UPDATE repair_schedule SET equipment_id = ?, repair_date = ?, status_rs = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("issi", $equipment_id, $repair_date, $status_rs, $id);

    if ($stmt_update->execute()) {
        echo "Repair schedule updated successfully";
    } else {
        echo "Error: " . $stmt_update->error;
    }

    $stmt_update->close();



?>
