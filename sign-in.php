<?php

session_start();
require_once 'connect.php';

if (isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($password)) {
        echo "<script>alert('กรุณากรอกรหัสผ่าน')</script>";
        header('refresh:1;index.php');
        exit(); // ออกจากการทำงานทันทีหลังจาก redirect
    } else {
        // ค้นหาผู้ใช้จากฐานข้อมูล
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result_check = $stmt->get_result();

        if (!$result_check) {
            echo "<script>alert('เกิดข้อผิดพลาดในการค้นหาผู้ใช้')</script>";
            header('refresh:1;index.php');
            exit();  // ออกจากการทำงานทันทีหลังจาก redirect
        }

        // ตรวจสอบว่ามีผู้ใช้ในฐานข้อมูลหรือไม่
        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // ตรวจสอบบทบาทของผู้ใช้
                if (isset($row['urole']) && $row['urole'] == '2') {
                    $_SESSION['admin_login'] = $row['id_user'];
                    $_SESSION['username'] = $row['fname'];
                    header("location: admin.php");
                    exit();
                } else {
                    $_SESSION['user_login'] = $row['id_user'];
                    $_SESSION['username'] = $row['fname'];
                    header("location: user.php");
                    exit();
                }
            } else {
                echo "<script>alert('รหัสผ่านผิด')</script>";
                header('refresh:1;index.php');
                exit();
            }
        } else {
            echo "<script>alert('ไม่มีข้อมูลในระบบ')</script>";
            header('refresh:1;index.php');
            exit(); 
        }
    }
}
?>