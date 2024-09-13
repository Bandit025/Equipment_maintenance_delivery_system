<?php
require_once 'connect.php';

// Get the equipment ID from the URL


// Fetch the equipment details


// Check if the form is submitted

    $id = $_POST['id'];
    $name = $_POST['name'];
    $purchase = $_POST['purchase'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $image = $_FILES['image']['name'];

    $sql = "SELECT * FROM equipment WHERE id = $id";
    $result = $conn->query($sql);
    $equipment = $result->fetch_assoc();
    // Handle file upload
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $target_file = $equipment['image'];
    }

    // Update the equipment details
    $sql = "UPDATE equipment SET name='$name', purchase_date='$purchase', description='$description', status='$status', image='$target_file' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('แก้ไขครุภัณฑ์สำเร็จ');</script>";
        header('refresh:1;url=manage_equipment.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }


?>