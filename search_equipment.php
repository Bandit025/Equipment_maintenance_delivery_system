<?php
// เริ่มต้น session
session_start();
require_once 'connect.php';
// ตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}



$search_results = [];

// ตรวจสอบว่ามีการส่งฟอร์มหรือไม่
if (isset($_POST['search'])) {
    $query = $_POST['query'];
    
    // สร้างคำสั่ง SQL สำหรับการค้นหาครุภัณฑ์
    $sql = "SELECT * FROM equipment a INNER JOIN status_equipment b ON a.status = b.id_e WHERE name LIKE '%$query%' OR description LIKE '%$query%'";
    $result = mysqli_query($conn, $sql);
    
    // เก็บผลการค้นหา
    if ($result && mysqli_num_rows($result) > 0) {
        $search_results = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        $message = "ไม่พบครุภัณฑ์ที่ค้นหา";
    }
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาครุภัณฑ์</title>
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
                        <a class="nav-link" href="user.php">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="search_equipment.php">ค้นหาครุภัณฑ์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="repair_history.php">ประวัติการซ่อม</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">ออกจากระบบ</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- ฟอร์มการค้นหา -->
    <div class="container mt-5">
        <h2>ค้นหาครุภัณฑ์</h2>
        <form method="POST" action="search_equipment.php" class="mb-4">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="ป้อนชื่อครุภัณฑ์หรือคำอธิบาย" required>
                <button class="btn btn-primary" type="submit" name="search">ค้นหา</button>
            </div>
        </form>

        <!-- ผลการค้นหา -->
        <?php if (!empty($search_results)): ?>
            <h4>ผลการค้นหา:</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>รหัสครุภัณฑ์</th>
                        <th>ชื่อครุภัณฑ์</th>
                        <th>รายละเอียด</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($search_results as $equipment): ?>
                        <tr>
                            <td><?php echo $equipment['bib']; ?></td>
                            <td><?php echo $equipment['name']; ?></td>
                            <td><?php echo $equipment['description']; ?></td>
                            <td><img src="uploads/<?php echo htmlspecialchars($equipment['image']); ?>" style="width: 100px; height: auto;"></td>
                            <td><?php echo $equipment['name_e']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif (isset($message)): ?>
            <p class="text-danger"><?php echo $message; ?></p>
        <?php endif; ?>
    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>