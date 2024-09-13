<?php
require_once 'connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $purchase_date = $_POST['purchase'];
    $status = $_POST['status'];

    // Generate a random bib number
    $bib = rand(10000, 99999);

    // Check if an image file is uploaded
    $target_dir = "uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $new_file_name = uniqid() . '.' . $imageFileType; // Generate a unique file name
    $target_file = $target_dir . $new_file_name;

    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $new_file_name;

                // Insert data into the database
                $sql = "INSERT INTO equipment (name, description, purchase_date, status, image, bib) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi", $name, $description, $purchase_date, $status, $image_url, $bib);

                if ($stmt->execute()) {
                    
                    echo "<script>alert('เพิ่มครุภัณฑ์สำเร็จ');</script>";
                    header('refresh:1;url=manage_equipment.php');
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close statement
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

?>