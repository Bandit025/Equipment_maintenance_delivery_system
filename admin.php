<?php
// เริ่มต้นการใช้งาน session
session_start();

// ตรวจสอบว่าผู้ใช้เป็นผู้ดูแลระบบหรือไม่
if (!isset($_SESSION['admin_login'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้า Admin</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">ระบบส่งซ่อมครุภัณฑ์</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">จัดการสมาชิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_equipment.php">จัดการครุภัณฑ์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">จัดการกำหนดการซ่อม</a>
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
        <h2>ยินดีต้อนรับ, ผู้ดูแลระบบ: <?php echo $_SESSION['username']; ?></h2>
        <div class="row">
            <!-- การจัดการสมาชิก -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">จัดการสมาชิก</h5>
                        <p class="card-text">เพิ่ม, ลบ, แก้ไขข้อมูลสมาชิกในระบบ</p>
                        <a href="manage_users.php" class="btn btn-primary">จัดการสมาชิก</a>
                    </div>
                </div>
            </div>

            <!-- การจัดการครุภัณฑ์ -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">จัดการครุภัณฑ์</h5>
                        <p class="card-text">เพิ่ม, ลบ, แก้ไขข้อมูลครุภัณฑ์ในระบบ</p>
                        <a href="manage_equipment.php" class="btn btn-primary">จัดการครุภัณฑ์</a>
                    </div>
                </div>
            </div>

            <!-- การจัดการกำหนดการซ่อม -->
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">จัดการกำหนดการซ่อม</h5>
                        <p class="card-text">เพิ่ม, ลบ, แก้ไขกำหนดการซ่อมครุภัณฑ์</p>
                        <a href="manage_repair_schedule.php" class="btn btn-primary">จัดการกำหนดการซ่อม</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>