<?php
// เริ่มต้นการใช้งาน session
session_start();

if (!isset($_SESSION['admin_login'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php';

// ตรวจสอบการลบข้อมูล
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql_delete = "DELETE FROM repair_schedule WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();
    $stmt_delete->close();
    header('Location: manage_repair_schedule.php');
    exit();
}

$sql_rh = "SELECT * FROM repair_schedule a 
              INNER JOIN status_repair_schedule b ON a.status_rs = b.id_rs
              INNER JOIN equipment c ON a.equipment_id = c.id";
$result_data = mysqli_query($conn, $sql_rh);

?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการกำหนดการซ่อมครุภัณฑ์</title>
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
        <h2>จัดการกำหนดการซ่อมครุภัณฑ์</h2>

        <!-- ฟอร์มเพิ่มกำหนดการซ่อม -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">เพิ่มกำหนดการซ่อม</h5>
                <form action="insert_repair_schedule.php" method="POST">
                    <div class="mb-3">
                        <label for="equipment_id" class="form-label">ID ครุภัณฑ์</label>
                        <select class="form-control" id="equipment_id" name="equipment_id" required>
                            <?php
                            $sql = "SELECT * FROM equipment ";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['bib'] . " " . $row['name']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="repair_date" class="form-label">วันที่ซ่อม</label>
                        <input type="date" class="form-control" id="repair_date" name="repair_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">สถานะการซ่อม</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1">รอดำเนินการ</option>
                            <option value="2">กำลังซ่อม</option>
                            <option value="3">ซ่อมเสร็จสิ้น</option>
                        </select>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">เพิ่มกำหนดการซ่อม</button>
                </form>
            </div>
        </div>

        <!-- ตารางข้อมูลกำหนดการซ่อม -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID ครุภัณฑ์</th>
                    <th>วันที่ซ่อม</th>
                    <th>สถานะการซ่อม</th>
                    <th>อัปเดตล่าสุด</th>
                    <th>การดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = $result_data->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $data['bib'] ." ". $data['name']; ?></td>
                        <td><?php echo htmlspecialchars($data['repair_date']); ?></td>
                        <td><?php echo htmlspecialchars($data['name_rs']); ?></td>
                        <td><?php echo htmlspecialchars($data['updated_at']); ?></td>
                        <td>
                            <a href="edit_repair_schedule.php?id=<?php echo $data['id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                            <a href="manage_repair_schedule.php?delete=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบกำหนดการนี้?');">ลบ</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>