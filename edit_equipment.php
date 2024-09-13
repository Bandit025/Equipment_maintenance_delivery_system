<?php
// Connect to the database
require_once 'connect.php';

// Get the equipment ID from the URL
$equipment_id = $_GET['id'];

// Fetch the equipment details
$sql = "SELECT * FROM equipment WHERE id = $equipment_id";
$result = $conn->query($sql);
$equipment = $result->fetch_assoc();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $purchase = $_POST['purchase'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $image = $_FILES['image']['name'];

    // Handle file upload
    if ($image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $target_file = $equipment['image'];
    }

    // Update the equipment details
    $sql = "UPDATE equipment SET name='$name', purchase='$purchase', description='$description', status='$status', image='$target_file' WHERE id=$equipment_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('แก้ไขครุภัณฑ์สำเร็จ');</script>";
        header('refresh:1;url=manage_equipment.php');
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการครุภัณฑ์</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ระบบส่งซ่อมครุภัณฑ์</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">กลับไปยังหน้า Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">ออกจากระบบ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- เนื้อหา -->
    <div class="container mt-5">
        <h2>จัดการครุภัณฑ์</h2>

        <!-- ฟอร์มเพิ่มครุภัณฑ์ -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">แก้ไขครุภัณฑ์</h5>
                <form action="update_equipment.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อครุภัณฑ์</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $equipment['name']; ?>" required>
                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $equipment['id']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">วันที่ซื้อครุภัณฑ์</label>
                        <input type="date" class="form-control" id="purchase" name="purchase" value="<?php echo $equipment['purchase_date']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">รายละเอียดครุภัณฑ์</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $equipment['description']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">สถานะครุภัณฑ์</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1" <?php if ($equipment['status'] == 1) echo 'selected'; ?>>ใช้งานอยู่</option>
                            <option value="2" <?php if ($equipment['status'] == 2) echo 'selected'; ?>>ส่งซ่อม</option>
                            <option value="3" <?php if ($equipment['status'] == 3) echo 'selected'; ?>>ปลดระวาง</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">รูปครุภัณฑ์</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img src="uploads/<?php echo $equipment['image']; ?>" alt="Current Image" width="100">
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">แก้ไขครุภัณฑ์</button>
                </form>
            </div>
        </div>

    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Equipment</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>

<body>
    <div class="container">
        <h2>Edit Equipment</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อครุภัณฑ์</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $equipment['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="purchase" class="form-label">วันที่ซื้อครุภัณฑ์</label>
                <input type="date" class="form-control" id="purchase" name="purchase" value="<?php echo $equipment['purchase_date']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียดครุภัณฑ์</label>
                <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $equipment['description']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">สถานะครุภัณฑ์</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1" <?php if ($equipment['status'] == 1) echo 'selected'; ?>>ใช้งานอยู่</option>
                    <option value="2" <?php if ($equipment['status'] == 2) echo 'selected'; ?>>ส่งซ่อม</option>
                    <option value="3" <?php if ($equipment['status'] == 3) echo 'selected'; ?>>ปลดระวาง</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">รูปครุภัณฑ์</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="<?php echo $equipment['image']; ?>" alt="Current Image" width="100">
            </div>
            <button type="submit" name="update" class="btn btn-primary">อัปเดตครุภัณฑ์</button>
        </form>
    </div>
</body>

</html> -->