<?php

// เริ่มต้น session
session_start();
require_once 'connect.php';
// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}



// ดึงข้อมูลประวัติการซ่อม
$query = "SELECT r.id, e.name AS equipment_name, r.repair_date, r.completed_date, r.details, r.cost 
          FROM repair_history r
          JOIN equipment e ON r.equipment_id = e.id
          ORDER BY r.repair_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประวัติการซ่อมบำรุงครุภัณฑ์</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="user.php">ระบบส่งซ่อมครุภัณฑ์</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="search_equipment.php">ค้นหาครุภัณฑ์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="repair_history.php">ประวัติการซ่อม</a>
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
        <h2>ประวัติการซ่อมบำรุงครุภัณฑ์</h2>
        
        <!-- ตรวจสอบว่ามีข้อมูลประวัติการซ่อมหรือไม่ -->
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ชื่อครุภัณฑ์</th>
                        <th>วันที่ส่งซ่อม</th>
                        <th>วันที่ซ่อมเสร็จ</th>
                        <th>รายละเอียดการซ่อม</th>
                        <th>ค่าใช้จ่าย (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- ลูปแสดงรายการประวัติการซ่อม -->
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['equipment_name']; ?></td>
                            <td><?php echo $row['repair_date']; ?></td>
                            <td><?php echo $row['completed_date']; ?></td>
                            <td><?php echo $row['details']; ?></td>
                            <td><?php echo number_format($row['cost'], 2); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">ไม่มีข้อมูลประวัติการซ่อมบำรุงครุภัณฑ์</p>
        <?php endif; ?>
    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>