<?php
// เริ่มต้นการใช้งาน session
session_start();

// ตรวจสอบว่าผู้ใช้เป็นผู้ดูแลระบบหรือไม่
if (!isset($_SESSION['admin_login'])) {
    header('Location: login.php');
    exit();
}

require_once 'connect.php';

// ดึงข้อมูลสมาชิกจากตาราง users
$sql = "SELECT * FROM users a INNER JOIN urole b ON a.urole = b.id_urole";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสมาชิก</title>
    <!-- เรียกใช้ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin.php">ระบบส่งซ่อมครุภัณฑ์</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">หน้าแรก</a>
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
        <h2>จัดการสมาชิก</h2>

        <!-- ปุ่มเพิ่มสมาชิก -->
        <div class="mb-3">
            <a href="register.php" class="btn btn-success">เพิ่มสมาชิกใหม่</a>
        </div>

        <!-- ตารางแสดงข้อมูลสมาชิก -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ชื่อ</th>
                    <th>นามสกุล</th>
                    <th>บทบาท</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // แสดงข้อมูลสมาชิกจากฐานข้อมูล
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['lname']); ?></td>
                            <td><?php echo htmlspecialchars($row['name_urole']); ?></td>
                            <td>
                                <a href='edit_member.php?id_user=<?php echo $row['id_user']; ?>' class='btn btn-warning btn-sm'>แก้ไข</a>
                                <a href='delete_member.php?id_user=<?php echo $row['id_user']; ?>' class='btn btn-danger btn-sm' onclick='return confirm("คุณต้องการลบสมาชิกนี้หรือไม่?");'>ลบ</a>
                            </td>
                        </tr>
                    <?php }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>ไม่มีข้อมูลสมาชิก</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- เรียกใช้ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>