<?php
// เริ่มต้นการใช้งาน session
session_start();

if (!isset($_SESSION['admin_login'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php';


$sql="SELECT * FROM equipment a INNER JOIN status_equipment b ON a.status = b.id_e";
$result = mysqli_query($conn, $sql);

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
                <h5 class="card-title">เพิ่มครุภัณฑ์</h5>
                <form action="insert_equipment.php" method="POST"enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">ชื่อครุภัณฑ์</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">วันที่ซื้อรุภัณฑ์</label>
                        <input type="date" class="form-control" id="purchase" name="purchase" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">รายละเอียดครุภัณฑ์</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">สถานะครุภัณฑ์</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">ใช้งานอยู่</option>
                            <option value="2">ส่งซ่อม</option>
                            <option value="3">ปลดระวาง</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">รูปครุภัณฑ์</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">เพิ่มครุภัณฑ์</button>
                </form>
            </div>
        </div>

        <!-- ตารางข้อมูลครุภัณฑ์ -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัสครุภัณฑ์</th>
                    <th>ชื่อครุภัณฑ์</th>
                    <th>รายละเอียด</th>
                    <th>สถานะ</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['bib']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" style="width: 100px; height: auto;"></td>
                    <td><?php echo $row['name_e']; ?></td>
                    <td>
                        <a href="edit_equipment.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                        <a href="delete_equipment.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบครุภัณฑ์นี้?');">ลบ</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>